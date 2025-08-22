import axios from 'axios'

const API_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8081/api'

export async function getCustomers(page = 1) {
    const response = await axios.get(`${API_URL}/customers?page=${page}`)
    return response.data
}

export async function createCustomer(payload) {
    const response = await axios.post(`${API_URL}/customers`, payload)
    return response.data
}
