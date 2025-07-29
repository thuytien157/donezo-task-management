<template>
    <div>Đang đăng nhập...</div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { toast } from 'vue3-toastify'

const route = useRoute();
const router = useRouter();

onMounted(() => {
    const token = route.query.token;

    const userStr = ref({
        user: route.query.user,
        id: route.query.id
    });

    if (token && userStr.value) {
        localStorage.setItem('token', token);

        try {
            localStorage.setItem('user', JSON.stringify(userStr.value));
        } catch (e) {
            console.error('Lỗi stringify user:', e);
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
