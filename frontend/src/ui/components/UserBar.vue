<script setup lang="ts">
import Button from "@/ui/components/shared/Button.vue";
import UserSelector from "@/ui/components/UserSelector.vue";

</script>

<template>
  <div class="user-bar">
    <div class="time">
      <div class="done">0h 00min 00s</div>
      /
      <div class="pending">8:00:00</div>
    </div>

    <Button class="action" type="success">Entrar</Button>

    <UserSelector />
  </div>
</template>
