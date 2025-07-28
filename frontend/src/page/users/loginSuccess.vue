<template>
    <div>Đang đăng nhập...</div>
</template>

<script setup>
import { onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { toast } from 'vue3-toastify'

const route = useRoute();
const router = useRouter();

onMounted(() => {
    const token = route.query.token;
    const userStr = route.query.user;
    const error = route.query.error;

    if (error) {
        toast.error(error);
        setTimeout(() => {
            router.push('/login');
        }, 1500);
        return;
    }

    if (token && userStr) {
        localStorage.setItem('token', token);

        try {
            const user = JSON.parse(userStr);
            localStorage.setItem('user', JSON.stringify(user));
        } catch (e) {
            console.error('Lỗi parse user:', e);
            localStorage.setItem('user', userStr);
        }

        toast.success("Đăng nhập thành công!");
        setTimeout(() => {
            router.push('/home').then(() => window.location.reload());
        }, 1500);
    } else {
        router.push('/login');
    }
});
</script>
