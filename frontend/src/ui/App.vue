<script setup lang="ts">
import {container} from "@/core/container.ts";
import type { User } from "@/core/auth/domain/entity/user";
import { ref } from "vue";
import NoUsersView from "@/ui/views/NoUsersView.vue";

const query = container.get('Auth.User.Query.All')
const users = ref<User[]>([]);
const ready = ref(false);

query.run()
  .then((response) => users.value = response)
  .then(() => ready.value = true);
</script>

<template>
  <template v-if="ready">
    <NoUsersView v-if="users.length === 0" />
  </template>
</template>
