# Understanding Vue.js Emits

In Vue.js, components communicate with each other. A common rule is: **"Data flows down, events flow up."**

- **Props**: Parent components pass data DOWN to children.
- **Emits**: Child components send messages UP to parents.

## What is an `emit`?
Think of an `emit` like a walkie-talkie. A child component cannot directly change the data it receives from a parent. Instead, it presses the walkie-talkie button (`emit`) and shouts a message up to the parent component, asking the parent to change the data.

---

## 3 Steps of the Emit Process

Here is exactly how the emit process works, using our `TaskForm.vue` and `App.vue` as an example:

### Step 1: The Child Defines the Event
Before a child can shout a message, it has to declare the channels it is allowed to use. We do this using `defineEmits`.

**In `TaskForm.vue` (Child):**
```javascript
// We declare that this component is allowed to emit a 'create' event
const emit = defineEmits(['create'])
```

### Step 2: The Child Emits the Event
When an action happens (like a user clicking "Add Task"), the child component uses the `emit` function. It provides two things:
1. The **Name** of the event (`'create'`).
2. The **Payload** (the data we are sending to the parent, like the task details).

**In `TaskForm.vue` (Child):**
```javascript
const submitForm = () => {
  // 1. User clicks submit.
  // 2. We emit the 'create' event to the parent.
  // 3. We send the form data ({ title: '...', description: '...' }) as the payload.
  emit('create', { ...form.value })
}
```

### Step 3: The Parent Listens to the Event
The parent component (`App.vue`) places the child component in its template. To listen to the child's walkie-talkie, the parent uses the `@` symbol (which stands for `v-on`).

**In `App.vue` (Parent):**
```html
<template>
  <!-- 
    The parent is listening for the '@create' event. 
    When it hears it, it triggers the 'createTask' function! 
  -->
  <TaskForm @create="createTask" />
</template>

<script setup>
// The parent receives the payload (formData) that the child sent!
const createTask = async (formData) => {
  console.log("The child sent me this new task:", formData);
  // Now the parent can save it to the database!
  await api.post('/tasks', formData)
}
</script>
```

---

## Summary Diagram

```text
+-----------------------+
|                       |
|       App.vue         | <--- 3. Parent Hears `@create` and runs `createTask(formData)`
|      (Parent)         |
|                       |
+-----------+-----------+
            ^
            |  2. Child shouts `emit('create', formData)` UP to the parent
            |
+-----------+-----------+
|                       |
|    TaskForm.vue       | <--- 1. User clicks "Add Task" button
|      (Child)          |
|                       |
+-----------------------+
```
