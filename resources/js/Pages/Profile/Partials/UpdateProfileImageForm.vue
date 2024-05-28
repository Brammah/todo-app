<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";

const user = usePage().props.auth.user;

const form = useForm({
  photo: null,
});

const initialImageUrl = user.photo ? `/storage/photos/${user.photo}` : null;
const imagePreviewUrl = ref(initialImageUrl);

function handleFileChange(event) {
  form.photo = event.target.files[0];
  if (form.photo) {
    imagePreviewUrl.value = URL.createObjectURL(form.photo);
  }
}

function submit() {
  form.post("/photo");
}
</script>

<template>
     <header>
        <h2 class="text-lg font-medium text-gray-900">Profile Photo</h2>

        <p class="mt-1 text-sm text-gray-600">
            Update your account's profile photo.
        </p>
    </header>

    <form @submit.prevent="submit">
        <div>
        <img
            v-if="imagePreviewUrl"
            :src="imagePreviewUrl"
            class="object-cover w-16 h-16 mt-4 rounded-full"
            alt="Image preview"
        />
            <input class="block w-full my-4 text-sm border rounded-3xl text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" type="file" @change="handleFileChange" >
        </div>
        <div class="flex items-center gap-4 mt-6">
        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
        </div>
    </form>
</template>
