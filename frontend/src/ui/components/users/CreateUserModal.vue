<script setup lang="ts">
import Modal from '@/ui/components/shared/Modal.vue'
import Button from '@/ui/components/shared/Button.vue'
import TextInput from '@/ui/components/shared/TextInput.vue'
import { ref } from 'vue'
import { container } from '@/core/container.ts'
import type { User } from '@/core/auth/domain/entity/user.ts'

const emit = defineEmits<{
  (evt: 'dismiss'): void
  (evt: 'created', user: User): void
}>()

const command = container.get('Auth.User.Command.SignUp')
const name = ref('')

async function onCreate(): Promise<void> {
  command
    .run(name.value)
    .then((user: User) => emit('created', user))
    .then(() => emit('dismiss'))
}
</script>

<template>
  <teleport to="#modals">
    <Modal @dismiss="emit('dismiss')">
      <template #header>Crear usuario</template>

      <TextInput v-model="name" name="name" label="Nombre usuario" />

      <template #footer>
        <div class="flex w-full gap-3">
          <Button class="basis-1/2 text-lg" type="tertiary" @click="emit('dismiss')"
            >Cancelar</Button
          >
          <Button class="basis-1/2 text-lg" type="primary" @click="onCreate">Crear</Button>
        </div>
      </template>
    </Modal>
  </teleport>
</template>
