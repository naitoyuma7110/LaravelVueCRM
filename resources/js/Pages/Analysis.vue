<script setup>
import { getToday } from '@/common';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { onMounted, reactive } from 'vue';
import dayjs from 'dayjs';
import Chart from '@/Components/Chart.vue';
import ResultTable from '@/Components/ResultTable.vue';

const form = reactive({
  startDate: null,
  endDate: null,
  type: 'perDay',
  rfmParams: [
    14, 28, 60, 90, 5, 4, 3, 2, 70000, 50000, 20000, 10000
  ]
})



const data = reactive({
  data: null,
  labels: null,
  totals: null,
  type: null,
  count: null
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
      console.log(res.data);
      data.data = res.data.data
      data.labels = res.data.labels
      data.totals = res.data.totals
      data.type = res.data.type
      data.count = res.data.count
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
            <div class="flex flex-col text-center w-full mb-10">
              <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">データ分析</h1>
            </div>
            <section>
              <h2 class="text-xl font-bold">分析設定</h2>
              <div class="my-8">
                <label for="startDate" class="block text-lg  text-gray-700">
                  方法
                </label>
                <ul
                  class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                      <input v-model="form.type" checked id="type-perDay" type="radio" value="perDay" name="list-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                      <label for="type-perDay"
                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">日別
                      </label>
                    </div>
                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                      <input v-model="form.type" id="type-perMonth" type="radio" value="perMonth" name="list-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                      <label for="type-perMonth"
                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">月別</label>
                    </div>
                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                      <input v-model="form.type" id="type-perYear" type="radio" value="perYear" name="list-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                      <label for="type-perYear"
                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">年別
                      </label>
                    </div>
                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                      <input v-model="form.type" id="type-decil" type="radio" value="decil" name="list-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                      <label for="type-decil"
                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">デシル分析
                      </label>
                    </div>
                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                      <input v-model="form.type" id="type-rfm" type="radio" value="rfm" name="list-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                      <label for="type-rfm"
                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">RFM分析
                      </label>
                    </div>
                  </li>
                </ul>
              </div>

              <form @submit.prevent="">
                <div class="max-w-screen-md grid sm:grid-cols-3 gap-4 mx-auto">
                  <div class="">
                    <label for="startDate" class="block text-lg font-medium text-gray-700">
                      From:
                    </label>
                    <input type="date" name="startDate" autocomplete="given-name"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                      v-model="form.startDate">
                  </div>
                  <div class="">
                    <label for="startDate" class="block text-lg font-medium text-gray-700">
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
              <div v-show="data.data" class="lg:w-2/3 w-full mx-auto overflow-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto my-10">
                  <label for="startDate" class="block text-sm  text-gray-500 text-right">
                    分析データ:{{ data.count }}件
                  </label>
                  <Chart :data="data"></Chart>
                  <ResultTable :data="data"></ResultTable>
                </div>
              </div>
              <div v-if="form.type === 'rfm'">RFM表示</div>
            </section>
          </div>
        </div>
      </div>
    </div>
</AuthenticatedLayout>
</template>
