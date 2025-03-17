<script setup lang="ts">
import Avatar from '@/ui/components/shared/Avatar.vue'
import type { User } from '@/core/auth/domain/entity/user.ts'
import DropdownItem from '@/ui/components/shared/DropdownItem.vue'
import CheckIcon from '@/ui/components/shared/icons/CheckIcon.vue'

interface Props {
  user: User
  active: boolean
}
defineProps<Props>()
</script>

<template>
  <DropdownItem :class="{ active }">
    <template #icon>
      <Avatar :name="user.name" />
    </template>

    <div class="w-full flex justify-between">
      {{ user.name }}

      <CheckIcon v-if="active" />
    </div>
  </DropdownItem>
</template>
