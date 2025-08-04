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

const route = useRoute();
const router = useRouter();
const loading = ref(true);

const handleLoginCallback = async () => {
    const token = route.query.token;
    const userStr = {
        user: route.query.user,
        id: route.query.id
    };

    if (token && userStr.user) {
        localStorage.setItem('token', token);
        try {
            localStorage.setItem('user', JSON.stringify(userStr));
        } catch (e) {
            console.error('Lỗi stringify user:', e);
        }

        setTimeout(() => {
            loading.value = false;
            toast.success("Đăng nhập thành công!");
            router.push('/home').then(() => window.location.reload());
        }, 1500);

    } else {
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