<script setup lang="ts">
import Button from "@/ui/components/shared/Button.vue";
import UserSelector from "@/ui/components/UserSelector.vue";
import type {WorkEntry} from "@/core/tracking/domain/entity/work-entry.root.ts";
import {computed, ref, toRefs} from "vue";
import type {User} from "@/core/auth/domain/entity/user.ts";
import {APP_CONFIG} from "@/config/app.config.ts";

const emit = defineEmits<{
  (evt: 'open'): void
  (evt: 'close'): void
}>()

interface Props {
  users: User[],
  currentUser: User,
  entries: WorkEntry[],
}
const props = defineProps<Props>();
const { entries } = toRefs(props);

const openEntry = computed(() => entries.value.find((entry) => entry.end === null));

const now = ref(0);
setInterval(() => now.value = Math.floor(new Date().getTime() / 1000));

const secondsFinished = computed(() => {
  let time = 0;
  for (const entry of entries.value) {
    if(!entry.end) {
      continue;
    }

    time += (entry.end - entry.start);
  }

  return time;
});

const secondsDone = computed(() => {
  if(!openEntry.value) {
    return secondsFinished.value
  }

  return secondsFinished.value + (now.value - openEntry.value.start);
});

const pendingSeconds = computed(() => APP_CONFIG.WORKING_DAY_SECONDS - secondsDone.value);

const done = computed(() => {
  const value = new Date(secondsDone.value * 1000).toISOString().slice(11, 19);
  const parts = value.split(':');

  return `${parts[0]}h ${parts[1].padStart(2, '0')}min ${parts[2].padStart(2, '0')}s`;
})
const pending = computed(() => new Date(pendingSeconds.value * 1000).toISOString().slice(11, 19));
</script>

<template>
  <div class="user-bar">
    <div class="time">
      <div class="done">{{ done }}</div>
      /
      <div class="pending">{{ pending }}</div>
    </div>

    <Button v-if="openEntry" class="action" type="error" @click="emit('close')">Salir</Button>
    <Button v-else class="action" type="success" @click="emit('open')">Entrar</Button>

    <UserSelector :users="users" :currentUser="currentUser" />
  </div>
</template>
