<script setup lang="ts">
import type {User} from "@/core/auth/domain/entity/user.ts";
import type {WorkEntry} from "@/core/tracking/domain/entity/work-entry.root.ts";

interface Props {
  user: User;
  entries: WorkEntry[],
}
defineProps<Props>();

</script>

<template>
  <div>
    {{ entries }}
  </div>
</template>
