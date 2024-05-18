<script setup>
  import { onMounted } from 'vue'
  import { useMoviesStore } from '../stores/movies'
  import MovieCard from '../components/MovieCard.vue'

  const moviesStore = useMoviesStore()
  onMounted(() => moviesStore.getMovies())
</script>

<template>
  <h1 class="my-3 text-3xl text-center dark:text-white">Movies</h1>

  <div class="mx-auto" v-if="moviesStore.isLoading">
    <span class="text-2xl font-bold text-indigo-700 dark:text-indigo-400">
      Is Loading...
    </span>
  </div>
  <div class="grid grid-cols-3 gap-4 mb-10" v-else>
    <MovieCard v-for="movie in moviesStore.movies" :key="movie.id" :movie />
  </div>
</template>
