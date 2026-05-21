<script setup>
import StudentCard from '../components/StudentCard.vue'

const students = [
  { id: 1, name: 'Dara', skill: 'Vue.js' },
  { id: 2, name: 'Sokha', skill: 'Laravel' },
  { id: 3, name: 'Vanna', skill: 'JavaScript' },
  { id: 4, name: 'Bopha', skill: 'CSS' },
  { id: 5, name: 'Piseth', skill: 'PHP' }
]
</script>

<template>
  <h1>Students</h1>

  <StudentCard
    v-for="student in students"
    :key="student.id"
    :name="student.name"
    :skill="student.skill"
  />
</template>
