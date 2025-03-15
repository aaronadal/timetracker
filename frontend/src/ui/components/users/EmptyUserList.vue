<script setup lang="ts">
import UserIcon from "@/ui/components/shared/icons/UserIcon.vue";
import Button from "@/ui/components/shared/Button.vue";
import Card from "@/ui/components/shared/Card.vue";

const emit = defineEmits<{
  (evt: 'create'): void,
}>()
</script>

<template>
  <Card class="flex justify-center h-full items-center">
    <div class="content-center flex flex-col items-center gap-4">
      <p class="text-3xl font-bold text-primary">Aún no tienes usuarios creados</p>
      <Button type="primary" @click="emit('create')">
        <UserIcon />
        Crear nuevo
      </Button>
    </div>
  </Card>
</template>
