<template>
  <div>
    <div class="project-info-header shadow-sm" style="background-color: white">
      <div class="project-details">
        <h3 class="project-title">{{ project_name }}</h3>
      </div>
      <div class="project-actions">
        <div class="action-item" @click="toggleView">
          <i
            :class="isListView ? 'bi bi-grid-3x3-gap-fill' : 'bi bi-list-task'"
          ></i>
        </div>

        <button
          v-if="
            !isLoading ||
            project_name === 'Dự án Todo App' ||
            (isLeader && isGroup == true)
          "
          class="action-item share-button"
          data-bs-toggle="modal"
          data-bs-target="#shareModal"
        >
          <i class="bi bi-person-plus-fill"></i>
          Chia sẻ
        </button>
      </div>
    </div>
  </div>

  <div id="trello-board" v-if="!isListView">
    <template v-if="isLoading">
      <div class="list-container" v-for="n in 6" :key="n">
        <div class="trello-list skeleton-list">
          <div class="list-header">
            <div class="skeleton-title"></div>
            <div class="list-actions">
              <div class="skeleton-card-count"></div>
            </div>
          </div>
          <div class="card-container">
            <div class="trello-card skeleton-card" v-for="i in 3" :key="i">
              <div class="skeleton-card-content"></div>
              <div class="skeleton-card-deadline"></div>
              <div class="card-meta">
                <div
                  class="skeleton-card-meta-avatar"
                  v-for="j in 2"
                  :key="j"
                ></div>
              </div>
            </div>
          </div>
          <div class="add-card-placeholder">
            <div class="skeleton-add-card-placeholder"></div>
          </div>
        </div>
      </div>
    </template>

    <template v-else>
      <div
        class="list-container"
        v-for="(taskList, status) in tasks"
        :key="status"
      >
        <div class="trello-list">
          <div class="list-header">
            <h3>{{ status }}</h3>
            <div class="list-actions">
              <span class="card-count">{{
                taskList ? taskList.length : 0
              }}</span>
              <div class="form-add">
                <span class="icon-add" @click="toggleDropdown(status)">+</span>

                <form
                  class="p-2 border shadow-sm bg-white form-detail"
                  style="width: 300px"
                  v-if="showDropdown[status]"
                  @submit.prevent="insertTask(projectId, status)"
                >
                  <div>
                    <label class="form-label fw-normal" style="font-size: 14px"
                      >Tiêu đề nhiệm vụ</label
                    ><br />
                    <small
                      class="text-danger"
                      v-if="errors && errors.title && errors.title.length > 0"
                    >
                      {{ errors.title[0] }}
                    </small>
                    <input
                      type="text"
                      class="form-control mb-2"
                      v-model="title"
                    />
                  </div>
                  <div>
                    <label class="form-label fw-normal" style="font-size: 14px"
                      >Người được phân công</label
                    ><br />
                    <small
                      class="text-danger"
                      v-if="
                        errors && errors.user_id && errors.user_id.length > 0
                      "
                    >
                      {{ errors.user_id[0] }}
                    </small>
                    <multiselect
                      v-model="newAssignees"
                      :options="member"
                      :multiple="true"
                      :close-on-select="false"
                      :clear-on-select="false"
                      :preserve-search="true"
                      placeholder="Tìm kiếm hoặc chọn người"
                      label="email"
                      track-by="id"
                      :preselect-first="false"
                      :taggable="true"
                      @tag="addTag"
                    >
                      <template slot="tag" slot-scope="{ option, remove }">
                        <span class="multiselect__tag custom-tag">
                          <span>{{ option.email }}</span>
                          <i
                            class="multiselect__tag-icon"
                            @click="remove(option)"
                          ></i>
                        </span>
                      </template>
                      <template slot="option" slot-scope="props">
                        <div class="option__desc">
                          <span class="option__title">{{
                            props.option.email
                          }}</span>
                        </div>
                      </template>
                      <template slot="afterList">
                        <div class="search-more-text">Tìm kiếm thêm...</div>
                      </template>
                      <template slot="noResult"
                        >Không tìm thấy kết quả.</template
                      >
                      <template slot="noOptions">Danh sách rỗng.</template>
                    </multiselect>
                  </div>
                  <div>
                    <label class="form-label fw-normal" style="font-size: 14px"
                      >Thời hạn hoàn thành</label
                    ><br />
                    <small
                      class="text-danger"
                      v-if="
                        errors && errors.deadline && errors.deadline.length > 0
                      "
                    >
                      {{ errors.deadline[0] }}
                    </small>
                    <input
                      type="text"
                      :ref="(el) => (datetimePickerRefs[status] = el)"
                      placeholder="Chọn ngày giờ"
                      class="form-control mb-3"
                      v-model="deadline"
                    />
                  </div>
                  <div class="d-flex justify-content-between">
                    <div class="d-flex gap-1">
                      <button class="btn btn-sm create-btn" type="submit">
                        Thêm nhanh
                      </button>
                      <router-link
                        :to="`/projects/${projectId}/tasks/new`"
                        class="btn btn-sm btn-secondary"
                      >
                        Chi tiết
                      </router-link>
                    </div>
                    <button
                      class="btn btn-sm btn-light border"
                      style="color: #042d62"
                    >
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <draggable
            class="card-container"
            :list="taskList"
            :group="{ name: 'tasks', pull: true, put: true }"
            item-key="id"
            @change="onTaskChange($event, status)"
            @start="onDragStart($event, status)"
          >
            <template #item="{ element }">
              <div class="trello-card">
                <router-link
                  :to="`/projects/${projectId}/tasks/${element.id}`"
                  class="text-decoration-none text-dark"
                >
                  <div class="card-content fw-semibold">
                    {{ element.title }}
                  </div>
                  <i
                    class="bi bi-clock text-dark"
                    style="font-size: 14px; margin-right: 5px"
                  ></i>
                  <span>{{ formatDateTime(element.deadline) }}</span>
                  <div class="card-meta">
                    <img
                      v-for="user in element.assignees"
                      :key="user.id"
                      :src="user.avatar"
                      style="width: 18px; border-radius: 2px; margin-left: 4px"
                      alt=""
                    />
                  </div>
                </router-link>
              </div>
            </template>
          </draggable>

          <div class="form-add">
            <span class="add-card-placeholder" @click="toggleDropdown(status)"
              >+ Thêm thẻ khác</span
            >
          </div>
        </div>
      </div>
    </template>
  </div>

  <div id="list-view" v-else class="list-container-list-view">
    <div
      class="list-view-group"
      v-for="(taskList, status) in tasks"
      :key="status"
    >
      <h4 class="list-view-group-title">{{ status }}</h4>
      <div class="list-view-item-header">
        <div class="list-view-item-title">Tiêu đề nhiệm vụ</div>
        <div class="list-view-item-assignees">Người được giao</div>
        <div class="list-view-item-deadline">Thời hạn</div>
      </div>
      <router-link
        :to="`/projects/${projectId}/tasks/${task.id}`"
        class="text-decoration-none text-dark"
        v-for="task in taskList"
        :key="task.id"
      >
        <div class="list-view-item">
          <div class="list-view-item-title">
            {{ task.title }}
          </div>
          <div class="list-view-item-assignees">
            <img
              v-for="user in task.assignees"
              :key="user.id"
              :src="user.avatar"
              class="assignee-avatar"
              alt=""
            />
          </div>
          <div class="list-view-item-deadline">
            <i class="bi bi-clock"></i> {{ formatDateTime(task.deadline) }}
          </div>
        </div>
      </router-link>
    </div>
  </div>

  <div
    class="modal fade"
    id="shareModal"
    tabindex="-1"
    aria-labelledby="shareModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="shareModalLabel">Chia sẻ bảng</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <small
            class="text-danger"
            v-if="errors && errors.email && errors.email.length > 0"
          >
            {{ errors.email[0] }}
          </small>

          <form class="d-flex mb-3 gap-2" @submit.prevent="sendEmail">
            <input
              type="email"
              class="form-control w-75"
              placeholder="Địa chỉ email"
              v-model="email"
            />

            <button
              disabled=""
              type="button"
              class="btn btn-primary share-btn w-25"
              v-if="sendLoading"
            >
              <svg
                aria-hidden="true"
                role="status"
                class="inline w-4 h-4 mr-3 text-white animate-spin"
                viewBox="0 0 100 101"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                  fill="#E5E7EB"
                ></path>
                <path
                  d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                  fill="currentColor"
                ></path>
              </svg>
              Chia sẻ
            </button>

            <button
              class="btn btn-primary share-btn1 w-25"
              type="submit"
              v-else
            >
              Chia sẻ
            </button>
          </form>

          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button
                class="nav-link active"
                id="members-tab"
                data-bs-toggle="tab"
                data-bs-target="#members"
                type="button"
                role="tab"
                aria-controls="members"
                aria-selected="true"
              >
                Thành viên của bảng thông tin
                <span class="member-count">1</span>
              </button>
            </li>
          </ul>
          <div class="tab-content mt-3" id="myTabContent">
            <div
              class="tab-pane fade show active"
              id="members"
              role="tabpanel"
              aria-labelledby="members-tab"
            >
              <div
                class="member-list-item d-flex justify-content-between align-items-center"
                v-for="value in member"
                :key="value.id"
              >
                <div class="d-flex align-items-center">
                  <img
                    :src="value.avatar"
                    alt=""
                    srcset=""
                    class="member-avatar"
                  />
                  <div class="member-info">
                    <p class="mb-0 member-name">
                      {{ value.fullname }} <span class="text-muted">(bạn)</span>
                    </p>
                    <small class="member-role">{{ value.email }}</small>
                  </div>
                </div>
                <button
                  class="btn btn-light admin-role-btn"
                  type="button"
                  v-if="value.pivot.role == 'member'"
                >
                  Thành viên
                </button>
                <button
                  class="btn btn-light admin-role-btn"
                  type="button"
                  v-else
                >
                  Trưởng dự án
                </button>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="requests"
              role="tabpanel"
              aria-labelledby="requests-tab"
            >
              <p class="text-muted">Không có yêu cầu tham gia nào.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { nextTick, onMounted, ref, computed } from "vue";
import draggable from "vuedraggable";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Vietnamese } from "flatpickr/dist/l10n/vn.js";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";
import { toast } from "vue3-toastify";
import { useTokenUser } from "@/components/store/useTokenUser";
export default {
  components: {
    draggable,
    Multiselect,
  },
  props: {
    projectId: {
      type: [String, Number],
      required: true,
    },
  },
  setup(props) {
    const showDropdown = ref({});
    const tasks = ref({});
    const project_name = ref("");
    const isGroup = ref(null);
    const isLoading = ref(false);
    const member = ref([]);
    const fpInstances = ref({});
    const datetimePickerRefs = ref({});
    const title = ref("");
    const deadline = ref("");
    const errors = ref({});
    const draggingTaskOldStatus = ref(null);
    const sendLoading = ref(false);
    const isLeader = ref(false);
    const { userId, token } = useTokenUser();
    const checkUserRole = (members) => {
      const foundMember = members.find((m) => String(m.id) === String(userId));

      if (foundMember && foundMember.pivot.role === "leader") {
        isLeader.value = true;
      } else {
        isLeader.value = false;
      }

      // console.log(currentUser.value);
      // console.log(members);
      // console.log(foundMember);
    };
    function toggleDropdown(status) {
      showDropdown.value[status] = !showDropdown.value[status];

      if (showDropdown.value[status]) {
        nextTick(() => {
          const inputElement = datetimePickerRefs.value[status];
          if (inputElement && !fpInstances.value[status]) {
            fpInstances.value[status] = flatpickr(inputElement, {
              enableTime: true,
              noCalendar: false,
              dateFormat: "Y-m-d H:i",
              altInput: true,
              altFormat: "d/m/Y H:i",
              minDate: "today",
              locale: Vietnamese,
              disableMobile: true,
            });
          }
        });
      } else {
        if (fpInstances.value[status]) {
          fpInstances.value[status].destroy();
          delete fpInstances.value[status];
        }
      }
    }

    const getTaskByIdProject = async (id) => {
      try {
        isLoading.value = true;
        const res = await axios.get(`http://127.0.0.1:8000/api/project/${id}`, {
          headers: {
            Authorization: `Bearer ${token.value}`,
          },
        });
        tasks.value = res.data.tasks_by_status;
        member.value = res.data.member;
        project_name.value = res.data.project_name;
        isGroup.value = res.data.isGroup;
        checkUserRole(res.data.member);
        // console.log(tasks.value);
      } catch (error) {
        console.error("Lỗi khi lấy dữ liệu nhiệm vụ:", error);
      } finally {
        isLoading.value = false;
      }
    };
    const newAssignees = ref([]);

    const addTag = (newTag) => {
      const tag = {
        name: newTag,
        id: member.value.length + 1,
        email: newTag,
      };
      member.value.push(tag);
      newAssignees.value.push(tag);
    };

    const insertTask = async (project_id, status) => {
      try {
        const res = await axios.post(
          "http://127.0.0.1:8000/api/task",
          {
            project_id: project_id,
            status: status,
            deadline: deadline.value,
            title: title.value,
            user_id: newAssignees.value.map((user) => user.id),
          },
          {
            headers: {
              Authorization: `Bearer ${token.value}`,
            },
          }
        );
        toast.success("Thêm nhiệm vụ thành công");
        title.value = "";
        deadline.value = "";
        newAssignees.value = [];
        errors.value = {};
        await getTaskByIdProject(project_id);
        showDropdown.value[status] = false;
      } catch (error) {
        errors.value = {};
        if (error.response && error.response.status === 422) {
          errors.value = error.response.data.errors;
        }
        console.log(error);
      }
    };

    const onDragStart = (event, status) => {
      draggingTaskOldStatus.value = status;
    };

    const onTaskChange = async (event, currentStatus) => {
      if (event.added) {
        const movedTask = event.added.element;
        const newStatus = currentStatus;

        const oldStatus = draggingTaskOldStatus.value;
        // console.log('sss' + oldStatus);
        // console.log('sss1' + newStatus);
        if (oldStatus !== newStatus) {
          try {
            await axios.put(
              "http://127.0.0.1:8000/api/task/update-status",
              {
                task_id: movedTask.id,
                status: newStatus,
                old_value: oldStatus,
                new_value: newStatus,
              },
              {
                headers: { Authorization: `Bearer ${token.value}` },
              }
            );

            movedTask.status = newStatus;
          } catch (err) {
            console.error("Lỗi khi cập nhật trạng thái nhiệm vụ:", err);
            await getTaskByIdProject(props.projectId);
          }
        }
      }
      draggingTaskOldStatus.value = null;
    };

    const formatDateTime = (dateStr) => {
      if (!dateStr) return "";
      const d = new Date(dateStr);
      const year = d.getFullYear();
      const month = String(d.getMonth() + 1).padStart(2, "0");
      const day = String(d.getDate()).padStart(2, "0");
      const hours = String(d.getHours()).padStart(2, "0");
      const minutes = String(d.getMinutes()).padStart(2, "0");
      return `${day}/${month}/${year} - ${hours}:${minutes}`;
    };
    const email = ref("");
    const sendEmail = async () => {
      sendLoading.value = true;
      try {
        await axios.post(
          "http://127.0.0.1:8000/api/invite-member",
          {
            project_id: props.projectId,
            email: email.value,
          },
          {
            headers: { Authorization: `Bearer ${token.value}` },
          }
        );
        toast.success("Gửi lời mời thành công");
        errors.value = {};
      } catch (error) {
        errors.value = {};
        if (error.response && error.response.status === 422) {
          errors.value = error.response.data.message;
        } else {
          errors.value = "Đã xảy ra lỗi. Không thể gửi lời mời";
        }
      } finally {
        sendLoading.value = false;
      }
    };

    const isListView = ref(false);
    const toggleView = () => {
      isListView.value = !isListView.value;
    };

    const allTasks = computed(() => {
      const mergedTasks = [];
      for (const status in tasks.value) {
        if (Object.hasOwnProperty.call(tasks.value, status)) {
          mergedTasks.push(...tasks.value[status]);
        }
      }
      return mergedTasks;
    });

    onMounted(async () => {
      await getTaskByIdProject(props.projectId);
    });

    return {
      tasks,
      isLoading,
      toggleDropdown,
      showDropdown,
      formatDateTime,
      datetimePickerRefs,
      member,
      addTag,
      newAssignees,
      insertTask,
      title,
      deadline,
      onTaskChange,
      errors,
      token,
      onDragStart,
      draggingTaskOldStatus,
      project_name,
      sendEmail,
      email,
      sendLoading,
      userId,
      isLeader,
      isGroup,
      isListView,
      toggleView,
      allTasks,
    };
  },
};
</script>
<style scoped>
.list-container-list-view {
  width: 100%;
  padding: 10px;
}

.list-view-group {
  margin-bottom: 20px;
}

.list-view-group-title {
  font-size: 1.2rem;
  font-weight: 600;
  color: #172b4d;
  padding: 8px 15px;
  background-color: #e2e2e2;
  border-radius: 4px;
  margin-bottom: 0;
}

.list-view-item-header {
  display: flex;
  justify-content: space-between;
  padding: 12px 15px;
  background-color: #f1f2f4;
  font-weight: 600;
  border-bottom: 1px solid #dfe1e6;
  font-size: 14px;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
}

.list-view-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 15px;
  background-color: #fff;
  border-bottom: 1px solid #dfe1e6;
  transition: background-color 0.2s ease;
  font-size: 14px;
}

.list-view-item:hover {
  background-color: #f4f5f7;
}

.list-view-item-title {
  flex-basis: 50%;
  word-wrap: break-word;
}

.list-view-item-assignees {
  flex-basis: 25%;
  text-align: center;
}

.list-view-item-deadline {
  flex-basis: 25%;
  text-align: right;
  color: #6b778c;
}

.assignee-avatar {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  margin-right: -8px;
  border: 2px solid #fff;
  box-shadow: 0 0 0 1px #dfe1e6;
}

.assignee-avatar:first-child {
  margin-right: 0;
}

/* Các đoạn CSS bạn đã có từ trước giữ nguyên */

.modal-title {
  font-weight: 600;
  font-size: 1.2rem;
}

.input-group-append .dropdown,
.input-group-append .dropdown-toggle {
  height: 100%;
}

.share-role-btn {
  background-color: #f1f2f4;
  color: #172b4d;
  border: 1px solid #ced4da;
  border-left: none;
  border-right: none;
  border-radius: 0;
  font-size: 14px;
}

.share-role-btn:hover {
  background-color: #dfe1e6;
  color: #172b4d;
}

.share-btn {
  background-color: #042d62;
  color: #fff;
  border: none;
  font-weight: 600;
  font-size: 14px;
  display: inline-flex;
  align-items: center;
}

.share-btn1 {
  background-color: #042d62;
  color: #fff;
  border: none;
  font-weight: 600;
  font-size: 14px;
}

.share-btn svg {
  display: inline;
  width: 1.3rem;
  height: 1.3rem;
  margin-right: 0.75rem;
  color: white;
  animation: spin_357 1s linear infinite;
}

@keyframes spin_357 {
  from {
    transform: rotate(0deg);
  }

  to {
    transform: rotate(360deg);
  }
}

.share-btn:hover {
  background-color: #102e3f;
}

.share-link-section {
  background-color: #f1f2f4;
  border-radius: 5px;
  border: 1px solid #e0e1e6;
}

.share-link-info {
  display: flex;
  align-items: flex-start;
  gap: 10px;
}

.link-icon {
  font-size: 20px;
  color: #42526e;
}

.link-text p {
  font-size: 14px;
  color: #172b4d;
}

.link-action {
  font-size: 12px;
  color: #0079bf;
  text-decoration: underline;
}

.link-action:hover {
  color: #026aa7;
}

.change-link-btn {
  font-size: 14px;
  color: #172b4d;
  background-color: #fff;
  border: 1px solid #dfe1e6;
}

.nav-tabs {
  border-bottom: 1px solid #dfe1e6;
}

.nav-tabs .nav-link {
  color: #42526e;
  border: none;
  border-bottom: 2px solid transparent;
  padding: 0.5rem 1rem;
  font-size: 14px;
}

.nav-tabs .nav-link.active {
  color: #172b4d;
  font-weight: 600;
  background-color: transparent;
  border-color: #0079bf;
}

.member-count {
  background-color: #e0e1e6;
  color: #42526e;
  border-radius: 50%;
  padding: 2px 7px;
  font-size: 12px;
  margin-left: 5px;
}

.member-list-item {
  padding: 8px 0;
}

.member-avatar {
  color: white;
  width: 32px;
  height: 32px;
  border-radius: 4px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
  font-size: 12px;
  margin-right: 10px;
}

.member-info .member-name {
  font-size: 14px;
  font-weight: 600;
  color: #172b4d;
}

.member-info .member-role {
  font-size: 12px;
  color: #6b778c;
}

.admin-role-btn {
  font-size: 14px;
  color: #172b4d;
  background-color: #fff;
  border: 1px solid #dfe1e6;
}

.admin-role-btn:hover {
  background-color: #f1f2f4;
}

.project-info-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 16px;
  color: #042d62;
  z-index: 9999;
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.project-details {
  display: flex;
  align-items: center;
  gap: 10px;
  padding-left: 20px;
}

.project-title {
  font-size: 17px;
  font-weight: bold;
  margin: 0;
}

.project-visibility-button {
  display: flex;
  align-items: center;
  gap: 5px;
  background-color: #042d62;
  border: none;
  border-radius: 3px;
  padding: 4px 8px;
  color: #fff;
  font-size: 12px;
  cursor: pointer;
}

.project-visibility-button:hover {
  background-color: rgba(255, 255, 255, 0.4);
}

.project-actions {
  display: flex;
  align-items: center;
  gap: 8px;
}

.action-item {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgba(155, 150, 150, 0.3);
  border-radius: 3px;
  padding: 6px 8px;
  cursor: pointer;
  font-size: 14px;
}

.action-item:hover {
  background-color: #b1c4d8;
}

.share-button {
  background-color: #042d62;
  color: #fff;
  font-weight: 500;
  gap: 5px;
  cursor: pointer;
}

.share-button:hover {
  background-color: #274975;
}

.more-options {
  font-size: 18px;
  font-weight: bold;
}

@keyframes pulse-bg {
  0% {
    background-color: #eee;
  }

  50% {
    background-color: #f5f5f5;
  }

  100% {
    background-color: #eee;
  }
}

.skeleton-list {
  background-color: #e2e2e2 !important;
}

.skeleton-title {
  width: 120px;
  height: 20px;
  background-color: #d1d1d1;
  border-radius: 4px;
  animation: pulse-bg 1.5s infinite;
}

.skeleton-card-count {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: #d1d1d1;
  animation: pulse-bg 1.5s infinite;
}

.skeleton-card {
  background-color: #d1d1d1;
  animation: pulse-bg 1.5s infinite;
}

.skeleton-card-content {
  width: 90%;
  height: 18px;
  background-color: #e2e2e2;
  border-radius: 4px;
  margin-bottom: 8px;
  animation: pulse-bg 1.5s infinite;
}

.skeleton-card-deadline {
  width: 60%;
  height: 14px;
  background-color: #e2e2e2;
  border-radius: 4px;
  margin-bottom: 8px;
  animation: pulse-bg 1.5s infinite;
}

.skeleton-card-meta-avatar {
  width: 20px;
  height: 20px;
  border-radius: 3px;
  background-color: #e2e2e2;
  margin-left: 4px;
  animation: pulse-bg 1.5s infinite;
}

.skeleton-add-card-placeholder {
  width: 100%;
  height: 20px;
  background-color: #d1d1d1;
  border-radius: 4px;
  animation: pulse-bg 1.5s infinite;
}

.multiselect__tag.custom-tag {
  display: flex;
  align-items: center;
  padding: 4px 8px 4px 4px;
  border-radius: 4px;
  background-color: #e0e0e0;
  color: #333;
  font-size: 13px;
  margin-right: 6px;
  margin-bottom: 4px;
  line-height: 1;
}

.custom-tag .multiselect__tag-icon {
  margin-left: 8px;
  cursor: pointer;
  font-size: 16px;
  line-height: 1;
}

.custom-tag .multiselect__tag-icon:after {
  content: "×";
  color: #999;
}

.custom-tag .multiselect__tag-icon:hover:after {
  color: #333;
}

.custom-avatar-circle {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 10px;
  font-weight: bold;
  color: white;
  margin-right: 8px;
  flex-shrink: 0;
}

.multiselect__option .option__desc {
  display: flex;
  align-items: center;
  padding: 5px 0;
}

.multiselect__option .option__title {
  margin-left: 5px;
}

.multiselect__input,
.multiselect__single {
  border: none;
  border-bottom: 1px solid #ced4da;
  padding: 6px 10px;
  min-height: 38px;
  box-sizing: border-box;
}

.multiselect__tags {
  border: 1px solid #ced4da;
  border-radius: 4px;
  padding: 8px 40px 0 8px;
  min-height: 38px;
}

.multiselect__placeholder {
  color: #6c757d;
}

.multiselect__select {
  height: 38px;
}

.search-more-text {
  padding: 8px 12px;
  color: #007bff;
  cursor: pointer;
  font-size: 14px;
  text-align: center;
}

.search-more-text:hover {
  background-color: #f8f9fa;
}

.create-btn {
  background-color: #042d62;
  color: #fff;
}

#trello-board {
  display: flex;
  padding: 10px;
  min-height: 100vh;
  overflow-x: auto;
  align-items: flex-start;
}

.list-container {
  display: flex;
}

.trello-list {
  background-color: #f5f5f7;
  border-radius: 3px;
  width: 310px;
  margin-right: 8px;
  padding: 8px;
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  max-height: calc(100vh - 10px);
  position: relative;
}

.list-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
  padding: 0 4px;
  /* Giảm padding ngang */
  color: #172b4d;
}

.list-header h3 {
  margin: 0;
  font-size: 14px;
  /* Giảm kích thước chữ */
  font-weight: 600;
  /* Đậm hơn */
}

.list-actions {
  display: flex;
  align-items: center;
  gap: 8px;
  /* Khoảng cách giữa các icon */
  font-size: 14px;
  color: #6b778c;
  /* Màu xám nhạt cho icon và số lượng */
}

.card-count {
  background-color: #c4c6ca;
  /* Nền xám cho số lượng */
  border-radius: 50%;
  /* Bo tròn */
  width: 20px;
  height: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 12px;
  font-weight: bold;
  color: #fff;
}

.icon-add,
.icon-more {
  cursor: pointer;
  padding: 2px 4px;
  font-size: 24px;
}

.icon-add:hover,
.icon-more:hover {
  background-color: rgba(9, 30, 66, 0.08);
  border-radius: 3px;
}

.list-progress-bar {
  background-color: #d1d4d8;
  height: 5px;
  border-radius: 5px;
  margin-bottom: 8px;
  overflow: hidden;
}

.progress-fill {
  background-color: #042d62;
  height: 100%;
  border-radius: 5px;
  transition: width 0.3s ease-in-out;
}

.card-container {
  flex-grow: 1;
  min-height: 300px;
  overflow-y: auto;
  padding-right: 2px;
  /* max-height: 500px; */
}

.trello-card {
  background-color: #fff;
  border-radius: 3px;
  box-shadow: 0 1px 0 rgba(9, 30, 66, 0.25);
  padding: 6px 8px;
  margin-bottom: 8px;
  cursor: pointer;
  word-wrap: break-word;
  color: #172b4d;
  font-size: 14px;
  max-height: 100px;
}

.trello-card:hover {
  background-color: #fdfdfd;
}

.card-content {
  margin-bottom: 4px;
}

.card-meta {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  flex-wrap: nowrap;
}

.card-assignee {
  font-weight: 500;
}

.card-icons {
  display: flex;
  align-items: center;
  gap: 8px;
}

.form-detail {
  position: absolute;
  z-index: 9999;
  transform: translateX(-90%);
}

.icon-star,
.icon-attach,
.icon-options {
  font-size: 14px;
  color: #6b778c;
}

.card-label {
  padding: 2px 6px;
  border-radius: 3px;
  font-weight: bold;
  font-size: 10px;
  color: #fff;
  text-transform: uppercase;
}

.add-card-placeholder,
.add-list-placeholder {
  color: #6b778c;
  padding: 8px 12px;
  cursor: pointer;
  margin-top: 8px;
  font-size: 14px;
  border-radius: 3px;
  display: flex;
  align-items: center;
  gap: 5px;
}

.add-card-placeholder:hover,
.add-list-placeholder:hover {
  background-color: rgba(9, 30, 66, 0.08);
  color: #172b4d;
}

.add-list-placeholder {
  width: 272px;
  background-color: rgba(0, 0, 0, 0.1);
  color: #fff;
  margin-left: 8px;
  display: flex;
  align-items: center;
  font-weight: bold;
}

.add-list-placeholder:hover {
  background-color: rgba(0, 0, 0, 0.2);
  color: #fff;
}

/* Responsive */
@media (max-width: 768px) {
  .list-view-item-header {
    display: none;
  }

  .list-view-item {
    flex-direction: column;
    align-items: flex-start;
    padding: 10px;
  }

  .list-view-item-title {
    flex-basis: 100%;
    font-weight: 600;
    margin-bottom: 5px;
  }

  .list-view-item-status {
    flex-basis: 100%;
    text-align: left;
    font-size: 12px;
    background-color: #e0e0e0;
    padding: 2px 8px;
    border-radius: 12px;
    margin-bottom: 5px;
  }

  .list-view-item-deadline {
    flex-basis: 100%;
    text-align: left;
    font-size: 12px;
  }

  /* Giao diện Trello-board */
  #trello-board {
    padding: 5px;
  }
  .trello-list {
    width: 270px;
    margin-right: 5px;
  }
}
</style>
