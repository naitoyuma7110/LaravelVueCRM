<script setup>
import { Chart, registerables } from 'chart.js'
import { BarChart, LineChart } from 'vue-chart-3'
import { reactive, computed } from 'vue'
import dayjs from 'dayjs';

Chart.register(...registerables)

const props = defineProps({
  data: {
    type: Object
  }
})

const labels = computed(() => {
  if (props.data.type !== 'decil' && props.data.labels) {
    return props.data.labels.map(label =>
      dayjs(label).format('YYYY-MM-DD')
    );
  } else {
    return props.data.labels
  }
}
)
const totals = computed(() => props.data.totals)

const bardata = reactive({
  labels: labels,
  datasets: [
    {
      label: props.data.type == 'decil' ? '売上合計' : '売上',
      data: totals,
      backgroundColor: 'rgb(75, 192, 192)',
      tension: 0.1,
    },
  ],
});

</script>
<template>
  <div v-show="props.data">
    <BarChart :chartData="bardata" />
  </div>
</template>
