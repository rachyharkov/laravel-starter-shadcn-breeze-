<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center pt-6 sm:justify-center sm:pt-0"
    >

        <slot />

        <!-- <div
            class="mt-6  bg-white px-6 py-4 shadow-md sm:rounded-lg"
        >
        </div> -->
    </div>
</template>
