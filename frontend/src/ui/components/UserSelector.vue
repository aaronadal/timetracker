<script setup lang="ts">
import Avatar from "@/ui/components/shared/Avatar.vue";
import type {User} from "@/core/auth/domain/entity/user.ts";

interface Props {
  currentUser: User;
}
defineProps<Props>();
</script>

<template>
  <div class="user-selector">
    <Avatar :name="currentUser.name" />
    <div class="name">{{ currentUser.name }}</div>
  </div>
</template>
