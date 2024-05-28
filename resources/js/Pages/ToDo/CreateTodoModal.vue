<template>
    <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <button @click="closeModal" class="absolute text-gray-500 top-4 right-4 hover:text-gray-700" aria-label="Close modal">
                <i class="fa fa-times"></i>
            </button>
            <h2 id="modal-title" class="text-lg font-semibold">Create Task</h2>
            <form @submit.prevent="createTask" class="mt-4 space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" v-model="newTask.name" class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" v-model="newTask.description" class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" v-model="newTask.status" class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="pending">Pending</option>
                            <option value="backlog">Backlog</option>
                            <option value="complete">Complete</option>
                        </select>
                    </div>
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                        <select id="priority" v-model="newTask.priority" class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="lowest">Lowest</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="highest">Highest</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="closeModal" class="px-4 py-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:ring-1">Create</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isOpen: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
            newTask: {
                name: '',
                description: '',
                status: 'pending',
                priority: 'medium',
            },
        };
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        async createTask() {
            try {
                await axios.post('/task', this.newTask);
                this.$emit('taskCreated');
                this.closeModal();
            } catch (error) {
                console.error('Error creating task:', error);
            }
        },
    },
};
</script>

<style scoped>
.fixed {
    display: flex;
    align-items: center;
    justify-content: center;
}
.bg-black {
    background-color: rgba(0, 0, 0, 0.5);
}
.bg-white {
    background-color: white;
}
.rounded-lg {
    border-radius: 0.5rem;
}
.shadow-lg {
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}
.absolute {
    position: absolute;
}
.top-4 {
    top: 1rem;
}
.right-4 {
    right: 1rem;
}
.text-gray-500 {
    color: #6b7280;
}
.text-gray-700 {
    color: #374151;
}
.hover\:text-gray-700:hover {
    color: #374151;
}
</style>
