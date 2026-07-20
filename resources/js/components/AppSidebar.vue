<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BookOpen, FolderGit2, House, ClockArrowRight } from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarGroup,
    SidebarMenuSub
} from '@/components/ui/sidebar';
import { Collapsible, CollapsibleTrigger, CollapsibleContent } from './ui/collapsible';
import { ChevronRight } from '@lucide/vue';
import { dashboard, timeOff } from '@/routes';
import type { NavItem } from '@/types';
import type { InertiaLinkProps } from '@inertiajs/vue3';

const mainNavItems = [
    {
        title: "Home",
        href: dashboard(),
        icon: House,
    },
    {
        title: "Request Time-off",
        icon: ClockArrowRight,
        defaultOpen: false,
        items: [
            {
                title: "Submit a Form",
                href: timeOff(),
            },
        ],
    },
]

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];

defineProps<{
    mainNavItems?: Array<{
        title: string
        href: NonNullable<InertiaLinkProps['href']>;
        icon?: any
        defaultOpen?: boolean
        items?: Array<{ title: string; href: NonNullable<InertiaLinkProps['href']>; }>
    }>
}>()
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <SidebarGroup>
                <SidebarMenu>
                    <SidebarMenuItem v-for="item in mainNavItems" :key="item.title">

                        <!-- CASE A: The item has sub-items -> Render Collapsible -->
                        <Collapsible v-if="item.items && item.items.length" :default-open="item.defaultOpen"
                            class="group/collapsible">
                            <CollapsibleTrigger as-child>
                                <SidebarMenuButton>
                                    <component :is="item.icon" v-if="item.icon" />
                                    <span>{{ item.title }}</span>
                                    <ChevronRight
                                        class="ml-auto transition-transform group-data-[state=open]/collapsible:rotate-90" />
                                </SidebarMenuButton>
                            </CollapsibleTrigger>

                            <CollapsibleContent>
                                <SidebarMenuSub>
                                    <SidebarMenuItem v-for="subItem in item.items" :key="subItem.title">
                                        <SidebarMenuButton as-child>
                                            <Link :href="subItem.href">
                                                <span>{{ subItem.title }}</span>
                                            </Link>
                                        </SidebarMenuButton>
                                    </SidebarMenuItem>
                                </SidebarMenuSub>
                            </CollapsibleContent>
                        </Collapsible>

                        <!-- CASE B: Normal item -> Render Standard Button -->
                        <SidebarMenuButton v-else as-child>
                            <Link :href="item.href">
                                <component :is="item.icon" v-if="item.icon" />
                                <span>{{ item.title }}</span>
                            </Link>
                        </SidebarMenuButton>

                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroup>
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
