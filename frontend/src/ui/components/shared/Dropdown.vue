<script setup lang="ts">
import Card from "@/ui/components/shared/Card.vue";
import CloseIcon from "@/ui/components/shared/icons/CloseIcon.vue";

const emit = defineEmits<{
  (evt: 'dismiss'): void,
}>();

interface Props {
  top: string;
  right: string;
}
defineProps<Props>();
</script>

<template>
  <div class="dropdown">
    <div class="backdrop" @click="emit('dismiss')" />

    <Card class="absolute" :style="{top, right}">
      <div class="dropdown-content">
        <slot />
      </div>
    </Card>
  </div>
</template>
