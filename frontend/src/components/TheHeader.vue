<template>
    <header>
        <nav class="navbar navbar-expand-lg p-3 shadow-sm position-fixed top-0 w-100"
            style="background-color: white; z-index: 999">
            <div class="container-fluid">
                <!-- Logo -->
                <router-link :to="'/'">
                    <img src="/img/logo.png" alt="Logo" class="logo" />
                </router-link>

                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarResponsive">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Content -->
                <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarResponsive">
                    <!-- Left side -->
                    <div
                        class="d-flex flex-column flex-lg-row gap-2 align-items-start align-items-lg-center justify-content-end mt-2 mt-lg-0 w-100 me-3">
                        <!-- <button type="button" class="btn create-btn" data-bs-toggle="modal"
                            data-bs-target="#exampleModal1" @click="projectModalInstance = true">
                            + Thêm dự án
                        </button> -->
                        <router-link :to="'projects/new'" type="button" class="btn create-btn">
                            + Thêm dự án
                        </router-link>

                    </div>

                    <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                        <label class="toggle-switch">
                            <input type="checkbox" />
                            <span class="switch-bg">
                                <span class="switch-handle"></span>
                            </span>
                        </label>
                        <div class="dropdown-container">
                            <a class="nav-link" @click="toggleDropdown()">
                                <img v-if="avatar && avatar !== ''" :src="avatar" alt="Avatar" class="avatar-img" />
                                <i v-else class="bi bi-people avatar-icon"></i>
                            </a>
                            <ul class="dropdown-menu" v-if="showDropdown">
                                <li>
                                    <a class="dropdown-item" href="/profile">Hồ sơ tài khoản</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a class="dropdown-item" @click="logout" style="cursor: pointer">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- <div v-if="projectModalInstance" class="custom-backdrop"></div> -->
    <!-- <div class="modal fade" id="exampleModal1" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form class="modal-content" @submit.prevent="insertProject">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #042d62">
                        Thêm dự án mới
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="projectModalInstance = false"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex">
                        <div class="col-6 border-end pe-3">
                            <div class="mb-3">
                                <label class="form-label">Dự án <span class="text-danger">*</span></label>
                                <br />
                                <small class="text-danger" v-if="
                                    errors &&
                                    errors.is_group_project &&
                                    errors.is_group_project.length > 0
                                ">
                                    {{ errors.is_group_project[0] }}
                                </small>

                                <select class="form-select" v-model="is_group_project">
                                    <option :value="false">Cá nhân</option>
                                    <option :value="true">Nhóm</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                                <br />
                                <small class="text-danger" v-if="errors && errors.title && errors.title.length > 0">
                                    {{ errors.title[0] }}
                                </small>

                                <input type="text" class="form-control" id="" v-model="title" />
                            </div>
                            <div class="mb-3">
                                <label class="form-check-label" for="">Mô tả</label>
                                <br />
                                <small class="text-danger" v-if="
                                    errors &&
                                    errors.description &&
                                    errors.description.length > 0
                                ">
                                    {{ errors.description[0] }}
                                </small>
                                <textarea name="" id="" cols="3" class="form-control" v-model="description"></textarea>
                            </div>
                        </div>
                        <div class="col-6 ps-3">
                            <div class="mb-3">
                                <label class="form-label">Thời gian bắt đầu</label><br />
                                <small class="text-danger" v-if="
                                    errors && errors.start_date && errors.start_date.length > 0
                                ">
                                    {{ errors.start_date[0] }}
                                </small>
                                <input type="date" class="form-control" v-model="start_date" :min="today" />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Thời gian kết thúc</label><br />
                                <small class="text-danger"
                                    v-if="errors && errors.end_date && errors.end_date.length > 0">
                                    {{ errors.end_date[0] }}
                                </small>
                                <input type="date" class="form-control" v-model="end_date" :min="today" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="">Trạng thái <span
                                        class="text-danger">*</span></label><br />
                                <small class="text-danger" v-if="errors && errors.status && errors.status.length > 0">
                                    {{ errors.status[0] }}
                                </small>
                                <select name="" id="" class="form-select" v-model="status">
                                    <option value="Đang thực hiện">Đang thực hiện</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Hủy
                    </button>
                    <button type="submit" class="create-btn" :class="{ loading: isLoading }">
                        <span v-if="!isLoading">Tạo mới</span>
                        <span v-else class="spinner"></span>
                    </button>
                </div>
            </form>
        </div>
    </div> -->
</template>

<script>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import { Project } from "./store/crudProject";
export default {
    setup() {
        const userString = localStorage.getItem("user");
        const tokenString = localStorage.getItem("token");
        const avatar = ref("");
        const token = ref("");
        const showDropdown = ref(false);
        function toggleDropdown() {
            showDropdown.value = !showDropdown.value;
        }
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

        onMounted(() => {
            if (userString && tokenString) {
                const user = JSON.parse(userString);
                avatar.value = JSON.parse(user.user);
                // console.log(avatar.value);
                token.value = tokenString;
                // console.log(token.value);
            }
        });

        const logout = async () => {
            try {
                await axios.get("http://127.0.0.1:8000/api/logout", {
                    headers: {
                        Authorization: `Bearer ${token.value}`,
                    },
                });
                localStorage.removeItem("token");
                localStorage.removeItem("user");
                window.location.reload();
                toast.success("Đăng xuất thành công!");
            } catch (error) {
                console.error(error);
                toast.error("Đăng xuất thất bại!");
            }
        };

        return {
            avatar,
            token,
            logout,
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
            toggleDropdown,
            showDropdown,
        };
    },
};
</script>
<style scoped>
.dropdown-container {
    position: relative;
    display: inline-block;
}

.nav-link {
    cursor: pointer;
}

.avatar-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.avatar-icon {
    font-size: 24px;
    color: #555;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    z-index: 1000;
    min-width: 160px;
    padding: 10px 0;
    margin-top: 5px;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 4px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    list-style: none;
    display: block;
}

/* Các mục trong dropdown */
.dropdown-item {
    display: block;
    padding: 8px 16px;
    clear: both;
    font-weight: 400;
    color: #333;
    text-decoration: none;
    white-space: nowrap;
}

/* Hiệu ứng khi di chuột qua các mục */
.dropdown-item:hover {
    color: #fff;
    background-color: #007bff;
    /* Màu nền khi hover */
}

/* Đường kẻ phân cách */
.dropdown-divider {
    height: 1px;
    margin: 9px 0;
    overflow: hidden;
    background-color: #e9ecef;
}

.logo {
    width: 120px;
    margin-right: 100px;
}

@media (max-width: 768px) {
    .search-box {
        min-width: 100% !important;
    }

    .create-btn {
        width: 100%;
    }
}

.btn-icon {
    border: 1px solid #ddd;
    border-radius: 10px;
    background: none;
    color: #333;
    padding: 0px 10px;
    transition: color 0.3s ease, transform 0.3s ease;
    cursor: pointer;
    background: #ffffff;
    box-shadow: 5px 5px 10px #ecebeb;
}

.layout-icon {
    font-size: 25px;
}

.avatar-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.avatar-icon {
    font-size: 40px;
    color: #555;
}

.icon-btn:hover {
    color: #12b76a;
    transform: scale(1.1);
}

.toggle-switch {
    position: relative;
    width: 40px;
    height: 21px;
    display: inline-block;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.switch-bg {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    border-radius: 24px;
    transition: background-color 0.3s;
}

.switch-handle {
    position: absolute;
    height: 15px;
    width: 15px;
    left: 3px;
    top: 3px;
    background-color: white;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s;
}

input:checked+.switch-bg {
    background-color: #12b76a;
}

input:checked+.switch-bg .switch-handle {
    transform: translateX(19px);
}

/* Tìm kiếm */
.search-box {
    display: flex;
    align-items: center;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 3px 5px;
    height: 40px;
    min-width: 100px;
    /* max-width: 300px; */
    transition: box-shadow 0.3s;
}

.search-box:hover {
    box-shadow: 0 0 0 2px #042d62;
}

.search-input {
    border: none;
    outline: none;
    background: transparent;
    padding-left: 8px;
    font-size: 14px;
    color: #333;
    flex-grow: 1;
}

.search-input::placeholder {
    color: #999;
    font-size: 13px;
}

.search-btn {
    border: none;
    background: none;
    color: #555;
    font-size: 16px;
    cursor: pointer;
    padding: 0 5px;
}

.search-btn:hover {
    color: #12b76a;
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
}

.create-btn .spinner {
    border: 2px solid #fff;
    border-top: 2px solid transparent;
    border-radius: 50%;
    width: 14px;
    height: 14px;
    animation: spin 0.6s linear infinite;
    display: none;
}

.create-btn.loading .spinner {
    display: inline-block;
}

.create-btn:hover {
    background-color: #042d62;
    color: #fff;
}

.custom-backdrop {
    position: fixed;
    /* Đảm bảo nó che phủ toàn bộ màn hình */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* Nền đen mờ */
    z-index: 1040;
    /* Đặt z-index thấp hơn modal (thường là 1050) nhưng cao hơn nội dung khác */
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
