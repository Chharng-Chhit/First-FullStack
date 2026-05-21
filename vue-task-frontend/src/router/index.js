import { createRouter, createWebHistory } from 'vue-router'

import HomeView from '../views/HomeView.vue'
import AboutView from '../views/AboutView.vue'
import StudentView from '../views/StudentView.vue'
import TaskView from '../views/TaskView.vue'

const routes = [
  {
    path: '/',
    component: HomeView
  },
  {
    path: '/about',
    component: AboutView
  },
  {
    path: '/students',
    component: StudentView
  },
  {
    path: '/students/:id',
    component: () => import('../views/StudentDetailView.vue')
  },
  {
    path: '/tasks',
    component: TaskView
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
