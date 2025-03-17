<script setup lang="ts">
import { container } from '@/core/container.ts'
import type { User } from '@/core/auth/domain/entity/user'
import { provide, type Ref, ref, watch } from 'vue'
import NoUsersView from '@/ui/views/NoUsersView.vue'
import { WorkEntry } from '@/core/tracking/domain/entity/work-entry.root'
import UserEntriesView from '@/ui/views/UserEntriesView.vue'
import { SET_CURRENT_USER } from '@/ui/injections.ts'

const allUsersQuery = container.get('Auth.User.Query.All')
const users = ref<User[]>([]) as Ref<User[]>
const ready = ref(false)
const currentUser = ref<User | null>(null) as Ref<User | null>
watch(
  users,
  () => setCurrentUser(users.value[0] || null),
  { deep: true },
)

function setCurrentUser(user: User | null): void {
  currentUser.value = user
}

const userEntriesQuery = container.get('Tracking.WorkEntry.Query.AllByUser')
const userEntries = ref<WorkEntry[]>([]) as Ref<WorkEntry[]>

watch(currentUser, () => {
  userEntries.value = []

  const user = currentUser.value
  if (user === null) {
    return
  }

  userEntriesQuery.run(user.id).then((entries) => (userEntries.value = entries))
})

allUsersQuery
  .run()
  .then((response) => (users.value = response))
  .then(() => (ready.value = true))

provide(SET_CURRENT_USER, setCurrentUser)
</script>

<template>
  <template v-if="ready">
    <NoUsersView v-if="users.length === 0" />
    <UserEntriesView
      v-else-if="currentUser"
      :users="users"
      :current-user="currentUser"
      :entries="userEntries"
    />
  </template>
</template>
