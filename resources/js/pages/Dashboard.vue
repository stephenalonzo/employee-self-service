<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard } from '@/routes';
import { ref, onMounted, computed, watch } from 'vue';
import ApexCharts from 'apexcharts';
import { initFlowbite } from 'flowbite';

interface empLeave {
    id: number;
    name: string;
    hours: number;
}

interface Props {
    empLeave?: empLeave[];
}

const props = withDefaults(defineProps<Props>(), {
    empLeave: () => [
        { id: 1, name: 'Annual Leave', hours: 164 },
        { id: 2, name: 'Sick Leave', hours: 45 }
    ]
});

const chartRef = ref<HTMLDivElement | null>(null);
let chart: any = null;

const chartOptions = computed<ApexCharts.ApexOptions>(() => ({
    series: props.empLeave.map(item => ({
        name: item.name,
        color: item.name === 'Annual Leave' ? '#007A55' : '#C70036',
        data: [item.hours]
    })),
    chart: {
        sparkline: { enabled: false },
        type: "bar",
        width: "100%",
        height: 100,
        toolbar: { show: false }
    },
    fill: { opacity: 1 },
    plotOptions: {
        bar: {
            horizontal: true,
            barHeight: "100%",
            dataLabels: { position: "top" },
        },
    },
    legend: { show: true, position: "bottom" },
    dataLabels: { enabled: false },
    xaxis: {
        categories: ["Hours Available"],
        axisTicks: { show: false },
        axisBorder: { show: false },
    },
    grid: {
        show: true,
        strokeDashArray: 4,
        padding: { left: 2, right: 2, top: -20 },
    }
}));

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Home',
                href: dashboard(),
            },
        ],
    },
});

onMounted(async() => {
    initFlowbite();
    if (typeof window !== 'undefined' && chartRef.value) {
        const ApexChartsModule = await import('apexcharts');
        const ApexCharts = ApexChartsModule.default;

        chart = new ApexCharts(chartRef.value, chartOptions.value);
        chart.render();
    }
});

watch(() => props.empLeave, () => {
    chart?.updateOptions(chartOptions.value);
}, { deep: true });
</script>

<template>

    <Head title="Home" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-base shadow-xs p-4">
                <div class="flex justify-between border-light border-b pb-3">
                    <dl>
                        <dt class="text-body">[TEST] Total Leave Hours</dt>
                        <dd class="text-2xl font-semibold text-heading">{{empLeave.reduce((accumulator, currentItem) =>
                            accumulator + currentItem.hours, 0) }}</dd>
                    </dl>
                </div>

                <div class="grid grid-cols-2 py-3">
                    <dl v-for="empLeave in props.empLeave">
                        <div v-if="empLeave.name == 'Annual Leave'">
                            <dt class="text-body">{{ empLeave.name }}</dt>
                            <dd class="text-lg font-semibold text-fg-success">{{ empLeave.hours }}</dd>
                        </div>
                        <div v-else>
                            <dt class="text-body">{{ empLeave.name }}</dt>
                            <dd class="text-lg font-semibold text-fg-danger">{{ empLeave.hours }}</dd>
                        </div>
                    </dl>
                </div>

                <div ref="chartRef" class="min-h-full!"></div>
            </div>

            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-default dark:border-sidebar-border w-full min-h-full!">
                <div class="p-4 flex flex-col justify-around h-full">
                    <div class="space-y-3">
                        <h4 class="text-3xl font-semibold">$911.40</h4>
                        <h2 class="font-medium text-gray-500">Last Paycheck: 6/24/2026</h2>
                    </div>
                    <hr class="w-full">
                    <div class="space-y-3">
                        <h4 class="text-3xl font-semibold">$10,638.97</h4>
                        <h2 class="font-medium text-gray-500">YTD</h2>
                    </div>
                </div>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-default dark:border-sidebar-border w-full min-h-full!">
                <div class="p-4 h-full">
                    <div class="grid grid-cols-2 gap-6 w-full h-full">
                        <a href="#" class="w-full h-full border px-4 py-2 rounded-md font-semibold flex items-center justify-center">
                            <span class="text-xl uppercase">Time In</span>
                        </a>
                        <a href="#" class="w-full h-full border px-4 py-2 rounded-md font-semibold flex items-center justify-center">
                            <span class="text-xl uppercase">Out Lunch</span>
                        </a>
                        <a href="#" class="w-full h-full border px-4 py-2 rounded-md font-semibold flex items-center justify-center">
                            <span class="text-xl uppercase">In Lunch</span>
                        </a>
                        <a href="#" class="w-full h-full border px-4 py-2 rounded-md font-semibold flex items-center justify-center">
                            <span class="text-xl uppercase">Time Out</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="relative min-h-[100vh] flex-1 rounded-xl border border-default md:min-h-min dark:border-sidebar-border">


<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">
                    Product name
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Color
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Category
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Price
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Stock
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-neutral-primary border-b border-default">
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    Apple MacBook Pro 17"
                </th>
                <td class="px-6 py-4">
                    Silver
                </td>
                <td class="px-6 py-4">
                    Laptop
                </td>
                <td class="px-6 py-4">
                    $2999
                </td>
                <td class="px-6 py-4">
                    231
                </td>
            </tr>
            <tr class="bg-neutral-primary border-b border-default">
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    Microsoft Surface Pro
                </th>
                <td class="px-6 py-4">
                    White
                </td>
                <td class="px-6 py-4">
                    Laptop PC
                </td>
                <td class="px-6 py-4">
                    $1999
                </td>
                <td class="px-6 py-4">
                    423
                </td>
            </tr>
            <tr class="bg-neutral-primary">
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    Magic Mouse 2
                </th>
                <td class="px-6 py-4">
                    Black
                </td>
                <td class="px-6 py-4">
                    Accessories
                </td>
                <td class="px-6 py-4">
                    $99
                </td>
                <td class="px-6 py-4">
                    121
                </td>
            </tr>
        </tbody>
    </table>
</div>

        </div>
    </div>
</template>
