<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

import { nl2br } from '@/common'

defineProps({
  item: Object
})

const deleteItem = id => {
  Inertia.delete(route('items.destroy', { item: id }), {
    onBefore: () => confirm('本当に削除しますか？')
  })
}

</script>

<template>

  <Head title="商品詳細" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品詳細</h2>
    </template>
    <section class="text-gray-600 body-font ">
      <div class="container px-5 py-8 mx-auto">
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
          <div class="flex flex-wrap -m-2">
            <div class="p-2 w-full">
              <div class="">
                <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                <div
                  class="w-full bg-opacity-50 rounded border border-gray-300   focus:ring-2 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ item.name }}
                </div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="">
                <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                <div v-html="nl2br(item.memo)"
                  class="w-full bg-opacity-50 rounded border border-gray-300   focus:ring-2 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                </div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="">
                <label for="price" class="leading-7 text-sm text-gray-600">価格</label>
                <div
                  class="w-full bg-opacity-50 rounded border border-gray-300   focus:ring-2 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ item.price }}
                </div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="">
                <label for="status" class="leading-7 text-sm text-gray-600">状態</label>
                <div
                  class="w-full bg-opacity-50 rounded border border-gray-300   focus:ring-2 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <span v-if="item.is_selling === 1">販売中</span>
                  <span v-if="item.is_selling === 0">停止中</span>
                </div>
              </div>
            </div>
            <div class="flex">
              <div class="p-2 w-full">
                <Link :href="route('items.edit', { item: item.id })" as="button"
                  class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                編集</Link>
              </div>
              <div class="p-2 w-full">
                <button @click="deleteItem(item.id)"
                  class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AuthenticatedLayout>
</template>
