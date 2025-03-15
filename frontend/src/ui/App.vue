<script setup lang="ts">
import {container} from "@/core/container.ts";
import type { User } from "@/core/auth/domain/entity/user";
import {computed, provide, ref} from "vue";
import NoUsersView from "@/ui/views/NoUsersView.vue";
import UserBar from "@/ui/components/UserBar.vue";
import {CURRENT_USER} from "@/ui/injections.ts";

const query = container.get('Auth.User.Query.All')
const users = ref<User[]>([]);
const ready = ref(false);

const currentUser = computed(() => {
  return users.value.slice(-1)[0] || undefined;
});

query.run()
  .then((response) => users.value = response)
  .then(() => ready.value = true);

provide(CURRENT_USER, currentUser);
</script>

<template>
  <template v-if="ready">
    <NoUsersView v-if="users.length === 0" />
    <template v-else>
      <UserBar />
    </template>
  </template>
</template>
