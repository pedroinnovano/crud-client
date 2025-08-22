<script setup>
import CustomerTable from '@/components/CustomerTable.vue'
import CustomerCreateModal from '@/components/CustomerCreateModal.vue'
import { getCustomers } from '@/services/customerService'
import { onMounted, ref } from 'vue'

const customers = ref([])
const pagination = ref(null)
const currentPage = ref(1)
const loading = ref(false)
const showModal = ref(false)

async function fetchCustomers(page = 1) {
  try {
    loading.value = true
    const response = await getCustomers(page)
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
      <h1 class="text-2xl font-bold text-gray-800 mb-6">Contatos</h1>
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
