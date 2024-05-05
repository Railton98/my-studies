<script setup>
import Header from './components/Header.vue'
import Card from './components/Card.vue'

import cards from './cards.json'
</script>

<template>
  <Header />

  <div class="board">
    <div class="list">
      <div class="list-title">To Do</div>
      <Card v-for="card in cards.todo" :key="card.id">{{ card.title }}</Card>
    </div>

    <div class="list">
      <div class="list-title">Doing</div>
      <Card v-for="card in cards.doing" :key="card.id">{{ card.title }}</Card>
    </div>

    <div class="list">
      <div class="list-title">Done</div>
      <Card v-for="card in cards.done" :key="card.id">{{ card.title }}</Card>
    </div>

    <div class="list">
      <div class="list-title">Observations</div>
      <Card v-for="card in cards.observations" :key="card.id">{{ card.title }}</Card>
    </div>
  </div>
</template>

<style scoped>
.board {
  display: flex;
  justify-content: flex-start;
  margin: 0 0.8rem;
}

.list {
  background: var(--color-grey);
  width: 23rem;
  height: 30rem;
  border-radius: 0.8rem;
  box-shadow: 0 0.1rem 0.2rem 0 rgba(33, 33, 33, 0.1);
  margin: 3rem 0.8rem;
  padding: 0 0.7rem;
}

.list-title {
  padding: 0.8rem 0.5rem;
  margin-bottom: 0.6rem;
}
</style>
