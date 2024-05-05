<script setup>
  //   import { ref } from 'vue'
  //   const name = ref('Tecks')
  //   const birthYear = ref(2000)

  import { reactive } from 'vue'

  const person = reactive({
    name: '',
    birthYear: 0,
  })
</script>

<template>
  <form class="user-form">
    <!-- <label for="name">Nome: </label><br />
    <input type="text" id="name" name="name" v-model="name" />
    <label for="year">Ano Nascimento: </label><br />
    <input type="number" id="year" name="year" v-model="birthYear" /> -->

    <label for="name">Nome: </label><br />
    <input type="text" id="name" name="name" v-model="person.name" />
    <label for="year">Ano Nascimento: </label><br />
    <input type="number" id="year" name="year" v-model="person.birthYear" />
  </form>
  <p>{{ person.name }} nasceu em {{ person.birthYear }}</p>
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
</style>
