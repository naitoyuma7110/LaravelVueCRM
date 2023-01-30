<script setup>
import { getToday } from '@/common';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { onMounted, reactive } from 'vue';


const form = reactive({
  startDate: null,
  endDate: null,
  type: 'perDay'
})



onMounted(() => {
  form.startDate = getToday()
  form.endDate = getToday()
})

const analysisByToFrom = async () => {
  try {
    await axios.get(route('api.analysis'), {
      // await axios.get('/api/analysis', {
      params: {
        startDate: form.startDate,
        endDate: form.endDate,
        type: form.type
      }
    }).then((res) => {
      console.log(res);
    })

  } catch (e) {
    e.message
  }
}

</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">データ分析</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <section>
              <form @submit.prevent="">
                <div class="max-w-screen-md grid sm:grid-cols-3 gap-4 mx-auto">
                  <div class="">
                    <label for="startDate" class="block text-sm font-medium text-gray-700">
                      From:
                    </label>
                    <input type="date" name="startDate" autocomplete="given-name"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                      v-model="form.startDate">
                  </div>
                  <div class="">
                    <label for="startDate" class="block text-sm font-medium text-gray-700">
                      To:
                    </label>
                    <input type="date" name="startDate" autocomplete="given-name"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                      v-model="form.endDate">
                  </div>
                  <div class="flex items-end">
                    <button type="button" @click="analysisByToFrom"
                      class="align-item-end py-2 px-6 text-white bg-blue-400 border-0 rounded focus:outline-none hover:bg-blue-500">分析する</button>
                  </div>
                </div>
              </form>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
