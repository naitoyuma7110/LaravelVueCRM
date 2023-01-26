<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";
import { onMounted, reactive, ref, computed } from "vue";
import dayjs from "dayjs"

const props = defineProps({
  items: {
    type: Object
  },
  order: {
    type: Object
  }
})

const updatePurchases = (id) => {
  itemList.value.forEach(item => {
    if (item.quantity > 0) {
      form.items.push({
        id: item.id,
        quantity: item.quantity
      })
    }
  })
  Inertia.put(route('purchases.update', { purchase: id }), form)
}


const quantity = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]

const totalPrice = computed(() => {
  let total = 0;
  props.items.forEach(item => {
    total += item.price * item.quantity
  })
  return total
})

const form = reactive({
  id: props.order[0].id,
  date: props.order[0].createrd_at,
  customer_id: props.order[0].customer_id,
  status: props.order[0].status,
  items: []
})

// 配列はref
const itemList = ref([])


onMounted(() => {
  props.items.forEach(item => {
    itemList.value.push({
      id: item.id, name: item.name, price: item.price, quantity: item.quantity
    });
  })
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
            <form @submit.prevent="updatePurchases(form.id)">
              <div class="container px-5 py-8 mx-auto">
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                  <div class="p-2 w-full">
                    <div>
                      <label for="name" class="leading-7 text-sm text-gray-600">会員名</label>
                      <div class="text-lg">{{ order[0].customer_name }}</div>
                    </div>
                  </div>
                  <div class="p-2 w-full">
                    <div>
                      <label for="date" class="leading-7 text-sm text-gray-600">購入日</label>
                      <div class="text-lg">{{ dayjs(order[0].created_at).format('YYYY-MM-DD') }}</div>
                    </div>
                  </div>
                  <div class="p-2 w-full" v-if="order[0].status == 0">
                    <div>
                      <label for="date" class="leading-7 text-sm text-gray-600">キャンセル日</label>
                      <div class="text-lg">{{ dayjs(order[0].updated_at).format('YYYY-MM-DD') }}</div>
                    </div>
                  </div>
                  <div class="p-2 w-full">
                    <label for="status" class="leading-7 text-sm text-gray-600">ステータス</label>
                    <div class="flex items-center pl-4 border border-gray-200 rounded dark:border-gray-700">
                      <input id="status-1" type="radio" v-model="form.status" value="1" name="status"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="status-1"
                        class=" w-full py-4 ml-2 font-medium text-gray-900 dark:text-gray-300">購入予定</label>
                    </div>
                    <div class="flex items-center pl-4 border border-gray-200 rounded dark:border-gray-700">
                      <input id="status-2" type="radio" v-model="form.status" value="0" name="status"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="status-2"
                        class=" w-full py-4 ml-2 font-medium text-gray-900 dark:text-gray-300">キャンセル</label>
                    </div>
                  </div>
                  <div class="w-full p-2">
                    <table class="w-full text-center text-gray-600 dark:text-gray-400">
                      <thead>
                        <tr class="h-10 bg-gray-500  text-white">
                          <th>ID</th>
                          <th>商品名</th>
                          <th>数量</th>
                          <th>値段</th>
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
                    <div class="w-full text-lg text-right my-2 py-2 pr-4 border rounded border-gray-300">
                      合計金額：{{ totalPrice }}
                    </div>
                  </div>
                </div>
                <div class="p-2 w-full">
                  <button
                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>



