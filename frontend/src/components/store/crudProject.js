import { onMounted, ref } from "vue";
import axios from "axios";
import { Modal } from "bootstrap";
import { toast } from "vue3-toastify";
import Pusher from "pusher-js";
export const Project = {
  setup() {
    const projects = ref([]);
    const isLoading = ref(false);
    const projectModalInstance = ref(false);
    const groupProjects = ref([]);
    const personalProjects = ref([]);
    const getAllProject = async () => {
      try {
        isLoading.value = true;
        const res = await axios.get("http://127.0.0.1:8000/api/project");
        projects.value = res.data.projects;
        groupProjects.value = projects.value.filter(
          (project) => project.is_group_project == 1
        );
        // console.log(groupProjects.value);

        personalProjects.value = projects.value.filter(
          (project) => project.is_group_project == 0
        );
        isLoading.value = false;
      } catch (error) {
        isLoading.value = false;
        console.log(error);
      }
    };

    const formatDate = (dateStr) => {
      if (!dateStr) return "";
      const date = new Date(dateStr);
      return date.toLocaleDateString("vi-VN");
    };

    const title = ref("");
    const description = ref("");
    const is_group_project = ref(false);
    const start_date = ref("");
    const end_date = ref("");
    const status = ref("Đang thực hiện");
    const today = new Date().toISOString().split("T")[0];
    const isLoading1 = ref(false);
    const errors = ref({});
    const id = ref(0);
    const userString = localStorage.getItem("user");

    const insertProject = async () => {
      try {
        const res = await axios.post("http://127.0.0.1:8000/api/project", {
          owner_id: id.value,
          title: title.value,
          description: description.value,
          is_group_project: is_group_project.value,
          start_date: start_date.value,
          end_date: end_date.value,
          status: status.value,
        });

        const modal = document.getElementById("exampleModal1");
        const modalInstance = Modal.getInstance(modal);
        if (modalInstance) {
          modalInstance.hide();
        }
        projectModalInstance.value = false;
        toast.success("Thêm thành công");

        errors.value = {};
      } catch (error) {
        if (error.response && error.response.status === 422) {
          errors.value = error.response.data.errors;
        }
      }
    };

    const project = ref({});
    const getProjectById = async (id) => {
      isLoading.value = true;
      try {
        const res = await axios.get(
          `http://127.0.0.1:8000/api/project/${id}/edit`
        );
        project.value = res.data.project;
        description.value = res.data.project.description;
        isLoading.value = false;
      } catch (error) {
        console.log(error);
      }
    };
    const editProjectById = async (id) => {
      isLoading.value = true;
      try {
        const res = await axios.put(`http://127.0.0.1:8000/api/project/${id}`, {
          description: description.value,
        });
        isLoading.value = false;
        toast.success("Sửa thành công");
      } catch (error) {
        console.log(error);
      }
    };
    onMounted(() => {
      if (userString) {
        const user = JSON.parse(userString);
        id.value = JSON.parse(user.id);
      }
    });
    return {
      projects,
      isLoading,
      formatDate,
      getAllProject,
      isLoading1,
      status,
      end_date,
      start_date,
      is_group_project,
      description,
      title,
      insertProject,
      errors,
      today,
      id,
      projectModalInstance,
      personalProjects,
      groupProjects,
      getProjectById,
      project,
      editProjectById,
    };
  },
};
