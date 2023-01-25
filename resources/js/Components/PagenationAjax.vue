<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { onMounted, defineEmits } from 'vue';
const props = defineProps({
  links: Array
})

const emit = defineEmits(['pagenation:customers'])

const pagenation = e => {
  emit('pagenation:customers', e)
}
</script>
<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap mb-1">
      <template v-for="(link, index) in links" :key="index">
        <div v-if="link.url === null"
          class="px-3 py-2 ml-0 leading-tight rounded text-gray-500 bg-white border border-gray-300  hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          v-html="link.label">
        </div>
        <div type='button' v-else
          class="px-3 py-2 leading-tight hover:cursor-pointer rounded text-gray-500 bg-white border border-gray-300 hover:bg-gray-100  hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          :class="{ 'bg-blue-700 text-white hover:bg-blue-700 hover:text-white': link.active }"
          @click="pagenation(link.url)" v-html="link.label">
        </div>
      </template>
    </div>
  </div>
</template>
