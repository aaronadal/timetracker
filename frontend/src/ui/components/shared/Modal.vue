<script setup lang="ts">
import Card from '@/ui/components/shared/Card.vue'
import CloseIcon from '@/ui/components/shared/icons/CloseIcon.vue'

const emit = defineEmits<{
  (evt: 'dismiss'): void
}>()
</script>

<template>
  <div class="modal">
    <div class="backdrop" />

    <Card>
      <template #header>
        <slot name="header" />
        <CloseIcon class="cursor-pointer" @click="emit('dismiss')" />
      </template>

      <slot />

      <template #footer>
        <slot name="footer" />
      </template>
    </Card>
  </div>
</template>
