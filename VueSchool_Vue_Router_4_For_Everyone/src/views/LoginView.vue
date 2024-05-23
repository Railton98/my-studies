<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const username = ref('')
const password = ref('')

const router = useRouter()
const route = useRoute()

function login() {
  window.user = username.value

  const redirectPath = route.query.redirect || '/protected'
  router.push(redirectPath)
}
</script>

<template>
  <div class="login">
    <form class="form" @submit.prevent="login">
      <h1>Login</h1>
      <label for="username">Username</label>
      <input v-model="username" id="username" type="text" class="input" />
      <label for="password">Password</label>
      <input v-model="password" id="password" type="password" class="input" />
      <button class="btn">Login</button>
    </form>
  </div>
</template>
