<script setup>
import { onMounted, ref } from 'vue'
import api from './services/api'

// Import our new modular components
import HeroHeader from './components/HeroHeader.vue'
import TaskStats from './components/TaskStats.vue'
import TaskForm from './components/TaskForm.vue'
import TaskList from './components/TaskList.vue'

// Global state
const tasks = ref([])
const loading = ref(false)
const errorMessage = ref('')

const filterStatus = ref('all')
const search = ref('')

// API Methods
const fetchTasks = async () => {
  loading.value = true
  errorMessage.value = ''

  try {
    const response = await api.get('/tasks', {
      params: {
        status: filterStatus.value,
        search: search.value,
      },
    })

    tasks.value = response.data.data
  } catch (error) {
    errorMessage.value = 'Cannot load tasks. Please check Laravel API and CORS.'
    console.error(error)
  } finally {
    loading.value = false
  }
}

const createTask = async (formData) => {
  try {
    await api.post('/tasks', formData)
    await fetchTasks()
  } catch (error) {
    errorMessage.value = 'Cannot create task. Please check validation.'
    console.error(error)
  }
}

const toggleStatus = async (task) => {
  const nextStatus = task.status === 'completed' ? 'pending' : 'completed'

  try {
    await api.patch(`/tasks/${task.id}`, {
      status: nextStatus,
    })

    await fetchTasks()
  } catch (error) {
    errorMessage.value = 'Cannot update task status.'
    console.error(error)
  }
}

const deleteTask = async (task) => {
  try {
    await api.delete(`/tasks/${task.id}`)
    await fetchTasks()
  } catch (error) {
    errorMessage.value = 'Cannot delete task.'
    console.error(error)
  }
}

// Initial fetch when the app starts
onMounted(() => {
  fetchTasks()
})
</script>

<template>
  <main class="page">
    <HeroHeader />

    <TaskStats :tasks="tasks" />

    <TaskForm @create="createTask" />

    <TaskList
      :tasks="tasks"
      :loading="loading"
      :error-message="errorMessage"
      v-model:search="search"
      v-model:filterStatus="filterStatus"
      @fetch="fetchTasks"
      @toggle-status="toggleStatus"
      @delete-task="deleteTask"
    />
  </main>
</template>

<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: Inter, Arial, sans-serif;
  background: #f4f7fb;
  color: #172033;
}

button,
input,
textarea,
select {
  font: inherit;
}

button {
  border: 0;
  border-radius: 10px;
  padding: 11px 16px;
  background: #42b883;
  color: white;
  cursor: pointer;
  font-weight: 700;
}

button:hover {
  opacity: 0.9;
}

input,
textarea,
select {
  width: 100%;
  border: 1px solid #d9e1ec;
  border-radius: 10px;
  padding: 12px 14px;
  background: #ffffff;
  outline: none;
}

input:focus,
textarea:focus,
select:focus {
  border-color: #42b883;
}

.page {
  width: min(980px, 92vw);
  margin: 0 auto;
  padding: 40px 0;
}

.card {
  background: white;
  border: 1px solid #e5eaf2;
  border-radius: 18px;
  box-shadow: 0 10px 30px rgba(31, 45, 61, 0.06);
  padding: 24px;
  margin-bottom: 18px;
}

.empty,
.error {
  padding: 14px;
  border-radius: 12px;
}

.empty {
  background: #f8fafc;
  color: #64748b;
}

.error {
  background: #fee2e2;
  color: #991b1b;
}

.muted {
  color: #6b7280;
}
</style>
