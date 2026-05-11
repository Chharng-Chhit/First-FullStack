<script setup>
import { computed, onMounted, ref } from 'vue'
import api from './services/api'

const tasks = ref([])
const loading = ref(false)
const errorMessage = ref('')

const form = ref({
  title: '',
  description: '',
  due_date: '',
  priority: 'medium',
})

const filterStatus = ref('all')
const search = ref('')

const totalTasks = computed(() => tasks.value.length)
const completedTasks = computed(() => tasks.value.filter((task) => task.status === 'completed').length)
const pendingTasks = computed(() => tasks.value.filter((task) => task.status === 'pending').length)

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

const createTask = async () => {
  if (!form.value.title.trim()) {
    alert('Please enter task title')
    return
  }

  try {
    await api.post('/tasks', form.value)

    form.value = {
      title: '',
      description: '',
      due_date: '',
      priority: 'medium',
    }

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
  if (!confirm(`Delete "${task.title}"?`)) return

  try {
    await api.delete(`/tasks/${task.id}`)
    await fetchTasks()
  } catch (error) {
    errorMessage.value = 'Cannot delete task.'
    console.error(error)
  }
}

onMounted(() => {
  fetchTasks()
})
</script>

<template>
  <main class="page">
    <section class="hero">
      <p class="eyebrow">Vue.js + Laravel API</p>
      <h1>Task Manager</h1>
      <p class="subtitle">
        A simple full stack CRUD project for beginner training.
      </p>
    </section>

    <section class="stats-grid">
      <div class="stat-card">
        <span>Total</span>
        <strong>{{ totalTasks }}</strong>
      </div>
      <div class="stat-card">
        <span>Pending</span>
        <strong>{{ pendingTasks }}</strong>
      </div>
      <div class="stat-card">
        <span>Completed</span>
        <strong>{{ completedTasks }}</strong>
      </div>
    </section>

    <section class="card">
      <h2>Create Task</h2>

      <form class="task-form" @submit.prevent="createTask">
        <input v-model="form.title" type="text" placeholder="Task title" />

        <textarea
          v-model="form.description"
          rows="3"
          placeholder="Task description"
        ></textarea>

        <div class="form-row">
          <input v-model="form.due_date" type="date" />

          <select v-model="form.priority">
            <option value="low">Low Priority</option>
            <option value="medium">Medium Priority</option>
            <option value="high">High Priority</option>
          </select>
        </div>

        <button type="submit">Add Task</button>
      </form>
    </section>

    <section class="card">
      <div class="toolbar">
        <h2>Task List</h2>

        <div class="filters">
          <input
            v-model="search"
            type="search"
            placeholder="Search task..."
            @input="fetchTasks"
          />

          <select v-model="filterStatus" @change="fetchTasks">
            <option value="all">All</option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
          </select>
        </div>
      </div>

      <p v-if="loading" class="muted">Loading tasks...</p>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>

      <div v-if="!loading && tasks.length === 0" class="empty">
        No tasks yet. Create your first task.
      </div>

      <div class="task-list">
        <article v-for="task in tasks" :key="task.id" class="task-card">
          <div>
            <h3 :class="{ done: task.status === 'completed' }">
              {{ task.title }}
            </h3>
            <p>{{ task.description || 'No description' }}</p>

            <div class="meta">
              <span :class="['badge', task.status]">{{ task.status }}</span>
              <span class="badge">{{ task.priority }}</span>
              <span v-if="task.due_date" class="badge">Due: {{ task.due_date }}</span>
            </div>
          </div>

          <div class="actions">
            <button class="secondary" @click="toggleStatus(task)">
              {{ task.status === 'completed' ? 'Mark Pending' : 'Complete' }}
            </button>
            <button class="danger" @click="deleteTask(task)">Delete</button>
          </div>
        </article>
      </div>
    </section>
  </main>
</template>
