<template>
    <div class="task-detail-page container-fluid p-0">
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
        } = Project.setup();
        const editableDivRef = ref(null);
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
.dark-mode .task-detail-page {
    background-color: #1a1a1a !important;
    /* Nền của toàn bộ trang */
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

.dark-mode input {
    background-color: #3c3e4b;
    color: aliceblue;

}

.dark-mode select {
    background-color: #3c3e4b;
    color: aliceblue;
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
