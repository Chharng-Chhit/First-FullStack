<script setup>
// App.vue is now just a layout component containing navigation and router-view!
</script>

<template>
  <main class="page">
    <nav class="main-nav">
      <router-link to="/">Tasks</router-link>
      <router-link to="/about">About</router-link>
    </nav>

    <!-- Vue Router will inject the current page component here -->
    <router-view />
  </main>
</template>

<style>
/* Global Styles remain here */
* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: Inter, Arial, sans-serif;
  background: #f4f7fb;
  color: #172033;
}

button,
input,
textarea,
select {
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

input,
textarea,
select {
  width: 100%;
  border: 1px solid #d9e1ec;
  border-radius: 10px;
  padding: 12px 14px;
  background: #ffffff;
  outline: none;
}

input:focus,
textarea:focus,
select:focus {
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

.empty,
.error {
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

/* Navigation Styles */
.main-nav {
  display: flex;
  gap: 20px;
  margin-bottom: 30px;
  padding-bottom: 20px;
  border-bottom: 1px solid #e5eaf2;
}

.main-nav a {
  text-decoration: none;
  color: #6b7280;
  font-weight: 600;
  padding: 8px 16px;
  border-radius: 8px;
  transition: all 0.2s;
}

.main-nav a:hover {
  background: #f8fafc;
  color: #172033;
}

.main-nav a.router-link-active {
  background: #42b883;
  color: white;
}
</style>
