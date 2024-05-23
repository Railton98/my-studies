<script setup>
import { reactive } from 'vue'
import sourceData from '@/data.json'

const destinations = reactive(sourceData.destinations)
</script>

<template>
  <div id="nav">
    <RouterLink :to="{ name: 'home' }"> Vue School Travel App </RouterLink>
    <RouterLink
      v-for="destination in destinations"
      :key="destination.id"
      :to="{ name: 'destination.show', params: { id: destination.id, slug: destination.slug } }"
    >
      {{ destination.name }}
    </RouterLink>
    <RouterLink :to="{ name: 'protected' }">Dashboard</RouterLink>
  </div>
</template>
