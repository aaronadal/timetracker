<script setup lang="ts">
import {container} from "@/core/container.ts";
import type { User } from "@/core/auth/domain/entity/user";
import {computed, ref, watch} from "vue";
import NoUsersView from "@/ui/views/NoUsersView.vue";
import { WorkEntry } from "@/core/tracking/domain/entity/work-entry.root";
import UserEntriesView from "@/ui/views/UserEntriesView.vue";

const allUsersQuery = container.get('Auth.User.Query.All')
const users = ref<User[]>([]);
const ready = ref(false);
const currentUser = computed(() => {
  return users.value.slice(-1)[0] || null;
});

const userEntriesQuery = container.get('Tracking.WorkEntry.Query.AllByUser');
const userEntries = ref<WorkEntry[]>([]);

watch(currentUser, () => {
  userEntries.value = [];

  const user = currentUser.value;
  if(user === null) {
    return
  }

  userEntriesQuery.run(user.id)
    .then((entries) => userEntries.value = entries);
});

allUsersQuery.run()
  .then((response) => users.value = response)
  .then(() => ready.value = true);
</script>

<template>
  <template v-if="ready && currentUser">
    <NoUsersView v-if="users.length === 0" />
    <UserEntriesView v-else :current-user="currentUser" :entries="userEntries" />
  </template>
</template>
