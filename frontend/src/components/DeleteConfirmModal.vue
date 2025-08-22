<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-xl relative">
      <div class="flex items-center mb-4">
        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
        </div>
        <div>
          <h3 class="text-lg font-semibold text-gray-900">Confirmar Exclusão</h3>
          <p class="text-sm text-gray-500">Esta ação não pode ser desfeita.</p>
        </div>
      </div>

      <p class="text-gray-700 mb-6">
        Tem certeza que deseja excluir o contato <strong>{{ customerName }}</strong>?
      </p>

      <div class="flex justify-end gap-3">
        <button 
          type="button" 
          @click="$emit('cancel')"
          class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors"
          :disabled="loading"
        >
          Cancelar
        </button>
        <button 
          type="button" 
          @click="$emit('confirm')"
          class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors disabled:opacity-60"
          :disabled="loading"
        >
          <span v-if="loading">Excluindo...</span>
          <span v-else>Excluir</span>
        </button>
      </div>

      <p v-if="error" class="text-red-600 text-sm mt-4">{{ error }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  customerName: {
    type: String,
    required: true
  },
  loading: {
    type: Boolean,
    default: false
  },
  error: {
    type: String,
    default: ''
  }
})

defineEmits(['cancel', 'confirm'])
</script>