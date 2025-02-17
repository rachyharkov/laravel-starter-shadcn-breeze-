<script setup>
import { ref, watch } from "vue";
import Sidebar from "@/Components/Sidebar.vue";
import flasher from '@flasher/flasher'

const flash = ref([]);

defineProps({
    flash: Object
})


watch(flash, (newValue) => {
  flasher.render(newValue);
}, {
    immediate: true,
    deep: true
});



</script>

<template>
    <div class="flex flex-row gap-2 h-svh">
        <Sidebar/>
        <div class="flex flex-col items-start justify-start pb-3 w-full overflow-y-scroll ps-2 pe-5">
            <slot/>
        </div>
    </div>
    <toaster></toaster>
</template>
