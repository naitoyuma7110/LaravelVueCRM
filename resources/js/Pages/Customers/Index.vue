<script setup>
import Pagenation from '@/Components/Pagenation.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted } from 'vue';

import SearchInput from '@/Components/SearchInput.vue';

const props = defineProps({
  customers: Object
})

onMounted(() => {
  console.log(props.customers)
})
</script>

<template>

  <Head title="顧客一覧" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客一覧</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <section class="text-gray-600 body-font">
            <FlashMessage></FlashMessage>
            <div class="container px-5 py-8 mx-auto">
              <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">顧客一覧</h1>
              </div>
              <div class="flex my-4 lg:w-2/3 w-full mx-auto">
                <SearchInput></SearchInput>
                <Link :href="route('customers.create')" as="button"
                  class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                顧客追加</Link>
              </div>
              <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                <table class="table-auto w-full text-left whitespace-no-wrap">
                  <thead>
                    <tr>
                      <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                        ID</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        氏名
                      </th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        カナ
                      </th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        電話番号
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="customer in customers.data" :key="customer.id">
                      <td class="px-4 py-3">{{ customer.id }}
                      </td>
                      <Link as="button" :href="route('customers.show', { customer: customer.id })"
                        class="px-4 p-3 border-0 focus:outline-none rounded text-sky-600 cursor-pointer underline decoration-sky-500">
                      {{ customer.name }}
                      </Link>
                      <td class="px-4 py-3">{{ customer.kana }}</td>
                      <td class="px-4 py-3">{{ customer.tel }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
        <Pagenation class="mt-6" :links="customers.links"></Pagenation>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
