<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()
</script>

<template>
  <h1>Student Detail</h1>
  <p>Student ID: {{ route.params.id }}</p>
</template>
