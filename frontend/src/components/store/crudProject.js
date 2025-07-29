import { onMounted, ref } from "vue";
import axios from "axios";
import { Modal } from "bootstrap";
import { toast } from "vue3-toastify";
export const Project = {
  setup() {
    const projects = ref([]);
    const isLoading = ref(false);
    const projectModalInstance = ref(false);

    const getAllProject = async () => {
      try {
        isLoading.value = true;
        const res = await axios.get("http://127.0.0.1:8000/api/project");
        projects.value = res.data.projects;
        // console.log(res.data);

        isLoading.value = false;
      } catch (error) {
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
    onMounted(() => {
      if (userString) {
        const user = JSON.parse(userString);
        id.value = JSON.parse(user.id);
      }
    });
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
        await getAllProject();
        const modal = document.getElementById("exampleModal");
        const modalInstance = Modal.getInstance(modal);
        modalInstance.hide();
        projectModalInstance.value = false;
        toast.success("Thêm thành công");
        errors.value = {};
      } catch (error) {
        if (error.response && error.response.status === 422) {
          errors.value = error.response.data.errors;
        }
      }
    };

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
    };
  },
};
