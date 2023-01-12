<script setup>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

defineProps({
  errors:Object
})



const form = reactive({
  title:null,
  content: null
})


const submit = () => {
  Inertia.post('/inertia', form)
}


</script>
<template>
  <form @submit.prevent="submit">
    <label for="first_name">Title:</label>
    <input id="first_name" v-model="form.title" /><br>
    <div v-if="errors">{{ errors.title }}</div>

    <label for="last_name">Content:</label>
    <input id="last_name" v-model="form.content" /><br>
    <div v-if="errors">{{ errors.content }}</div>

    <button>Submit</button>
  </form>
</template>