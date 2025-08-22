<template>
  <div class="bg-white">


    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center">
            Nome
            <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cidade</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Idade</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <tr
            v-for="customer in customers"
            :key="customer.id"
            class="hover:bg-gray-50 transition"
        >
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex-shrink-0 h-10 w-10">
              <img class="h-10 w-10 rounded-full object-cover" :src="customer.photo" :alt="customer.name" />
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">{{ customer.name }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ customer.email }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ customer.phone }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ customer.city }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ customer.state }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ customer.age }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex space-x-2">
              <button 
                @click="$emit('edit', customer.id)"
                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition-colors"
              >
                Editar
              </button>
              <button 
                @click="$emit('delete', customer.id)"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition-colors"
              >
                Excluir
              </button>
            </div>
          </td>
        </tr>

        <tr v-if="!customers.length">
          <td colspan="8" class="text-center py-12 text-gray-400">
            <div class="flex flex-col items-center justify-center">
              <svg
                  class="w-16 h-16 mb-4 text-gray-300"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  viewBox="0 0 24 24"
              >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                />
              </svg>
              <p class="mb-2 text-sm">Ainda não há contatos</p>
              <button
                  class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm"
                  @click="$emit('create')"
              >
                + Adicionar contato
              </button>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div v-if="pagination && pagination.last_page > 1" class="flex items-center justify-between mt-6">
      <div class="text-sm text-gray-700">
        Mostrando {{ pagination.from }} a {{ pagination.to }} de {{ pagination.total }} resultados
      </div>
      <div class="flex gap-1">
        <button
          v-for="link in pagination.links"
          :key="link.label"
          @click="handlePaginationClick(link)"
          :disabled="!link.url || link.active"
          :class="[
            'px-3 py-2 text-sm border rounded-md transition-colors',
            link.active
              ? 'bg-blue-600 text-white border-blue-600'
              : link.url
              ? 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'
              : 'bg-gray-100 text-gray-400 border-gray-300 cursor-not-allowed'
          ]"
          v-html="link.label"
        >
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  customers: Array,
  pagination: Object
})

function handlePaginationClick(link) {
  if (link.url && !link.active && link.page) {
    emit('change-page', link.page)
  }
}

const emit = defineEmits(['create', 'edit', 'delete', 'change-page'])
</script>
