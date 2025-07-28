<template>
    <header>
        <nav class="navbar navbar-expand-lg p-3 shadow-sm position-fixed w-100 top-0"
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
                        class="d-flex flex-column flex-lg-row gap-2 align-items-start align-items-lg-center mt-2 mt-lg-0 w-75">
                        <div class="search-box flex-grow-1">
                            <input type="text" placeholder="Tìm kiếm..." class="search-input" />
                            <button class="search-btn">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <button type="button" class="btn create-btn" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            + Thêm dự án
                        </button>
                        <div class="btn-icon">
                            <i class="bi bi-bar-chart-line-fill layout-icon"></i>
                        </div>
                        <div class="btn-icon">
                            <i class="bi bi-list layout-icon"></i>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                        <label class="toggle-switch">
                            <input type="checkbox" />
                            <span class="switch-bg">
                                <span class="switch-handle"></span>
                            </span>
                        </label>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img v-if="avatar && avatar !== ''" :src="avatar" alt="Avatar" class="avatar-img" />
                                <i v-else class="bi bi-people avatar-icon"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/profile">Hồ sơ tài khoản</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" @click="logout" style="cursor: pointer;">Đăng xuất</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #042d62">
                        Thêm dự án mới
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="d-flex">
                        <div class="col-6 border-end pe-3">
                            <div class="mb-3">
                                <label class="form-label">Dự án <span class="text-danger">*</span></label>
                                <select name="" id="" class="form-select">
                                    <option value="">Cá nhân</option>
                                    <option value="">Nhóm</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="" />
                            </div>
                            <div class="mb-3">
                                <label class="form-check-label" for="">Mô tả</label>
                                <textarea name="" id="" cols="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-6 ps-3">
                            <div class="mb-3">
                                <label class="form-label">Thời gian bắt đầu</label>
                                <input type="date" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Thời gian kết thúc</label>
                                <input type="date" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="">Trạng thái <span class="text-danger">*</span></label>
                                <select name="" id="" class="form-select">
                                    <option value="">Cá nhân</option>
                                    <option value="">Nhóm</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Hủy
                    </button>
                    <button type="submit" class="btn create-btn">Tạo mới</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from 'vue-router'
import { toast } from "vue3-toastify";
export default {
    setup() {
        const userString = localStorage.getItem("user");
        const tokenString = localStorage.getItem("token");
        const avatar = ref('');
        const token = ref('');
        const router = useRouter();
        onMounted(() => {
            const user = JSON.parse(userString);
            avatar.value = user;
            // console.log(avatar.value);
            token.value = tokenString;
            // console.log(token.value);
        });

        const logout = async () => {
            try {
                await axios.get('http://127.0.0.1:8000/api/logout', {
                    headers: {
                        Authorization: `Bearer ${token.value}`
                    }
                });
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                window.location.reload();
                toast.success('Đăng xuất thành công!');
            } catch (error) {
                console.error(error);
                toast.error('Đăng xuất thất bại!');
            }
        };
        return {
            avatar,
            token,
            logout
        };
    },
};
</script>
<style scoped>
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
}
</style>
