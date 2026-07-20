<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3';
import { Clock } from '@lucide/vue';
import type ApexCharts from 'apexcharts';
import { initFlowbite } from 'flowbite';
import { ref, onMounted, computed, watch } from 'vue';
import { dashboard } from '@/routes';
import { route } from 'ziggy-js';

// eslint-disable-next-line vue/no-dupe-keys
interface empLeave {
    id: number;
    name: string;
    hours: number;
}

// eslint-disable-next-line vue/no-dupe-keys
interface timesheets {
    id: number;
    emp_id: number;
    time_in: string;
    lunch_out: string;
    lunch_in: string;
    time_out: string;
}

interface Props {
    empLeave?: empLeave[];
    timesheets?: timesheets[];
}

const props = defineProps<Props>();

const page = usePage();
const user = computed(() => page.props.auth.user);

const empLeaveData = computed<empLeave[]>(() => {
    if (props.empLeave) return props.empLeave;

    const user = page.props.auth?.user as any;
    return [
        { id: 1, name: 'Annual Leave', hours: user?.annual_leave ?? 0 },
        { id: 2, name: 'Sick Leave', hours: user?.sick_leave ?? 0 },
    ];
});

const totalHours = computed(() => {
    return empLeaveData.value.reduce(
        (accumulator, currentItem) => accumulator + Number(currentItem.hours),
        0
    );
});

type PunchKey = 'time_in' | 'lunch_out' | 'lunch_in' | 'time_out';

const punchLabels: Record<PunchKey, string> = {
    time_in: 'Timed In',
    lunch_out: 'Out for Lunch',
    lunch_in: 'In from Lunch',
    time_out: 'Timed Out',
};

const punchButton: Record<PunchKey, string> = {
    time_in: 'Lunch Out',
    lunch_out: 'Lunch In',
    lunch_in: 'Time Out',
    time_out: 'Time In',
};

const getPunchType = computed<PunchKey>(() => {
    return (page.props.auth.user?.punch_type as PunchKey) || 'time_out';
});

const getPunchLabel = computed(() => punchLabels[getPunchType.value]);

const getPunchButton = computed(() => punchButton[getPunchType.value]);

// const userId = page.props.auth.user?.id;

const createPunch = () => {
    router.post(route('time-punch.store'));
};

const chartRef = ref<HTMLDivElement | null>(null);
let chart: any = null;

const chartOptions = computed<ApexCharts.ApexOptions>(() => ({
    series: empLeaveData.value.map((item) => ({
        name: item.name,
        color: item.name === 'Annual Leave' ? '#007A55' : '#C70036',
        data: [item.hours],
    })),
    chart: {
        sparkline: { enabled: false },
        type: 'bar',
        width: '100%',
        height: 100,
        toolbar: { show: false },
    },
    fill: { opacity: 1 },
    plotOptions: {
        bar: {
            horizontal: true,
            barHeight: '100%',
            dataLabels: { position: 'top' },
        },
    },
    legend: { show: true, position: 'bottom' },
    dataLabels: { enabled: false },
    xaxis: {
        categories: ['Hours Available'],
        axisTicks: { show: false },
        axisBorder: { show: false },
    },
    grid: {
        show: true,
        strokeDashArray: 4,
        padding: { left: 2, right: 2, top: -20 },
    },
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

onMounted(async () => {
    initFlowbite();

    if (typeof window !== 'undefined' && chartRef.value) {
        const ApexChartsModule = await import('apexcharts');
        const ApexCharts = ApexChartsModule.default;

        chart = new ApexCharts(chartRef.value, chartOptions.value);
        chart.render();
    }
});

watch(
    () => empLeaveData.value,
    () => {
        chart?.updateOptions(chartOptions.value);
    },
    { deep: true },
);
</script>

<template>
    <Head title="Home" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="w-full rounded-base border border-default bg-neutral-primary-soft p-4 shadow-xs"
            >
                <div class="flex justify-between border-b border-light pb-3">
                    <dl>
                        <dt class="text-body">Total Leave Hours</dt>
                        <dd class="text-2xl font-semibold text-heading">
                            {{ totalHours }}
                        </dd>
                    </dl>
                </div>

                <div class="grid grid-cols-2 py-3">
                    <dl>
                        <div>
                            <dt class="text-body">Annual Leave</dt>
                            <dd class="text-lg font-semibold text-fg-success">
                                {{ page.props.auth.user?.annual_leave }}
                            </dd>
                        </div>
                    </dl>
                    <dl>
                        <div>
                            <dt class="text-body">Sick Leave</dt>
                            <dd class="text-lg font-semibold text-fg-danger">
                                {{ page.props.auth.user?.sick_leave }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div ref="chartRef" class="min-h-full!"></div>
            </div>

            <div
                class="relative aspect-video min-h-full! w-full overflow-hidden rounded-xl border border-default dark:border-sidebar-border"
            >
                <div class="flex h-full flex-col justify-around p-4">
                    <div class="space-y-3">
                        <h4 class="text-3xl font-semibold">$911.40</h4>
                        <h2 class="font-medium text-gray-500">
                            Last Paycheck: 6/24/2026
                        </h2>
                    </div>
                    <hr class="w-full" />
                    <div class="space-y-3">
                        <h4 class="text-3xl font-semibold">$10,638.97</h4>
                        <h2 class="font-medium text-gray-500">YTD</h2>
                    </div>
                </div>
            </div>
            <div
                class="relative aspect-video min-h-full! w-full overflow-hidden rounded-xl border border-default dark:border-sidebar-border"
            >
                <div class="flex h-full flex-col justify-around p-4">
                    <div class="space-y-6">
                        <Clock class="size-12" />
                        <div>
                            <p
                                class="text-xs font-medium text-gray-500 uppercase"
                            >
                                You are currently:
                            </p>
                            <div v-if="user">
                                <h2 class="text-2xl font-semibold">
                                    {{ getPunchLabel }}
                                </h2>
                            </div>
                        </div>
                    </div>
                    <hr class="w-full" />
                    <div>
                        <button
                            @click="createPunch"
                            class="rounded border px-4 py-2"
                        >
                            {{ getPunchButton }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative flex-1 rounded-xl">
            <div
                class="relative h-[550px] overflow-x-auto overflow-y-scroll rounded-base border border-default bg-neutral-primary-soft shadow-xs"
            >
                <table
                    class="w-full text-left text-sm text-body rtl:text-right"
                >
                <thead
                class="rounded-base border-b border-default bg-neutral-secondary-soft text-sm text-body"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Employee ID
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Time In
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Lunch Out
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Lunch In
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Time Out
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="border-b border-default bg-neutral-primary"
                            v-for="time in props.timesheets"
                            :key="time.id"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium whitespace-nowrap text-heading"
                            >
                                {{ time.emp_id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ time.time_in }}
                            </td>
                            <td class="px-6 py-4">
                                {{ time.lunch_out }}
                            </td>
                            <td class="px-6 py-4">
                                {{ time.lunch_in }}
                            </td>
                            <td class="px-6 py-4">
                                {{ time.time_out }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
