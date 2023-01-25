<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { getToday } from "@/common"
import { Inertia } from "@inertiajs/inertia";
import { onMounted, reactive, ref, computed } from "vue";
import Micromodal from '@/Components/Micromodal.vue';

const props = defineProps({
  customers: {
    type: Array
  },
  items: {
    type: Array
  },
  errors: {
    type: Object
  },
})

const storePurchases = () => {
  itemList.value.forEach(item => {
    if (item.quantity > 0) {
      form.items.push({
        id: item.id,
        quantity: item.quantity
      })
    }
  })
  Inertia.post(route('purchases.store'), form)
}

// 配列はref
const itemList = ref([])

const form = reactive({
  customer_id: null,
  status: true,
  items: [],
  date: null
})

const quantity = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]

onMounted(() => {
  form.date = getToday();
  props.items.forEach(item => {
    itemList.value.push({
      id: item.id, name: item.name, price: item.price, quantity: 0
    })
  });
})

const setCustomerId = id => {
  form.customer_id = id
}

const totalPrice = computed(() => {
  let total = 0;
  itemList.value.forEach(item => {
    total += item.price * item.quantity
  })
  return total
})

</script>

<template>

  <Head title="商品登録" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品購入</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

          <section class="text-gray-600 body-font ">
            <form @submit.prevent="storePurchases">
              <div class="container px-5 py-8 mx-auto">
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                  <div class="p-2 w-full">
                    <div>
                      <label for="name" class="leading-7 text-sm text-gray-600">会員名</label>
                      <Micromodal @update:customerId="setCustomerId"></Micromodal>
                    </div>
                    <InputError class="mt-2" :message="errors.customer_id" />
                  </div>
                  <div class="p-2 w-full">
                    <div>
                      <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                      <input type="date" id="date" v-model="form.date" class="w-full rounded">
                    </div>
                    <InputError class="mt-2" :message="errors.date" />
                  </div>
                  <div class="w-full p-2">
                    <table class="w-full text-center text-gray-600 dark:text-gray-400">
                      <thead>
                        <tr class="h-10 bg-gray-500  text-white">
                          <th>ID</th>
                          <th>商品名</th>
                          <th>値段</th>
                          <th>数量</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in itemList" :key="item.id"
                          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                          <td>{{ item.id }}</td>
                          <td>{{ item.name }}</td>
                          <td class="h-12">
                            <select name="quantity" v-model="item.quantity" class=" bg-gray-50 border border-gray-300 text-gray-900
                        text-sm rounded focus:ring-blue-500 focus:border-blue-500">
                              <option v-for="q in quantity" :value="q">{{ q }}</option>
                            </select>
                          </td>
                          <td>{{ item.price }}</td>
                        </tr>
                      </tbody>
                    </table>
                    <InputError class="mt-2" :message="props.errors.items" />
                    <div class="w-full text-lg text-right my-2 py-2 pr-24 border rounded border-gray-300">
                      合計金額：{{ totalPrice }}
                    </div>
                  </div>
                </div>
                <div class="p-2 w-full">
                  <button
                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

