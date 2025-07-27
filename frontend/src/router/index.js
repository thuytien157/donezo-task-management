import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/home',
    name: 'client-home',
    component: () => import('../page/home.vue'),
  },
  {
    path: '/',
    redirect: '/home'
  },
  {
    path: '/project',
    // redirect: '/project-detail',
    component: () => import("../page/project-detail.vue"),
  },
  {
    path: '/task',
    // redirect: '/project-detail',
    component: () => import("../page/task-detail.vue"),
  },
  {
    path: '/task/new',
    // redirect: '/project-detail',
    component: () => import("../page/task-insert.vue"),
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
