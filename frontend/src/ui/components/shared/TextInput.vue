<script setup lang="ts">
import { toRefs } from 'vue'
import { useModelValue } from '@/ui/composables/ModelValue.ts'

const emit = defineEmits<{
  (event: 'update:modelValue', modelValue?: string): void
}>()

interface Props {
  modelValue?: string
  name: string
  label?: string
}

const props = defineProps<Props>()
const { modelValue } = toRefs(props)

const modelValueProxy = useModelValue(modelValue, emit, 'update:modelValue')
</script>

<template>
  <div class="input-text">
    <label v-if="label">{{ label }}</label>
    <input v-model="modelValueProxy" :name="name" type="text" />
  </div>
</template>
