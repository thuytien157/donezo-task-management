<template>
  <main class="container-fluid mt-3">
    <div class="d-flex justify-content-between align-items-center">
      <h4 class="text-start pt-2">Dự án nhóm</h4>
      <nav v-if="groupProjects.length > itemsPerPage" aria-label="Group projects pagination">
        <ul class="pagination pagination-sm my-2">
          <li class="page-item" :class="{ disabled: currentPageGroup === 1 }">
            <a class="page-link" href="#" @click.prevent="currentPageGroup--">Trước</a>
          </li>
          <li class="page-item" v-for="page in totalPagesGroup" :key="page"
            :class="{ active: page === currentPageGroup }">
            <a class="page-link" href="#" @click.prevent="currentPageGroup = page">{{ page }}</a>
          </li>
          <li class="page-item" :class="{ disabled: currentPageGroup === totalPagesGroup }">
            <a class="page-link" href="#" @click.prevent="currentPageGroup++">Sau</a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="row" v-if="isLoading">
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2 card-dardmode" v-for="n in 12" :key="n">
        <div class="card">
          <div class="card__skeleton card__title"></div>
          <div class="card__skeleton card__description"></div>
          <div class="card__skeleton card__description"></div>
          <div class="card__skeleton card__meta"></div>
        </div>
      </div>
    </div>
    <div class="row" v-else style="min-height: 150px;">
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2" v-for="project in paginatedGroupProjects" :key="project.id">
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
            <div class="lh-lg tacvu" style="font-size: 14px;">
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
                  <router-link :to="`/projects/${project.id}/overview`" class="dropdown-item">Tổng hợp</router-link>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div v-if="groupProjects.length == 0" class="empty-state-container">
        <div class="empty-state-content">
          <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-folder2-open"
            viewBox="0 0 16 16">
            <path
              d="M1 3.5A1.5 1.5 0 0 1 2.5 2h2.764c.958 0 1.76.606 2.072 1.40a2 2 0 0 0 .584.804A1.5 1.5 0 0 1 9.736 5h5.514A1.5 1.5 0 0 1 16 6.5v1.293L14.736 5H9.736a.5.5 0 0 0-.462.291c-.42.876-1.125 1.631-2.28 2.083A3.5 3.5 0 0 0 1 9.5a3.5 3.5 0 0 0 2.28 3.291c1.155.452 1.86.607 2.28.083A.5.5 0 0 0 7.736 12h5.514L16 13.293V14.5A1.5 1.5 0 0 1 14.5 16H2.5A1.5 1.5 0 0 1 1 14.5zM2.5 3.5A.5.5 0 0 0 2 4v4.5A2.5 2.5 0 0 1 4.5 11H13.736a1.5 1.5 0 0 1 .462.291c.42.876 1.125 1.631 2.28 2.083A3.5 3.5 0 0 0 13.5 16H2.5A1.5 1.5 0 0 1 1 14.5v-11.5A.5.5 0 0 0 .5 2h-1zM2.5 3.5a.5.5 0 0 1 .5-.5h2.764a1.5 1.5 0 0 1 1.236.637l.636.953a.5.5 0 0 0 .408.209h4.456A1.5 1.5 0 0 1 14.5 5.5v11.5z" />
            <path
              d="M14.5 16h-12a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5h3.181a1.5 1.5 0 0 1 1.236.637l.636.953a.5.5 0 0 0 .408.209h6.059a.5.5 0 0 1 .5.5v2H14.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5z" />
          </svg>
          <h3 class="empty-state-title">Chưa có dự án nào</h3>
        </div>
      </div>
    </div>


    <hr />

    <div class="d-flex justify-content-between align-items-center">
      <h4 class="text-start pt-2">Dự án cá nhân</h4>
      <nav v-if="personalProjects.length > itemsPerPage" aria-label="Personal projects pagination">
        <ul class="pagination pagination-sm my-2">
          <li class="page-item" :class="{ disabled: currentPagePersonal === 1 }">
            <a class="page-link" href="#" @click.prevent="currentPagePersonal--">Trước</a>
          </li>
          <li class="page-item" v-for="page in totalPagesPersonal" :key="page"
            :class="{ active: page === currentPagePersonal }">
            <a class="page-link" href="#" @click.prevent="currentPagePersonal = page">{{ page }}</a>
          </li>
          <li class="page-item" :class="{ disabled: currentPagePersonal === totalPagesPersonal }">
            <a class="page-link" href="#" @click.prevent="currentPagePersonal++">Sau</a>
          </li>
        </ul>
      </nav>
    </div>
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
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2" v-for="project in paginatedPersonalProjects"
        :key="project.id">
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
            <div class="lh-lg tacvu" style="font-size: 14px;">
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
                  <router-link :to="`/projects/${project.id}/overview`" class="dropdown-item">Tổng hợp</router-link>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div v-if="personalProjects.length == 0" class="empty-state-container">
        <div class="empty-state-content">
          <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-folder2-open"
            viewBox="0 0 16 16">
            <path
              d="M1 3.5A1.5 1.5 0 0 1 2.5 2h2.764c.958 0 1.76.606 2.072 1.40a2 2 0 0 0 .584.804A1.5 1.5 0 0 1 9.736 5h5.514A1.5 1.5 0 0 1 16 6.5v1.293L14.736 5H9.736a.5.5 0 0 0-.462.291c-.42.876-1.125 1.631-2.28 2.083A3.5 3.5 0 0 0 1 9.5a3.5 3.5 0 0 0 2.28 3.291c1.155.452 1.86.607 2.28.083A.5.5 0 0 0 7.736 12h5.514L16 13.293V14.5A1.5 1.5 0 0 1 14.5 16H2.5A1.5 1.5 0 0 1 1 14.5zM2.5 3.5A.5.5 0 0 0 2 4v4.5A2.5 2.5 0 0 1 4.5 11H13.736a1.5 1.5 0 0 1 .462.291c.42.876 1.125 1.631 2.28 2.083A3.5 3.5 0 0 0 13.5 16H2.5A1.5 1.5 0 0 1 1 14.5v-11.5A.5.5 0 0 0 .5 2h-1zM2.5 3.5a.5.5 0 0 1 .5-.5h2.764a1.5 1.5 0 0 1 1.236.637l.636.953a.5.5 0 0 0 .408.209h4.456A1.5 1.5 0 0 1 14.5 5.5v11.5z" />
            <path
              d="M14.5 16h-12a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5h3.181a1.5 1.5 0 0 1 1.236.637l.636.953a.5.5 0 0 0 .408.209h6.059a.5.5 0 0 1 .5.5v2H14.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5z" />
          </svg>
          <h3 class="empty-state-title">Chưa có dự án nào</h3>
        </div>
      </div>
    </div>


  </main>
</template>
<script>
import { Project } from "@/components/store/crudProject";
import { computed, onMounted, onUnmounted, ref } from "vue";

export default {
  setup() {
    const activeMenuId = ref(null);
    const itemsPerPage = 8;
    const currentPageGroup = ref(1);
    const currentPagePersonal = ref(1)
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


    const totalPagesGroup = computed(() => {
      return Math.ceil(groupProjects.value.length / itemsPerPage);
    });

    const paginatedGroupProjects = computed(() => {
      const start = (currentPageGroup.value - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      return groupProjects.value.slice(start, end);
    });

    const totalPagesPersonal = computed(() => {
      return Math.ceil(personalProjects.value.length / itemsPerPage);
    });

    const paginatedPersonalProjects = computed(() => {
      const start = (currentPagePersonal.value - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      return personalProjects.value.slice(start, end);
    });

    function setPage(type, page) {
      if (type === 'group') {
        currentPageGroup.value = page;
      } else {
        currentPagePersonal.value = page;
      }
    }
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
      paginatedGroupProjects,
      paginatedPersonalProjects,
      getAllProject,
      itemsPerPage,
      currentPageGroup,
      currentPagePersonal,
      totalPagesGroup,
      totalPagesPersonal,
      setPage,
      groupProjects,
      personalProjects
    };
  },
};
</script>
<style scoped>
.dark-mode .card {
  background-color: #3C3E4B !important;
  border-color: #555 !important;
  box-shadow: 0 2px 4px rgba(255, 255, 255, 0.1);
}

.dark-mode .container-fluid {
  background-color: #1a1d26;
}

.dark-mode .card h5 {
  color: #fff !important;
}

.tacvu {
  color: #042d64;
}

.dark-mode .tacvu {
  color: #4888db;
}

.dark-mode .btn-light {
  background-color: #4a4a4a !important;
  border-color: #555 !important;
  color: #f0f0f0 !important;
}

.dark-mode .btn-light:hover {
  background-color: #555555 !important;
}

.dark-mode h4,
.dark-mode .empty-state-title {
  color: #f0f0f0;
}

.dark-mode .page-link {
  background-color: #2a2a2a;
  border-color: #555;
  color: #f0f0f0;
}

.dark-mode .page-item.active .page-link {
  background-color: #0f3b75;
  border-color: #0f3b75;
  color: #fff;
}

.dark-mode .page-link:hover {
  background-color: #444;
  border-color: #666;
}

.dark-mode .page-item.disabled .page-link {
  background-color: #2a2a2a;
  border-color: #555;
  color: #888;
}

.dark-mode .card {
  background-color: #3c3e4b;
  border: 1px solid #444;
}

.dark-mode .card h5 {
  color: #fff;
  /* Tiêu đề màu trắng */
}

.dark-mode .card .text-decoration-none {
  color: #f0f0f0;
}


.dark-mode .text-danger {
  color: #ff8a8a !important;
}

.dark-mode .custom-dropdown-menu {
  background-color: #3c3e4b;
  border: 1px solid #555;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.3);
}

.dark-mode .custom-dropdown-menu li .dropdown-item {
  color: #f0f0f0;
}

.dark-mode .custom-dropdown-menu li .dropdown-item:hover {
  background-color: #4a4a4a;
  color: #fff;
}

.dark-mode .btn-light {
  background-color: #4a4a4a !important;
  border-color: #555 !important;
  color: #f0f0f0 !important;
}

.dark-mode .btn-light:hover {
  background-color: #555555 !important;
}

.dark-mode .empty-state-content svg {
  color: #999999;
}

.empty-state-container {
  display: flex;
  justify-content: center;
  align-items: center;
}

.empty-state-content {
  text-align: center;
  color: #6c757d;
  padding: 40px;
  border-radius: 8px;
  max-width: 450px;
}

.empty-state-content svg {
  color: #8a8787;
  margin-bottom: 20px;
}

.empty-state-title {
  font-size: 16px;
  font-weight: 600;
  color: #343a40;
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
}

.custom-dropdown-menu {
  display: none;
  position: absolute;
  top: 100%;
  right: 0;
  background-color: white;
  border-radius: 0.25rem;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
  list-style: none;
  padding: 0.5rem 0;
  margin: 0;
  min-width: 10rem;
  z-index: 1000;
  transform: translate(0, 0.5rem);
  transition: all 0.2s ease-in-out;
}

.custom-dropdown-menu.show {
  display: block;
  transform: translate(0, 0);
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
