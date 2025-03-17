<script setup lang="ts">
import EmptyUserList from '@/ui/components/users/EmptyUserList.vue'
import CreateUserModal from '@/ui/components/users/CreateUserModal.vue'
import { ref } from 'vue'

const showCreateUserModal = ref(false)
</script>

<template>
  <EmptyUserList @create="showCreateUserModal = true" />
  <CreateUserModal @dismiss="showCreateUserModal = false" v-if="showCreateUserModal" />
</template>
