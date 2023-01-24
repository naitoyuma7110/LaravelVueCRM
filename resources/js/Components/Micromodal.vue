<script setup>
import axios from "axios"
import { ref, reactive, defineEmits } from "vue"
import { Link, Inertia } from "@inertiajs/inertia-vue3";

const search = ref()
const customers = reactive({
  value: ""
})

const searchCustomers = async () => {
  try {
    await axios
      .get('/api/searchCustomers', {
        params: {
          search: search.value
        }
      })
      .then((res) => {
        console.log(res.data.data)
        customers.value = res.data
      })
    toggleStatus();
  } catch (e) {
    console.log(e.message)
  }
}

const emit = defineEmits(['update:customerId'])

const setCustomer = e => {
  search.value = e.kana
  emit('update:customerId', e.id)
  toggleStatus()
}

const isShow = ref(false);
const toggleStatus = () => {
  isShow.value = !isShow.value
}
</script>
<template>
  <transition name="fade">
    <div v-if="isShow" class="modal micromodal-slide" :class="isShow ? 'is-open' : ''">
      <div class="modal__overlay" tabindex="-1">
        <div class="modal__container">
          <header class="modal__header">
            <h2 class="modal__title">
              顧客検索
            </h2>
            <button @click="toggleStatus" type="button" class="modal__close"></button>
          </header>
          <main class="modal__content">
            <div class="w-full mx-auto overflow-auto">
              <table class="table-auto w-full text-left whitespace-no-wrap">
                <thead>
                  <tr>
                    <th
                      class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                      ID
                    </th>
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
                  <tr v-for="customer in customers.value.data" :key="customer.id">
                    <td as="button" class="px-4 p-3 border-0 focus:outline-none rounded">
                      {{ customer.id }}
                    </td>
                    <td class="px-4 py-3 ">
                      {{ customer.name }}
                    </td>
                    <td class="px-4 py-3 text-sky-600 cursor-pointer underline decoration-sky-500"
                      @click="setCustomer(customer)">{{ customer.kana }}</td>
                    <td class="px-4 py-3">{{ customer.tel }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </main>
          <footer class="modal__footer">
            <button @click="toggleStatus" type="button" class="modal__btn">閉じる</button>
          </footer>
        </div>
      </div>
    </div>
  </transition>
  <div>
    <input type="text" name="search" v-model="search" class="py-2 mr-1 rounded">
    <button type='button'
      class=" py-2 px-6 text-white bg-blue-400 border-0 rounded focus:outline-none hover:bg-blue-500" @click="
      searchCustomers();">検索</button>
  </div>
</template>
<style>
.fade-enter-active,
.fade-leave-active {
  will-change: opacity;
  transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1) 0ms;
}

.fade-enter,
.fade-leave-to {
  opacity: 0
}
</style>
