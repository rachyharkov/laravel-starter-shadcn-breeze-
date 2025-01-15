<script setup>
import { ref, watch } from "vue";
import Sidebar from "@/Components/Sidebar.vue";
import flasher from '@flasher/flasher'

const messages = ref([]);

defineProps({
    messages: Object
})


watch(messages, (newValue) => {
  flasher.render(newValue);
});

</script>

<template>
    <div class="flex flex-row gap-2 h-svh">
        <Sidebar/>
        <div class="flex flex-col items-start justify-start py-3 pe-3 w-full">
            <slot/>
        </div>
    </div>
</template>
