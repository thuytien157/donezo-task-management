<template>
    <main class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div v-if="loading" class="text-center">
            <div class="spinner">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            <p class="mt-3 fs-5 fw-bold text-secondary">Đang xử lý...</p>
        </div>
        <div v-else>
        </div>
    </main>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2';
const route = useRoute();
const router = useRouter();
const loading = ref(true);

const handleLoginCallback = async () => {
    const token = route.query.token;
    const loginExistingAccount = route.query.login_existing_account;
    const userStr = {
        user: route.query.user,
        id: route.query.id
    };

    if (loginExistingAccount === 'true' && token && userStr) {
        loading.value = false;
        Swal.fire({
            title: 'Đã có tài khoản!',
            text: "Email này đã được đăng ký. Bạn có muốn đăng nhập không?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#042d62',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đăng nhập',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.setItem('token_donezo', token);
                localStorage.setItem('user_donezo', JSON.stringify(userStr));
                toast.success("Đăng nhập thành công!");
                router.push('/');
                window.location.reload();
            }
        });
    }
    else if (token && userStr.user) {
        localStorage.setItem('token_donezo', token);
        try {
            localStorage.setItem('user_donezo', JSON.stringify(userStr));
        } catch (e) {
            console.error('Lỗi stringify user:', e);
        }

        setTimeout(() => {
            loading.value = false;
            toast.success("Đăng nhập thành công!");
            router.push('/home').then(() => window.location.reload());
        }, 1500);
    }
    else {
        loading.value = false;
        router.push('/login');
    }
};

onMounted(() => {
    setTimeout(() => {
        handleLoginCallback();
    }, 50);
});
</script>
<style scoped>
.spinner {
    --gap: 5px;
    --clr: #042d64;
    --height: 23px;
    width: 100px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--gap);
}

.spinner span {
    background: var(--clr);
    width: 6px;
    height: var(--height);
    animation: grow 1s ease-in-out infinite;
}

.spinner span:nth-child(2) {
    animation: grow 1s ease-in-out 0.15s infinite;
}

.spinner span:nth-child(3) {
    animation: grow 1s ease-in-out 0.3s infinite;
}

.spinner span:nth-child(4) {
    animation: grow 1s ease-in-out 0.475s infinite;
}

@keyframes grow {

    0%,
    100% {
        transform: scaleY(1);
    }

    50% {
        transform: scaleY(1.8);
    }
}
</style>