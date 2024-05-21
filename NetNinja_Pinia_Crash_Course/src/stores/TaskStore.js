import { defineStore } from 'pinia'
import { reactive } from 'vue'

export const useTaskStore = defineStore('taskStore', () => {
  const tasks = reactive([
    { id: 1, title: 'buy some milk', isFav: false },
    { id: 2, title: 'play Gloomhaven', isFav: true },
  ])

  return {
    tasks,
  }
})
