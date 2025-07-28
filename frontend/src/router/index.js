import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/home",
    name: "client-home",
    component: () => import("../page/home/home.vue"),
    meta: { requiresAuth: true },
  },
  {
    path: "/",
    redirect: "/home",
  },
  {
    path: "/project",
    component: () => import("../page/projects/project-detail.vue"),
    meta: { requiresAuth: true },
  },
  {
    path: "/task",
    component: () => import("../page/tasks/task-detail.vue"),
    meta: { requiresAuth: true },
  },
  {
    path: "/task/new",
    component: () => import("../page/tasks/task-insert.vue"),
    meta: { requiresAuth: true },
  },
  {
    path: "/register",
    component: () => import("../page/users/register.vue"),
    meta: { hideHeader: true },
  },
  {
    path: "/login",
    component: () => import("../page/users/login.vue"),
    meta: { hideHeader: true },
  },
  {
    path: "/login-success",
    component: () => import("../page/users/LoginSuccess.vue"),
  },
  {
    path: "/forgot-password",
    component: () => import("../page/users/forgotPassword.vue"),
    meta: { hideHeader: true },
  },
  {
    path: "/reset-password",
    component: () => import("../page/users/resetPassword.vue"),
    meta: { hideHeader: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  document.title = to.meta.title || "DONEZO TASKMANAMENT";

  const token = localStorage.getItem("token");
  const userString = localStorage.getItem("user");
  const user = userString ? JSON.parse(userString) : null;

  const isAuthenticated = token && user;

  if ((to.path === "/login" || to.path === "/register") && isAuthenticated) {
    next("/home");
  } else if (to.meta.requiresAuth && !isAuthenticated) {
    next("/login");
  } else {
    next();
  }
});

export default router;
