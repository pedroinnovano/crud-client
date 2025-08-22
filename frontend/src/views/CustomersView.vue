<script setup>
import CustomerTable from '@/components/CustomerTable.vue'
import CustomerCreateModal from '@/components/CustomerCreateModal.vue'
import { getCustomers } from '@/services/customerService'
import { onMounted, ref } from 'vue'

const customers = ref([])
const pagination = ref({})
const currentPage = ref(1)
const loading = ref(false)
const searchName = ref('')
const showModal = ref(false)

async function fetchCustomers(page = 1) {
  try {
    loading.value = true
    const response = await getCustomers(page, searchName.value)
    customers.value = response.data || []
    pagination.value = response.meta || null
    currentPage.value = page
  } catch (error) {
    console.error('Error fetching customers:', error)
    customers.value = []
  } finally {
    loading.value = false
  }
}

function handleSearch() {
  currentPage.value = 1
  fetchCustomers(1)
}

function goToCreate() {
  showModal.value = true
}

function goToEdit(customer) {
  alert('Editar cliente: ' + customer.name)
}

function handlePageChange(page) {
  fetchCustomers(page)
}

function handleCustomerCreated() {
  showModal.value = false
  fetchCustomers(currentPage.value)
}

onMounted(() => fetchCustomers(1))
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-6xl p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Contatos</h1>
        <button 
          @click="goToCreate"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors"
        >
          Adicionar Contato
        </button>
      </div>
      
      <div class="mb-6">
        <div class="flex gap-2">
          <input 
            v-model="searchName"
            @keyup.enter="handleSearch"
            type="text" 
            placeholder="Buscar pelo nome..."
            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <button 
            @click="handleSearch"
            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors"
          >
            Buscar
          </button>
          <button 
            @click="searchName = ''; handleSearch()"
            class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg transition-colors"
          >
            Limpar
          </button>
        </div>
      </div>
      <div v-if="loading" class="flex justify-center items-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
      </div>
      <CustomerTable 
        v-else
        :customers="customers" 
        :pagination="pagination"
        @create="goToCreate" 
        @edit="goToEdit"
        @change-page="handlePageChange"
      />
    </div>
    <CustomerCreateModal v-if="showModal" @close="showModal = false" @created="handleCustomerCreated" />
  </div>
</template>
