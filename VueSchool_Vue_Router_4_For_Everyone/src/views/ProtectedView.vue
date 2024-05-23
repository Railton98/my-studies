<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'

const username = computed(() => window.user)

const router = useRouter()

function logout() {
  window.user = null
  router.push({ name: 'home' })
}
</script>

<template>
  <div>
    <h1>Greetings, {{ username }}</h1>
    <button @click="logout">Logout</button>
    <RouterLink :to="{ name: 'invoices' }">
      <button>Invoices</button>
    </RouterLink>
  </div>
</template>
