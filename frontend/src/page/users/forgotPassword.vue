<template>
    <div class="d-flex justify-content-center pt-5">
        <div class="form-container shadow rounded">
            <div class="logo-container">
                Quên mật khẩu
            </div>

            <form class="form" @submit.prevent="forgotPass">
                <div class="form-group">
                    <label for="email">Email</label>
                    <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                    <input type="text" id="email" name="email" placeholder="Nhập email của bạn tại đây..."
                        v-model="email">
                </div>

                <button type="submit" class="form-submit-btn">
                <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin"
                    v-if="isLoading" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="#E5E7EB"></path>
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentColor"></path>
                </svg>
                Gửi
            </button>
            </form>

            <p class="signup-link">
                Bạn đã có tài khoản?
                <router-link :to="'/login'" class="signup-link link"> Đăng nhập ngay</router-link>
            </p>
        </div>
    </div>
</template>
<script>
import { ref } from 'vue';
import axios from 'axios';
import { toast } from 'vue3-toastify'

export default {
    setup() {
        const email = ref('')
        const errors = ref('')
        const isLoading = ref(false)

        const forgotPass = async () => {
            isLoading.value = true
            try {
                const res = await axios.post(`${import.meta.env.VITE_URL_API}api/forgot-password`, {
                    email: email.value
                })
                toast.success('Gửi thành công')
               
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    errors.value = {};
                    errors.value = error.response.data.errors;
                }else if(error.response && error.response.status === 404){
                    errors.value = {};
                    errors.value = {
                        email: [error.response.data.message] 
                    };
                }
            }finally{
                 isLoading.value = false
            }
        }

        return {
            email,
            errors,
            forgotPass,
            isLoading
        }
    }
}
</script>
<style scoped>
.form-container {
    width: 450px;
    background-color: #fff;
    padding: 32px 24px;
    font-size: 14px;
    font-family: inherit;
    color: #212121;
    display: flex;
    flex-direction: column;
    gap: 20px;
    box-sizing: border-box;
    border-radius: 10px;

}

.form-container button:active {
    scale: 0.95;
}

.form-container .logo-container {
    text-align: center;
    font-weight: 600;
    font-size: 18px;
}

.form-container .form {
    display: flex;
    flex-direction: column;
}

.form-container .form-group {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.form-container .form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-container .form-group input {
    width: 100%;
    padding: 12px 16px;
    border-radius: 6px;
    font-family: inherit;
    border: 1px solid #ccc;
}

.form-container .form-group input::placeholder {
    opacity: 0.5;
}

.form-container .form-group input:focus {
    outline: none;
    border-color: #1778f2;
}

.form-container .form-submit-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: inherit;
    color: #fff;
    background-color: #032f5c;
    border: none;
    width: 100%;
    padding: 12px 16px;
    font-size: inherit;
    gap: 8px;
    margin: 12px 0;
    cursor: pointer;
    border-radius: 6px;
    box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.084), 0px 2px 3px rgba(0, 0, 0, 0.168);
}

.form-submit-btn svg {
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


.form-container .form-submit-btn:hover {
    background-color: #313131;
}

.form-container .link {
    color: #1778f2;
    text-decoration: none;
}

.form-container .signup-link {
    align-self: center;
    font-weight: 500;
}

.form-container .signup-link .link {
    font-weight: 400;
}

.form-container .link:hover {
    text-decoration: underline;
}
</style>