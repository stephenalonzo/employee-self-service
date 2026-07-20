<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { timeOff } from '@/routes';
import { ref, onMounted } from 'vue';
import { DateRangePicker } from 'flowbite-datepicker';
import { route } from 'ziggy-js';

const rangePickerContainer = ref<HTMLDivElement | null>(null);

const page = usePage();

const form = useForm({
    emp_name: page.props.auth?.user.name,
    emp_id: (page.props as any).auth?.user.emp_id,
    emp_department: '',
    leave_type: '',
    leave_start: '',
    leave_end: '',
    leave_reason: ''
});

onMounted(() => {
    const containerNode = rangePickerContainer.value as HTMLDivElement | null;

    if (containerNode) {
        const rangePicker = new DateRangePicker(containerNode, {
            allowOneSidedRange: false,
            autohide: true,
            format: 'yyyy-mm-dd',
        });

        const startInput = containerNode.querySelector('input[name="leave_start"]') as HTMLInputElement | null;
        const endInput = containerNode.querySelector('input[name="leave_end"]') as HTMLInputElement | null;

        if (startInput) {
            startInput.addEventListener('changeDate', (e: Event) => {
                const target = e.target as HTMLInputElement;
                form.leave_start = target.value;
            });
        }

        if (endInput) {
            endInput.addEventListener('changeDate', (e: Event) => {
                const target = e.target as HTMLInputElement;
                form.leave_end = target.value;
            });
        }
    }
});

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Request Time-off',
                href: timeOff(),
            },
        ],
    },
});

const handleSubmit = (() => {
    form.post(route('time-off.store'))
})
</script>

<template>

    <Head title="Request Time-off" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Request Time-off</h2>
                <form @submit.prevent="handleSubmit" method="POST">
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee
                                Name</label>
                            <input type="text" v-model="form.emp_name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Enter your full name">
                            <div v-if="form.errors.emp_name" class="text-sm text-red-500">{{ form.errors.emp_name }}
                            </div>
                        </div>
                        <div class="w-full">
                            <label for="brand"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee
                                Number</label>
                            <input type="text" v-model="form.emp_id" id="brand"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Enter your employee number">
                            <div v-if="form.errors.emp_id" class="text-sm text-red-500">{{ form.errors.emp_id }}</div>
                        </div>
                        <div class="w-full">
                            <label for="price"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                            <input type="text" v-model="form.emp_department" id="price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Enter your department">
                            <div v-if="form.errors.emp_department" class="text-sm text-red-500">{{
                                form.errors.emp_department }}</div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="category"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type of
                                Leave</label>
                            <select id="category" v-model="form.leave_type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected>Select type of leave</option>
                                <option value="AL">Annual Leave</option>
                                <option value="SL">Sick Leave</option>
                                <option value="WP">Without Pay</option>
                            </select>
                            <div v-if="form.errors.leave_type" class="text-sm text-red-500">{{ form.errors.leave_type }}
                            </div>
                        </div>
                        <div ref="rangePickerContainer" class="sm:col-span-2 sm:flex sm:space-x-6 sm:items-center">
                            <div class="flex flex-col w-full">
                                <label for="datepicker-range-start"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start
                                    Date</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-body" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-start" name="leave_start" type="text"
                                        class="block w-full ps-9 pe-3 py-2.5 bg-neutral-secondary-medium border border-gray-300 text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 py-2.5 shadow-xs placeholder:text-body"
                                        placeholder="Select date start of leave" v-model="form.leave_start">
                                    <div v-if="form.errors.leave_start" class="text-sm text-red-500">{{
                                        form.errors.leave_start }}</div>
                                </div>
                            </div>
                            <div class="flex flex-col w-full">
                                <label for="datepicker-range-end"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End
                                    Date</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-body" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-end" name="leave_end" type="text"
                                        class="block w-full ps-9 pe-3 py-2.5 bg-neutral-secondary-medium border border-gray-300 text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 py-2.5 shadow-xs placeholder:text-body"
                                        placeholder="Select date end of leave" v-model="form.leave_end">
                                    <div v-if="form.errors.leave_end" class="text-sm text-red-500">{{
                                        form.errors.leave_end }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reason for
                                Leave</label>
                            <textarea id="description" rows="8"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Your description here" v-model="form.leave_reason"></textarea>
                            <div v-if="form.errors.leave_reason" class="text-sm text-red-500">{{
                                form.errors.leave_reason }}</div>
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-gray-700 rounded-lg focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-900 hover:bg-gray-800">
                        Submit
                    </button>
                </form>
            </div>
        </section>
    </div>
</template>
