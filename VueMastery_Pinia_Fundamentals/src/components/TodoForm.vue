<script setup>
  import { ref } from 'vue'
  import { useTodoListStore } from '@/stores/todoList'

  const todo = ref('')

  const store = useTodoListStore()

  function addItemAndClear(item) {
    if (item.length === 0) return

    store.addTodo(item)
    todo.value = ''
  }
</script>

<template>
  <form @submit.prevent="addItemAndClear(todo)">
    <input type="text" v-model="todo" />
    <button type="submit">Add</button>
  </form>
</template>

<style scoped></style>
