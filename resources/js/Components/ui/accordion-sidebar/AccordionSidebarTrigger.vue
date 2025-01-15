<script setup>
import { cn } from '@/lib/utils';
// import { ChevronDown } from 'lucide-vue-next';
import { Icon } from '@iconify/vue';
import { AccordionHeader, AccordionTrigger } from 'radix-vue';
import { computed } from 'vue';
import { Button } from '../button';

const props = defineProps({
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  class: { type: null, required: false },
});

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;

  return delegated;
});
</script>

<template>
  <AccordionHeader class="flex">
    <AccordionTrigger
      v-bind="delegatedProps"
      :class="
        cn(
          'flex flex-1 items-center justify-between font-medium transition-all [&[data-state=open]>button>iconify-icon]:rotate-180',
          props.class,
        )
      "
    >
        <Button size="lg" variant="ghost" class="block w-full flex flex-row items-center justify-between px-4">
            <div class="w-full flex items-center">
                <slot/>
            </div>
            <slot name="icon">
                <iconify-icon icon="lucide:chevron-down" class="h-4 w-4 shrink-0 transition-transform duration-200"/>
            </slot>
        </Button>
    </AccordionTrigger>
  </AccordionHeader>
</template>
