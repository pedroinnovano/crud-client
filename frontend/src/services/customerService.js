import axios from 'axios'

const API_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8081/api'

// Helper function to normalize array/single value fields
export function normalize(v) {
    return Array.isArray(v) ? v[0] : v
}

// Normalize pagination metadata
function normalizePaginationData(data) {
    if (!data) return data
    
    const normalizedData = { ...data }
    
    // Normalize meta fields
    if (normalizedData.meta) {
        Object.keys(normalizedData.meta).forEach(key => {
            if (key === 'links' && Array.isArray(normalizedData.meta[key])) {
                // Keep links array as is, but normalize individual link properties
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
    
    // Normalize links fields
    if (normalizedData.links) {
        Object.keys(normalizedData.links).forEach(key => {
            normalizedData.links[key] = normalize(normalizedData.links[key])
        })
    }
    
    return normalizedData
}

export async function getCustomers(page = 1) {
    const response = await axios.get(`${API_URL}/customers?page=${page}`)
    return normalizePaginationData(response.data)
}

export async function createCustomer(payload) {
    const response = await axios.post(`${API_URL}/customers`, payload)
    return response.data
}
