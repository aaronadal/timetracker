<script setup lang="ts">
import Avatar from "@/ui/components/shared/Avatar.vue";
import type {User} from "@/core/auth/domain/entity/user.ts";
import {inject} from "vue";
import {CURRENT_USER} from "@/ui/injections.ts";

const user = inject<User|undefined>(CURRENT_USER);
</script>

<template>
  <div class="user-selector" v-if="user">
    <Avatar :name="user.name" />
    <div class="name">{{ user.name }}</div>
  </div>
</template>
