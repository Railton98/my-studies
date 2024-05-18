<script setup>
  import NavBar from './components/NavBar.vue'
</script>

<template>
  <h1>Header</h1>

  <div class="max-w-7xl mx-auto">
    <NavBar />

    <RouterView />
  </div>
</template>
