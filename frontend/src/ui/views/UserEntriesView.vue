<script setup lang="ts">
import type { User } from '@/core/auth/domain/entity/user';
import type { WorkEntry } from '@/core/tracking/domain/entity/work-entry.root';
import UserBar from '../components/UserBar.vue';
import WorkEntriesList from '../components/work-entries/WorkEntriesList.vue';
import { toRefs } from 'vue';
import { container } from '@/core/container';
import {TimestampProvider} from "@/core/shared/domain/timestamp-provider.ts";

interface Props {
  currentUser: User;
  entries: WorkEntry[],
}
const props = defineProps<Props>();
const { currentUser } = toRefs(props);

const openEntryCommand = container.get('Tracking.WorkEntry.Command.OpenEntry');
const closeEntryCommand = container.get('Tracking.WorkEntry.Command.CloseEntry');
const deleteEntryCommand = container.get('Tracking.WorkEntry.Command.DeleteEntry');

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

function onDelete(entry: WorkEntry): void {
  deleteEntryCommand.run(entry.user, entry.id);
}
</script>

<template>
    <div class="grid grid-rows-[auto_1fr] gap-3">
        <UserBar :current-user="currentUser" :entries="entries" @open="onOpen" @close="onClose" />
        <WorkEntriesList :user="currentUser" :entries="entries" @delete="onDelete" />
    </div>
</template>

<style lang="css" scoped>

</style>
