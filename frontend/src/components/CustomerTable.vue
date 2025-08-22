<template>
  <div class="bg-white p-6 rounded-xl shadow-md border border-zinc-200">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-semibold text-zinc-800">Contatos</h2>
      <button
          class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm flex items-center gap-2 transition"
          @click="$emit('create')"
      >
        <span class="text-lg">+</span> Adicionar contato
      </button>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-zinc-50 text-zinc-500 text-xs uppercase tracking-wider">
        <tr>
          <th class="px-4 py-3">Nome</th>
          <th class="px-4 py-3">E-mail</th>
          <th class="px-4 py-3">Telefone</th>
          <th class="px-4 py-3">Cidade</th>
          <th class="px-4 py-3">Estado</th>
          <th class="px-4 py-3 text-center">Ações</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="customer in customers"
            :key="customer.id"
            class="border-t hover:bg-zinc-50 transition"
        >
          <td class="px-4 py-3">{{ customer.name }}</td>
          <td class="px-4 py-3">{{ customer.email }}</td>
          <td class="px-4 py-3">{{ customer.phone }}</td>
          <td class="px-4 py-3">{{ customer.city }}</td>
          <td class="px-4 py-3">{{ customer.state }}</td>
          <td class="px-4 py-3 text-center">
            <button
                class="text-indigo-600 hover:underline text-xs font-medium"
                @click="$emit('edit', customer)"
            >
              ✏️ Editar
            </button>
          </td>
        </tr>

        <tr v-if="!customers.length">
          <td colspan="6" class="text-center py-12 text-zinc-400">
            <div class="flex flex-col items-center justify-center">
              <svg
                  class="w-16 h-16 mb-4 text-zinc-300"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  viewBox="0 0 24 24"
              >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"
                />
              </svg>
              <p class="mb-2 text-sm">Ainda não há contatos</p>
              <button
                  class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm"
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

    <!-- Paginação -->
    <div v-if="pagination && pagination.last_page > 1" class="flex justify-center gap-2 mt-6">
      <button
          v-for="page in pagination.last_page"
          :key="page"
          @click="$emit('change-page', page)"
          :class="[
          'px-3 py-1 rounded-md text-sm',
          page === pagination.current_page
            ? 'bg-indigo-600 text-white'
            : 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200'
        ]"
      >
        {{ page }}
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  customers: Array,
  pagination: Object
})
</script>
