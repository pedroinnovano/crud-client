<template>
  <div class="reports-container">
    <div class="header">
      <h1 class="title">Relatórios de Clientes</h1>
      <p class="subtitle">Visualize dados e estatísticas dos seus clientes</p>
    </div>

    <!-- Grid de Gráficos -->
    <div class="charts-grid">
      <!-- Clientes por Mês -->
      <div class="chart-card">
        <div class="chart-header">
          <h3>Clientes por Mês</h3>
          <div v-if="loading.customersPerMonth" class="loading">Carregando...</div>
        </div>
        <div v-if="error.customersPerMonth" class="error">{{ error.customersPerMonth }}</div>
        <div v-else id="customersPerMonthChart" class="chart"></div>
      </div>

      <!-- Clientes por Faixa Etária -->
      <div class="chart-card">
        <div class="chart-header">
          <h3>Clientes por Faixa Etária</h3>
          <div v-if="loading.customersByAge" class="loading">Carregando...</div>
        </div>
        <div v-if="error.customersByAge" class="error">{{ error.customersByAge }}</div>
        <div v-else id="customersByAgeChart" class="chart"></div>
      </div>

      <!-- Clientes por Estado -->
      <div class="chart-card">
        <div class="chart-header">
          <h3>Clientes por Estado</h3>
          <div v-if="loading.customersByState" class="loading">Carregando...</div>
        </div>
        <div v-if="error.customersByState" class="error">{{ error.customersByState }}</div>
        <div v-else id="customersByStateChart" class="chart"></div>
      </div>

      <!-- Top 5 Cidades -->
      <div class="chart-card">
        <div class="chart-header">
          <h3>Top 5 Cidades</h3>
          <div v-if="loading.topCities" class="loading">Carregando...</div>
        </div>
        <div v-if="error.topCities" class="error">{{ error.topCities }}</div>
        <div v-else id="topCitiesChart" class="chart"></div>
      </div>
    </div>

    <!-- Tabela de Clientes por Cidade -->
    <div class="table-card">
      <div class="chart-header">
        <h3>Clientes por Cidade</h3>
        <div v-if="loading.customersByCity" class="loading">Carregando...</div>
      </div>
      <div v-if="error.customersByCity" class="error">{{ error.customersByCity }}</div>
      <div v-else-if="customersByCity.length > 0" class="table-container">
        <table class="data-table">
          <thead>
            <tr>
              <th>Cidade</th>
              <th>Total de Clientes</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in customersByCity" :key="item.city">
              <td>{{ item.city }}</td>
              <td>{{ item.total }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import {
  getCustomersPerMonth,
  getCustomerCountByCity,
  getCustomerCountByState,
  getCustomerCountByAgeRange,
  getTopCitiesWithMostCustomers
} from '@/services/reportsService'

const customersPerMonth = ref([])
const customersByCity = ref([])
const customersByState = ref([])
const customersByAge = ref([])
const topCities = ref([])

const loading = ref({
  customersPerMonth: false,
  customersByCity: false,
  customersByState: false,
  customersByAge: false,
  topCities: false
})

const error = ref({
  customersPerMonth: '',
  customersByCity: '',
  customersByState: '',
  customersByAge: '',
  topCities: ''
})

let customersPerMonthChart = null
let customersByAgeChart = null
let customersByStateChart = null
let topCitiesChart = null

async function fetchCustomersPerMonth() {
  loading.value.customersPerMonth = true
  error.value.customersPerMonth = ''
  try {
    const data = await getCustomersPerMonth()
    customersPerMonth.value = data
    createCustomersPerMonthChart(data)
  } catch (err) {
    error.value.customersPerMonth = 'Erro ao carregar dados de clientes por mês'
  } finally {
    loading.value.customersPerMonth = false
  }
}

async function fetchCustomersByCity() {
  loading.value.customersByCity = true
  error.value.customersByCity = ''
  try {
    const data = await getCustomerCountByCity()
    customersByCity.value = data
  } catch (err) {
    error.value.customersByCity = 'Erro ao carregar dados de clientes por cidade'
  } finally {
    loading.value.customersByCity = false
  }
}

async function fetchCustomersByState() {
  loading.value.customersByState = true
  error.value.customersByState = ''
  try {
    const data = await getCustomerCountByState()
    customersByState.value = data
    createCustomersByStateChart(data)
  } catch (err) {
    error.value.customersByState = 'Erro ao carregar dados de clientes por estado'
  } finally {
    loading.value.customersByState = false
  }
}

// Fetch customers by age data
async function fetchCustomersByAge() {
  loading.value.customersByAge = true
  error.value.customersByAge = ''
  try {
    const data = await getCustomerCountByAgeRange()
    customersByAge.value = data
    createCustomersByAgeChart(data)
  } catch (err) {
    error.value.customersByAge = 'Erro ao carregar dados de clientes por faixa etária'
  } finally {
    loading.value.customersByAge = false
  }
}

// Fetch top cities data
async function fetchTopCities() {
  loading.value.topCities = true
  error.value.topCities = ''
  try {
    const data = await getTopCitiesWithMostCustomers()
    topCities.value = data
    createTopCitiesChart(data)
  } catch (err) {
    error.value.topCities = 'Erro ao carregar dados das principais cidades'
  } finally {
    loading.value.topCities = false
  }
}

function createCustomersPerMonthChart(data) {
  if (!data || data.length === 0) return
  
  const options = {
    series: [{
      name: 'Clientes',
      data: data.map(item => item.total || 0)
    }],
    chart: {
      type: 'area',
      height: 350,
      zoom: {
        enabled: false
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth'
    },
    title: {
      text: 'Evolução de Clientes por Mês',
      align: 'left'
    },
    grid: {
      row: {
        colors: ['#f3f3f3', 'transparent'],
        opacity: 0.5
      },
    },
    xaxis: {
      categories: data.map(item => item.month || 'N/A')
    },
    colors: ['#4F46E5']
  }
  
  if (customersPerMonthChart) {
    customersPerMonthChart.destroy()
  }
  
  customersPerMonthChart = new ApexCharts(document.querySelector('#customersPerMonthChart'), options)
  customersPerMonthChart.render()
}

function createCustomersByAgeChart(data) {
  if (!data || data.length === 0) return
  
  const options = {
    series: data.map(item => item.total || 0),
    chart: {
      type: 'donut',
      height: 350
    },
    labels: data.map(item => item.range || 'N/A'),
    title: {
      text: 'Distribuição por Faixa Etária',
      align: 'left'
    },
    colors: ['#EF4444', '#F97316', '#EAB308', '#22C55E', '#3B82F6'],
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      }
    }]
  }
  
  if (customersByAgeChart) {
    customersByAgeChart.destroy()
  }
  
  customersByAgeChart = new ApexCharts(document.querySelector('#customersByAgeChart'), options)
  customersByAgeChart.render()
}

function createCustomersByStateChart(data) {
  if (!data || data.length === 0) return
  
  const options = {
    series: [{
      name: 'Clientes',
      data: data.map(item => item.total || 0)
    }],
    chart: {
      type: 'bar',
      height: 350
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded'
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: data.map(item => item.state || 'N/A')
    },
    yaxis: {
      title: {
        text: 'Número de Clientes'
      }
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val + ' clientes'
        }
      }
    },
    colors: ['#10B981']
  }
  
  if (customersByStateChart) {
    customersByStateChart.destroy()
  }
  
  customersByStateChart = new ApexCharts(document.querySelector('#customersByStateChart'), options)
  customersByStateChart.render()
}

function createTopCitiesChart(data) {
  if (!data || data.length === 0) return
  
  const options = {
    series: [{
      name: 'Clientes',
      data: data.map(item => item.total || 0)
    }],
    chart: {
      type: 'bar',
      height: 350
    },
    plotOptions: {
      bar: {
        horizontal: true,
      },
    },
    dataLabels: {
      enabled: false
    },
    xaxis: {
      categories: data.map(item => item.city || 'N/A')
    },
    colors: ['#8B5CF6']
  }
  
  if (topCitiesChart) {
    topCitiesChart.destroy()
  }
  
  topCitiesChart = new ApexCharts(document.querySelector('#topCitiesChart'), options)
  topCitiesChart.render()
}

onMounted(() => {
  console.log('ReportsView mounted')
  console.log('ApexCharts available:', typeof ApexCharts !== 'undefined')
  
  if (typeof ApexCharts === 'undefined') {
    console.error('ApexCharts not loaded from CDN')
    return
  }
  
  setTimeout(() => {
    fetchCustomersPerMonth()
    fetchCustomersByCity()
    fetchCustomersByState()
    fetchCustomersByAge()
    fetchTopCities()
  }, 100)
})
</script>

<style scoped>
.reports-container {
  padding: 24px;
  max-width: 1200px;
  margin: 0 auto;
}

.header {
  margin-bottom: 32px;
  text-align: center;
}

.title {
  font-size: 2.5rem;
  font-weight: bold;
  color: #1f2937;
  margin-bottom: 8px;
}

.subtitle {
  font-size: 1.125rem;
  color: #6b7280;
  margin: 0;
}

.charts-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
  gap: 24px;
  margin-bottom: 32px;
}

.chart-card, .table-card {
  background: white;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  border: 1px solid #e5e7eb;
}

.chart-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

.chart-header h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #374151;
  margin: 0;
}

.chart {
  min-height: 350px;
}

.loading {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 350px;
  color: #6b7280;
  font-size: 1rem;
}

.error {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 350px;
  color: #dc2626;
  background-color: #fef2f2;
  border: 1px solid #fecaca;
  border-radius: 8px;
  padding: 16px;
  text-align: center;
}

.table-container {
  overflow-x: auto;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 16px;
}

.data-table th,
.data-table td {
  padding: 12px 16px;
  text-align: left;
  border-bottom: 1px solid #e5e7eb;
}

.data-table th {
  background-color: #f9fafb;
  font-weight: 600;
  color: #374151;
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.data-table td {
  color: #6b7280;
}

.data-table tr:hover {
  background-color: #f9fafb;
}

@media (max-width: 768px) {
  .charts-grid {
    grid-template-columns: 1fr;
  }
  
  .chart-card, .table-card {
    padding: 16px;
  }
  
  .title {
    font-size: 2rem;
  }
}
</style>