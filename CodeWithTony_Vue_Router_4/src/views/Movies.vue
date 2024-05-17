<script setup>
  import { ref, onMounted } from 'vue'
  import MovieCard from '../components/MovieCard.vue'

  const movieList = ref([])

  onMounted(async () => {
    movieList.value = await (await fetch('http://localhost:8000/movies')).json()
  })
</script>

<template>
  <h1>Movies</h1>
  <div class="grid grid-cols-3 gap-4">
    <MovieCard v-for="movie in movieList" :key="movie.id" :movie />
  </div>
</template>
