<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { Core as YubinBangoCore } from "yubinbango-core2";

defineProps({
  errors: Object,
})


const form = reactive({
  name: null,
  kana: null,
  tel: null,
  email: null,
  postcode: null,
  address: null,
  birthday: null,
  gender: null,
  memo: null
})

const searchAddress = () => {
  new YubinBangoCore(String(form.postcode), (value) => {
    form.address = value.region + value.locality + value.street
  });
};

const storeCustomers = () => {
  Inertia.post('/customers', form)
}
</script>

<template>

  <Head title="顧客登録" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客登録</h2>
    </template>

    <section class="text-gray-600 body-font relative">
      <form @submit.prevent="storeItem">
        <div class="container px-5 py-8 mx-auto">
          <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="name" class="leading-7 text-sm text-gray-600">顧客名</label>
                  <input v-model="form.name" type="text" id="name" name="name"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
              </div>
              <InputError class="mt-2" :message="errors.name" />
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="name" class="leading-7 text-sm text-gray-600">フリカナ</label>
                  <input v-model="form.kana" type="text" id="kana" name="kana"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
              </div>
              <InputError class="mt-2" :message="errors.kana" />
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                  <input v-model="form.tel" type="number" id="tel" name="tel"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
              </div>
              <InputError class="mt-2" :message="errors.tel" />
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                  <input v-model="form.email" type="email" id="email" name="email"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
              </div>
              <InputError class="mt-2" :message="errors.email" />
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label>
                  <div>
                    <input v-model="form.postcode" type="text" id="postcode" name="postcode"
                      class=" bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    <button
                      class=" py-2 px-6 text-white bg-blue-400 border-0 rounded focus:outline-none hover:bg-blue-500"
                      @click="searchAddress">住所検索</button>
                  </div>
                </div>
              </div>
              <InputError class="mt-2" :message="postCodeErrorMessage" />
              <InputError class="mt-2" :message="errors.postcode" />
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                  <input v-model="form.address" type="text" id="address" name="address"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
              </div>
              <InputError class="mt-2" :message="errors.address" />
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="birthday" class="leading-7 text-sm text-gray-600">誕生日</label>
                  <input v-model="form.birthday" type="date" id="birthday" name="birthday"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
              </div>
              <InputError class="mt-2" :message="errors.birthday" />
              <div class="p-2 w-full">
                <label for="gender" class="leading-7 text-sm text-gray-600">性別</label>
                <div class="flex">
                  <div class="flex items-center px-4 border border-gray-200 rounded dark:border-gray-700">
                    <input id="male" type="radio" v-model="form.gender" value="1" name="gender"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="male"
                      class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">男性</label>
                  </div>
                  <div class="flex items-center px-4 border border-gray-200 rounded dark:border-gray-700">
                    <input checked id="female" type="radio" v-model="form.gender" value="2" name="gender"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="female"
                      class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">女性</label>
                  </div>
                  <div class="flex items-center px-4 border border-gray-200 rounded dark:border-gray-700">
                    <input checked id="other" type="radio" v-model="form.gender" value="3" name="gender"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="other"
                      class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">その他</label>
                  </div>
                </div>
              </div>
              <InputError class="mt-2" :message="errors.gender" />
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="text" class="leading-7 text-sm text-gray-600">メモ</label>
                  <textarea v-model="form.memo" type="text" id="memo" name="memo"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  </textarea>
                </div>
              </div>
              <InputError class="mt-2" :message="errors.memo" />
              <div class="p-2 w-full">
                <button @click="storeCustomers"
                  class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>

    </section>
  </AuthenticatedLayout>
</template>
