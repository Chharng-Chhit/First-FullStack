<script setup>
import { onMounted, ref } from 'vue'
import api from '../services/api'

// Import our new modular components
import HeroHeader from '../components/HeroHeader.vue'
import TaskStats from '../components/TaskStats.vue'
import TaskForm from '../components/TaskForm.vue'
import TaskList from '../components/TaskList.vue'

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
  <div>
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
  </div>
</template>
