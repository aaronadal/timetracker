<script setup lang="ts">
import {container} from "@/core/container.ts";
import type { User } from "@/core/auth/domain/entity/user";
import {computed, ref, watch} from "vue";
import NoUsersView from "@/ui/views/NoUsersView.vue";
import UserBar from "@/ui/components/UserBar.vue";
import UserEntriesView from "@/ui/views/UserEntriesView.vue";
import { WorkEntry } from "@/core/tracking/domain/entity/work-entry.root";
import {TimestampProvider} from "@/core/shared/domain/timestamp-provider.ts";

const allUsersQuery = container.get('Auth.User.Query.All')
const users = ref<User[]>([]);
const ready = ref(false);
const currentUser = computed(() => {
  return users.value.slice(-1)[0] || null;
});

const openEntryCommand = container.get('Tracking.WorkEntry.Command.OpenEntry');
const closeEntryCommand = container.get('Tracking.WorkEntry.Command.CloseEntry');
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

function onOpen() {
  if(!currentUser.value) {
    return;
  }

  openEntryCommand.run(currentUser.value.id, TimestampProvider.now());
}

function onClose() {
  if(!currentUser.value) {
    return;
  }

  closeEntryCommand.run(currentUser.value.id, TimestampProvider.now());
}
</script>

<template>
  <template v-if="ready && currentUser">
    <NoUsersView v-if="users.length === 0" />
    <template v-else>
      <UserBar :current-user="currentUser" :entries="userEntries" @open="onOpen" @close="onClose" />
      <UserEntriesView :user="currentUser" :entries="userEntries" />
    </template>
  </template>
</template>
