<template>
    <div class="d-flex justify-content-center pt-5">
        <form class="form shadow p-3 mb-5 rounded" @submit.prevent="login">
            <div class="flex-column">
                <label>Email </label>
            </div>
            <small class="text-danger" v-if="errors.email">{{
                errors.email[0]
                }}</small>
            <div class="inputForm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20">
                    <g data-name="Layer 3" id="Layer_3">
                        <path
                            d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z">
                        </path>
                    </g>
                </svg>
                <input placeholder="Nhập email của bạn tại đây..." class="input" type="text" v-model="email" />
            </div>

            <div class="flex-column">
                <label>Mật khẩu </label>
            </div>
            <small class="text-danger" v-if="errors.password">{{
                errors.password[0]
                }}</small>
            <div class="inputForm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
                    <path
                        d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0">
                    </path>
                    <path
                        d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0">
                    </path>
                </svg>
                <input placeholder="Nhập mật khẩu của bạn tại đây" class="input" type="password" v-model="password" />
            </div>

            <div class="flex-row">
                <router-link :to="'/forgot-password'" class="span">Quên mật khẩu?</router-link>
            </div>
            <button type="submit" class="button-submit">
                <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin"
                    v-if="isLoading" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="#E5E7EB"></path>
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentColor"></path>
                </svg>
                Đăng nhập
            </button>
            <p class="p">
                Bạn chưa có tài khoản?
                <router-link :to="'/register'" class="span">Đăng ký</router-link>
            </p>
            <p class="p line">Hoặc</p>

            <div class="flex-row">
                <button class="btn google" @click="loginGG" type="button">
                    <svg xml:space="preserve" style="enable-background: new 0 0 512 512" viewBox="0 0 512 512" y="0px"
                        x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"
                        id="Layer_1" width="20" version="1.1">
                        <path d="M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256
	c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456
	C103.821,274.792,107.225,292.797,113.47,309.408z" style="fill: #fbbb00"></path>
                        <path d="M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451
	c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535
	c29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z"
                            style="fill: #518ef8"></path>
                        <path d="M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512
	c-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771
	c28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z" style="fill: #28b446"></path>
                        <path d="M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012
	c-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0
	C318.115,0,375.068,22.126,419.404,58.936z" style="fill: #f14336"></path>
                    </svg>

                    Google</button><button class="btn apple" @click="loginGH" type="button">
                    <svg viewBox="0 0 24 24" fill="currentColor" height="28" width="28"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.001 2C6.47598 2 2.00098 6.475 2.00098 12C2.00098 16.425 4.86348 20.1625 8.83848 21.4875C9.33848 21.575 9.52598 21.275 9.52598 21.0125C9.52598 20.775 9.51348 19.9875 9.51348 19.15C7.00098 19.6125 6.35098 18.5375 6.15098 17.975C6.03848 17.6875 5.55098 16.8 5.12598 16.5625C4.77598 16.375 4.27598 15.9125 5.11348 15.9C5.90098 15.8875 6.46348 16.625 6.65098 16.925C7.55098 18.4375 8.98848 18.0125 9.56348 17.75C9.65098 17.1 9.91348 16.6625 10.201 16.4125C7.97598 16.1625 5.65098 15.3 5.65098 11.475C5.65098 10.3875 6.03848 9.4875 6.67598 8.7875C6.57598 8.5375 6.22598 7.5125 6.77598 6.1375C6.77598 6.1375 7.61348 5.875 9.52598 7.1625C10.326 6.9375 11.176 6.825 12.026 6.825C12.876 6.825 13.726 6.9375 14.526 7.1625C16.4385 5.8625 17.276 6.1375 17.276 6.1375C17.826 7.5125 17.476 8.5375 17.376 8.7875C18.0135 9.4875 18.401 10.375 18.401 11.475C18.401 15.3125 16.0635 16.1625 13.8385 16.4125C14.201 16.725 14.5135 17.325 14.5135 18.2625C14.5135 19.6 14.501 20.675 14.501 21.0125C14.501 21.275 14.6885 21.5875 15.1885 21.4875C19.259 20.1133 21.9999 16.2963 22.001 12C22.001 6.475 17.526 2 12.001 2Z">
                        </path>
                    </svg>

                    Github
                </button>
            </div>
        </form>
    </div>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";

export default {
    setup() {
        const isLoading = ref(false);
        const email = ref("");
        const password = ref("");

        const router = useRouter();
        const errors = ref({});
        const login = async () => {
            isLoading.value = true;
            const token = localStorage.getItem("token_donezo");
            try {
                const res = await axios.post(
                    `${import.meta.env.VITE_URL_API}api/login`,
                    {
                        email: email.value,
                        password: password.value,
                    },
                    {
                        headers: {
                            // 'Content-Type': 'application/json',
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );

                const userStr = {
                    user: res.data.avatar,
                    id: res.data.user,
                };
                // console.log(res.data);
                localStorage.setItem("user_donezo", JSON.stringify(userStr));
                localStorage.setItem("token_donezo", res.data.token);

                errors.value = {};
                router.push("https://shopgrid-vue.netlify.app/home");
                toast.success("Đăng nhập thành công");
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    errors.value = {};
                    errors.value = error.response.data.errors;
                } else if (error.response.status === 401) {
                    errors.value = {};
                    toast.error(error.response.data.message);
                }
            } finally {
                isLoading.value = false;
            }
        };

        const loginGG = async () => {
            window.location.href = `${import.meta.env.VITE_URL_API}api/google/redirect`;
        };
        const loginGH = async () => {
            window.location.href = `${import.meta.env.VITE_URL_API}api/github/redirect`;
        };

        return {
            email,
            password,
            login,
            errors,
            loginGG,
            loginGH,
            isLoading,
        };
    },
};
</script>

<style scoped>
.form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 450px;
    background-color: #fff;
}

::placeholder {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
        Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
}

.form button {
    align-self: flex-end;
}

.flex-column>label {
    color: #032f5c;
    font-weight: 600;
}

.inputForm {
    border: 1.5px solid #ecedec;
    border-radius: 10px;
    height: 50px;
    display: flex;
    align-items: center;
    padding-left: 10px;
    transition: 0.2s ease-in-out;
    background-color: white;
}

.input {
    margin-left: 10px;
    border-radius: 10px;
    border: none;
    width: 100%;
    height: 100%;
}

.input:focus {
    outline: none;
}

.inputForm:focus-within {
    border: 1.5px solid #2d79f3;
}

.flex-row {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 10px;
    justify-content: space-between;
}

.flex-row>div>label {
    font-size: 14px;
    color: black;
    font-weight: 400;
}

.span {
    font-size: 14px;
    margin-left: 5px;
    color: #032f5c;
    font-weight: 500;
    cursor: pointer;
}

.button-submit {
    margin: 20px 0 10px 0;
    background-color: #032f5c;
    border: none;
    color: white;
    font-size: 15px;
    font-weight: 500;
    border-radius: 10px;
    height: 50px;
    width: 100%;
    cursor: pointer;
}

.button-submit svg {
    display: inline;
    width: 1.3rem;
    height: 1.3rem;
    margin-right: 0.75rem;
    color: white;
    animation: spin_357 1s linear infinite;
}

@keyframes spin_357 {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}

.p {
    text-align: center;
    color: black;
    font-size: 14px;
    margin: 5px 0;
}

.btn {
    margin-top: 10px;
    width: 100%;
    height: 50px;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: 500;
    gap: 10px;
    border: 1px solid #ededef;
    background-color: white;
    cursor: pointer;
    transition: 0.2s ease-in-out;
}

.btn:hover {
    border: 1px solid #2d79f3;
}
</style>
