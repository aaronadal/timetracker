<script setup lang="ts">
import {toRefs} from "vue";
import {useModelValue} from "@/ui/composables/ModelValue.ts";

const emit = defineEmits<{
  (event: "update:modelValue", modelValue?: string): void;
}>();

interface Props {
  modelValue?: string;
  name: string;
  label?: string;
}

const props = defineProps<Props>();
const { modelValue: rawModelValue } = toRefs(props);

const modelValue = useModelValue(rawModelValue, emit, "update:modelValue");
</script>

<template>
  <div class="input-text">
    <label v-if="label">{{ label }}</label>
    <input v-model="modelValue" :name="name" type="text" />
  </div>
</template>
