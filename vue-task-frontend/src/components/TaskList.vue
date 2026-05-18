<script setup>
defineProps({
  tasks: {
    type: Array,
    required: true,
  },
  loading: {
    type: Boolean,
    default: false,
  },
  errorMessage: {
    type: String,
    default: '',
  },
  search: {
    type: String,
    default: '',
  },
  filterStatus: {
    type: String,
    default: 'all',
  },
})

// Step 1: Define all the custom events this component is allowed to emit to the parent
const emit = defineEmits([
  'update:search',        // Used for v-model:search
  'update:filterStatus',  // Used for v-model:filterStatus
  'fetch',               // Tells parent to fetch new data from API
  'toggle-status',       // Tells parent a task status was clicked
  'delete-task',         // Tells parent the delete button was clicked
])

const updateSearch = (event) => {
  // Step 2: Emit the new search text up to the parent to update the v-model
  emit('update:search', event.target.value)
  // Step 3: Emit the 'fetch' event to tell the parent to call the API again
  emit('fetch')
}

const updateFilterStatus = (event) => {
  // Emit the new filter selection up to the parent
  emit('update:filterStatus', event.target.value)
  emit('fetch')
}

const toggleStatus = (task) => {
  // Emit the 'toggle-status' event and send the specific 'task' object as the payload
  emit('toggle-status', task)
}

const deleteTask = (task) => {
  if (confirm(`Delete "${task.title}"?`)) {
    // Emit the 'delete-task' event and send the specific 'task' object as the payload
    emit('delete-task', task)
  }
}
</script>

<template>
  <section class="card">
    <div class="toolbar">
      <h2>Task List</h2>

      <div class="filters">
        <input
          :value="search"
          type="search"
          placeholder="Search task..."
          @input="updateSearch"
        />

        <select :value="filterStatus" @change="updateFilterStatus">
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
</template>

<style scoped>
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

.meta,
.actions {
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
  .toolbar,
  .filters {
    grid-template-columns: 1fr;
  }

  .task-card {
    flex-direction: column;
  }
}
</style>
