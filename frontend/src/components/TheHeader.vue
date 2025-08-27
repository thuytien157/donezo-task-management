<template>
    <header id="main-header">
        <nav class="navbar navbar-expand-lg p-3 shadow-sm position-fixed top-0 w-100"
            style="background-color: white; z-index: 999">
            <div class="container-fluid">
                <router-link :to="'/'" v-if="isDarkMode">
                    <img src="/img/logo1.png" alt="Logo" class="logo" style="background-color: aliceblue;" />
                </router-link>
                <router-link :to="'/'" v-else>
                    <img src="/img/logo.png" alt="Logo" class="logo" style="background-color: aliceblue;" />
                </router-link>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarResponsive">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <router-link :to="'/projects/new'" type="button" class="btn create-btn">
                                + Thêm dự án
                            </router-link>
                        </li>
                    </ul>

                    <ul class="navbar-nav me-3 mb-2 mb-lg-0">
                        <li class="nav-item">
                            <div class="dropdown-container">
                                <a class="nav-link" @click="toggleDropdown()">
                                    <img v-if="avatar && avatar !== ''" :src="avatar" alt="Avatar" class="avatar-img" />
                                    <i v-else class="bi bi-people avatar-icon"></i>
                                </a>
                                <ul class="dropdown-menu" v-if="showDropdown">
                                    <li>
                                        <div class="dropdown-item d-flex justify-content-between"
                                            style="cursor: pointer">
                                            Chế độ tối
                                            <label class="toggle-switch">
                                                <input type="checkbox" @change="toggleDarkMode" :checked="isDarkMode" />
                                                <span class="switch-bg">
                                                    <span class="switch-handle"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" @click="logout" style="cursor: pointer">Đăng xuất</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import { Project } from "./store/crudProject";
import { useTokenUser } from "./store/useTokenUser";
import { useDarkMode } from "./store/darkmode";

export default {
    setup() {
        const showDropdown = ref(false);
        // const isDarkMode = ref(false);

        function toggleDropdown() {
            showDropdown.value = !showDropdown.value;
        }

        const {
            isDarkMode,
            toggleDarkMode
        } = useDarkMode.setup()

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

        const {
            avatar,
            token
        } = useTokenUser()

        const logout = async () => {
            try {
                await axios.get(`${import.meta.env.VITE_URL_API}api/logout`, {
                    headers: {
                        Authorization: `Bearer ${token.value}`,
                    },
                });
                localStorage.removeItem("token_donezo");
                localStorage.removeItem("user_donezo");
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
            isDarkMode,
            toggleDarkMode,
        };
    },
};
</script>


<style scoped>
.dark-mode {
    background-color: #3C3E4B;
    color: #f0f0f0;
}

.dark-mode .navbar {
    background-color: #3C3E4B !important;
    box-shadow: 0 2px 4px rgba(255, 255, 255, 0.1);
}

.dark-mode .dropdown-menu {
    background-color: #3a3a3a;
    border: 1px solid #3a3a3a;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
}

.dark-mode .dropdown-item {
    color: #f0f0f0;
}

.dark-mode .dropdown-item:hover {
    background-color: #333333;
    color: #fff;
}

.dark-mode .avatar-icon {
    color: #f0f0f0;
}

.dark-mode .create-btn {
    background-color: #0f3b75;
    color: #fff;
}


.dark-mode .toggle-switch input:checked+.switch-bg {
    background-color: #2ec436;
}

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
    margin-top: 5px;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 4px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    list-style: none;
    display: block;
}

.dropdown-item {
    display: block;
    clear: both;
    font-weight: 400;
    color: #333;
    text-decoration: none;
    white-space: nowrap;
    font-size: 14px;
}

.dropdown-item:hover {
    color: #000000;
    background-color: #e7e9ec;
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

.create-btn {
    background-color: #0f3b75;
    color: #fff;
}

.create-btn:hover {
    background-color: #405a7c;
    color: #fff;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
