<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard, timePunch } from '@/routes';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Time Punch',
                href: timePunch(),
            },
        ],
    },
});
</script>

<template>

    <Head title="Time Punch" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <h1>Hello World!</h1>
    </div>
</template>
