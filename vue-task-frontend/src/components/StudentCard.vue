<script setup>
defineProps({
  name: {
    type: String,
    required: true
  },
  skill: {
    type: String,
    default: 'Frontend Development'
  }
})
</script>

<template>
  <div class="card">
    <h2>{{ name }}</h2>
    <p>Skill: {{ skill }}</p>
  </div>
</template>

<style scoped>
.card {
  border: 1px solid #ddd;
  padding: 16px;
  border-radius: 10px;
  margin-bottom: 10px;
}
</style>
