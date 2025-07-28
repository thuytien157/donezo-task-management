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

                <button class="form-submit-btn" type="submit">Gửi</button>
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

        const forgotPass = async () => {
            try {
                const res = await axios.post('http://127.0.0.1:8000/api/forgot-password', {
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
            }
        }

        return {
            email,
            errors,
            forgotPass
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