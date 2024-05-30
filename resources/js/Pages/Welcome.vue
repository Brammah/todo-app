<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>

    <Head title="Welcome" />
    <header class="relative z-50 w-full h-24">
        <div
            class="container flex items-center justify-center h-full max-w-6xl px-8 mx-auto sm:justify-between xl:px-0">
            <a href="/" class="relative flex items-center h-full font-black leading-none">
                <span class="ml-3 text-xl text-blue-800">TaskManager</span>
            </a>

            <div
                class="absolute left-0 flex-col items-center justify-center hidden w-full pb-8 mt-48 border-b border-blue-200 md:relative md:w-auto md:bg-transparent md:border-none md:mt-0 md:flex-row md:p-0 md:items-end md:flex md:justify-between">
                <a href="/login"
                    class="relative z-40 px-3 py-2 mr-0 text-sm font-bold bg-black rounded-md md:px-5 lg:text-white sm:mr-3 md:mt-0">Login</a>
                <a href="/register"
                    class="relative z-40 inline-block w-auto h-full px-5 py-3 text-sm font-bold leading-none transition-all duration-300 bg-blue-600 rounded shadow-md text-blue fold-bold lg:bg-blue lg:text-white sm:w-full lg:shadow-none hover:shadow-xl">
                    Get Started
                </a>
            </div>
        </div>
    </header>

    <div class="relative items-center justify-center w-full overflow-x-hidden lg:pt-20 lg:pb-20 xl:pt-20 xl:pb-20">
        <div
            class="container flex flex-col items-center justify-between h-full max-w-6xl px-8 mx-auto -mt-32 lg:flex-row xl:px-0">
            <div
                class="z-30 flex flex-col items-center w-full max-w-xl text-center pt-36 lg:items-start lg:w-1/2 lg:pt-20 xl:pt-40 lg:text-left">
                <h1 class="relative mb-2 text-3xl font-bold leading-tight text-gray-900 text-start sm:text-6xl xl:mb-8">
                    Simplify Your
                </h1>
                <h1 class="relative mb-2 text-3xl font-bold leading-tight text-gray-900 text-start sm:text-6xl xl:mb-8">
                    Workflow with
                </h1>
                <h1 class="relative mb-2 text-3xl font-bold leading-tight text-gray-900 text-start sm:text-6xl xl:mb-8">
                    TaskManager
                </h1>
                <p class="pr-0 mb-8 text-base text-gray-600 sm:text-lg xl:text-xl lg:pr-20">
                    Welcome to TaskManager, your ultimate solution for efficient task management. Designed individuals,
                    TaskManager streamlines your projects, deadlines and daily to-dos with intuitive features and
                    seamless integration. Boost your productivity, stay organized and achieve more with less effort. Try
                    TraskManager today and transform the way you work.
                </p>
                <a href="/register"
                    class="relative self-start inline-block w-auto px-8 py-4 mx-auto mt-0 text-base font-bold text-white bg-blue-600 border-t border-gray-200 rounded-md shadow-xl sm:mt-1 fold-bold lg:mx-0">
                    Get Started
                </a>

                <div class="flex-col hidden mt-12 sm:flex lg:mt-24">
                    <p class="mb-4 text-sm font-medium tracking-widest text-gray-500">&copy; TaskManager
                        {{ new Date().getFullYear() }}
                    </p>
                </div>

            </div>
            <div class="relative z-50 flex flex-col items-end justify-center w-full h-full lg:w-1/2 ms:pl-8">
                <div class="container relative left-0 w-full max-w-4xl lg:absolute xl:max-w-6xl lg:w-screen">
                    <img src='images/bluebookhero.svg'
                        class="w-full h-auto mt-20 mb-20 ml-0 lg:mt-24 xl:mt-40 lg:mb-0 lg:h-full lg:-ml-12">
                </div>
            </div>
        </div>
    </div>
</template>
