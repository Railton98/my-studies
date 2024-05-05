<script setup>
  import Header from './components/Header.vue'
</script>

<template>
  <NavBar />
  <component is="NavBar"></component>
  <header>
    <Header />
  </header>

  <main></main>
</template>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
  }

  header {
    line-height: 1.5;
  }
</style>
