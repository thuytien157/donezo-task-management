<template>
  <main class="container-fluid">
    <h4 class="text-start pt-2">Dự án nhóm</h4>
    <div class="row" v-if="isLoading">
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2" v-for="n in 12" :key="n">
        <div class="card">
          <div class="card__skeleton card__title"></div>
          <div class="card__skeleton card__description"></div>
          <div class="card__skeleton card__description"></div>
          <div class="card__skeleton card__meta"></div>
        </div>
      </div>
    </div>
    <div class="row" v-else>
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2" v-for="project in groupProjects" :key="project.id">
        <div class="card rounded text-start">
          <router-link :to="`/projects/${project.id}/tasks`" class="text-decoration-none">
            <h5 style="color: #032f5c">{{ project.title }}</h5>
            <div class="fw-light lh-lg" style="font-size: 14px">
              {{ project.status }}
            </div>
            <div class="text-danger lh-lg" style="font-size: 14px">
              Hạn chót: {{ formatDate(project.end_date) }}
            </div>

          </router-link>

          <div class="d-flex justify-content-between mt-2">
            <div class="lh-lg" style="font-size: 14px; color: #032f5c">
              {{ project.tasks_count }} tác vụ
            </div>
            <div class="custom-dropdown">

              <button class="btn btn-sm btn-light" @click.stop="toggleMenuByProjectId(project.id)">
                <i class="bi bi-three-dots-vertical"></i>
              </button>
              <ul class="custom-dropdown-menu" :class="{ show: activeMenuId === project.id }">
                <li>
                  <router-link class="dropdown-item" :to="`/projects/${project.id}`">Thông tin</router-link>
                </li>
                <li>
                  <router-link class="dropdown-item" :to="`/projects/${project.id}/charts`">Biểu đồ</router-link>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <hr class="my-4" />

    <h4 class="text-start pt-2">Dự án cá nhân</h4>
    <div class="row" v-if="isLoading">
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2" v-for="n in 12" :key="n">
        <div class="card">
          <div class="card__skeleton card__title"></div>
          <div class="card__skeleton card__description"></div>
          <div class="card__skeleton card__description"></div>
          <div class="card__skeleton card__meta"></div>
        </div>
      </div>
    </div>
    <div class="row" v-else>
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2" v-for="project in personalProjects" :key="project.id">
        <div class="card rounded text-start">
          <router-link :to="`/projects/${project.id}/tasks`" class="text-decoration-none">
            <h5 style="color: #032f5c">{{ project.title }}</h5>
            <div class="fw-light lh-lg" style="font-size: 14px">
              {{ project.status }}
            </div>
            <div class="text-danger lh-lg" style="font-size: 14px">
              Hạn chót: {{ formatDate(project.end_date) }}
            </div>

          </router-link>

          <div class="d-flex justify-content-between mt-2">
            <div class="lh-lg" style="font-size: 14px; color: #032f5c">
              {{ project.tasks_count }} tác vụ
            </div>
            <div class="custom-dropdown">

              <button class="btn btn-sm btn-light" @click.stop="toggleMenuByProjectId(project.id)">
                <i class="bi bi-three-dots-vertical"></i>
              </button>
              <ul class="custom-dropdown-menu" :class="{ show: activeMenuId === project.id }">
                <li>
                  <router-link class="dropdown-item" :to="`/projects/${project.id}`">Thông tin</router-link>
                </li>
                <li>
                  <router-link class="dropdown-item" :to="`/projects/${project.id}/charts`">Biểu đồ</router-link>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<script>
import { Project } from "@/components/store/crudProject";
import { onMounted, onUnmounted, ref } from "vue";

export default {
  setup() {
    const activeMenuId = ref(null);

    function toggleMenuByProjectId(projectId) {
      if (activeMenuId.value === projectId) {
        activeMenuId.value = null;
      } else {
        activeMenuId.value = projectId;
      }
    }

    function closeMenuOnClickOutside(event) {
      if (
        event.target.closest(".dropdown") === null &&
        activeMenuId.value !== null
      ) {
        activeMenuId.value = null;
      }
    }

    const {
      isLoading,
      formatDate,
      personalProjects,
      groupProjects,
      getAllProject,
    } = Project.setup();

    onMounted(async () => {
      await getAllProject();
      document.addEventListener("click", closeMenuOnClickOutside);
    });

    onUnmounted(() => {
      document.removeEventListener("click", closeMenuOnClickOutside);
    });

    return {
      activeMenuId,
      toggleMenuByProjectId,
      isLoading,
      formatDate,
      groupProjects,
      personalProjects,
      getAllProject,
    };
  },
};
</script>
<style scoped>
.content {
  padding-top: 76px;
  background-color: #fafafa;
}

.content1 {
  padding-top: none;
  background-color: #fafafa;
}

.card {
  width: 100%;
  max-width: 100%;
  padding: 1rem;
  text-align: left;
  border-radius: 0.8rem;
  background-color: white;
}

.card:hover {
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.card__skeleton {
  background-color: #e2e2e2;
  border-radius: 4px;
  margin-bottom: 0.5rem;
}

.card__title {
  height: 20px;
  width: 75%;
  margin-top: 0;
  margin-bottom: 1rem;
}

.card__description {
  height: 12px;
  width: 100%;
}

.card__description:nth-of-type(2) {
  width: 90%;
}

.card__description:nth-of-type(3) {
  width: 80%;
  margin-bottom: 1rem;
}

.card__meta {
  height: 12px;
  width: 50%;
}

.custom-card {
  position: relative;
}

.custom-dropdown {
  position: relative;
  /* Thêm position: relative để menu con định vị tương đối */
}

.custom-dropdown-menu {
  display: none;
  position: absolute;
  top: 100%;
  right: 0;
  /* Đặt menu ở bên phải nút toggle */
  background-color: white;
  border-radius: 0.25rem;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
  list-style: none;
  padding: 0.5rem 0;
  margin: 0;
  min-width: 10rem;
  z-index: 1000;
  transform: translate(0, 0.5rem);
  /* Di chuyển xuống dưới một chút */
  transition: all 0.2s ease-in-out;
}

.custom-dropdown-menu.show {
  display: block;
  transform: translate(0, 0);
  /* Di chuyển lên vị trí ban đầu khi hiển thị */
}

.custom-dropdown-menu li .dropdown-item {
  display: block;
  padding: 0.25rem 1rem;
  clear: both;
  color: #212529;
  text-decoration: none;
  background-color: transparent;
  border: 0;
  cursor: pointer;
  white-space: nowrap;
}

.custom-dropdown-menu li .dropdown-item:hover {
  color: #1e2125;
  background-color: #e9ecef;
}
</style>
