<script setup>
import Pagenation from '@/Components/Pagenation.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import SearchInput from '@/Components/SearchInput.vue';

import { onMounted } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import dayjs from "dayjs"

const props = defineProps({
  orders: {
    type: Object
  }
})
onMounted(() => {
  console.log(props.orders.data)
})
</script>
<template>

  <Head title="購買履歴" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">購入履歴</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <section class="text-gray-600 body-font">
            <div class="container px-5 py-8 mx-auto">
              <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">購入履歴</h1>
              </div>
              <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                <SearchInput></SearchInput>
                <table class="table-auto my-2 w-full text-center whitespace-no-wrap">
                  <thead>
                    <tr>
                      <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                        ID</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        購入金額
                      </th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        ステータス
                      </th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        購入日
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="order in orders.data" :key="order.id">
                      <td class="px-4 py-3 border-b-2 ">
                        <Link :href="route('purchases.show', { purchase: order.id })" as="button"
                          class="p-2 text-sky-600 cursor-pointer underline decoration-sky-500">
                        {{ order.id }}</Link>
                      </td>
                      <td class="px-4 py-3 border-b-2">{{ order.total }}</td>
                      <td class="px-4 py-3 border-b-2">{{ order.status }}</td>
                      <td class="px-4 py-3 border-b-2">{{ dayjs(order.created_at).format('YYYY-MM-DD HH:mm:ss') }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
        <Pagenation class="mt-6" :links="orders.links"></Pagenation>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
