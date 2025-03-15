<script setup lang="ts">
import {computed, toRefs} from "vue";
import AvatarIcon from "@/ui/components/shared/icons/AvatarIcon.vue";

interface Props {
  name: string
}
const props = defineProps<Props>();
const { name } = toRefs(props);

const letters = computed(() => {
  const words = name.value.split(' ').filter((word: string) => word !== '');
  if(words.length === 0) {
    return '';
  }

  if(words.length === 1) {
    return words[0][0];
  }

  return `${words[0][0]}${words[1][0]}`;
});
</script>

<template>
  <div class="avatar">
    <AvatarIcon class="background" />
    <div class="letters">{{ letters }}</div>
  </div>
</template>
