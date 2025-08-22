<template>
  <div>
    <nav class="bg-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
          <div class="flex items-center space-x-8">
            <div class="flex-shrink-0">
              <h1 class="text-xl font-bold text-gray-800">CRUD Client</h1>
            </div>
            <div class="hidden md:flex space-x-8">
              <router-link
                to="/"
                class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors"
                :class="{ 'text-blue-600 font-semibold': $route.path === '/' }"
              >
                Home
              </router-link>
              <router-link
                to="/customers"
                class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors"
                :class="{ 'text-blue-600 font-semibold': $route.path === '/customers' }"
              >
                Clientes
              </router-link>
              <router-link
                to="/reports"
                class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors"
                :class="{ 'text-blue-600 font-semibold': $route.path === '/reports' }"
              >
                Relatórios
              </router-link>

            </div>
          </div>
        </div>
      </div>
    </nav>
    
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>
