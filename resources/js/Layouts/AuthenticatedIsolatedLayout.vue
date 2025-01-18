<script setup>
import { ref, watch } from "vue";
import Sidebar from "@/Components/Sidebar.vue";
import flasher from '@flasher/flasher'
import Header from "@/Components/Header.vue";

const messages = ref([]);

defineProps({
    messages: Object,
    title: String,
    breadcrumb: Array,
    description: String
})


watch(messages, (newValue) => {
  flasher.render(newValue);
});

</script>

<template>
    <div class="flex flex-col gap-2 h-svh">
        <Header :title="title" :breadcrumb="breadcrumb" :description="description" :isolated="true"/>
        <div class="flex flex-col items-start justify-start py-3 w-full px-2 max-w-screen-lg mx-auto">
            <slot/>
        </div>
    </div>
</template>
