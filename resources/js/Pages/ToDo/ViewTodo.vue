<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();
const tasks = ref(page.props.tasks);

const accordions = ref(Object.keys(tasks.value).map(status => ({
    title: status.charAt(0).toUpperCase() + status.slice(1),
    content: tasks.value[status],
    isOpen: false
})));

const toggleAccordion = (index) => {
    accordions.value[index].isOpen = !accordions.value[index].isOpen;
};
</script>



<template>

    <Head title="Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Tasks</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="px-8 py-4">
                        <div class="flex items-center justify-between">
                            <h1 class="text-2xl font-bold">Pending</h1>
                            <button
                                class="p-2 text-white bg-indigo-500 rounded-md btn-block btn-sm hover:bg-indigo-600">
                                <i class="fa fa-plus me-2"></i> Add Todo
                            </button>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="p-4">
                            <div class="flex flex-wrap items-center -mx-2">
                                <div class="w-full px-2 mb-4 lg:w-6/12 lg:mb-0">
                                    <input type="text" placeholder="Search todos..."
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                </div>
                                <div class="w-full px-2 mb-4 lg:w-3/12 lg:mb-0">
                                    <select
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        name="status" id="status">
                                        <option value="" disabled selected class="text-gray-500">Status:</option>
                                        <option value="all">All</option>
                                        <option value="pending">Pending</option>
                                        <option value="in-progress">Backlog</option>
                                        <option value="completed">Complete</option>
                                    </select>
                                </div>
                                <div class="w-full px-2 mb-4 lg:w-3/12 lg:mb-0">
                                    <select
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        name="priority" id="priority">
                                        <option value="" disabled selected class="text-gray-500">Priority:</option>
                                        <option value="all">All</option>
                                        <option value="highest"><i
                                                class="text-red-600 fa-solid fa-angles-up me-2"></i>Highest
                                        </option>
                                        <option value="high"><i class="text-red-600 fa-solid fa-angle-up me-2"></i>High
                                        </option>
                                        <option value="medium">Medium</option>
                                        <option value="low"><i class="text-blue-800 fa-solid fa-angle-down me-2"></i>Low
                                        </option>
                                        <option value="lowest"><i
                                                class="text-blue-800 fa-solid fa-angles-down me-2"></i>Lowest
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="relative mb-3" v-for="(accordion, index) in accordions" :key="index">
                            <h6 class="mb-0">
                                <button
                                    class="relative flex items-center w-full p-4 font-semibold text-left transition-all ease-in border-b border-solid cursor-pointer border-slate-100 text-slate-700 rounded-t-1 group text-dark-500"
                                    @click="toggleAccordion(index)">
                                    <span class="ms-4">{{ accordion.title }}</span>
                                    <i class="absolute right-0 pt-1 text-base transition-transform me-8 fa fa-chevron-down"
                                        :class="{ 'rotate-180': accordion.isOpen }"></i>
                                </button>
                            </h6>
                            <div v-show="accordion.isOpen"
                                class="overflow-hidden transition-all duration-300 ease-in-out">
                                <div class="p-4 text-sm leading-normal text-blue-gray-500/80">
                                    <div v-for="task in accordion.content" :key="task.id"
                                        class="mb-2 border rounded-md card">
                                        <div class="flex items-center justify-between p-4 card-header">
                                            <div class="flex-col">
                                                <div class="card-title">{{ task.name }}</div>
                                                <div class="text-gray-600">{{ task.created_at }}</div>
                                            </div>
                                            <div class="card-toolbar">Toolbar</div>
                                        </div>
                                        <div class="px-4 card-body">{{ task.description }}</div>
                                        <div class="my-4 card-footer">
                                            <span
                                                class="bg-gray-100 text-gray-800 text-xs font-medium ms-4 me-2 px-2.5 py-0.5 rounded dark:bg-gray-200 dark:text-gray-800">
                                                <i class="text-orange-400 fa-solid fa-circle me-2"></i>{{ task.status }}
                                            </span>
                                            <span
                                                class="bg-gray-100 text-gray-800 text-xs font-medium ms-4 me-2 px-2.5 py-0.5 rounded dark:bg-gray-200 dark:text-gray-800">
                                                <i
                                                    class="text-red-600 fa-solid fa-angles-up me-2"></i>{{ task.priority }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
