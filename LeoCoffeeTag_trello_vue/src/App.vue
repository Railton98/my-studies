<script setup>
import { Container, Draggable } from 'vue3-smooth-dnd'
import Header from './components/Header.vue'
import Card from './components/Card.vue'

import cards from './cards.json'
import { reactive } from 'vue'

let draggingCard = reactive({
  lane: '',
  index: -1,
  cardData: []
})

function handleDragStart(lane, dragResult) {
  const { payload, isSource } = dragResult

  if (isSource) {
    draggingCard = {
      lane,
      index: payload.index,
      cardData: { ...cards[lane][payload.index] }
    }
  }
}

function handleDrop() {}

function getChildPayload(index) {
  return { index }
}
</script>

<template>
  <Header />

  <div class="board">
    <div class="list">
      <h2 class="list-title">To Do</h2>
      <Container
        group-name="trello"
        @drag-start="handleDragStart('todo', $event)"
        @drag="handleDrop"
        :get-child-payload="getChildPayload"
      >
        <Draggable v-for="card in cards.todo" :key="card.id">
          <Card>{{ card.title }}</Card>
        </Draggable>
      </Container>
    </div>

    <div class="list">
      <h2 class="list-title">Doing</h2>
      <Container
        group-name="trello"
        @drag-start="handleDragStart('doing', $event)"
        @drag="handleDrop"
        :get-child-payload="getChildPayload"
      >
        <Draggable v-for="card in cards.doing" :key="card.id">
          <Card>{{ card.title }}</Card>
        </Draggable>
      </Container>
    </div>

    <div class="list">
      <h2 class="list-title">Done</h2>
      <Container
        group-name="trello"
        @drag-start="handleDragStart('done', $event)"
        @drag="handleDrop"
        :get-child-payload="getChildPayload"
      >
        <Draggable v-for="card in cards.done" :key="card.id">
          <Card>{{ card.title }}</Card>
        </Draggable>
      </Container>
    </div>

    <div class="list">
      <h2 class="list-title">Observations</h2>
      <Container
        group-name="trello"
        @drag-start="handleDragStart('observations', $event)"
        @drag="handleDrop"
        :get-child-payload="getChildPayload"
      >
        <Draggable v-for="card in cards.observations" :key="card.id">
          <Card>{{ card.title }}</Card>
        </Draggable>
      </Container>
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
