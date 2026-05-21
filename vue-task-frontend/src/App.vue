<script setup>
import { onMounted, ref, computed } from 'vue'
import axios from 'axios'
import Navbar from './components/Navbar.vue'

// We define the base URL here so it's easy to see and change
const API_URL = 'http://127.0.0.1:8000/api'

// --- State ---
const tasks = ref([])
const loading = ref(false)
const errorMessage = ref('')

const filterStatus = ref('all')
const search = ref('')

const form = ref({
  title: '',
  description: '',
  due_date: '',
  priority: 'medium',
})

// --- Computed Properties for Stats ---
const totalTasks = computed(() => tasks.value.length)
const completedTasks = computed(() => tasks.value.filter((task) => task.status === 'completed').length)
const pendingTasks = computed(() => tasks.value.filter((task) => task.status === 'pending').length)

// --- API Methods ---
const fetchTasks = async () => {
  loading.value = true
  errorMessage.value = ''

  try {
    const response = await axios.get(`${API_URL}/tasks`, {
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

const submitForm = async () => {
  if (!form.value.title.trim()) {
    alert('Please enter task title')
    return
  }

  try {
    await axios.post(`${API_URL}/tasks`, { ...form.value })
    
    // Reset the form after success
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
    await axios.patch(`${API_URL}/tasks/${task.id}`, {
      status: nextStatus,
    })
    await fetchTasks()
  } catch (error) {
    errorMessage.value = 'Cannot update task status.'
    console.error(error)
  }
}

const deleteTask = async (task) => {
  if (confirm(`Delete "${task.title}"?`)) {
    try {
      await axios.delete(`${API_URL}/tasks/${task.id}`)
      await fetchTasks()
    } catch (error) {
      errorMessage.value = 'Cannot delete task.'
      console.error(error)
    }
  }
}

// Initial fetch when the app starts
onMounted(() => {
  fetchTasks()
})
</script>

<template>
  <div>
    <Navbar />
    <main class="page">
    <!-- Hero Header -->
    <section class="hero">
      <p class="eyebrow">Vue.js + Laravel API</p>
      <h1>Task Manager</h1>
      <p class="subtitle">
        A simple full stack CRUD project for beginner training.
      </p>
    </section>

    <!-- Task Stats -->
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

    <!-- Create Task Form -->
    <section class="card">
      <h2>Create Task</h2>
      <form class="task-form" @submit.prevent="submitForm">
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

    <!-- Task List -->
    <section class="card">
      <div class="toolbar">
        <h2>Task List</h2>
        <div class="filters">
          <!-- We use @input and @change to fetch tasks immediately when the user types or selects -->
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
  </div>
</template>

<style>
/* Global Styles */
* {
  box-sizing: border-box;
}
body {
  margin: 0;
  font-family: Inter, Arial, sans-serif;
  background: #f4f7fb;
  color: #172033;
}
button, input, textarea, select {
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
input, textarea, select {
  width: 100%;
  border: 1px solid #d9e1ec;
  border-radius: 10px;
  padding: 12px 14px;
  background: #ffffff;
  outline: none;
}
input:focus, textarea:focus, select:focus {
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
.empty, .error {
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

/* Hero Header Styles */
.hero {
  margin-bottom: 24px;
}
.eyebrow {
  color: #42b883;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}
.hero h1 {
  margin: 0;
  font-size: 42px;
}
.subtitle {
  color: #6b7280;
}

/* Stats Styles */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-bottom: 18px;
}
.stat-card {
  background: white;
  border: 1px solid #e5eaf2;
  border-radius: 18px;
  box-shadow: 0 10px 30px rgba(31, 45, 61, 0.06);
  padding: 18px;
}
.stat-card span {
  display: block;
  color: #6b7280;
  margin-bottom: 6px;
}
.stat-card strong {
  font-size: 28px;
}
@media (max-width: 760px) {
  .stats-grid {
    grid-template-columns: 1fr;
  }
}

/* Form Styles */
.task-form {
  display: grid;
  gap: 12px;
}
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  align-items: center;
}
@media (max-width: 760px) {
  .form-row {
    grid-template-columns: 1fr;
  }
}

/* Task List Styles */
.toolbar {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  align-items: center;
}
.filters {
  display: grid;
  grid-template-columns: 1fr 160px;
  gap: 10px;
}
.task-list {
  display: grid;
  gap: 12px;
  margin-top: 16px;
}
.task-card {
  display: flex;
  justify-content: space-between;
  gap: 14px;
  padding: 18px;
  border: 1px solid #e7edf5;
  border-radius: 16px;
  background: #fbfcfe;
}
.task-card h3 {
  margin: 0 0 8px;
}
.task-card p {
  margin: 0 0 10px;
  color: #5f6b7a;
}
.done {
  text-decoration: line-through;
  color: #6b7280;
}
.meta, .actions {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}
.badge {
  display: inline-flex;
  border-radius: 999px;
  padding: 5px 10px;
  font-size: 12px;
  font-weight: 700;
  background: #eef2f7;
  color: #445066;
}
.badge.completed {
  background: #dcfce7;
  color: #166534;
}
.badge.pending {
  background: #fef3c7;
  color: #92400e;
}
.secondary {
  background: #3b82f6;
}
.danger {
  background: #ef4444;
}
@media (max-width: 760px) {
  .toolbar, .filters {
    grid-template-columns: 1fr;
  }
  .task-card {
    flex-direction: column;
  }
}
</style>
