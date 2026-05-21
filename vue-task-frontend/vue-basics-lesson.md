# Vue.js Basics for Beginners

Vue.js is a progressive JavaScript framework used to build user interfaces. It makes building interactive web applications much easier by connecting your data directly to your HTML.

When you use Vue in "Single File Components" (like our `App.vue`), the file is divided into three main sections:

## 1. The Anatomy of a `.vue` File

```html
<script setup>
// 1. Logic (JavaScript)
// This is where you put your variables, functions, and imports.
</script>

<template>
<!-- 2. View (HTML) -->
<!-- This is where you write your HTML and use Vue's special syntax to display data. -->
</template>

<style scoped>
/* 3. Styling (CSS) */
/* CSS written here only applies to this specific component if 'scoped' is used. */
</style>
```

---

## 2. Reactivity (`ref`)

In vanilla JavaScript, if you change a variable, the HTML doesn't update automatically. You have to manually find the HTML element and change its inner text.

In Vue, we use **Reactivity**. When data changes, Vue automatically updates the HTML for you! We use `ref()` to make a variable reactive.

```javascript
import { ref } from 'vue'

const count = ref(0) // Creating a reactive variable

// To change it inside the script, you MUST use .value
const addOne = () => {
  count.value = count.value + 1 
}
```

In the `<template>`, you don't need to write `.value`, Vue handles it automatically:
```html
<p>The count is: {{ count }}</p>
```

---

## 3. Vue Directives (The "v-" attributes)

Vue gives you special HTML attributes called directives that allow you to add logic directly inside your HTML.

### `v-if` (Conditional Rendering)
Use this to show or hide an element based on a condition.
```html
<!-- Only shows up if 'loading' is true -->
<p v-if="loading">Please wait...</p>
```

### `v-for` (Loops)
Use this to loop over an array and create HTML elements for each item.
```html
<!-- Creates a <li> for every task in the 'tasks' array -->
<ul>
  <li v-for="task in tasks" :key="task.id">
    {{ task.title }}
  </li>
</ul>
```

### `v-model` (Two-way Data Binding)
This is magic for forms! It links an input field directly to a `ref` variable. If the user types in the input, the variable updates. If the variable changes in code, the input updates.
```html
<input type="text" v-model="search" placeholder="Type here..." />
<p>You typed: {{ search }}</p>
```

### `@` or `v-on` (Event Listeners)
This is how you listen to user actions like clicks or form submissions. `@` is shorthand for `v-on:`.
```html
<!-- Runs the 'deleteTask' function when clicked -->
<button @click="deleteTask(task)">Delete</button>

<!-- Prevents the page from reloading when the form is submitted -->
<form @submit.prevent="submitForm">
```

---

## 4. `onMounted`

Sometimes you need to run some code immediately when the page loads (like fetching data from your Laravel API). You use the `onMounted` hook for this.

```javascript
import { onMounted } from 'vue'

onMounted(() => {
  // This runs as soon as the component is loaded onto the screen
  fetchTasks()
})
```

---

## 5. Connecting Data with `:` (v-bind)

If you want to use a JavaScript variable inside a standard HTML attribute (like `href`, `class`, or `disabled`), you must put a colon `:` in front of the attribute name. This tells Vue to evaluate what's inside the quotes as JavaScript.

```html
<!-- WRONG: This literally sets the class to the string "task.status" -->
<div class="task.status"></div>

<!-- RIGHT: This evaluates task.status (e.g., "completed") and applies it -->
<div :class="task.status"></div>
```
