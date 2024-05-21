import { defineStore } from 'pinia'
import { computed, reactive, ref } from 'vue'

export const useTaskStore = defineStore('taskStore', () => {
  // state
  const tasks = ref([
    { id: 1, title: 'buy some milk', isFav: false },
    { id: 2, title: 'play Gloomhaven', isFav: true },
  ])

  // getters
  const favs = computed(() => tasks.value.filter((t) => t.isFav))
  const favCount = computed(() =>
    tasks.value.reduce(
      (previous, current) => (current.isFav ? previous + 1 : previous),
      0
    )
  )
  const totalCount = computed(() => tasks.value.length)

  // actions
  function addTask(task) {
    tasks.value.push(task)
  }

  function deleteTask(id) {
    tasks.value = tasks.value.filter((t) => t.id !== id)
  }

  function toggleFav(id) {
    const task = tasks.value.find((t) => t.id === id)
    task.isFav = !task.isFav
  }

  return {
    tasks,

    favs,
    favCount,
    totalCount,

    addTask,
    deleteTask,
    toggleFav,
  }
})
