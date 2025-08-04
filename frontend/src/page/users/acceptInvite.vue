<template>
    <main class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div v-if="loading" class="text-center">
            <div class="spinner">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>
        <div class="text-center">

            <p class="mt-3 fs-5">Đang xử lý</p>
        </div>

    </main>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import Swal from 'sweetalert2'

const route = useRoute();
const router = useRouter();

const loading = ref(true);
const token = ref(localStorage.getItem("token"));
const handleInviteCallback = async () => {
    const invitationToken = route.query.token;

    if (!token.value) {
        Swal.fire({
            icon: 'info',
            title: 'Bạn chưa đăng nhập',
            text: 'Vui lòng đăng nhập để chấp nhận lời mời này.',
            confirmButtonText: 'Đăng nhập',
            confirmButtonColor: '#042d64',
        }).then((result) => {
            if (result.isConfirmed) {
                router.push('/login');
            } else {
                router.push('/home');
            }
        });
        loading.value = false;
        return;
    }

    try {
        const res = await axios.post('http://127.0.0.1:8000/api/invite-member-accepted', {
            token: invitationToken,
        }, {
            headers: {
                Authorization: `Bearer ${token.value}`,
            },
        });

        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: res.data.message || 'Bạn đã chấp nhận lời mời thành công!',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    } catch (error) {
        const errorMessage = error.response?.data?.message || 'Có lỗi xảy ra, vui lòng thử lại sau.';

        Swal.fire({
            toast: true,
            icon: 'error',
            title: errorMessage,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

    } finally {
        loading.value = false;
        setTimeout(() => {
            router.push('/home');
        }, 3000);
    }
};

onMounted(() => {
    handleInviteCallback();
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