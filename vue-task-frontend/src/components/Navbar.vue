<template>
  <nav class="navbar">
    <div class="brand">
      <span class="logo">⚡</span>
      <span class="title">Task Manager App</span>
    </div>
    <div class="links">
      <a href="#" class="active">Home</a>
      <a href="#">About</a>
    </div>
  </nav>
</template>

<script setup>
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 24px;
  background: white;
  border-bottom: 1px solid #e5eaf2;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
  margin-bottom: 24px;
}

.brand {
  display: flex;
  align-items: center;
  gap: 10px;
}

.logo {
  font-size: 24px;
}

.title {
  font-size: 20px;
  font-weight: 700;
  color: #172033;
}

.links {
  display: flex;
  gap: 20px;
}

.links a {
  text-decoration: none;
  color: #6b7280;
  font-weight: 500;
  font-size: 16px;
  transition: color 0.2s;
}

.links a:hover,
.links a.active {
  color: #42b883;
}
</style>