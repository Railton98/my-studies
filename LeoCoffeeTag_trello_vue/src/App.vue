<script setup>
import Header from './components/Header.vue'
</script>

<template>
  <Header />

  <div class="board">
    <div class="card">
      <div class="card-title">To Do</div>
    </div>

    <div class="card">
      <div class="card-title">Doing</div>
    </div>

    <div class="card">
      <div class="card-title">Done</div>
    </div>

    <div class="card">
      <div class="card-title">Observations</div>
    </div>
  </div>
</template>

<style scoped>
.board {
  display: flex;
  justify-content: flex-start;
  margin: 0 0.8rem;
}

.card {
  background: var(--color-grey);
  width: 23rem;
  height: 30rem;
  border-radius: 0.8rem;
  box-shadow: 0 0.1rem 0.2rem 0 rgba(33, 33, 33, 0.1);
  margin: 3rem 0.8rem;
  padding: 0 0.7rem;
}

.card-title {
  padding: 0.8rem 0.5rem;
  margin-bottom: 0.6rem;
}
</style>
