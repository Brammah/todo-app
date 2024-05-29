<template>
    <div class="relative">
        <button @click="toggleDropdown"
            class="w-full p-2 text-gray-500 border border-gray-300 rounded-md focus:outline-none text-start focus:ring-2 focus:ring-blue-500">
            {{ selected ? selected.label : placeholder }}
            <i class="absolute text-sm fa fa-chevron-down right-4"></i>
        </button>
        <div v-if="isOpen" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg">
            <ul>
                <li v-for="option in options" :key="option.value" @click="selectOption(option)"
                    class="p-2 cursor-pointer hover:bg-gray-100">
                    <i :class="option.iconClass" class="mr-2"></i>{{ option.label }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        options: {
            type: Array,
            required: true
        },
        placeholder: {
            type: String,
            default: 'Select...'
        }
    },
    data() {
        return {
            isOpen: false,
            selected: null
        };
    },
    methods: {
        toggleDropdown() {
            this.isOpen = !this.isOpen;
        },
        selectOption(option) {
            this.selected = option;
            this.isOpen = false;
            this.$emit('input', option.value);
        }
    }
};
</script>

<style>
/* Add your custom styles here */
</style>
