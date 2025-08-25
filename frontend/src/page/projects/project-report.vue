<template>
    <div class="container mt-5">
        <div v-if="isLoading">
            <div class="skeleton-container">
                <div class="skeleton-header-line skeleton-box"></div>
                <div v-for="i in 5" :key="i" class="skeleton-line skeleton-box"></div>
            </div>
        </div>

        <table v-else class="table table-bordered table-striped text-center align-middle" style="z-index: 9999;">
            <thead>
                <tr>
                    <th rowspan="2"></th>
                    <th :colspan="Object.keys(totalTaskByStatus).length">Tổng</th>
                    <th rowspan="2">Tổng task</th>
                </tr>
                <tr>
                    <th v-for="(count, status) in totalTaskByStatus" :key="status">
                        {{ status }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Tổng</strong></td>
                    <td v-for="(count, status) in totalTaskByStatus" :key="status">
                        <strong>{{ count }}</strong>
                    </td>
                    <td><strong>{{ totalTasks }}</strong></td>
                </tr>
                <tr v-for="(userReport, index) in tasksByUserAndStatus" :key="index">
                    <td>{{ userReport.user.email }}</td>
                    <td v-for="(count, status) in userReport.user.total_tasks_by_status" :key="status">
                        {{ count }}
                    </td>
                    <td>{{ userReport.user.total_tasks }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { useTokenUser } from '@/components/store/useTokenUser';
import axios from 'axios';
import { onMounted, ref } from 'vue';

export default {
    props: {
        projectId: {
            type: [String, Number],
            required: true,
        },
    },
    setup(props) {
        const isLoading = ref(true);
        const totalTaskByStatus = ref({});
        const tasksByUserAndStatus = ref([]);
        const totalTasks = ref(0);
        const {
            token
        } = useTokenUser();

        const report = async (id) => {
            isLoading.value = true
            try {
                const res = await axios.get(`${import.meta.env.VITE_URL_API}api/project/report/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token.value}`,
                    },
                });

                totalTaskByStatus.value = res.data.totalTaskByStatus;
                tasksByUserAndStatus.value = res.data.tasksByUserAndStatus;
                totalTasks.value = res.data.totalTasks;
            } catch (error) {
                console.log(error);
            } finally {
                isLoading.value = false
            }
        };

        onMounted(async () => {
            await report(props.projectId);
        });

        return {
            token,
            totalTaskByStatus,
            tasksByUserAndStatus,
            totalTasks,
            isLoading
        };
    },
};
</script>

<style scoped>
th,
td {
    vertical-align: middle;
}

/* ---------------------------------------------------- */
/* Styles cho bảng trong dark mode */
/* ---------------------------------------------------- */
.dark-mode .table {
    background-color: #3c3e4b;
    color: #fff;
    border-color: #fff;
}

.dark-mode .table thead th {
    background-color: #3c3e4b;
    color: #fff;
}

.dark-mode .table tbody td {
    background-color: #3c3e4b;
    color: #fff;
}

.skeleton-container {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--table-border-color);
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.dark-mode .skeleton-container {
    border-color: var(--table-border-color);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.skeleton-box {
    background-color: #e0e0e0;
    border-radius: 4px;
    animation: loading 1.5s infinite ease-in-out;
}

.skeleton-box::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    transform: translateX(-100%);
    background-image: linear-gradient(90deg,
            rgba(255, 255, 255, 0) 0,
            rgba(255, 255, 255, 0.2) 20%,
            rgba(255, 255, 255, 0.5) 60%,
            rgba(255, 255, 255, 0));
    animation: shimmer 1.5s infinite;
}

.dark-mode .skeleton-box {
    background-color: #333;
}

.dark-mode .skeleton-box::after {
    background-image: linear-gradient(90deg,
            rgba(255, 255, 255, 0) 0,
            rgba(255, 255, 255, 0.1) 20%,
            rgba(255, 255, 255, 0.3) 60%,
            rgba(255, 255, 255, 0));
}

@keyframes shimmer {
    100% {
        transform: translateX(100%);
    }
}

.skeleton-line {
    height: 20px;
    margin-bottom: 10px;
    position: relative;
    overflow: hidden;
}

.skeleton-header-line {
    height: 40px;
    margin-bottom: 10px;
    position: relative;
    overflow: hidden;
}
</style>