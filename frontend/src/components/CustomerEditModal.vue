<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-xl relative">
      <h2 class="text-xl font-semibold mb-4">Editar Contato</h2>

      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div v-for="field in fields" :key="field.name">
          <label :for="field.name" class="block font-medium text-sm text-zinc-700">
            {{ field.label }}
          </label>
          <input
              v-if="field.name === 'phone'"
              v-model="form[field.name]"
              :id="field.name"
              :type="field.type"
              class="w-full border rounded-md px-4 py-2 mt-1"
              :class="{'border-red-500': errors[field.name]}"
              :placeholder="field.placeholder"
              @input="formatPhone"
              maxlength="15"
          />
          <input
              v-else
              v-model="form[field.name]"
              :id="field.name"
              :type="field.type"
              class="w-full border rounded-md px-4 py-2 mt-1"
              :class="{'border-red-500': errors[field.name]}"
              :placeholder="field.placeholder"
          />
          <p v-if="errors[field.name]" class="text-red-500 text-sm mt-1">{{ errors[field.name] }}</p>
        </div>

        <div class="flex justify-end gap-2 mt-4">
          <button type="button" @click="$emit('close')" class="text-zinc-600 hover:underline">Cancelar</button>
          <button
              type="submit"
              class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 disabled:opacity-60"
              :disabled="loading"
          >
            <span v-if="loading">Salvando...</span>
            <span v-else>Salvar</span>
          </button>
        </div>

        <p v-if="apiError" class="text-red-600 text-sm mt-4">{{ apiError }}</p>
        <p v-if="success" class="text-green-600 text-sm mt-4">Contato atualizado com sucesso!</p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import { updateCustomer, getCustomer } from '@/services/customerService'

const props = defineProps({
  customerId: {
    type: Number,
    required: true
  }
})

const emit = defineEmits(['close', 'updated'])

const loading = ref(false)
const success = ref(false)
const apiError = ref('')
const form = reactive({
  name: '',
  email: '',
  phone: '',
  city: '',
  state: '',
  photo: '',
  age: ''
})

const errors = reactive({})

const fields = [
  { name: 'name', label: 'Nome', type: 'text', placeholder: 'João da Silva' },
  { name: 'email', label: 'E-mail', type: 'email', placeholder: 'joao@email.com' },
  { name: 'phone', label: 'Telefone', type: 'text', placeholder: '(81) 99999-9999' },
  { name: 'city', label: 'Cidade', type: 'text', placeholder: 'Recife' },
  { name: 'state', label: 'Estado', type: 'text', placeholder: 'PE' },
  { name: 'photo', label: 'URL da Foto', type: 'text', placeholder: 'https://...' },
  { name: 'age', label: 'Idade', type: 'number', placeholder: '30' }
]

function formatPhone(event) {
  let value = event.target.value.replace(/\D/g, '')
  
  if (value.length <= 10) {
    // Format: (XX) XXXX-XXXX for landline
    if (value.length >= 10) {
      value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3')
    } else if (value.length >= 6) {
      value = value.replace(/(\d{2})(\d{4})(\d*)/, '($1) $2-$3')
    } else if (value.length >= 2) {
      value = value.replace(/(\d{2})(\d*)/, '($1) $2')
    } else if (value.length >= 1) {
      value = value.replace(/(\d*)/, '($1')
    }
  } else {
    // Format: (XX) 9XXXX-XXXX for mobile
    value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3')
  }
  
  form.phone = value
}

function validate() {
  errors.name = !form.name ? 'Nome é obrigatório' : ''
  errors.email = !form.email ? 'E-mail é obrigatório' : ''
  errors.phone = !form.phone ? 'Telefone é obrigatório' : ''
  errors.city = !form.city ? 'Cidade é obrigatória' : ''
  errors.state = !form.state ? 'Estado é obrigatório' : ''
  errors.age = !form.age ? 'Idade é obrigatória' : ''
  return Object.values(errors).every(e => !e)
}

async function loadCustomer() {
  try {
    loading.value = true
    const customer = await getCustomer(props.customerId)
    
    console.log('Customer data received:', customer)
    
    // Populate form with customer data
    Object.keys(form).forEach(key => {
      if (customer[key] !== undefined) {
        form[key] = customer[key]
      }
    })
    
    console.log('Form populated:', form)
  } catch (err) {
    console.error('Error loading customer:', err)
    apiError.value = 'Erro ao carregar dados do contato'
  } finally {
    loading.value = false
  }
}

async function handleSubmit() {
  if (!validate()) return

  loading.value = true
  apiError.value = ''
  success.value = false

  try {
    await updateCustomer(props.customerId, form)
    success.value = true
    emit('updated')
    setTimeout(() => {
      emit('close')
    }, 1200)
  } catch (err) {
    apiError.value = 'Erro ao atualizar contato. Tente novamente.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadCustomer()
})
</script>