<template>
    <div class="task-detail-page container-fluid p-0">
        <header v-if="isLoading"
            class="task-detail-header d-flex flex-column flex-md-row align-items-md-center justify-content-between px-4 py-3 border-bottom">
            <div class="d-flex align-items-start align-items-md-center  flex-column flex-md-row">
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
            <div class="d-flex align-items-start align-items-md-center flex-column flex-md-row">
                <div class="d-flex flex-column align-items-start">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 custom-breadcrumb-ol">
                            <li class="breadcrumb-item">
                                <router-link :to="'/home'"
                                    class="text-decoration-none text-secondary fw-semibold small">Dự án</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link :to="`/projects/${projectId}/tasks`"
                                    class="text-decoration-none text-secondary fw-semibold small">Nhiệm vụ
                                </router-link>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="d-none d-lg-flex align-items-center gap-2">
                <div class="status-tag" :class="{ 'status-done': status === 'Việc cần làm' }"
                    @click="status = 'Việc cần làm'">
                    Việc cần làm
                </div>
                <div class="status-tag" :class="{ 'status-done': status === 'Phân tích' }"
                    @click="status = 'Phân tích'">
                    Phân tích
                </div>
                <div class="status-tag" :class="{ 'status-done': status === 'Thực hiện' }"
                    @click="status = 'Thực hiện'">
                    Thực hiện
                </div>
                <div class="status-tag" :class="{ 'status-done': status === 'Kiểm thử' }" @click="status = 'Kiểm thử'">
                    Kiểm thử
                </div>
                <div class="status-tag" :class="{ 'status-done': status === 'Hoàn tất' }" @click="status = 'Hoàn tất'">
                    Hoàn tất
                </div>
                <div class="status-tag" :class="{ 'status-done': status === 'Hủy bỏ' }" @click="status = 'Hủy bỏ'">
                    Hủy bỏ
                </div>
            </div>

            <div
                class="d-flex d-lg-none align-items-center gap-2 w-100 justify-content-between status-mobile-container">
                <div class="dropdown">
                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                        @click="toggleStatusDropdown">
                        Trạng thái
                    </button>
                    <div class="dropdown-menu" :class="{ 'show': showStatusDropdown }">
                        <a class="dropdown-item" :class="{ 'active': status === 'Việc cần làm' }"
                            @click="status = 'Việc cần làm'">Việc cần làm</a>
                        <a class="dropdown-item" :class="{ 'active': status === 'Phân tích' }"
                            @click="status = 'Phân tích'">Phân tích</a>
                        <a class="dropdown-item" :class="{ 'active': status === 'Thực hiện' }"
                            @click="status = 'Thực hiện'">Thực hiện</a>
                        <a class="dropdown-item" :class="{ 'active': status === 'Kiểm thử' }"
                            @click="status = 'Kiểm thử'">Kiểm thử</a>
                        <a class="dropdown-item" :class="{ 'active': status === 'Hoàn tất' }"
                            @click="status = 'Hoàn tất'">Hoàn tất</a>
                        <a class="dropdown-item" :class="{ 'active': status === 'Hủy bỏ' }"
                            @click="status = 'Hủy bỏ'">Hủy bỏ</a>
                    </div>
                </div>
            </div>
        </header>

        <main v-if="isLoading" class="task-content p-3 m-md-4" style="background-color: white">
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

        <main v-else class="task-content p-3 m-md-4" style="background-color: white">
            <div class="row">
                <form class="col-12" @submit.prevent="insertTask(projectId)">
                    <small class="text-danger" v-if="
                        errors && errors.title && errors.title.length > 0
                    ">
                        {{ errors.title[0] }}
                    </small>
                    <div class="d-flex align-items-center mb-1 flex-column align-items-start">

                        <input class="mb-0 fw-medium input" style="font-size: 1.5rem; padding: 5px" v-model="title"
                            placeholder="Nhập tiêu đề nhiệm vụ tại đây.." />

                    </div>

                    <div class="task-info-grid mb-4 mt-3">
                        <div class="task-info-row">
                            <div class="task-info-label">Dự án</div>
                            <div class="task-info-value fw-semibold">{{ project_name }}</div>
                        </div>
                        <div class="task-info-row">
                            <div class="task-info-label">Người được phân công</div>
                            <div class="task-info-value d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <multiselect v-if="editing1" v-model="newAssignees" :options="member"
                                        :multiple="true" :close-on-select="false" :clear-on-select="false"
                                        :preserve-search="true" placeholder="Chọn người được phân công" label="email"
                                        track-by="id" :preselect-first="false" :taggable="true" @tag="addTag">
                                        <template slot="tag" slot-scope="{ option, remove }">
                                            <span class="multiselect__tag custom-tag">
                                                <img :src="option.avatar" alt="" style="
                            width: 20px;
                            border-radius: 20%;
                            margin-right: 5px;
                            " />
                                                <span>{{ option.email }}</span>
                                                <i class="multiselect__tag-icon" @click="remove(option)"></i>
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
                                        <template slot="noResult">Không tìm thấy kết quả.</template>
                                        <template slot="noOptions">Danh sách rỗng.</template>
                                    </multiselect>
                                    <div v-else-if="newAssignees.length > 0"
                                        class="d-flex align-items-center flex-wrap gap-2">
                                        <div v-for="member in newAssignees" :key="member.id"
                                            class="d-flex align-items-center">
                                            <img :src="member.avatar" alt="Avatar"
                                                style="width: 20px; border-radius: 50%; margin-right: 5px" />
                                            <span class="fw-semibold small">{{ member.email }}</span>
                                        </div>
                                    </div>
                                    <div v-else>Chưa được phân công</div>
                                    <small class="text-danger" v-if="
                                        errors && errors.user_id && errors.user_id.length > 0
                                    ">
                                        {{ errors.user_id[0] }}
                                    </small>
                                </div>
                                <button @click="editing1 = !editing1" class="btn btn-sm btn-link text-primary ms-2 p-0"
                                    type="button">
                                    <i :class="editing1 == true ? 'bi bi-check-lg' : 'bi bi-pencil'"></i>
                                </button>
                            </div>
                        </div>
                        <div class="task-info-row">
                            <div class="task-info-label">Hạn chót</div>
                            <div class="task-info-value d-flex flex-column align-items-start">
                                <input type="text" ref="datetimePickerRefs" placeholder="Chọn ngày giờ"
                                    class="form-control border-0 border-bottom" v-model="deadline" />
                                <small class="text-danger" v-if="
                                    errors && errors.deadline && errors.deadline.length > 0
                                ">
                                    {{ errors.deadline[0] }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="fs-6 mb-2">Mô tả chi tiết</div>
                    <QuillEditor ref="quillRef" v-model:content="description" :toolbar="toolbarOptions"
                        content-type="html" theme="snow" style="height: 200px" />
                    <button class="btn create-btn" type="submit">Thêm</button>
                </form>
            </div>
        </main>
    </div>
</template>

<script>
import { nextTick, onMounted, onUnmounted, ref, watch } from "vue";
import axios from "axios";
import { toast } from 'vue3-toastify';
import Multiselect from "vue-multiselect";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Vietnamese } from "flatpickr/dist/l10n/vn.js";
import { Project } from "@/components/store/crudProject";
import { QuillEditor } from "@vueup/vue-quill";
import { useTokenUser } from "@/components/store/useTokenUser";

export default {
    components: {
        QuillEditor,
        Multiselect,

    },
    props: {
        projectId: {
            type: [String, Number],
            required: true,
        },
    },
    setup(props) {
        const showStatusDropdown = ref(false);

        const toggleStatusDropdown = () => {
            showStatusDropdown.value = !showStatusDropdown.value;
        };
        const isLoading = ref(true)
        const project_name = ref("")
        const member = ref([]);
        const newAssignees = ref([]);
        const editing1 = ref(false);
        const editing = ref(false);
        const deadline = ref("");
        const status = ref("Việc cần làm");
        const datetimePickerRefs = ref(null);
        const fpInstance = ref(null);
        const title = ref("");
        const description = ref("");
        const errors = ref({});
        const quillRef = ref(null);
        const toolbarOptions = [
            // Nhóm 1: Các định dạng văn bản cơ bản
            ["bold", "italic", "underline", "strike"], // in đậm, in nghiêng, gạch chân, gạch ngang

            // Nhóm 2: Các loại tiêu đề và blockquote
            [{ header: 1 }, { header: 2 }], // Tiêu đề H1, H2
            [{ list: "ordered" }, { list: "bullet" }], // Danh sách có số, danh sách có chấm
            [{ script: "sub" }, { script: "super" }], // Chỉ số dưới, chỉ số trên
            [{ indent: "-1" }, { indent: "+1" }], // Giảm thụt lề, tăng thụt lề
            [{ direction: "rtl" }], // Hướng văn bản từ phải sang trái

            // Nhóm 3: Kiểu chữ, căn chỉnh và màu sắc
            [{ size: ["small", false, "large", "huge"] }], // Cỡ chữ
            [{ header: [1, 2, 3, 4, 5, 6, false] }], // Tiêu đề H1-H6
            [{ font: [] }], // Kiểu font chữ
            [{ align: [] }], // Căn chỉnh văn bản
            ["clean"], // Xóa định dạng

            // Nhóm 4: Các đối tượng nhúng và link
            ["link", "image"], // Chèn link, ảnh, video
            ["code-block"], // Trích dẫn, khối code
        ];

        const {

            token
        } = useTokenUser()
        const getTaskByIdProject = async (id) => {
            try {
                // isLoading.value = true;
                const res = await axios.get(`${import.meta.env.VITE_URL_API}api/project/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token.value}`,
                    },
                });
                member.value = res.data.member;
                project_name.value = res.data.project_name;
                // console.log(tasks.value);
            } catch (error) {
                console.error("Lỗi khi lấy dữ liệu nhiệm vụ:", error);
            } finally {
                isLoading.value = false;
            }
        };

        const addTag = (newTag) => {
            const tag = {
                name: newTag,
                id: member.value.length + 1,
                email: newTag,
            };
            member.value.push(tag);
            newAssignees.value.push(tag);
        };

        const insertTask = async (project_id) => {
            try {
                const res = await axios.post(
                    `${import.meta.env.VITE_URL_API}api/task`,
                    {
                        project_id: project_id,
                        status: status.value,
                        deadline: deadline.value,
                        title: title.value,
                        description: description.value,
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
            } catch (error) {
                errors.value = {};
                if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
                console.log(error);
            }
        };

        const initFlatpickr = () => {
            const inputElement = datetimePickerRefs.value;
            // console.log("inputElement:", inputElement);
            if (inputElement) {
                if (fpInstance.value) {
                    fpInstance.value.destroy();
                }
                fpInstance.value = flatpickr(inputElement, {
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
        };

        onMounted(async () => {
            await getTaskByIdProject(props.projectId)
            await nextTick(() => {
                initFlatpickr();
            });

        });

        return {
            isLoading,
            project_name,
            member,
            deadline,
            fpInstance,
            editing1,
            editing,
            description,
            title,
            token,
            toolbarOptions,
            toggleStatusDropdown,
            showStatusDropdown,
            status,
            quillRef,
            datetimePickerRefs,
            newAssignees,
            addTag,
            insertTask,
            errors
        };
    },
};
</script>
<style scoped>
.dark-mode .task-detail-page {
    background-color: #1a1a1a !important;
    /* Nền của toàn bộ trang */
}

.dark-mode input {
    background-color: #3c3e4b;
    color: aliceblue;

}

.dark-mode select {
    background-color: #3c3e4b;
    color: aliceblue;
}

.dark-mode .task-detail-header {
    background-color: #3c3e4b !important;
    border-bottom: none;
}

.dark-mode .custom-breadcrumb-ol .breadcrumb-item a {
    color: #e7e6e6;
}

.dark-mode .task-main-title {
    color: #e7e6e6;
}

.dark-mode .small {
    color: #e7e6e6;
}

.dark-mode .task-info-value {
    color: #e7e6e6;
}

.dark-mode .task-content {
    background-color: #3c3e4b !important;
    /* Nền chính của nội dung */
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    color: #f0f0f0;
}

.dark-mode .member-info .member-name {
    color: #f0f0f0 !important;
}

.dark-mode .member-info .member-name span {
    color: #ccc !important;
}

.dark-mode .task-title-input {
    color: #f0f0f0 !important;
    border-bottom-color: #444;
}

.dark-mode .task-info-label {
    color: #ffffff;
}

.dark-mode .form-select:disabled,
.dark-mode .form-control:disabled {
    background-color: #4a4a4a;
    color: #ccc;
    cursor: not-allowed;
    opacity: 0.7;
}

.dark-mode .ql-container.ql-snow,
.dark-mode .ql-toolbar.ql-snow {
    background-color: #3a3a3a;
    border-color: #555;
}

.dark-mode .ql-editor {
    background-color: #3a3a3a;
    color: #f0f0f0;
}

.dark-mode .create-btn {
    margin-top: 5px;
    background-color: #0f3b75;
}

.dark-mode .create-btn:hover {
    background-color: #385579;
}

.dark-mode .divider {
    color: #ccc;
}

.dark-mode .divider::before,
.dark-mode .divider::after {
    background: #555;
}

.dark-mode .activity-item .fw-semibold {
    color: #f0f0f0;
}

.dark-mode .activity-item .small {
    color: #ccc;
}


@keyframes pulse-dark {
    0% {
        background-color: #444;
    }

    50% {
        background-color: #555;
    }

    100% {
        background-color: #444;
    }
}

.dark-mode .skeleton-box {
    background-color: #444;
    animation: pulse-dark 1.5s infinite;
}

.dark-mode .skeleton-input-title,
.dark-mode .skeleton-label,
.dark-mode .skeleton-value,
.dark-mode .skeleton-multiselect-value,
.dark-mode .skeleton-deadline-value,
.dark-mode .skeleton-icon-btn,
.dark-mode .skeleton-textarea,
.dark-mode .skeleton-btn-small,
.dark-mode .skeleton-to-label,
.dark-mode .skeleton-badge,
.dark-mode .skeleton-avatar,
.dark-mode .skeleton-input,
.dark-mode .skeleton-btn-send,
.dark-mode .skeleton-hr,
.dark-mode .skeleton-activity-header,
.dark-mode .skeleton-activity-text,
.dark-mode .skeleton-activity-li {
    background-color: #444;
}

.input-group1 {
    position: relative;
    display: flex;
    gap: 5px;
}

.emoji-picker-container {
    position: absolute;
    bottom: 100%;
    right: 0;
    margin-bottom: 5px;
    z-index: 1000;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    background-color: white;
}

.quill-editor-custom .ql-editor {
    min-height: 100px;
    max-height: 150px;
    overflow-y: auto;
}

.divider {
    display: flex;
    align-items: center;
    text-align: center;
    color: #6d6c6c;
    margin-bottom: 5px;
}

.divider::before,
.divider::after {
    content: "";
    flex: 1;
    height: 1px;
    background: #a0a0a0;
}

.divider span {
    padding: 0 15px;
    font-weight: bold;
}

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

.create-btn {
    background-color: #032f5c;
    color: white;
    margin-top: 5px;
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
    color: #000000;
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

.status-mobile-container .dropdown {
    position: relative;
}

.status-mobile-container .dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.25rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
}

.status-mobile-container .dropdown-menu.show {
    display: block;
}

.status-mobile-container .dropdown-item {
    display: block;
    width: 100%;
    padding: 0.25rem 1.5rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    text-decoration: none;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    cursor: pointer;
}

.status-mobile-container .dropdown-item:hover,
.status-mobile-container .dropdown-item.active {
    background-color: #f8f9fa;
    color: #032f5c;
    font-weight: 600;
}

.task-detail-page {
    background-color: #f8f9fa;
    min-height: 100vh;
}

@media (max-width: 1024px) {
    .task-detail-header .task-main-title {
        width: 120px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
}

@media (max-width: 768px) {
    .emoji-picker-container {
        top: 100%;
        bottom: 0%;
    }


    .task-detail-header {
        flex-direction: column !important;
        align-items: flex-start !important;

    }

    .task-detail-header .task-main-title {
        font-size: 1.25rem;
        width: 120px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .status-mobile-container {
        width: 100%;
        margin-top: 1rem;
    }

    .task-content {
        padding: 1rem !important;
        margin: 1rem !important;
    }

    .task-info-grid {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }

    .input-group1 {
        display: flex;
        gap: 0.5rem;
    }

    .input-group .form-control {
        width: 100%;
    }

    .input-group button {
        width: 100%;
    }

    .btn.create-btn {
        width: 100%;
        margin-left: 0 !important;
    }
}

@media (max-width: 768px) {
    .task-detail-header {
        flex-direction: column;
        align-items: flex-start !important;

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
        margin-top: 5px;
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
