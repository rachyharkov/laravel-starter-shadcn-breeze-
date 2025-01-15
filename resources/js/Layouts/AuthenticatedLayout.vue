<script setup>
import { ref } from "vue";
import Sidebar from "@/Components/Sidebar.vue";
const showSidebar = ref(false);


const toggleSidebar = () => {
    showSidebar.value = !showSidebar.value;
};

defineExpose({ toggleSidebar });
</script>

<template>
    <div class="flex flex-row gap-2 h-svh">
        <Sidebar :is-shown="showSidebar"/>
        <div class="flex flex-col items-start justify-start py-3 pe-3 w-full">
            <slot/>
        </div>
    </div>
</template>
