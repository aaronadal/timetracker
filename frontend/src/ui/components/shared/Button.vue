<script setup lang="ts">
interface Props {
  type: 'primary'|'tertiary';
}

defineProps<Props>();
</script>

<template>
  <a :class="`button-${type}`">
    <slot />
  </a>
</template>
