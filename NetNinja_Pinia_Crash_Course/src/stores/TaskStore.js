import { defineStore } from 'pinia'
import { computed, reactive } from 'vue'

export const useTaskStore = defineStore('taskStore', () => {
  // state
  const tasks = reactive([
    { id: 1, title: 'buy some milk', isFav: false },
    { id: 2, title: 'play Gloomhaven', isFav: true },
  ])

  // getters
  const favs = computed(() => tasks.filter((t) => t.isFav))
  const favCount = computed(() =>
    tasks.reduce(
      (previous, current) => (current.isFav ? previous + 1 : previous),
      0
    )
  )
  const totalCount = computed(() => tasks.length)

  // actions

  return {
    tasks,
    favs,
    favCount,
    totalCount,
  }
})
