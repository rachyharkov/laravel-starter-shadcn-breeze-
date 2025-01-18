<script setup>
import { cn } from '@/lib/utils';
import { SelectIcon, SelectTrigger, useForwardProps } from 'radix-vue';
import { computed } from 'vue';

const props = defineProps({
  disabled: { type: Boolean, required: false },
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  class: { type: null, required: false },
  error: { type: null, required: false }
});

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;

  return delegated;
});

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
    <div class="flex flex-col">
        <SelectTrigger
          v-bind="forwardedProps"
          :class="
            cn(
              'flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background data-[placeholder]:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 [&>span]:truncate text-start',
              props.class,
              error && 'border-red-600 dark:border-red-800'
            )
          "
        >
          <slot />
          <SelectIcon as-child>
              <iconify-icon icon="lucide:chevron-down" class="w-4 h-4 opacity-50 shrink-0"/>
          </SelectIcon>
        </SelectTrigger>
        <p class="text-xs text-red-600 dark:text-red-800" v-if="error">{{ error }}</p>
    </div>
</template>
