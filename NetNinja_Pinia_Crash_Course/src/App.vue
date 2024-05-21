<script setup>
  import { ref, onMounted } from 'vue'
  import { storeToRefs } from 'pinia'
  import TaskDetails from './components/TaskDetails.vue'
  import TaskForm from './components/TaskForm.vue'
  import { useTaskStore } from './stores/TaskStore'

  const taskStore = useTaskStore()
  const { tasks, loading, favs, totalCount, favCount } = storeToRefs(taskStore)

  onMounted(() => {
    taskStore.getTasks()
  })

  const filter = ref('all')
</script>

<template>
  <main>
    <!-- heading -->
    <header>
      <img src="./assets/pinia-logo.svg" alt="pinia logo" />
      <h1>Pinia Tasks</h1>
    </header>

    <!-- filter -->
    <div class="new-task-form">
      <TaskForm />
    </div>

    <!-- filter -->
    <nav class="filter">
      <button @click="filter = 'all'">All tasks</button>
      <button @click="filter = 'favs'">Fav tasks</button>
    </nav>

    <!-- loading -->
    <div class="loading" v-if="loading">Loading tasks...</div>

    <!-- task list -->
    <div class="task-list" v-if="filter === 'all'">
      <p>You have {{ totalCount }} tasks left to do.</p>
      <div v-for="task in tasks" :key="task.id">
        <TaskDetails :task />
      </div>
    </div>

    <div class="task-list" v-if="filter === 'favs'">
      <p>You have {{ favCount }} tasks in your favs list.</p>
      <div v-for="task in favs" :key="task.id">
        <TaskDetails :task />
      </div>
    </div>

    <button @click="taskStore.$reset">reset the state</button>
  </main>
</template>
