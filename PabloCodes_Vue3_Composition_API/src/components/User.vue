<script setup>
  import { ref } from 'vue'

  const name = ref('Railton')
  const birthYear = ref(1998)
  const age = ref(0)

  function calcAge() {
    age.value = new Date().getFullYear() - birthYear.value
  }
</script>

<template>
  <form class="user-form">
    <label for="name">Nome: </label><br />
    <input type="text" id="name" name="name" v-model="name" />
    <label for="year">Ano Nascimento: </label><br />
    <input type="number" id="year" name="year" v-model="birthYear" />
  </form>

  <button class="btn" @click="calcAge">Calcular Idade</button>
  <p>{{ name }} tem {{ age }} anos</p>
</template>

<style scoped>
  .user-form {
    margin: 0 auto;
    padding: 5px;
    width: 200px;
    background-color: darkcyan;
  }

  p {
    text-align: center;
  }

  .btn {
    margin: 5px auto;
    padding: 5px;
    display: block;
    background: darkcyan;
    border-radius: 5px;
    border-style: none;
    cursor: pointer;
  }

  .btn:hover {
    background: rgb(102, 147, 147);
  }
</style>
