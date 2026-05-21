<template>
  <div class="app-layout">
    <nav class="navbar">
      <div class="brand">
        <span class="logo">⚡</span>
        <span class="title">Student App</span>
      </div>
      <div class="links">
        <RouterLink to="/">Home</RouterLink>
        <RouterLink to="/about">About</RouterLink>
        <RouterLink to="/students">Students</RouterLink>
        <RouterLink to="/tasks">Tasks</RouterLink>
      </div>
    </nav>

    <main class="page">
      <RouterView />
    </main>
  </div>
</template>

<style scoped>
.app-layout {
  min-height: 100vh;
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 24px;
  background: white;
  border-bottom: 1px solid #e5eaf2;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
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
.links a.router-link-active {
  color: #42b883;
}

.page {
  padding: 40px;
  max-width: 1000px;
  margin: 0 auto;
}
</style>
