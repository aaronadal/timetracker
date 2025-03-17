<script setup lang="ts">
import {computed, toRefs} from "vue";

interface Props {
  type: 'primary' | 'tertiary' | 'success' | 'error'
}

const props = defineProps<Props>()
const { type } = toRefs(props)

const classname = computed(() => {
  switch (type.value) {
    case "primary":
      return "button-primary"
    case "tertiary":
      return "button-tertiary"
    case "success":
      return "button-success"
    case "error":
      return "button-error"

    default:
      return ''
  }
})
</script>

<template>
  <a :class="classname">
    <slot />
  </a>
</template>
