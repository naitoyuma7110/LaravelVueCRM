<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';


const props = defineProps({
  items: Array
})


</script>

<template>

  <Head title="商品一覧" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品一覧</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <section class="text-gray-600 body-font">
            <FlashMessage></FlashMessage>
            <div class="container px-5 py-8 mx-auto">
              <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">商品一覧</h1>
              </div>
              <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
                <Link :href="route('items.create')" as="button"
                  class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                新規追加</Link>
              </div>
              <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                <table class="table-auto w-full text-center whitespace-no-wrap">
                  <thead>
                    <tr>
                      <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                        ID</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名
                      </th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">価格
                      </th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        ステータス</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in items" :key="item.id">
                      <td class="px-4 py-3">
                        {{ item.id }}
                      </td>
                      <td class="px-4 py-3">
                        <Link as="button" :href="route('items.show', { item: item.id })"
                          class="p-2 text-sky-600 cursor-pointer underline decoration-sky-500 border-0 focus:outline-none rounded">
                        {{ item.name }}</Link>
                      </td>
                      <td class="px-4 py-3">{{ item.price }}</td>
                      <td class="px-4 py-3">{{ item.is_selling === 1 ? '販売中' : '停止中' }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
