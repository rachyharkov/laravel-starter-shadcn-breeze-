<script setup>
import { cn } from '@/lib/utils';
// import { ChevronRight } from 'lucide-vue-next';
import { Icon } from '@iconify/vue';

const props = defineProps({
  class: { type: null, required: false },
});
</script>

<template>
  <li
    role="presentation"
    aria-hidden="true"
    :class="cn('[&>svg]:w-3.5 [&>svg]:h-3.5', props.class)"
  >
    <slot>
        <iconify-icon icon="lucide:chevron-right"/>
    </slot>
  </li>
</template>
