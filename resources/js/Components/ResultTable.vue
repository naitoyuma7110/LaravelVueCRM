<script setup>
import dayjs from 'dayjs';
const props = defineProps({
  data: {
    type: Object
  }
})
</script>

<template>
  <div v-show="data.type === 'perDay' || data.type === 'perMonth' || data.type === 'perYear'">
    <table class="table-auto w-full text-center whitespace-no-wrap mt-10">
      <thead>
        <tr>
          <th
            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
            日付</th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            合計売上金額</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="d in props.data.data">
          <td class="px-4 py-3 text-center border-b">
            {{ dayjs(d.date).format('YYYY-MM-DD') }}
          </td>
          <td class="px-4 py-3 text-center border-b">{{ d.total }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div v-show="data.type === 'decil'">
    <table class="table-auto w-full text-center whitespace-no-wrap mt-10">
      <thead>
        <tr>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl
            rounded-bl">
            デシル
          </th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            合計金額
          </th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            平均
          </th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            構成比
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="d in props.data.data">
          <td class="px-4 py-3 text-center border-b"> {{ d.decil }}</td>
          <td class="px-4 py-3 text-center border-b">{{ d.totalPerGroup }}円</td>
          <td class="px-4 py-3 text-center border-b">{{ d.average }}円</td>
          <td class="px-4 py-3 text-center border-b">{{ d.totalRatio }}%</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
