<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";
import { onMounted, reactive, ref, computed } from "vue";
import dayjs from "dayjs"

const props = defineProps({
  order: {
    type: Object
  },
  items: {
    type: Object
  }
})
onMounted(() => {
  console.log(props.order[0])
  console.log(props.items)
})
</script>

<template>

  <Head title="商品購入" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品購入</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

          <section class="text-gray-600 body-font ">
            <div class="container px-5 py-8 mx-auto">
              <div class="lg:w-1/2 md:w-2/3 mx-auto">
                <div class="p-2 w-full">
                  <div>
                    <label for="name" class="leading-7 text-sm text-gray-600">会員名</label>
                    <div class="w-full rounded text-lg">{{ props.order[0].customer_name }}</div>
                  </div>
                </div>
                <div class="p-2 w-full">
                  <div>
                    <label for="date" class="leading-7 text-sm text-gray-600">購入日</label>
                    <div class="w-full rounded text-lg ">
                      {{ dayjs(props.order[0].created_at).format('YYYY-MM-DD') }}
                    </div>
                  </div>
                </div>
                <div class="p-2 w-full">
                  <div>
                    <label for="status" class="leading-7 text-sm text-gray-600">ステータス</label>
                    <div class="w-full rounded text-lg ">
                      {{ props.order[0].status === 1 ? "未キャンセル" : `キャンセル : ${dayjs(props.order[0].updated_at).format('YYYY-MM-DD')}` }}
                    </div>
                  </div>
                </div>
                <div class="w-full p-2">
                  <table class="w-full text-center text-gray-600 dark:text-gray-400">
                    <thead>
                      <tr class="h-10 bg-gray-500  text-white">
                        <th>ID</th>
                        <th>商品名</th>
                        <th>値段</th>
                        <th>数量</th>
                        <th>小計</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in items" :key="item.id"
                        class="bg-white border-b h-12 dark:bg-gray-800 dark:border-gray-700">
                        <td>{{ item.item_id }}</td>
                        <td>{{ item.item_name }}</td>
                        <td>{{ item.item_price }}</td>
                        <td>{{ item.quantity }}</td>
                        <td>{{ item.subtotal }}</td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="w-full text-lg text-right my-2 py-2 pr-4 border rounded border-gray-300">
                    合計金額：{{ props.order[0].total }}
                  </div>
                </div>
              </div>
              <div class="p-2 w-full flex justify-center">
                <Link v-if="props.order[0].status" type="button"
                  :href="route('purchases.edit', { purchase: props.order[0].id })"
                  class=" text-white bg-sky-500 border-0 py-2 px-8 focus:outline-none hover:bg-sky-600 rounded text-lg">
                編集</Link>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>



