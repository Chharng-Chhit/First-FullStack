# Vue.js Core Concepts: Part 2

Once you understand basic reactivity (`ref`) and directives (`v-if`, `v-for`), you are ready to learn some of the more powerful core concepts in Vue.js!

---

## 1. Computed Properties (`computed`)

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

## 2. Watchers (`watch`)

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

## 3. Components and Props

As your `App.vue` gets larger, it becomes harder to read. Vue allows you to split your UI into smaller, reusable pieces called **Components**.

**Props** are custom attributes you can register on a component to pass data from a parent component down to a child component.

**Parent Component (`App.vue`):**
```html
<script setup>
import TaskCard from './TaskCard.vue'
import { ref } from 'vue'

const myTask = ref({ title: 'Cook dinner' })
</script>

<template>
  <!-- Passing 'myTask' data down into the TaskCard component -->
  <TaskCard :task="myTask" />
</template>
```

**Child Component (`TaskCard.vue`):**
```html
<script setup>
// The child declares what data it expects to receive
defineProps({
  task: Object
})
</script>

<template>
  <div class="card">
    <h3>{{ task.title }}</h3>
  </div>
</template>
```

---

## 4. Slots

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

## 5. Template Refs (Accessing DOM Elements)

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
