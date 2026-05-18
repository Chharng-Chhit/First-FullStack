<script setup>
import { ref } from 'vue'

const emit = defineEmits(['create'])

const form = ref({
  title: '',
  description: '',
  due_date: '',
  priority: 'medium',
})

const submitForm = () => {
  if (!form.value.title.trim()) {
    alert('Please enter task title')
    return
  }

  // We use emit to send a message UP to the parent (App.vue)
  // The first argument 'create' is the name of the custom event
  // The second argument '{ ...form.value }' is the data payload we are sending to the parent
  emit('create', { ...form.value })

  // Reset the form
  form.value = {
    title: '',
    description: '',
    due_date: '',
    priority: 'medium',
  }
}
</script>

<template>
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
</template>

<style scoped>
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
</style>
