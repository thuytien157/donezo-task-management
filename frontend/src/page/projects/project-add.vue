<template>
    <div class="task-detail-page container-fluid p-0">
        <!-- <main v-if="loading" class="task-content p-3 m-md-4" style="background-color: white">
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
        </main> -->

        <main class="task-content p-3 m-md-4" style="background-color: white">
            <div class="row">
                <form class="col-12" @submit.prevent="insertProject">

                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <input class="mb-0 fw-medium border-0 border-bottom w-100"
                            style="font-size: 1.5rem; color: #333; padding: 5px" v-model="title"
                            placeholder="Nhập tiêu đề án tại đây..." />
                        <small class="text-danger" v-if="
                            errors &&
                            errors.title &&
                            errors.title.length > 0
                        ">
                            {{ errors.title[0] }}
                        </small>
                    </div>

                    <div class="task-info-grid mb-4">
                        <div class="task-info-row">
                            <div class="task-info-label">Dự án</div>

                            <select class="form-select" v-model="is_group_project">
                                <option :value="false">Cá nhân</option>
                                <option :value="true">Nhóm</option>
                            </select>
                            <small class="text-danger" v-if="
                                errors &&
                                errors.is_group_project &&
                                errors.is_group_project.length > 0
                            ">
                                {{ errors.is_group_project[0] }}
                            </small>
                        </div>

                        <div class="task-info-row">
                            <div class="task-info-label">Thời gian bắt đầu</div>

                            <div class="task-info-value d-flex align-items-center">
                                <input type="date" class="form-control" v-model="start_date" :min="today" />
                            </div>
                            <small class="text-danger" v-if="
                                errors && errors.start_date && errors.start_date.length > 0
                            ">
                                {{ errors.start_date[0] }}
                            </small>
                        </div>
                        <div class="task-info-row">
                            <div class="task-info-label">Thời gian kết thúc</div>

                            <div class="task-info-value d-flex align-items-center">
                                <input type="date" class="form-control" v-model="end_date" :min="today" />
                            </div>
                            <small class="text-danger" v-if="
                                errors && errors.end_date && errors.end_date.length > 0
                            ">
                                {{ errors.end_date[0] }}
                            </small>
                        </div>
                        <div class="task-info-row">
                            <div class="task-info-label">Trạng thái</div>

                            <select class="form-select" v-model="status">
                                <option value="Đang thực hiện">Đang thực hiện</option>
                                <option value="Chưa bắt đầu">Chưa bắt đầu</option>
                            </select>
                            <small class="text-danger" v-if="
                                errors && errors.status && errors.status.length > 0
                            ">
                                {{ errors.status[0] }}
                            </small>
                        </div>
                    </div>
                    <div class="fs-6 mb-2">Mô tả chi tiết</div>
                    <QuillEditor ref="quillRef" v-model:content="description" :toolbar="toolbarOptions"
                        content-type="html" theme="snow" style="height: 300px" />

                    <button class="btn create-btn" type="submit">Thêm</button>
                </form>
            </div>
        </main>
    </div>
</template>

<script>
import { nextTick, onMounted, onUnmounted, ref, watch } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import { QuillEditor } from "@vueup/vue-quill";
import { Project } from "@/components/store/crudProject";

export default {
    components: {
        QuillEditor,
    },

    setup() {
        const {
            isLoading,
            status,
            end_date,
            start_date,
            is_group_project,
            description,
            title,
            insertProject,
            errors,
            today,
            projectModalInstance,
        } = Project.setup();
        const editableDivRef = ref(null);
        const quillRef = ref(null);
        const pastedFiles = ref([]);


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
        // const handlePaste = (event) => {
        //     const items = event.clipboardData.items;

        //     for (const item of items) {
        //         if (item.type.startsWith("image/")) {
        //             event.preventDefault();

        //             const file = item.getAsFile();
        //             pastedFiles.value.push(file);
        //             const imageUrl = URL.createObjectURL(file);
        //             const imageId = `pasted-image-${Date.now()}`;
        //             const imageHtml = `<img src="${imageUrl}" id="${imageId}" style="max-width: 100%; vertical-align: middle;">`;
        //             document.execCommand("insertHTML", false, imageHtml);
        //             updateContent();
        //             break;
        //         }
        //     }
        // };
        // const uploadImage = async (file) => {
        //     const formData = new FormData();
        //     formData.append("image", file);
        //     const res = await axios.post(
        //         "http://127.0.0.1:8000/api/task/upload-image",
        //         formData,
        //         {
        //             headers: {
        //                 Authorization: `Bearer ${token.value}`,
        //                 "Content-Type": "multipart/form-data",
        //             },
        //         }
        //     );
        //     return res.data.url;
        // };

        return {
            quillRef,

            toolbarOptions,
            editableDivRef,
            // handlePaste,
            isLoading,
            status,
            end_date,
            start_date,
            is_group_project,
            description,
            title,
            insertProject,
            errors,
            today,
        };
    },
};
</script>
<style scoped>
/* Định nghĩa các biến CSS để dễ dàng tùy chỉnh sau này */
:root {
    --primary-color: #042d62;
    --secondary-color: #f8f9fa;
    --border-color: #dee2e6;
    --text-color: #343a40;
    --muted-text-color: #6c757d;
    --placeholder-color: #999;
    --light-gray: #e9ecef;
    --dark-gray: #6c757d;
    --font-family: Arial, sans-serif;
}

/* Cấu trúc chung của trang */
.task-detail-page {
    background-color: var(--secondary-color);
    min-height: 100vh;
    font-family: var(--font-family);
    color: var(--text-color);
}

.task-content {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Tiêu đề dự án */
.task-title-input {
    font-size: 2rem;
    color: var(--text-color);
    font-weight: 500;
    border: none;
    border-bottom: 1px solid rgba(182, 179, 179, 0.39);
    width: 100%;
    padding-bottom: 5px;
    transition: border-bottom-color 0.3s;
}

.task-title-input:focus {
    outline: none;
    border-bottom-color: var(--primary-color);
}

/* Lưới thông tin dự án */
.task-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 0.5rem 2rem;
    margin-bottom: 2rem;
}

.task-info-label {
    color: var(--muted-text-color);
    font-weight: 500;
    font-size: 14px;
}

.task-info-value {
    font-size: 14px;
    padding-bottom: 0.5rem;
}

/* Các trường input và select */
.form-select,
.form-control {
    font-size: 14px;
}

/* Bộ soạn thảo QuillEditor */
.ql-container.ql-snow {
    border-radius: 0 0 8px 8px;
    border: 1px solid var(--border-color);
    min-height: 200px;
}

.ql-toolbar.ql-snow {
    border: 1px solid var(--border-color);
    border-radius: 8px 8px 0 0;
}

/* Input bình luận và nút Gửi */
.input-group1 {
    display: flex;
    align-items: flex-start;
    gap: 5px;
}

.input-group1 .form-control {
    flex-grow: 1;
    min-height: 40px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 8px 12px;
}

.input-group1 .btn-light {
    border: 1px solid var(--border-color);
    border-radius: 8px;
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    color: var(--muted-text-color);
    transition: background-color 0.2s;
}

.input-group1 .btn-light:hover {
    background-color: var(--light-gray);
}

.create-btn {
    background-color: #042d62;
    color: #fff;
    border: none;
    padding: 6px 16px;
    border-radius: 5px;
    position: relative;
    min-width: 90px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 5px;
}

.create-btn:hover {
    background-color: #042d62;
    color: #fff;
}

/* Emoji Picker */
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

/* Dấu phân cách */
.divider {
    display: flex;
    align-items: center;
    text-align: center;
    color: var(--muted-text-color);
    margin: 20px 0;
    font-weight: bold;
}

.divider::before,
.divider::after {
    content: "";
    flex: 1;
    height: 1px;
    background: var(--border-color);
}

.divider span {
    padding: 0 15px;
}

/* Lịch sử hoạt động */
.activity-item img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
}

.activity-item .fw-semibold {
    font-size: 14px;
}

.activity-item .small {
    font-size: 12px;
    color: var(--muted-text-color);
}

.activity-item ul {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
}

/* CSS cho Skeleton Loading */
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

.skeleton-input-title {
    width: 100%;
    height: 48px;
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
}

.skeleton-activity-text {
    width: 180px;
    height: 16px;
}

.skeleton-activity-li {
    width: 100%;
    height: 16px;
}

/* Responsive */
@media (max-width: 768px) {
    .task-content {
        padding: 1rem !important;
        margin: 1rem !important;
    }

    .task-info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .input-group1 {
        flex-direction: column;
    }

    .input-group1 .form-control {
        width: 100%;
    }

    .input-group1 .btn-light {
        width: 100%;
        margin-top: 5px;
    }

    .create-btn {
        width: 100%;
    }

    /* Sửa một số lớp CSS của Skeleton để phù hợp với mobile */
    .skeleton-input {
        width: 100%;
    }

    .skeleton-btn-send {
        width: 100%;
        margin-left: 0;
    }
}
</style>
