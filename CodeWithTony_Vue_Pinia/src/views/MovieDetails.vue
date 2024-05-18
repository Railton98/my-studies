<script setup>
  import { onMounted } from 'vue'
  import { useMoviesStore } from '../stores/movies'

  const props = defineProps({
    id: { type: String, required: true },
  })

  const moviesStore = useMoviesStore()

  onMounted(() => moviesStore.getSingleMovie(props.id))
</script>

<template>
  <section class="p-4 m-6 bg-white dark:bg-gray-900">
    <div class="mx-auto" v-if="moviesStore.isLoading">
      <span class="text-2xl font-bold text-indigo-700 dark:text-indigo-400">
        Is Loading...
      </span>
    </div>
    <div
      v-else
      class="container flex flex-col items-center px-4 py-12 mx-auto xl:flex-row"
    >
      <div class="flex justify-center xl:w-1/2">
        <img
          class="h-80 w-80 sm:w-[28rem] sm:h-[28rem] flex-shrink-0 object-cover rounded-md"
          :src="moviesStore.singleMovie.poster"
          :alt="moviesStore.singleMovie.title"
        />
      </div>

      <div
        class="flex flex-col items-center mt-6 xl:items-start xl:w-1/2 xl:mt-0"
      >
        <h2
          class="text-3xl font-bold tracking-tight text-gray-800 xl:text-4xl dark:text-white"
        >
          {{ moviesStore.singleMovie.title }}
        </h2>
        <span class="p-2 m-2 rounded-md bg-slate-300 text-slate-800">
          {{ moviesStore.singleMovie.year }}
        </span>
        <span class="p-2 m-2 rounded-md bg-slate-300 text-slate-800">
          {{ moviesStore.singleMovie.runtime }}
        </span>

        <div class="mt-6 sm:-mx-2">
          <div
            class="inline-flex w-full overflow-hidden rounded-lg shadow sm:w-auto sm:mx-2"
          >
            <button
              @click="$router.back()"
              class="inline-flex items-center justify-center w-full px-5 py-3 text-base font-medium text-white bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-600 hover:to-gray-600 sm:w-auto"
            >
              <span class="mx-2">Go Back</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
