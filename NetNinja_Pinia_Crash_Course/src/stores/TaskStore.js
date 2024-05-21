import { defineStore } from 'pinia'
import { computed, ref } from 'vue'

export const useTaskStore = defineStore('taskStore', () => {
  // state
  const tasks = ref([])
  const loading = ref(false)

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
  async function getTasks() {
    loading.value = true

    tasks.value = await (await fetch('http://localhost:3000/tasks')).json()
    loading.value = false
  }

  async function addTask(task) {
    tasks.value.push(task)

    const res = await fetch('http://localhost:3000/tasks', {
      method: 'POST',
      body: JSON.stringify(task),
      headers: { 'Content-Type': 'application/json' },
    })

    if (res.error) {
      console.error(res.error)
    }
  }

  async function deleteTask(id) {
    tasks.value = tasks.value.filter((t) => t.id !== id)

    const res = await fetch(`http://localhost:3000/tasks/${id}`, {
      method: 'DELETE',
    })

    if (res.error) {
      console.error(res.error)
    }
  }

  async function toggleFav(id) {
    const task = tasks.value.find((t) => t.id === id)
    task.isFav = !task.isFav

    const res = await fetch(`http://localhost:3000/tasks/${id}`, {
      method: 'PATCH',
      body: JSON.stringify({ isFav: task.isFav }),
      headers: { 'Content-Type': 'application/json' },
    })

    if (res.error) {
      console.error(res.error)
    }
  }

  return {
    tasks,
    loading,

    favs,
    favCount,
    totalCount,

    getTasks,
    addTask,
    deleteTask,
    toggleFav,
  }
})
