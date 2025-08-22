<script setup>
import CustomerTable from '@/components/CustomerTable.vue'
import CustomerCreateModal from '@/components/CustomerCreateModal.vue'
import CustomerEditModal from '@/components/CustomerEditModal.vue'
import DeleteConfirmModal from '@/components/DeleteConfirmModal.vue'
import { getCustomers, deleteCustomer } from '@/services/customerService'
import { onMounted, ref } from 'vue'

const customers = ref([])
const pagination = ref({})
const currentPage = ref(1)
const loading = ref(false)
const searchName = ref('')
const showModal = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const editingCustomerId = ref(null)
const deletingCustomer = ref(null)
const deleteLoading = ref(false)
const deleteError = ref('')

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

function handleEdit(customerId) {
  editingCustomerId.value = customerId
  showEditModal.value = true
}

function handleDelete(customerId) {
  const customer = customers.value.find(c => c.id === customerId)
  deletingCustomer.value = customer
  showDeleteModal.value = true
  deleteError.value = ''
}

async function confirmDelete() {
  if (!deletingCustomer.value) return
  
  deleteLoading.value = true
  deleteError.value = ''
  
  try {
    await deleteCustomer(deletingCustomer.value.id)
    showDeleteModal.value = false
    deletingCustomer.value = null
    await fetchCustomers(currentPage.value)
  } catch (err) {
    deleteError.value = 'Erro ao excluir contato. Tente novamente.'
  } finally {
    deleteLoading.value = false
  }
}

function cancelDelete() {
  showDeleteModal.value = false
  deletingCustomer.value = null
  deleteError.value = ''
  deleteLoading.value = false
}

function closeEditModal() {
  showEditModal.value = false
  editingCustomerId.value = null
}

function handleCustomerUpdated() {
  fetchCustomers(currentPage.value)
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
        @edit="handleEdit"
        @delete="handleDelete"
        @change-page="handlePageChange"
      />
    </div>
    <CustomerCreateModal v-if="showModal" @close="showModal = false" @created="handleCustomerCreated" />
    <CustomerEditModal 
      v-if="showEditModal" 
      :customer-id="editingCustomerId"
      @close="closeEditModal" 
      @updated="handleCustomerUpdated" 
    />
    <DeleteConfirmModal
       v-if="showDeleteModal"
       :customer-name="deletingCustomer?.name || ''"
       :loading="deleteLoading"
       :error="deleteError"
       @confirm="confirmDelete"
       @cancel="cancelDelete"
     />
  </div>
</template>
