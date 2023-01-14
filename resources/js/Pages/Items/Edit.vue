<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'



const props = defineProps({
  errors: Object,
  item: Object,
})

const form = reactive({
  id: props.item.id,
  name: props.item.name,
  memo: props.item.memo,
  price: props.item.price,
  is_selling: props.item.is_selling
})

const updateItem = (id) => {
  Inertia.put(route('items.update', {item: id}), form)
}
</script>

<template>
    <Head title="商品編集" />

    <AuthenticatedLayout>
      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品編集</h2>
      </template>

      <section class="text-gray-600 body-font relative">
        <form @submit.prevent="updateItem(form.id)">
          <div class="container px-5 py-8 mx-auto">
            <div class="lg:w-1/2 md:w-2/3 mx-auto">
              <div class="flex flex-wrap -m-2">
                <div class="p-2 w-full">
                  <div class="relative">
                    <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                    <input v-model="form.name" type="text" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  </div>
                </div>
                <InputError class="mt-2" :message="errors.name" />
                <div class="p-2 w-full">
                  <div class="relative">
                    <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                    <textarea v-model="form.memo" id="memo" name="memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                  </div>
                </div>
                <InputError class="mt-2" :message="errors.memo" />
                <div class="p-2 w-full">
                  <div class="relative">
                    <label for="price" class="leading-7 text-sm text-gray-600">価格</label>
                    <input v-model="form.price" type="number" id="price" name="price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  </div>
                </div>
                <InputError class="mt-2" :message="errors.price" />
                <div class="p-2 w-full">
                  <label for="price" class="leading-7 text-sm text-gray-600">ステータス</label>
                  <div class="flex items-center pl-4 border border-gray-200 rounded dark:border-gray-700">
                      <input id="is_selling-1" type="radio" v-model="form.is_selling" value="1"  name="is_selling" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="is_selling-1" class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">販売中</label>
                  </div>
                  <div class="flex items-center pl-4 border border-gray-200 rounded dark:border-gray-700">
                      <input checked id="is_selling-2" type="radio" v-model="form.is_selling" value="2" name="is_selling" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="is_selling-2" class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">停止中</label>
                  </div>
                </div>
                <div class="p-2 w-full">
                  <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
                </div>
              </div>
            </div>
          </div>
        </form>

      </section>
    </AuthenticatedLayout>
</template>
