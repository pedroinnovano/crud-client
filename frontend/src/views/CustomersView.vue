<script setup>
import CustomerTable from '@/components/CustomerTable.vue'
import CustomerCreateModal from '@/components/CustomerCreateModal.vue'
import { getCustomers } from '@/services/customerService'
import { onMounted, ref } from 'vue'

const customers = ref([])
const showModal = ref(false)

async function fetchCustomers() {
  const response = await getCustomers()
  customers.value = response.data
}

function goToCreate() {
  showModal.value = true
}

function goToEdit(customer) {
  alert('Editar cliente: ' + customer.name)
}

onMounted(fetchCustomers)
</script>

<template>
  <div class="max-w-6xl mx-auto p-6">
    <CustomerTable :customers="customers" @create="goToCreate" @edit="goToEdit" />
    <CustomerCreateModal v-if="showModal" @close="showModal = false" @created="fetchCustomers" />
  </div>
</template>
