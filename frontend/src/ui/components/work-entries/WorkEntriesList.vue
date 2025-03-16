<script setup lang="ts">
import type {User} from "@/core/auth/domain/entity/user.ts";
import type {WorkEntry} from "@/core/tracking/domain/entity/work-entry.root.ts";
import Card from "@/ui/components/shared/Card.vue";
import GridTable from "@/ui/components/shared/GridTable.vue";
import CloseIcon from "@/ui/components/shared/icons/CloseIcon.vue";

const emit = defineEmits<{
  (evt: 'delete', entry: WorkEntry): void;
}>()

interface Props {
  user: User;
  entries: WorkEntry[],
}
defineProps<Props>();

const getDayName = (timestamp: number) => {
  const days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
  const date = new Date(timestamp * 1000);

  return `${days[date.getDay()]} ${date.getDate()}`;
};

const formatTime = (timestamp: number | null) => {
  if (!timestamp) {
    return '';
  }

  const date = new Date(timestamp * 1000);

  return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
};
</script>

<template>
  <Card>
    <GridTable :cols="5">
      <template #headers>
        <div class="rounded-tl-lg">Día</div>
        <div>Tipo de fichaje</div>
        <div>Hora entrada</div>
        <div>Hora salida</div>
        <div class="rounded-tr-lg"></div>
      </template>

      <template v-for="entry in entries" :key="entry.id">
        <div>{{ getDayName(entry.start) }}</div>
        <div>Normal</div>
        <div>{{ formatTime(entry.start) }}</div>
        <div>{{ formatTime(entry.end) }}</div>
        <div>
          <CloseIcon class="cursor-pointer" @click="emit('delete', entry)" />
        </div>
      </template>
    </GridTable>
  </Card>
</template>
