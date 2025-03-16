<script setup lang="ts">
import {computed, toRefs} from "vue";

interface Props {
  cols: number;
}
const props = defineProps<Props>();
const { cols } = toRefs(props);

const colsClass = computed(() => "grid-cols-[" + "auto_".repeat(cols.value-1) + "min-content]");
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
