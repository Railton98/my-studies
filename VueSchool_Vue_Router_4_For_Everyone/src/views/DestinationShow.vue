<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const destination = ref()

watch(
  route,
  async (to) => {
    destination.value = await (
      await fetch(`https://travel-dummy-api.netlify.app/${to.params.slug}`)
    ).json()
  },
  { flush: 'pre', immediate: true, deep: true }
)
</script>

<template>
  <section class="destination" v-if="destination">
    <h1>{{ destination.name }}</h1>
    <div class="destination-details">
      <img :src="`/images/${destination.image}`" :alt="destination.name" />
      <p>{{ destination.description }}</p>
    </div>
  </section>
</template>
