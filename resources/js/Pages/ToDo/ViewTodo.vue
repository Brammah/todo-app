<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '/resources/js/Pages/ToDo/EditTodo.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { format } from 'date-fns';
import axios from 'axios';

const page = usePage();
const tasks = ref(page.props.tasks);
const successMessage = ref('');

const formatDate = (dateString) => {
    return format(new Date(dateString), "MMMM do yyyy");
};

const accordions = ref(Object.keys(tasks.value).map(status => ({
    title: status.charAt(0).toUpperCase() + status.slice(1),
    content: tasks.value[status],
    isOpen: false
})));

const toggleAccordion = (index) => {
    accordions.value[index].isOpen = !accordions.value[index].isOpen;
};

const dropdownOpen = ref({});

const toggleDropdown = (taskId) => {
    dropdownOpen.value[taskId] = !dropdownOpen.value[taskId];
};

const deleteTask = async (taskId) => {
    if (confirm('Are you sure you want to delete this task?')) {
        try {
            await axios.delete(`/task/${taskId}`);
            for (const status in tasks.value) {
                tasks.value[status] = tasks.value[status].filter(task => task.id !== taskId);
            }
            successMessage.value = 'Task deleted.';
            window.location.href = `/task`;
            setTimeout(() => {
                successMessage.value = '';
            }, 3000);
        } catch (error) {
            console.error('Error deleting task:', error);
        }
    }
};

const isEditModalOpen = ref(false);
const currentTask = ref(null);

const openEditModal = (task) => {
    currentTask.value = { ...task };
    isEditModalOpen.value = true;
};

const closeEditModal = () => {
    isEditModalOpen.value = false;
    currentTask.value = null;
};

const updateTask = async () => {
    try {
        await axios.put(`/task/${currentTask.value.id}`, currentTask.value);
        for (const status in tasks.value) {
            const taskIndex = tasks.value[status].findIndex(task => task.id === currentTask.value.id);
            if (taskIndex !== -1) {
                tasks.value[status][taskIndex] = { ...currentTask.value };
                break;
            }
        }
        closeEditModal();
        successMessage.value = 'Task updated successfully.';
        window.location.href = `/task`;
        setTimeout(() => {
            successMessage.value = '';
        }, 3000);
    } catch (error) {
        console.error('Error updating task:', error);
    }
};

const props = defineProps({
    successMessage: String
});

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
                        <div v-if="successMessage" class="p-3 my-4 text-white bg-green-600 rounded-md">
                            {{ successMessage }}
                        </div>
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
                                        <option value="backlog">Backlog</option>
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
                                        class="m-4 border rounded-md card">
                                        <div class="flex items-center justify-between p-4 card-header">
                                            <div class="flex-col">
                                                <div class="card-title text-dark">{{ task.name }}</div>
                                                <div class="text-gray-600">{{ formatDate(task.created_at) }}</div>
                                            </div>
                                            <div class="card-toolbar">
                                                <div class="relative inline-block text-left">
                                                    <div>
                                                        <button type="button"
                                                            class="inline-flex w-full justify-center gap-x-1.5 outline-0 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                                            @click="toggleDropdown(task.id)">
                                                            <i class="fa-solid fa-ellipsis"></i>
                                                        </button>
                                                    </div>
                                                    <div v-if="dropdownOpen[task.id]"
                                                        class="absolute right-0 z-10 w-56 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                        role="menu" aria-orientation="vertical">
                                                        <div class="py-1" role="none">
                                                            <a href="#" class="block px-4 py-2 text-sm text-green-500"
                                                                role="menuitem">
                                                                <i
                                                                    class="text-green-500 fa-regular fa-circle-check me-2"></i>
                                                                Mark as Done
                                                            </a>
                                                            <a href="#" class="block px-4 py-2 text-sm text-black"
                                                                role="menuitem">
                                                                <i class="text-black fa-solid fa-rotate-left me-2"></i>
                                                                Move to Backlog
                                                            </a>
                                                            <a href="#" @click.prevent="openEditModal(task)"
                                                                class="block px-4 py-2 text-sm text-black"
                                                                role="menuitem">
                                                                <i class="text-black fa-solid fa-pencil me-2"></i>
                                                                Edit Todo
                                                            </a>
                                                            <a href="#" @click.prevent="deleteTask(task.id)"
                                                                class="block px-4 py-2 text-sm text-red-700"
                                                                role="menuitem">
                                                                <i
                                                                    class="text-red-700 fa-regular fa-trash-can me-2"></i>
                                                                Delete Todo
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

    <Modal :isOpen="isEditModalOpen" @close="closeEditModal">
        <template #default>
            <h2 class="text-lg font-semibold">Edit Task</h2>
            <form @submit.prevent="updateTask" class="mt-4 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" v-model="currentTask.status"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="pending">Pending</option>
                            <option value="backlog">Backlog</option>
                            <option value="completed">Complete</option>
                        </select>
                    </div>
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                        <select id="priority" v-model="currentTask.priority"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="lowest">Lowest</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="highest">Highest</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" v-model="currentTask.name"
                        class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" v-model="currentTask.description"
                        class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="closeEditModal"
                        class="px-4 py-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Save
                    </button>
                </div>
            </form>
        </template>
    </Modal>
</template>
