<template>
    <div class="task-detail-page container-fluid p-0">
        <header v-if="loading"
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

            <div class="d-none d-lg-flex align-items-center gap-2">
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Việc cần làm' }"
                    @click="handleStatusChange('Việc cần làm')">
                    Việc cần làm
                    <span class="status-count" v-if="currentStatus === 'Việc cần làm'">{{ statusTime }}</span>
                </div>
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Phân tích' }"
                    @click="handleStatusChange('Phân tích')">
                    Phân tích
                    <span class="status-count" v-if="currentStatus === 'Phân tích'">{{ statusTime }}</span>
                </div>
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Thực hiện' }"
                    @click="handleStatusChange('Thực hiện')">
                    Thực hiện
                    <span class="status-count" v-if="currentStatus === 'Thực hiện'">{{ statusTime }}</span>
                </div>
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Kiểm thử' }"
                    @click="handleStatusChange('Kiểm thử')">
                    Kiểm thử
                    <span class="status-count" v-if="currentStatus === 'Kiểm thử'">{{ statusTime }}</span>
                </div>
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Hoàn tất' }"
                    @click="handleStatusChange('Hoàn tất')">
                    Hoàn tất
                    <span class="status-count" v-if="currentStatus === 'Hoàn tất'">{{ statusTime }}</span>
                </div>
                <div class="status-tag" :class="{ 'status-done': currentStatus === 'Hủy bỏ' }"
                    @click="handleStatusChange('Hủy bỏ')">
                    Hủy bỏ
                    <span class="status-count" v-if="currentStatus === 'Hủy bỏ'">{{ statusTime }}</span>
                </div>
                <div>
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

            </div>

            <div
                class="d-flex d-lg-none align-items-center gap-2 w-100 justify-content-between status-mobile-container">
                <div class="dropdown">
                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                        @click="toggleStatusDropdown">
                        {{ currentStatus }} <span class="status-count" style="font-size: 10px;"
                            v-if="currentStatus === currentStatus">({{ statusTime }})</span>
                    </button>
                    <div class="dropdown-menu" :class="{ 'show': showStatusDropdown }">
                        <a class="dropdown-item" :class="{ 'active': currentStatus === 'Việc cần làm' }"
                            @click="handleStatusChange('Việc cần làm')">Việc cần làm <span class="status-count"
                                v-if="currentStatus === 'Việc cần làm'">{{ statusTime }}</span></a>
                        <a class="dropdown-item" :class="{ 'active': currentStatus === 'Phân tích' }"
                            @click="handleStatusChange('Phân tích')">Phân tích <span class="status-count"
                                v-if="currentStatus === 'Phân tích'">{{ statusTime }}</span></a>
                        <a class="dropdown-item" :class="{ 'active': currentStatus === 'Thực hiện' }"
                            @click="handleStatusChange('Thực hiện')">Thực hiện <span class="status-count"
                                v-if="currentStatus === 'Thực hiện'">{{ statusTime }}</span></a>
                        <a class="dropdown-item" :class="{ 'active': currentStatus === 'Kiểm thử' }"
                            @click="handleStatusChange('Kiểm thử')">Kiểm thử <span class="status-count"
                                v-if="currentStatus === 'Kiểm thử'">{{ statusTime }}</span></a>
                        <a class="dropdown-item" :class="{ 'active': currentStatus === 'Hoàn tất' }"
                            @click="handleStatusChange('Hoàn tất')">Hoàn tất <span class="status-count"
                                v-if="currentStatus === 'Hoàn tất'">{{ statusTime }}</span></a>
                        <a class="dropdown-item" :class="{ 'active': currentStatus === 'Hủy bỏ' }"
                            @click="handleStatusChange('Hủy bỏ')">Hủy bỏ <span class="status-count"
                                v-if="currentStatus === 'Hủy bỏ'">{{ statusTime }}</span></a>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <span class="text-muted small me-1 d-flex align-items-center">1 / 1</span>
                    <router-link :to="`/projects/${projectId}/tasks/${prevTaskId}`"
                        class="btn btn-sm btn-light border text-secondary px-2 py-0">
                        <i class="bi bi-chevron-left"></i>
                    </router-link>
                    <router-link :to="`/projects/${projectId}/tasks/${nextTaskId}`"
                        class="btn btn-sm btn-light border text-secondary px-2 py-0">
                        <i class="bi bi-chevron-right"></i>
                    </router-link>
                </div>
            </div>
        </header>

        <main v-if="loading" class="task-content p-3 m-md-4" style="background-color: white">
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
                <div class="col-12">
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <input class="mb-0 fw-medium input" style="font-size: 2rem; color: #333" v-model="title"
                            @change="onTitleChange" />
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
                                <div v-else-if="selectedMembers.length > 0"
                                    class="d-flex align-items-center flex-wrap gap-2">
                                    <div v-for="member in selectedMembers" :key="member.id"
                                        class="d-flex align-items-center">
                                        <img :src="member.avatar" alt="Avatar"
                                            style="width: 20px; border-radius: 50%; margin-right: 5px" />
                                        <span class="fw-semibold small">{{ member.email }}</span>
                                    </div>
                                </div>
                                <div v-else>Chưa được phân công</div>
                                <button @click="editing1 = !editing1" class="btn btn-sm btn-link text-primary ms-2 p-0">
                                    <i :class="editing1 == true ? 'bi bi-check-lg' : 'bi bi-pencil'
                                        "></i>
                                </button>
                            </div>
                        </div>
                        <div class="task-info-row">
                            <div class="task-info-label">Hạn chót</div>
                            <div class="task-info-value d-flex align-items-center">
                                <input v-if="editing" type="text" id="deadline-input"
                                    class="form-control border-0 border-bottom" v-model="deadline" />
                                <div v-else class="fw-semibold text-danger">
                                    {{ formatDateTime(deadline) }}
                                </div>
                                <button @click="onDeadlineChange" class="btn btn-sm btn-link text-primary ms-2 p-0">
                                    <i :class="editing ? 'bi bi-check-lg' : 'bi bi-pencil'"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="fs-6 mb-2">Mô tả chi tiết</div>
                    <QuillEditor ref="quillRef" v-model:content="description" :modules="modules"
                        :toolbar="toolbarOptions" content-type="html" theme="snow" style="height: 300px" />

                    <hr />
                    <form @submit.prevent="sendContent">
                        <div class="input-group1 mb-1">
                            <div ref="editableDivRef" class="form-control" contenteditable="true" @paste="handlePaste"
                                @input="updateContent">
                            </div>
                            <button class="btn btn-light border" type="button" @click="toggleEmojiPicker"
                                ref="emojiButtonRef">
                                <i class="bi bi-emoji-smile"></i>
                            </button>
                            <div v-if="showEmojiPicker" ref="emojiPickerContainer"
                                class="emoji-picker-container emoji-picker-small"></div>
                        </div>

                        <button class="btn create-btn fw-semibold text-white mb-3" type="submit"
                            style="background-color: #042d62; margin-top: 5px; font-size: 12px;">
                            Gửi
                        </button>
                    </form>

                    <div class="divider">
                        <span>Lịch sử thay đổi</span>
                    </div>
                    <div class="activity-log">
                        <div class="activity-item mb-3" v-for="item in history" :key="item.id">
                            <div class="d-flex">
                                <img src="https://lh3.googleusercontent.com/a/ACg8ocIpgzkirqGH0zlbILR5HineXzvDIWQmYFZ0QHCTEHy1HLvk-A=s96-c"
                                    alt="" srcset=""
                                    class="me-2 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 32px; height: 32px; font-size: 14px" />
                                <div>
                                    <span class="fw-semibold" style="font-size: 14px">{{ item.creator.fullname }}
                                        <small class="text-muted ms-2" style="font-size: 12px">{{
                                            formatDateTime(item.changed_at)
                                        }}</small></span>
                                    <div class="small">
                                        <ul class="mb-0">
                                            <li v-if="item.change_type == 'Người được phân công'">
                                                {{ item.old_value_names }}
                                                <i class="bi bi-arrow-right"></i>
                                                <span class="text-primary fw-semibold" style="margin-right: 5px">{{
                                                    item.new_value_names
                                                }}</span>
                                                <span class="text-muted fst-italic">({{ item.change_type }})</span>
                                            </li>
                                            <li v-else-if="item.change_type != null">
                                                {{ item.old_value }}
                                                <i class="bi bi-arrow-right mx-1"></i>
                                                <span class="text-primary fw-semibold me-1"
                                                    v-html="item.new_value"></span>
                                                <span class="text-muted fst-italic">({{ item.change_type }})</span>
                                            </li>

                                            <li v-else>
                                                <span v-html="item.content || item.new_value"></span>
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
import { nextTick, onMounted, onUnmounted, ref, watch } from "vue";
import axios from "axios";
import { toast } from 'vue3-toastify';
import Multiselect from "vue-multiselect";
import flatpickr from "flatpickr";
import { Vietnamese } from "flatpickr/dist/l10n/vn.js";
import Pusher from "pusher-js";
import { QuillEditor } from "@vueup/vue-quill";
import ImageUploader from "quill-image-uploader";
import { createPicker } from "picmo";
import {
    format,
    isSameHour,
    isSameDay,
    isSameWeek,
    isSameMonth,
    isSameYear,
} from "date-fns";


export default {
    components: {
        Multiselect,
        QuillEditor,
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
        const showStatusDropdown = ref(false);

        const toggleStatusDropdown = () => {
            showStatusDropdown.value = !showStatusDropdown.value;
        };
        const loading = ref(true);
        const task = ref({});
        const creator = ref({});
        const project = ref({});
        const member = ref([]);
        const selectedMembers = ref([]);
        const editing = ref(false);
        const editing1 = ref(false);
        const deadline = ref("");
        const fpInstance = ref(null);
        const currentStatus = ref("");
        const title = ref("");
        const description = ref("");
        const oldTaskData = ref({});
        const tokenString = localStorage.getItem("token");
        const token = ref(tokenString);
        const history = ref([]);
        const initialSelectedMembers = ref([]);
        const content = ref("");
        const note = ref(false);
        const statusTime = ref("");
        let timerId = null;
        const prevTaskId = ref(props.taskId - 1);
        const nextTaskId = ref(parseInt(props.taskId) + 1);
        const quillRef = ref(null);
        const showEmojiPicker = ref(false);
        const emojiPickerContainer = ref(null);
        let pickerInstance = null;
        const emojiButtonRef = ref(null);
        const editableDivRef = ref(null);
        const pastedFiles = ref([]);
        const modules = {
            name: "imageUploader",
            module: ImageUploader,
            options: {
                upload: async (file) => {
                    const formData = new FormData();
                    formData.append("image", file);
                    uploadImage(file)
                },
            },
        };

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

        const toggleEmojiPicker = async () => {
            showEmojiPicker.value = !showEmojiPicker.value;

            if (showEmojiPicker.value) {
                await nextTick();

                if (emojiPickerContainer.value) {
                    if (pickerInstance) {
                        pickerInstance.destroy();
                        pickerInstance = null;
                    }

                    pickerInstance = createPicker({
                        rootElement: emojiPickerContainer.value,
                        // showCategoryTabs: false //  danh mục icon
                        showPreview: false, // foodter
                        emojiSize: "24px", // kích thước emoji
                        emojisPerRow: 8, // số lượng emoji trên mỗi hàng
                    });

                    pickerInstance.addEventListener("emoji:select", (event) => {
                        if (editableDivRef.value) {
                            editableDivRef.value.focus();
                            document.execCommand('insertText', false, event.emoji);
                            updateContent();
                        }
                    });
                }
            } else {
                if (pickerInstance) {
                    pickerInstance.destroy();
                    pickerInstance = null;
                }
            }
        };

        const handleClickOutside = (event) => {
            if (showEmojiPicker.value) {
                const picker = emojiPickerContainer.value;
                const button = emojiButtonRef.value;

                if (
                    picker &&
                    !picker.contains(event.target) &&
                    button &&
                    !button.contains(event.target)
                ) {
                    showEmojiPicker.value = false;
                }
            }
        };

        watch(showEmojiPicker, (newValue) => {
            if (newValue) {
                document.addEventListener("click", handleClickOutside);
            } else {
                document.removeEventListener("click", handleClickOutside);
            }
        });

        const updateContent = () => {
            content.value = editableDivRef.value.innerHTML;
        };

        const handlePaste = (event) => {
            const items = event.clipboardData.items;

            for (const item of items) {
                if (item.type.startsWith("image/")) {
                    event.preventDefault();

                    const file = item.getAsFile();
                    pastedFiles.value.push(file);
                    const imageUrl = URL.createObjectURL(file);
                    const imageId = `pasted-image-${Date.now()}`;
                    const imageHtml = `<img src="${imageUrl}" id="${imageId}" style="max-width: 100%; vertical-align: middle;">`;
                    document.execCommand("insertHTML", false, imageHtml);
                    updateContent();
                    break;
                }
            }
        };


        const uploadImage = async (file) => {
            const formData = new FormData();
            formData.append("image", file);
            const res = await axios.post(
                "http://127.0.0.1:8000/api/task/upload-image",
                formData,
                {
                    headers: {
                        Authorization: `Bearer ${token.value}`,
                        "Content-Type": "multipart/form-data",
                    },
                }
            );
            return res.data.url;
        };

        const getTaskById = async (showLoading = true) => {
            try {
                if (showLoading) {
                    loading.value = true;
                }
                const res = await axios.get(
                    `http://127.0.0.1:8000/api/task/${props.taskId}/edit`
                );

                task.value = res.data.task;
                title.value = res.data.task.title;
                description.value = res.data.task.description;
                currentStatus.value = res.data.task.status;
                deadline.value = res.data.task.deadline;
                selectedMembers.value = res.data.task.assignees;
                initialSelectedMembers.value = [...res.data.task.assignees];

                creator.value = res.data.task.creator;
                project.value = res.data.task.project;
                member.value = res.data.task.project.users;
                history.value = res.data.task.history;

                oldTaskData.value = {
                    title: title.value,
                    description: description.value,
                    status: currentStatus.value,
                    deadline: deadline.value,
                    user_id: initialSelectedMembers.value.map((user) => user.id),
                };
                updateStatusTime();

            } catch (error) {
                console.log(error);
            } finally {
                loading.value = false;
            }
        };

        function safeStringify(value) {
            return typeof value === "string" ? value : JSON.stringify(value);
        }
        const handleUpdate = async (field, oldValue, newValue) => {
            if (JSON.stringify(oldValue) === JSON.stringify(newValue)) {
                return;
            }

            const updateData = {
                project_id: props.projectId,
                title: title.value,
                description: description.value,
                status: currentStatus.value,
                deadline: deadline.value,
                user_id: selectedMembers.value.map((user) => user.id),
            };

            const historyData = {
                change_type: field,
                old_value: safeStringify(oldValue),
                new_value: safeStringify(newValue),
            };

            console.log("đ" + historyData.new_value);

            try {
                await axios.put(
                    `http://127.0.0.1:8000/api/task/${props.taskId}`,
                    {
                        ...updateData,
                        ...historyData,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${token.value}`,
                        },
                    }
                );
                oldTaskData.value[field] = newValue;
            } catch (error) {
                console.error(
                    "Lỗi khi cập nhật task:",
                    error.response?.data || error.message
                );

                toast.warning('Có lỗi xảy ra vui lòng thử lại!')
            }
        };

        const onTitleChange = () => {
            handleUpdate("Tiêu đề", oldTaskData.value.title, title.value);
        };

        const onDescriptionChange = async () => {
            // console.log('Nội dung mới:', newContent.value);
            try {
                await axios.put(
                    "http://127.0.0.1:8000/api/task/update-description",
                    {
                        task_id: props.taskId,
                        description: description.value,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${token.value}`,
                        },
                    }
                );
            } catch (error) {
                console.error(error);
            }
        };

        const onDeadlineChange = () => {
            if (editing.value) {
                handleUpdate("Hạn chót", oldTaskData.value.deadline, deadline.value);
            }
            editing.value = !editing.value;
        };

        const handleStatusChange = async (newStatus) => {
            const oldStatus = currentStatus.value;
            currentStatus.value = newStatus;
            handleUpdate("Giai đoạn", oldStatus, newStatus);
        };

        const handleAssigneesUpdate = async () => {
            if (!editing1.value) {
                const currentIds = selectedMembers.value.map((m) => m.id).sort();
                const initialIds = initialSelectedMembers.value.map((m) => m.id).sort();
                if (JSON.stringify(currentIds) !== JSON.stringify(initialIds)) {
                    await handleUpdate("Người được phân công", initialIds, currentIds);
                    initialSelectedMembers.value = [...selectedMembers.value];
                }
            }
        };

        const sendContent = async () => {
            const uploadPromises = pastedFiles.value.map(file => uploadImage(file));
            const imageUrls = await Promise.all(uploadPromises);

            let finalContent = editableDivRef.value.innerHTML;
            const tempImages = editableDivRef.value.querySelectorAll('img');

            tempImages.forEach((img, index) => {
                if (imageUrls[index]) {
                    img.src = imageUrls[index];
                }
            });

            finalContent = editableDivRef.value.innerHTML;

            try {
                const res = await axios.post(
                    `http://127.0.0.1:8000/api/task-history`,
                    {
                        task_id: props.taskId,
                        content: finalContent,
                        change_type: "Ghi chú",
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${token.value}`,
                        },
                    }
                );

                content.value = "";
                editableDivRef.value.innerHTML = "";
                pastedFiles.value = [];
                await getTaskById(false)
            } catch (error) {
                console.error("Lỗi khi gửi nội dung:", error);
            }
        };


        const initFlatpickr = () => {
            const inputElement = document.getElementById("deadline-input");
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
                    },
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

        const formatRelativeTime = (timestamp) => {
            if (!timestamp) return "";

            const changedAt = new Date(timestamp);
            const now = new Date();
            const diffInSeconds = Math.floor(
                (now.getTime() - changedAt.getTime()) / 1000
            );

            if (diffInSeconds < 60) {
                return "Vừa xong";
            }

            if (diffInSeconds < 3600) {
                // cùng giờ
                const minutes = Math.floor(diffInSeconds / 60);
                return minutes + " phút trước";
            } else if (isSameDay(changedAt, now)) {
                // cùng ngày
                const hours = Math.floor(diffInSeconds / 3600);
                return hours + " giờ trước";
            } else if (isSameWeek(changedAt, now)) {
                // cùng tuần
                return format(changedAt, "EEEE");
            } else if (isSameMonth(changedAt, now)) {
                // cùng tháng
                return format(changedAt, "d") + " ngày trước";
            } else if (isSameYear(changedAt, now)) {
                // cùng năm
                return format(changedAt, "MMMM") + " tháng trước";
            } else {
                return format(changedAt, "yyyy");
            }
        };

        const updateStatusTime = () => {
            // console.log('Chạy updateStatusTime');

            if (task.value && task.value.history_max_changed_at) {
                const changedAt = new Date(task.value.history_max_changed_at);
                const now = new Date();
                statusTime.value = formatRelativeTime(
                    task.value.history_max_changed_at
                );
            } else {
                statusTime.value = "Chưa có cập nhật";
            }
        };

        let pusher;
        let socketId = "";

        function setupPusher() {
            pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
                cluster: import.meta.env.VITE_PUSHER_CLUSTER,
            });

            pusher.connection.bind("connected", () => {
                socketId = pusher.connection.socket_id;
            });

            const channel = pusher.subscribe("channel-name");

            channel.bind("App\\Events\\TaskUpdated", (data) => {
                getTaskById(false);
            });
        }

        onMounted(async () => {
            await getTaskById(true);

            timerId = setInterval(updateStatusTime, 60 * 1000);
            nextTick(() => {
                initFlatpickr();
            });
            setupPusher();
            const editorInstance = quillRef.value?.getQuill();

            if (editorInstance) {
                editorInstance.on("selection-change", (range, oldRange) => {
                    if (range === null && oldRange !== null) {
                        onDescriptionChange();
                    }
                });
            } else {
                console.warn("Không lấy được instance Quill!");
            }
        });
        onUnmounted(() => {
            if (timerId) {
                clearInterval(timerId);
            }
            if (pickerInstance) {
                pickerInstance.destroy();
                pickerInstance = null;
            }
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

        watch(editing1, (newValue) => {
            if (!newValue) {
                handleAssigneesUpdate();
            }
        });

        return {
            loading,
            task,
            creator,
            project,
            member,
            selectedMembers,
            editing,
            formatDateTime,
            deadline,
            fpInstance,
            editing1,
            currentStatus,
            description,
            title,
            handleStatusChange,
            nextTaskId,
            prevTaskId,
            handleUpdate,
            onTitleChange,
            onDescriptionChange,
            onDeadlineChange,
            handleStatusChange,
            oldTaskData,
            token,
            tokenString,
            history,
            handleAssigneesUpdate,
            sendContent,
            content,
            socketId,
            pusher,
            note,
            formatRelativeTime,
            statusTime,
            safeStringify,
            quillRef,
            modules: [modules],
            toolbarOptions,
            toggleEmojiPicker,
            showEmojiPicker,
            pickerInstance,
            emojiPickerContainer,
            emojiButtonRef,
            updateStatusTime,
            editableDivRef,
            handlePaste,
            sendContent,
            updateContent,
            toggleStatusDropdown,
            showStatusDropdown
        };
    },
};
</script>
<style scoped>
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
