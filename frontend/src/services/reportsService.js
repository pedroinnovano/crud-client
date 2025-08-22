import axios from 'axios'

const API_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8081/api'

// Get customers per month report
export async function getCustomersPerMonth() {
    const response = await axios.get(`${API_URL}/reports/customers-per-month`)
    return response.data
}

// Get customer count by city report
export async function getCustomerCountByCity() {
    const response = await axios.get(`${API_URL}/reports/customer-count-by-city`)
    return response.data
}

// Get customer count by state report
export async function getCustomerCountByState() {
    const response = await axios.get(`${API_URL}/reports/customer-count-by-state`)
    return response.data
}

// Get customer count by age range report
export async function getCustomerCountByAgeRange() {
    const response = await axios.get(`${API_URL}/reports/customer-count-by-age-range`)
    return response.data
}

// Get top cities with most customers report
export async function getTopCitiesWithMostCustomers() {
    const response = await axios.get(`${API_URL}/reports/top-cities-with-most-customers`)
    return response.data
}