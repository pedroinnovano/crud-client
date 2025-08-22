import axios from 'axios'

const API_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8081/api'

export function normalize(v) {
    return Array.isArray(v) ? v[0] : v
}

function normalizePaginationData(data) {
    if (!data) return data
    
    const normalizedData = { ...data }
    
    if (normalizedData.meta) {
        Object.keys(normalizedData.meta).forEach(key => {
            if (key === 'links' && Array.isArray(normalizedData.meta[key])) {
                normalizedData.meta[key] = normalizedData.meta[key].map(link => {
                    const normalizedLink = { ...link }
                    Object.keys(normalizedLink).forEach(linkKey => {
                        normalizedLink[linkKey] = normalize(normalizedLink[linkKey])
                    })
                    return normalizedLink
                })
            } else {
                normalizedData.meta[key] = normalize(normalizedData.meta[key])
            }
        })
    }
    
    if (normalizedData.links) {
        Object.keys(normalizedData.links).forEach(key => {
            normalizedData.links[key] = normalize(normalizedData.links[key])
        })
    }
    
    return normalizedData
}

export async function getCustomers(page = 1, searchName = '') {
    let url = `${API_URL}/customers?page=${page}`
    if (searchName && searchName.trim()) {
        url += `&name=${encodeURIComponent(searchName.trim())}`
    }
    const response = await axios.get(url)
    return normalizePaginationData(response.data)
}

export async function createCustomer(payload) {
    const response = await axios.post(`${API_URL}/customers`, payload)
    return response.data
}

export async function getCustomer(id) {
    const response = await axios.get(`${API_URL}/customers/${id}`)
    // Handle both direct data and wrapped data responses
    return response.data.data || response.data
}

export async function updateCustomer(id, customerData) {
    const response = await axios.put(`${API_URL}/customers/${id}`, customerData)
    return response.data
}

export async function deleteCustomer(id) {
    const response = await axios.delete(`${API_URL}/customers/${id}`)
    return response.data
}
