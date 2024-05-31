<template>
    <div>
        <a :href="googleLoginUrl" class="relative px-3 py-2 mr-0 text-sm font-bold bg-white rounded-lg md:px-5 lg:text-white sm:mr-3 md:mt-0">
            <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" alt="Google Sign In">
        </a>
    </div>
</template>

<script>
export default {
    data() {
        return {
            googleLoginUrl: '/login/google',
        };
    },
};
</script>
