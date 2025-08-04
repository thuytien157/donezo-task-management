<template>
    <div class="task-detail-page container-fluid p-0">
        <header v-if="loading"
            class="task-detail-header d-flex flex-column flex-md-row align-items-md-center justify-content-between px-4 py-3 border-bottom">
            <div class="d-flex align-items-start align-items-md-center mb-3 mb-md-0 flex-column flex-md-row">
                <div class="skeleton-box skeleton-btn me-md-3 mb-2 mb-md-0"></div>
                <div class="d-flex flex-column align-items-start">
                    <div class="skeleton-box skeleton-breadcrumb"></div>
                    <div class="skeleton-box skeleton-title-main mt-2"></div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="skeleton-box skeleton-status-tag"></div>
                <div class="skeleton-box skeleton-status-tag"></div>
                <div class="skeleton-box skeleton-status-tag"></div>
                <div class="skeleton-box skeleton-pagination-count"></div>
                <div class="skeleton-box skeleton-pagination-btn"></div>
                <div class="skeleton-box skeleton-pagination-btn"></div>
            </div>
        </header>

        <header v-else
            class="task-detail-header d-flex flex-column flex-md-row align-items-md-center justify-content-between px-4 py-3 border-bottom">
            <div class="d-flex align-items-start align-items-md-center mb-3 mb-md-0 flex-column flex-md-row">
                <router-link :to="'task/new'" class="btn create-btn-new me-md-3 mb-2 mb-md-0">Mới</router-link>
                <div class="d-flex flex-column align-items-start">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 custom-breadcrumb-ol">
                            <li class="breadcrumb-item">
                                <router-link :to="'/home'"
                                    class="text-decoration-none text-secondary fw-semibold small">Dự án</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link :to="`/projects/${projectId}/tasks`"
                                    class="text-decoration-none text-secondary fw-semibold small">Nhiệm vụ</router-link>
                            </li>
                        </ol>
                    </nav>
                    <div class="text-dark fw-semibold task-main-title">
                        {{ task.title }}
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Việc cần làm' }"
                    @click="handleStatusChange('Việc cần làm')">
                    Việc cần làm <span class="status-count"></span>
                </div>
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Phân tích' }"
                    @click="handleStatusChange('Phân tích')">
                    Phân tích
                </div>
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Thực hiện' }"
                    @click="handleStatusChange('Thực hiện')">
                    Thực hiện
                </div>
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Kiểm thử' }"
                    @click="handleStatusChange('Kiểm thử')">
                    Kiểm thử
                </div>
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Hoàn tất' }"
                    @click="handleStatusChange('Hoàn tất')">
                    Hoàn tất
                </div>
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Hủy bỏ' }"
                    @click="handleStatusChange('Hủy bỏ')">
                    Hủy bỏ
                </div>
                <span class="text-muted small me-1">1 / 1</span>
                <router-link :to="`/projects/${projectId}/tasks/${prevTaskId}`"
                    class="btn btn-sm btn-light border text-secondary px-2 py-0">
                    <i class="bi bi-chevron-left"></i>
                </router-link>
                <router-link :to="`/projects/${projectId}/tasks/${nextTaskId}`"
                    class="btn btn-sm btn-light border text-secondary px-2 py-0">
                    <i class="bi bi-chevron-right"></i>
                </router-link>
            </div>
        </header>

        <main v-if="loading" class="task-content p-3 m-md-4" style="background-color: white;">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <div class="skeleton-box skeleton-input-title"></div>
                    </div>
                    <div class="task-info-grid mb-4">
                        <div class="task-info-row">
                            <div class="task-info-label skeleton-box skeleton-label"></div>
                            <div class="task-info-value skeleton-box skeleton-value"></div>
                        </div>
                        <div class="task-info-row">
                            <div class="task-info-label skeleton-box skeleton-label"></div>
                            <div class="task-info-value d-flex align-items-center">
                                <div class="skeleton-box skeleton-multiselect-value"></div>
                                <div class="skeleton-box skeleton-icon-btn ms-2"></div>
                            </div>
                        </div>
                        <div class="task-info-row">
                            <div class="task-info-label skeleton-box skeleton-label"></div>
                            <div class="task-info-value d-flex align-items-center">
                                <div class="skeleton-box skeleton-deadline-value"></div>
                                <div class="skeleton-box skeleton-icon-btn ms-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="fs-6 mb-2 skeleton-box skeleton-label"></div>
                    <div class="skeleton-box skeleton-textarea mb-1"></div>
                    <div class="d-flex gap-1 mb-4">
                        <div class="skeleton-box skeleton-btn-small"></div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3 ms-sm-4">
                        <div class="skeleton-box skeleton-to-label me-2 mb-2 mb-sm-0"></div>
                        <div class="d-flex flex-wrap gap-2">
                            <div class="skeleton-box skeleton-badge"></div>
                            <div class="skeleton-box skeleton-badge"></div>
                            <div class="skeleton-box skeleton-badge"></div>
                        </div>
                    </div>
                    <div class="input-group mb-1">
                        <div class="skeleton-box skeleton-avatar"></div>
                        <div class="skeleton-box skeleton-input"></div>
                        <div class="skeleton-box skeleton-icon-btn"></div>
                    </div>
                    <div class="skeleton-box skeleton-btn-send"></div>
                    <hr class="my-4 skeleton-hr" />
                    <div class="activity-log">
                        <div class="activity-item mb-3" v-for="i in 3" :key="i">
                            <div class="d-flex">
                                <div class="skeleton-box skeleton-avatar me-2"></div>
                                <div>
                                    <div class="skeleton-box skeleton-activity-header"></div>
                                    <div class="small mt-1">
                                        <div class="skeleton-box skeleton-activity-text"></div>
                                        <ul class="mb-0">
                                            <li>
                                                <div class="skeleton-box skeleton-activity-li"></div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <main v-else class="task-content p-3 m-md-4" style="background-color: white;">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <input class="mb-0 fw-medium input" style="font-size: 2rem; color: #333;" v-model="title"
                            @change="editTaskById" />
                    </div>

                    <div class="task-info-grid mb-4">
                        <div class="task-info-row">
                            <div class="task-info-label">Dự án</div>
                            <div class="task-info-value fw-semibold">{{ project.title }}</div>
                        </div>
                        <div class="task-info-row">
                            <div class="task-info-label">Người được phân công</div>
                            <div class="task-info-value d-flex align-items-center">
                                <multiselect v-if="editing1" v-model="selectedMembers" :options="member"
                                    :multiple="true" :close-on-select="false" :clear-on-select="false"
                                    :preserve-search="true" placeholder="Chọn người được phân công" label="email"
                                    track-by="id" :preselect-first="false" :taggable="true">
                                    <template slot="tag" slot-scope="{ option, remove }">
                                        <span class="multiselect__tag custom-tag">
                                            <img :src="option.avatar" alt=""
                                                style="width: 20px; border-radius: 20%; margin-right: 5px;" />
                                            <span>{{ option.email }}</span>
                                            <i class="multiselect__tag-icon" @click="remove(option)"></i>
                                        </span>
                                    </template>
                                    <template slot="option" slot-scope="props">
                                        <div class="option__desc">
                                            <span class="option__title">{{ props.option.email }}</span>
                                        </div>
                                    </template>
                                    <template slot="afterList">
                                        <div class="search-more-text">Tìm kiếm thêm...</div>
                                    </template>
                                    <template slot="noResult">Không tìm thấy kết quả.</template>
                                    <template slot="noOptions">Danh sách rỗng.</template>
                                </multiselect>
                                <div v-else-if="selectedMembers.length > 0"
                                    class="d-flex align-items-center flex-wrap gap-2">
                                    <div v-for="member in selectedMembers" :key="member.id"
                                        class="d-flex align-items-center">
                                        <img :src="member.avatar" alt="Avatar"
                                            style="width: 20px; border-radius: 50%; margin-right: 5px;" />
                                        <span class="fw-semibold small">{{ member.email }}</span>
                                    </div>
                                </div>
                                <div v-else>
                                    Chưa được phân công
                                </div>
                                <button @click="editing1 = !editing1" class="btn btn-sm btn-link text-primary ms-2 p-0">
                                    <i :class="editing1 == true ? 'bi bi-check-lg' : 'bi bi-pencil'"></i>
                                </button>
                            </div>
                        </div>
                        <div class="task-info-row">
                            <div class="task-info-label">Hạn chót</div>
                            <div class="task-info-value d-flex align-items-center">
                                <input v-if="editing" type="text" id="deadline-input"
                                    class="form-control border-0 border-bottom" v-model="deadline"
                                    @change="editTaskById" />
                                <div v-else class="fw-semibold text-danger">{{ formatDateTime(deadline) }}</div>
                                <button @click="editing = !editing" class="btn btn-sm btn-link text-primary ms-2 p-0">
                                    <i :class="editing ? 'bi bi-check-lg' : 'bi bi-pencil'"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="fs-6 mb-2">Mô tả chi tiết</div>
                    <textarea class="form-control mb-1" rows="6" v-model="description"
                        @change="editTaskById"></textarea>
                    <div class="d-flex gap-1 mb-4">
                        <button class="btn create-btn">Gửi tin</button>
                    </div>
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3 ms-sm-4">
                        <span class="text-secondary fw-semibold small me-2 mb-2 mb-sm-0">Đến:</span>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-light text-dark border fw-normal">cuongpham16895</span>
                            <span class="badge bg-light text-dark border fw-normal">khanhmps39093</span>
                            <span class="badge bg-light text-dark border fw-normal">quanmpcs39083</span>
                            <span class="badge bg-light text-dark border fw-normal">tuandmps40831</span>
                            <span class="badge bg-light text-dark border fw-normal">toanhttps39144</span>
                            <i class="bi bi-chevron-down text-secondary cursor-pointer"></i>
                        </div>
                    </div>
                    <div class="input-group mb-1">
                        <span class="input-group-text custom-badge bg-primary text-white">N</span>
                        <input type="text" class="form-control" placeholder="Gửi tin nhắn cho người theo dõi..." />
                        <button class="btn btn-light border"><i class="bi bi-emoji-smile"></i></button>
                    </div>
                    <button class="btn create-btn fw-semibold text-white"
                        style="background-color: #042d62; margin-left: 45px; margin-top: 5px;">Gửi</button>
                    <hr class="my-4" />
                    <div class="activity-log">
                        <div class="activity-item mb-3">
                            <div class="d-flex">
                                <span
                                    class="bg-secondary text-white me-2 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 32px; height: 32px; font-size: 14px;">
                                    N
                                </span>
                                <div>
                                    <span class="fw-semibold" style="font-size: 14px;">N4 Lê Thanh Toàn <small
                                            class="text-muted ms-2" style="font-size: 12px;">17:49 17 thg
                                            7</small></span>
                                    <div class="small">
                                        Giai đoạn đã thay đổi
                                        <ul class="mb-0">
                                            <li>
                                                Việc cần làm <i class="bi bi-arrow-right"></i>
                                                <span class="text-primary fw-semibold">Thực hiện</span>
                                                <span class="text-muted fst-italic">(Giai đoạn)</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="activity-item mb-3">
                            <div class="d-flex">
                                <span
                                    class="bg-secondary text-white me-2 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 32px; height: 32px; font-size: 14px;">
                                    N
                                </span>
                                <div>
                                    <span class="fw-semibold" style="font-size: 14px;">N4 Lê Thanh Toàn <small
                                            class="text-muted ms-2" style="font-size: 12px;">17:49 17 thg
                                            7</small></span>
                                    <div class="small">
                                        Giai đoạn đã thay đổi
                                        <ul class="mb-0">
                                            <li>
                                                Việc cần làm <i class="bi bi-arrow-right"></i>
                                                <span class="text-primary fw-semibold">Thực hiện</span>
                                                <span class="text-muted fst-italic">(Giai đoạn)</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="activity-item mb-3">
                            <div class="d-flex">
                                <span
                                    class="bg-secondary text-white me-2 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 32px; height: 32px; font-size: 14px;">
                                    N
                                </span>
                                <div>
                                    <span class="fw-semibold" style="font-size: 14px;">N4 Lê Thanh Toàn <small
                                            class="text-muted ms-2" style="font-size: 12px;">17:49 17 thg
                                            7</small></span>
                                    <div class="small">
                                        Giai đoạn đã thay đổi
                                        <ul class="mb-0">
                                            <li>
                                                Việc cần làm <i class="bi bi-arrow-right"></i>
                                                <span class="text-primary fw-semibold">Thực hiện</span>
                                                <span class="text-muted fst-italic">(Giai đoạn)</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { nextTick, onMounted, ref, watch } from 'vue';
import axios from 'axios';
import { Project } from '@/components/store/crudProject';
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Vietnamese } from "flatpickr/dist/l10n/vn.js";
import { toast } from 'vue3-toastify';

export default {
    components: {
        Multiselect,
    },
    props: {
        taskId: {
            type: [String, Number],
            required: true,
        },
        projectId: {
            type: [String, Number],
            required: true,
        },
    },
    setup(props) {
        const loading = ref(true); // Thêm biến loading
        const task = ref({});
        const creator = ref({});
        const project = ref({});
        const member = ref([]);
        const selectedMembers = ref([]);
        const editing = ref(false);
        const editing1 = ref(false);
        const deadline = ref("");
        const fpInstance = ref(null);
        const currentStatus = ref('');
        const title = ref('');
        const description = ref('');
        const {
            projects,
            getAllProject
        } = Project.setup();
        const prevTaskId = ref(props.taskId - 1);
        const nextTaskId = ref(parseInt(props.taskId) + 1);



        const insertTask = async (project_id, status) => {
            try {
                const res = await axios.post("http://127.0.0.1:8000/api/task", {
                    project_id: project_id,
                    created_by: user_id.value,
                    status: status,
                    deadline: deadline.value,
                    title: title.value,
                    user_id: newAssignees.value.map(user => user.id),
                });
                toast.success("Thêm nhiệm vụ thành công");
                title.value = '';
                deadline.value = '';
                newAssignees.value = [];
                errors.value = {}
                await getTaskByIdProject(project_id);
                showDropdown.value[status] = false;
            } catch (error) {
                errors.value = {}
                if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
                console.log(error);
            }
        };


        const handleStatusChange = async (newStatus) => {
            currentStatus.value = newStatus;
            await insertTask();
        };

        const initFlatpickr = () => {
            const inputElement = document.getElementById('deadline-input');
            if (inputElement) {
                if (fpInstance.value) {
                    fpInstance.value.destroy();
                }
                fpInstance.value = flatpickr(inputElement, {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i:s",
                    altInput: true,
                    altFormat: "d/m/Y H:i",
                    locale: Vietnamese,
                    disableMobile: true,
                    defaultDate: deadline.value,
                    onChange: (selectedDates, dateStr) => {
                        deadline.value = dateStr;
                    }
                });
            }
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

        onMounted(async () => {
            await getTaskById();
            await getAllProject();
            nextTick(() => {
                initFlatpickr();
            });
        });

        watch(editing, (newValue) => {
            if (newValue) {
                nextTick(() => {
                    initFlatpickr();
                });
            } else {
                if (fpInstance.value) {
                    fpInstance.value.destroy();
                    fpInstance.value = null;
                }
            }
        });

        watch(selectedMembers, async (newMembers, oldMembers) => {
            if (JSON.stringify(newMembers) !== JSON.stringify(oldMembers)) {
                await editTaskById();
            }
        }, { deep: true });

        return {
            loading, // Thêm loading vào return
            task,
            creator,
            project,
            projects,
            member,
            selectedMembers,
            editing,
            formatDateTime,
            deadline,
            fpInstance,
            editing1,
            editTaskById,
            currentStatus,
            description,
            title,
            handleStatusChange,
            nextTaskId,
            prevTaskId,
        };
    }
};
</script>
<style scoped>
.skeleton-box {
    background-color: #e2e2e2;
    border-radius: 4px;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% {
        background-color: #e2e2e2;
    }

    50% {
        background-color: #f0f0f0;
    }

    100% {
        background-color: #e2e2e2;
    }
}

.skeleton-btn {
    width: 70px;
    height: 38px;
}

.skeleton-breadcrumb {
    width: 150px;
    height: 14px;
    margin-bottom: 8px;
}

.skeleton-title-main {
    width: 250px;
    height: 24px;
}

.skeleton-status-tag {
    width: 90px;
    height: 34px;
}

.skeleton-pagination-count {
    width: 50px;
    height: 24px;
}

.skeleton-pagination-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
}

.skeleton-input-title {
    width: 100%;
    height: 48px;
    margin-bottom: 16px;
}

.skeleton-label {
    width: 120px;
    height: 18px;
}

.skeleton-value {
    width: 200px;
    height: 20px;
}

.skeleton-multiselect-value {
    width: 200px;
    height: 36px;
}

.skeleton-deadline-value {
    width: 150px;
    height: 36px;
}

.skeleton-icon-btn {
    width: 24px;
    height: 24px;
    border-radius: 4px;
}

.skeleton-textarea {
    width: 100%;
    height: 150px;
}

.skeleton-btn-small {
    width: 80px;
    height: 30px;
}

.skeleton-to-label {
    width: 80px;
    height: 20px;
}

.skeleton-badge {
    width: 100px;
    height: 24px;
}

.skeleton-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.skeleton-input {
    width: calc(100% - 80px);
    height: 40px;
}

.skeleton-btn-send {
    width: 60px;
    height: 38px;
    margin-left: 45px;
    margin-top: 5px;
}

.skeleton-hr {
    height: 1px;
    background-color: #e2e2e2;
    border: none;
}

.skeleton-activity-header {
    width: 250px;
    height: 20px;
    margin-bottom: 4px;
}

.skeleton-activity-text {
    width: 180px;
    height: 16px;
    margin-bottom: 4px;
}

.skeleton-activity-li {
    width: 100%;
    height: 16px;
}

.multiselect__tags {
    border: none !important;
    background: transparent !important;
    min-height: auto !important;
    padding: 0 !important;
    font-size: 14px;
    line-height: 1.2;
}

.multiselect__select {
    display: none !important;
}

.multiselect__tags .multiselect__input {
    display: none;
}

.multiselect--active .multiselect__tags .multiselect__input {
    display: block;
}

.multiselect__placeholder {
    display: none;
}

.multiselect__tag {
    background-color: transparent !important;
    border: none !important;
    color: #343a40 !important;
    padding: 2px 5px !important;
    font-size: 14px !important;
    margin-right: 5px !important;
    display: flex;
    align-items: center;
}

.multiselect__tag-icon {
    display: none;
}

.multiselect__tag img {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    margin-right: 5px;
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
    border: none;
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

/* Thẻ tag */
.multiselect__tag {
    background-color: #d0d1d1;
    /* xanh đậm */
    color: white;
    border-radius: 4px;
    font-weight: 600;
}

/* Màu khi hover option */
.multiselect__option--highlight {
    background-color: #c9b8ac;
    /* màu sáng dịu, trung tính */
    color: #042d62;
}

/* Màu option bình thường */
.multiselect__option {
    color: #042d62;
}

/* Placeholder và input */
.multiselect__input {
    color: #042d62;
}

/* Xóa box-shadow xanh lè */
.multiselect.is-open .multiselect__content-wrapper {
    box-shadow: 0 0 10px rgba(4, 45, 98, 0.3);
}

.input {
    color: #fff;
    font-size: 0.9rem;
    background-color: transparent;
    width: 100%;
    box-sizing: border-box;
    border: none;
    border-bottom: 1px solid rgba(182, 179, 179, 0.39);
}

/* styling of animated border */
.input-border {
    position: absolute;
    background: #5891ff;
    width: 0%;
    height: 2px;
    bottom: 0;
    left: 0;
    transition: 0.3s;
}

input:focus {
    outline: none;
}

input:focus~.input-border {
    width: 100%;
}

.task-detail-page {
    background-color: #f8f9fa;
    min-height: 100vh;
    font-family: Arial, sans-serif;
}

.task-detail-header {
    background-color: #ffffff;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
}

.create-btn-new {
    background-color: #e9ecef;
    color: #555;
    font-size: 13px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    padding: 8px 15px;
    min-width: 60px;
    text-align: center;
    white-space: nowrap;
}

.custom-breadcrumb-ol {
    margin-bottom: 0;
}

.custom-breadcrumb-ol .breadcrumb-item {
    color: #6c757d;
    font-size: 0.875rem;
    font-weight: 600;
}

.custom-breadcrumb-ol .breadcrumb-item+.breadcrumb-item::before {
    content: "/";
    color: #6c757d;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

.custom-breadcrumb-ol .breadcrumb-item a {
    color: #6c757d !important;
}

.task-main-title {
    font-size: 0.9rem;
    line-height: 1.2;
}

.status-tag {
    display: flex;
    align-items: center;
    padding: 0.3rem 0.75rem;
    margin-right: 0.5rem;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    background-color: #f0f2f5;
    color: #6c757d;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    white-space: nowrap;
}

.status-tag:hover {
    background-color: #e2e6ea;
    border-color: #c8cbce;
}

.status-tag.active-status-tag {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.status-tag.active-status-tag .status-count {
    background-color: rgba(255, 255, 255, 0.3);
    color: white;
}

.status-tag .status-count {
    background-color: #e9ecef;
    color: #6c757d;
    font-size: 0.75em;
    padding: 0.1em 0.4em;
    border-radius: 3px;
    margin-left: 0.5rem;
}

.status-mobile {
    display: none !important;
}

.status-tag.status-done {
    background-color: #bfc4c9;
    border-color: #7a8288;
    color: #032f5c;
    font-weight: 600;
}

.status-tag.status-done .status-count {
    color: #fff;
    background-color: #6c757d;
}


.task-content {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.task-content h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
}

.task-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 0.5rem 2rem;
    margin-bottom: 2rem;
}

.task-info-row {
    display: contents;
}

.task-info-label {
    color: #6c757d;
    font-weight: 500;
    font-size: 14px;
}

.task-info-value {
    color: #343a40;
    font-size: 14px;
    padding-bottom: 0.5rem;
}


/* Utility Classes */
.text-muted {
    color: #6c757d !important;
}

.text-secondary {
    color: #6c757d !important;
}

.fw-semibold {
    font-weight: 600 !important;
}

.small {
    font-size: 0.875em !important;
}

.cursor-pointer {
    cursor: pointer;
}

.activity-item .badge {
    min-width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 0.8rem;
    background-color: #6c757d;
}

@media (max-width: 768px) {
    .task-detail-header {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
        padding: 1rem;
    }

    .status-mobile {
        display: block !important;
    }

    .status-desktop {
        display: none !important;
    }

    .task-detail-header>div:first-child {
        width: 100%;
        justify-content: space-between;
        flex-direction: column;
        align-items: flex-start !important;
    }

    .create-btn-new {
        width: auto;
        margin-right: 0 !important;
        margin-bottom: 0.5rem !important;
    }

    .task-detail-header .d-flex.flex-column.align-items-start {
        width: 100%;
    }


    .task-detail-header .d-flex.flex-md-row.align-items-md-center.gap-2 {
        flex-direction: column;
        align-items: flex-start !important;
        width: 100%;
    }

    .task-detail-header .d-none.d-md-flex {
        display: none !important;
    }

    .task-detail-header .d-md-none {
        display: block !important;
        width: 100%;
    }

    .status-tag {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        margin-right: 0.25rem;
        margin-bottom: 0.5rem;
    }

    .task-info-grid {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }

    .task-content {
        padding: 1rem !important;
        margin: 1rem !important;
    }

    .d-flex.align-items-center.mb-3 {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .input-group {
        flex-direction: column;
        gap: 0.5rem;
    }

    .input-group input,
    .input-group button {
        width: 100%;
    }

    .btn.create-btn {
        width: 100%;
        margin-left: 0 !important;
    }

    .d-flex.align-items-center.gap-2.w-100.justify-content-end.w-md-auto {
        width: 100% !important;
        justify-content: flex-end !important;
        margin-top: 0.5rem;
    }
}

@media (max-width: 576px) {
    .task-detail-header .d-flex.align-items-md-center.gap-2 {
        align-items: stretch !important;
    }
}
</style>