# Vue.js Comprehensive Guide for Beginners

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

---

## 6. Computed Properties (`computed`)

Sometimes you have data that depends on other data. For example, if you have a list of `tasks`, you might want to know how many tasks are `completed`. 

Instead of manually updating a counter every time a task changes, you can use a **Computed Property**. It automatically calculates the value and caches it until the underlying data changes.

```javascript
import { ref, computed } from 'vue'

const tasks = ref([
  { title: 'Learn Vue', status: 'completed' },
  { title: 'Learn Laravel', status: 'pending' }
])

// Vue automatically recalculates this ONLY when 'tasks' changes!
const completedCount = computed(() => {
  return tasks.value.filter(task => task.status === 'completed').length
})
```

In your HTML, you use it just like a normal `ref`:
```html
<p>You have {{ completedCount }} completed tasks.</p>
```

---

## 7. Watchers (`watch`)

While `computed` is for calculating new data, `watch` is for **performing an action** when data changes (like saving to a database, or logging something).

```javascript
import { ref, watch } from 'vue'

const search = ref('')

// Vue will run this function every time 'search.value' changes
watch(search, (newValue, oldValue) => {
  console.log(`User changed search from ${oldValue} to ${newValue}`)
  
  // Example: You could trigger an API call here automatically!
})
```

---

## 8. Components and Props

As your `App.vue` gets larger, it becomes harder to read. Vue allows you to split your UI into smaller, reusable pieces called **Components**.

**Props** (short for properties) are custom attributes you can register on a component to pass data from a parent component down to a child component.

### Defining Props in the Child
Look at a component like `StudentCard.vue`:

```javascript
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
```

1. **`defineProps()`**: Acts like a contract for your component. It tells Vue: *"This component expects to receive data from the outside."*
2. **Type Checking (`type: String`)**: Ensures the parent sends a string (text). Catching bugs early!
3. **`required: true`**: The component cannot function without this prop.
4. **`default: '...'`**: Provides a fallback value if the parent forgets to pass this prop.

### Using Components and Props in the Parent

Now look at how the parent component (`StudentView.vue`) actually passes this data to the child:

```html
<script setup>
import StudentCard from '../components/StudentCard.vue'

const students = [
  { id: 1, name: 'Dara', skill: 'Vue.js' }
]
</script>

<template>
  <StudentCard
    v-for="student in students"
    :key="student.id"
    :name="student.name"
    :skill="student.skill"
  />
</template>
```

**Why do we use a colon (`:`) in front of the props?**
Notice the `:` before `:name` and `:skill`. This is short for `v-bind`.
- If you write `name="student.name"`, Vue will literally pass the exact text string `"student.name"`.
- By writing `:name="student.name"`, you are telling Vue: *"Please evaluate `student.name` as a JavaScript variable and pass its actual value (e.g., 'Dara')."*

---

## 9. Slots

Props are great for passing data, but what if you want to pass **HTML** into a component? That's what **Slots** are for.

Think of a slot as a placeholder inside a child component where the parent can inject any HTML it wants.

**Child Component (`Modal.vue`):**
```html
<div class="modal">
  <!-- Whatever HTML the parent provides will appear here -->
  <slot></slot> 
</div>
```

**Parent Component (`App.vue`):**
```html
<Modal>
  <!-- This HTML gets injected into the <slot> of the Modal component -->
  <h2>Warning!</h2>
  <p>Are you sure you want to delete this task?</p>
  <button>Yes</button>
</Modal>
```

---

## 10. Template Refs (Accessing DOM Elements)

Usually, you let Vue handle the DOM (HTML elements) for you using `v-if` and `v-model`. But sometimes you need direct access to an HTML element, for example, to focus an input field when the page loads.

You can use a `ref` on an HTML element to get a direct JavaScript reference to it.

```html
<script setup>
import { ref, onMounted } from 'vue'

// 1. Create a ref with a null value
const myInput = ref(null)

onMounted(() => {
  // 3. Once the component is mounted, myInput.value points to the actual HTML element!
  myInput.value.focus()
})
</script>

<template>
  <!-- 2. Attach the ref to the HTML element -->
  <input ref="myInput" type="text" placeholder="I will be focused automatically!" />
</template>
```
