<template>
  <div class="about-page">
    <section class="card">
      <h2>About This Project</h2>
      <p>
        This is a teaching project designed to show beginners how a Vue.js frontend 
        communicates with a Laravel backend using a REST API.
      </p>
      
      <h3>Key Concepts Covered:</h3>
      <ul>
        <li>Vue 3 Composition API (`script setup`)</li>
        <li>Component Architecture (Props & Emits)</li>
        <li>Vue Router</li>
        <li>Axios for API requests</li>
        <li>Laravel API Resources & Validation</li>
      </ul>
    </section>
  </div>
</template>

<style scoped>
.about-page {
  max-width: 600px;
  margin: 0 auto;
}

ul {
  line-height: 1.8;
  color: #4a5568;
}

h3 {
  margin-top: 30px;
  color: #2d3748;
}
</style>
