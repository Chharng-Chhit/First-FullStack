<script setup>
import { computed } from 'vue'

const props = defineProps({
  tasks: {
    type: Array,
    required: true,
  },
})

const totalTasks = computed(() => props.tasks.length)
const completedTasks = computed(() => props.tasks.filter((task) => task.status === 'completed').length)
const pendingTasks = computed(() => props.tasks.filter((task) => task.status === 'pending').length)
</script>

<template>
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
</template>

<style scoped>
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
</style>
