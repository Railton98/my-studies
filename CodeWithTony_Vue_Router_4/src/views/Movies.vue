<script setup>
  import { ref, onMounted } from 'vue'
  import MovieCard from '../components/MovieCard.vue'

  const movieList = ref([])
  const isLoading = ref(true)

  onMounted(() => {
    setTimeout(async () => {
      movieList.value = await (
        await fetch('http://localhost:8000/movies')
      ).json()
      isLoading.value = false
    }, 500)
  })
</script>

<template>
  <h1 class="text-3xl text-center dark:text-white my-3">Movies</h1>

  <div class="mx-auto" v-if="isLoading">
    <span class="text-2xl font-bold text-indigo-700 dark:text-indigo-400">
      Is Loading...
    </span>
  </div>
  <div class="grid grid-cols-3 gap-4 mb-10" v-else>
    <MovieCard v-for="movie in movieList" :key="movie.id" :movie />
  </div>
</template>
