<script setup lang="ts">
import Avatar from '@/ui/components/shared/Avatar.vue'
import type { User } from '@/core/auth/domain/entity/user.ts'
import ChevronDownIcon from '@/ui/components/shared/icons/ChevronDownIcon.vue'
import { inject, ref } from 'vue'
import Dropdown from '@/ui/components/shared/Dropdown.vue'
import DropdownItem from '@/ui/components/shared/DropdownItem.vue'
import AddIcon from '@/ui/components/shared/icons/AddIcon.vue'
import CreateUserModal from '@/ui/components/users/CreateUserModal.vue'
import UserSelectorItem from '@/ui/components/UserSelectorItem.vue'
import { SET_CURRENT_USER } from '@/ui/injections'

interface Props {
  users: User[]
  currentUser: User
}

defineProps<Props>()

const shift = 6
const triggerRef = ref<HTMLDivElement | null>(null)
const open = ref(false)
const showCreateUserModal = ref(false)

const setCurrentUser = inject(SET_CURRENT_USER, () => {}) as (user: User) => void

function onUserSelected(user: User): void {
  open.value = false
  setCurrentUser(user)
}

function dropdownTop(): string {
  if (!triggerRef.value) {
    return '0'
  }

  return `${triggerRef.value.offsetTop + triggerRef.value.offsetHeight + shift}px`
}

function dropdownRight(): string {
  if (!triggerRef.value) {
    return '0'
  }

  return `${window.innerWidth - (triggerRef.value.offsetLeft + triggerRef.value.offsetWidth + shift)}px`
}
</script>

<template>
  <div class="user-selector">
    <div class="selected" @click="open = true" ref="triggerRef">
      <Avatar :name="currentUser.name" />
      <div class="name">{{ currentUser.name }}</div>
      <ChevronDownIcon />
    </div>

    <teleport to="#modals">
      <Dropdown v-if="open" @dismiss="open = false" :top="dropdownTop()" :right="dropdownRight()">
        <UserSelectorItem
          v-for="user in users"
          :key="user.id"
          :user="user"
          :active="users.length > 1 && user.id === currentUser.id"
          @click="onUserSelected(user)"
        />

        <DropdownItem
          @click="
            () => {
              open = false
              showCreateUserModal = true
            }
          "
        >
          <template #icon>
            <AddIcon />
            Crear nuevo
          </template>
        </DropdownItem>
      </Dropdown>
    </teleport>

    <CreateUserModal @dismiss="showCreateUserModal = false" v-if="showCreateUserModal" />
  </div>
</template>
