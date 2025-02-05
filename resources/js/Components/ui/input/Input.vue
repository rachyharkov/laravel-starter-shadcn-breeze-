<script setup>
import { cn } from '@/lib/utils';
import { useVModel } from '@vueuse/core';

const props = defineProps({
  defaultValue: { type: [String, Number], required: false },
  modelValue: { type: [String, Number], required: false },
  type: { type: String, required: true },
  placeholder: { type: String, required: true },
  class: { type: null, required: false },
  error: { type: null, required: false }
});

const emits = defineEmits(['update:modelValue']);

const modelValue = useVModel(props, 'modelValue', emits, {
  passive: true,
  defaultValue: props.defaultValue,
});
</script>

<template>
    <div class="flex flex-col">
        <input
          v-model="modelValue"
          :type="type"
          :placeholder="placeholder"
          :class="
            cn(
              'flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',error && 'border-red-600 dark:border-red-800',props.class,
            )
          "
        />
        <p class="text-xs text-red-600 dark:text-red-800" v-if="error">{{ error }}</p>
    </div>
</template>
