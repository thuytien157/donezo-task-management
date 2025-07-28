<template>
    <div class="task-detail-page container-fluid p-0">
        <header
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
                                <router-link :to="'/project'"
                                    class="text-decoration-none text-secondary fw-semibold small">Nhiệm vụ</router-link>
                            </li>
                        </ol>
                    </nav>
                    <div class="text-dark fw-semibold task-main-title">
                        Code chức năng chatbot
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <div class="d-flex align-items-center status-desktop">
                    <div class="status-tag" :class="{ 'active-status-tag': currentStatus === 'todo' }"
                        @click="currentStatus = 'todo'">
                        Việc cần làm <span class="status-count">{{ task.statusCounts.todo }}</span>
                    </div>
                    <div class="status-tag" :class="{ 'active-status-tag': currentStatus === 'analysis' }"
                        @click="currentStatus = 'analysis'">
                        Phân tích/Thiết kế
                    </div>
                    <div class="status-tag" :class="{ 'active-status-tag': currentStatus === 'implement' }"
                        @click="currentStatus = 'implement'">
                        Thực hiện
                    </div>
                    <div class="status-tag" :class="{ 'active-status-tag': currentStatus === 'test' }"
                        @click="currentStatus = 'test'">
                        Kiểm thử <span class="status-count">7 ngày</span>
                    </div>
                    <div class="status-tag status-done" :class="{ 'active-status-tag': currentStatus === 'done' }"
                        @click="currentStatus = 'done'">
                        Hoàn tất <span class="status-count">1 tháng</span>
                    </div>
                    <div class="status-tag" :class="{ 'active-status-tag': currentStatus === 'cancel' }"
                        @click="currentStatus = 'cancel'">
                        Hủy bỏ <span class="status-count">1 phút</span>
                    </div>
                </div>
                <div class="d-flex align-items-center status-mobile">
                    <div class="dropdown">
                        <button class="status-tag" :class="{ 'active-status-tag': currentStatus === 'cancel' }"
                            data-bs-toggle="dropdown" @click="currentStatus = 'cancel'">
                            Hủy bỏ <span class="status-count">1 phút</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Kiểm thử</a></li>
                            <li><a class="dropdown-item" href="#">Hoàn tất</a></li>
                        </ul>
                    </div>
                </div>


                <span class="text-muted small me-1">1 / 1</span>
                <button class="btn btn-sm btn-light border text-secondary px-2 py-0">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-sm btn-light border text-secondary px-2 py-0">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </header>

        <main class="task-content p-3 m-md-4" style="background-color: white;">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <h2 class="mb-0 fw-medium" style="font-size: 2rem; color: #333;">{{ task.title }}</h2>
                    </div>

                    <div class="task-info-grid mb-4">
                        <div class="task-info-row">
                            <div class="task-info-label">Dự án</div>
                            <div class="task-info-value fw-semibold">{{ task.project }}</div>
                        </div>
                        <div class="task-info-row">
                            <div class="task-info-label">Người được phân công</div>
                            <div class="task-info-value d-flex align-items-center">
                                <span class="badge custom-badge me-2">{{ task.assignee.initials }}</span>
                                <span class="fw-semibold">{{ task.assignee.name }}</span>
                            </div>
                        </div>
                        <div class="task-info-row">
                            <div class="task-info-label">Hạn chót</div>
                            <div class="task-info-value text-danger fw-semibold">{{ task.deadline }}</div>
                        </div>
                    </div>

                    <div class="fs-6 mb-2">Mô tả chi tiết</div>
                    <textarea class="form-control mb-1" rows="6" v-model="task.description"></textarea>
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
export default {
    name: "TaskDetailPage",
    data() {
        return {
            currentStatus: "done", // Để active đúng tab trạng thái như trong ảnh
            task: {
                title: "Thiết kế figma trang đặt bàn",
                timeSpent: "6 giờ",
                project: "N4 High5",
                assignee: {
                    initials: "N",
                    name: "N4 Nguyễn Thị Thúy Tiên",
                },
                tags: [],
                customer: "CEO CườngPN11",
                deadline: "27/05/2025 12:00:00",
                statusCounts: {
                    todo: 4, // Cập nhật số lượng theo ảnh
                    analysis: 0,
                    implement: 0,
                    test: 0,
                    done: 0,
                    cancel: 0,
                },
                description: "Thêm thông tin về nhiệm vụ này...",
                subtasks: [],
            },
        };
    },
};
</script>

<style scoped>
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

.custom-badge {
    background-color: #0d6efd;
    color: #ffffff;
    padding: 0.2em 1.2em;
    font-size: 0.7rem;
    border-radius: 0.2rem;
    font-weight: 600;
    margin-right: 10px;
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