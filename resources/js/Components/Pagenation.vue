<script setup>
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
  links: Array
})
</script>
<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap mb-1">
      <template v-for="(link, index) in links" :key="index">
        <div v-if="link.url === null" 
        class="px-3 py-2 ml-0 leading-tight rounded text-gray-500 bg-white border border-gray-300  hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
        v-html="link.label">
        </div>
        <Link v-else
          class="px-3 py-2 leading-tight rounded text-gray-500 bg-white border border-gray-300 hover:bg-gray-100  hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          :class="{'bg-blue-700 text-white': link.active }"
          :href="link.url"
          v-html="link.label">
        </Link>
      </template>
    </div>
  </div>
</template>