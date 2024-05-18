<script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  const props = defineProps({
    id: {
      type: String,
      required: true,
    },
  })
  const queryMovie = ref({})
  const isLoading = ref(true)
  const router = useRoute()

  onMounted(() => {
    setTimeout(async () => {
      queryMovie.value = await (
        await fetch(`http://localhost:8000/movies/${parseInt(props.id)}`)
      ).json()
      isLoading.value = false
    }, 500)
  })
</script>

<template>
  <section class="bg-white dark:bg-gray-900 m-6 p-4">
    <div class="mx-auto" v-if="isLoading">
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
          :src="queryMovie.poster"
          :alt="queryMovie.title"
        />
      </div>

      <div
        class="flex flex-col items-center mt-6 xl:items-start xl:w-1/2 xl:mt-0"
      >
        <h2
          class="text-3xl font-bold tracking-tight text-gray-800 xl:text-4xl dark:text-white"
        >
          {{ queryMovie.title }}
        </h2>
        <span class="m-2 p-2 bg-slate-300 text-slate-800 rounded-md">
          {{ queryMovie.year }}
        </span>
        <span class="m-2 p-2 bg-slate-300 text-slate-800 rounded-md">
          {{ queryMovie.runtime }}
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
