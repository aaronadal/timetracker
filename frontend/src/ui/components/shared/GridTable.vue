<script setup lang="ts">
import { computed, toRefs } from 'vue'

interface Props {
  cols: 3|5
}
const props = defineProps<Props>()
const { cols } = toRefs(props)

const colsClass = computed(() => {
  switch (cols.value) {
    case 3:
      return 'grid-cols-[auto_auto_min-content]'
    case 5:
      return 'grid-cols-[auto_auto_auto_auto_min-content]'

    default:
      return ''
  }
})
</script>

<template>
  <div class="grid-table" :class="colsClass">
    <div class="headers">
      <slot name="headers" />
    </div>

    <div class="body">
      <slot />
    </div>
  </div>
</template>
