<script setup lang="ts">
import UserIcon from "@/ui/components/shared/icons/UserIcon.vue";
import Button from "@/ui/components/shared/Button.vue";
import Card from "@/ui/components/shared/Card.vue";

const emit = defineEmits<{
  (evt: 'create'): void,
}>()
</script>

<template>
  <Card>
    <div class="content-center flex flex-col h-full justify-center items-center gap-4">
      <p class="text-3xl font-bold text-primary">Aún no tienes usuarios creados</p>
      <Button class="text-lg" type="primary" @click="emit('create')">
        <UserIcon />
        Crear nuevo
      </Button>
    </div>
  </Card>
</template>
