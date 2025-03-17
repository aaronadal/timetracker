<script setup lang="ts">
import { useSlots } from 'vue'

const slots = useSlots()
</script>

<template>
  <div class="card">
    <div v-if="slots.header" class="header">
      <slot name="header" />
    </div>

    <div class="card-content">
      <slot />
    </div>

    <div v-if="slots.footer" class="footer">
      <slot name="footer" />
    </div>
  </div>
</template>
