<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia';

const search = ref('')
const searchCustomers = () => {
  Inertia.get(route('customers.index', { search: search.value }))
}


</script>

<template>
  <div>
    <input type="text" name="search" v-model="search" class="py-2 mr-1 rounded">
    <button class=" py-2 px-6 text-white bg-blue-400 border-0 rounded focus:outline-none hover:bg-blue-500"
      @click="searchCustomers">検索</button>
  </div>
</template>