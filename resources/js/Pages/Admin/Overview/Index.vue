<template>
    <AdminLayout>
        <template #Content>
            <div>
                <div class="flex items-center">
                    <h1 class="text-[#1F6391] text-[30px] font-bold">Overview</h1>
                    <el-date-picker
                        class="ml-[20px]"
                        v-model="month"
                        type="month"
                        placeholder="Pick a month"
                        @change="getData"
                        value-format="YYYY-MM-01"
                    />
                </div>
                <div>
                    <Line
                        id="my-chart-id"
                        :options="chartOptions"
                        :data="ordersData"
                        class="!h-[300px]"
                    />
                </div>
                <div>
                    <Bar
                        id="my-chart-id"
                        :options="chartOptions"
                        :data="revenueData"
                        class="!h-[300px]"
                    />
                </div>
            </div>
        </template>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue'
import { Bar, Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, PointElement, LineElement,} from 'chart.js'
import axios from 'axios';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, PointElement, LineElement,)

const props = defineProps(['data'])
const data = ref(props.data)
const month = ref('')

const ordersData = ref({
  labels: data.value.date,
  datasets: [
    {
      label: 'Orders',
      backgroundColor: '#f87979',
      data: data.value.orders
    },
  ]
})

const revenueData = ref({
  labels: data.value.date,
  datasets: [
    {
      label: 'Revenue',
      backgroundColor: '#4287f5',
      data: data.value.revenue
    },
  ]
})

const chartOptions = ref({
  responsive: true
})

const getCurrentMonth = () => {
    let current = new Date()
    let currentYear = current.getFullYear()
    let currentMonth = '0' + (current.getMonth() + 1)
    month.value = `${currentYear}-${currentMonth}-01`
}
getCurrentMonth()

const getData = () => {
    axios.post(route('api.admin.overview.get-data'), {month: month.value})
        .then(response => {
            data.value = response.data
        })
        .catch(error => {

        })
}

watch(() => data.value, (newData) => {
  // Cập nhật dữ liệu cho ordersData
  ordersData.value = {
    labels: newData.date,
    datasets: [
      {
        label: 'Orders',
        backgroundColor: '#f87979',
        data: newData.orders
      },
    ]
  }

  // Cập nhật dữ liệu cho revenueData
  revenueData.value = {
    labels: newData.date,
    datasets: [
      {
        label: 'Revenue',
        backgroundColor: '#4287f5',
        data: newData.revenue
      },
    ]
  }
}, { deep: true })
</script>