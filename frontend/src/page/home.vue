<template>
    <main class="container-fluid">
        <!-- <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2 mt-2">
                <div class="card">
                    <div class="card__skeleton card__title"></div>
                    <div class="card__skeleton card__description"></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2 mt-2">
                <div class="card">
                    <div class="card__skeleton card__title"></div>
                    <div class="card__skeleton card__description"></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2 mt-2">
                <div class="card">
                    <div class="card__skeleton card__title"></div>
                    <div class="card__skeleton card__description"></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2 mt-2">
                <div class="card">
                    <div class="card__skeleton card__title"></div>
                    <div class="card__skeleton card__description"></div>
                </div>
            </div>
        </div> -->

        <h4 class="text-start pt-2">Dự án nhóm</h4>
        <div class="row">
            <router-link :to="'/project'" class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2 text-decoration-none"
                style="cursor: pointer;">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </router-link>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card rounded text-start">
                    <h5>tên task</h5>
                    <div class="fw-light" style="font-size: 14px;">mô tả</div>
                    <div class="text-danger" style="font-size: 14px;"><i class="bi bi-list"></i>Deadline</div>
                    <div class="d-flex justify-content-between">
                        <div class="text-info" style="font-size: 14px;">123 tác vụ</div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Sơ đồ</a></li>
                                <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </main>
</template>
<script setup>
import { ref } from 'vue'

const showMenu = ref(false)

function toggleMenu() {
    showMenu.value = !showMenu.value
}

function closeMenu() {
    showMenu.value = false
}
</script>
<style scoped>
.card {
    width: 100%;
    max-width: 100%;
    padding: 1rem;
    text-align: center;
    border-radius: 0.8rem;
    background-color: white;
}

.card__skeleton {
    background-image: linear-gradient(90deg,
            #ccc 0px,
            rgb(229 229 229 / 90%) 40px,
            #ccc 80px);
    background-size: 300%;
    background-position: 100% 0;
    border-radius: inherit;
    animation: shimmer 1.5s infinite;
}

.card__title {
    height: 15px;
    margin-bottom: 15px;
}

.card__description {
    height: 100px;
}

@keyframes shimmer {
    to {
        background-position: -100% 0;
    }
}
</style>
