<template>
    <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
            <button @click="closeModal" class="absolute text-gray-500 top-4 right-4 hover:text-gray-700">
                <i class="fa fa-times"></i>
            </button>
            <slot></slot>
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
    methods: {
        closeModal() {
            this.$emit('close');
        },
    },
};
</script>
