import "./assets/main.css";

import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "bootstrap-icons/font/bootstrap-icons.css";
import "vue3-toastify/dist/index.css";
import "quill-image-uploader/dist/quill.imageUploader.min.css";
import "flatpickr/dist/flatpickr.min.css";
import "vue-multiselect/dist/vue-multiselect.css";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import 'bootstrap';
createApp(App).use(router).mount("#app");
