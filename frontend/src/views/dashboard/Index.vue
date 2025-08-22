<script setup>

import { useToast } from 'vue-toastification';
import AuthLayout from './AuthLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const usersCount = ref(0);
const newsCount = ref(0);
const impactsCount = ref(0);
const messagesCount = ref(0);
const data = ref(null);

const toast = useToast();

const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

async function fetchData() {
    try {
        const res = await axios.get(`${apiBaseUrl}/dashboard`);

        if (res.data) {
            usersCount.value = res.data.users || 0;
            newsCount.value = res.data.news || 0;
            impactsCount.value = res.data.impacts || 0;
            messagesCount.value = res.data.messages || 0;
            data.value = res.data;
        }        

    } catch (err) {
        data.value = null; // Clear any old data
        toast.error('Failed to fetch dashboard data. Please try again.');
    }
}

onMounted(fetchData);

</script>


<template>
    <AuthLayout>
        <h1 class="font-bold text-4xl">Dashboard</h1>
        <div class="cards grid md:grid-cols-2 lg:grid-cols-3">
            <div class="users border border-gray p-3 m-3 rounded-md text-center">
                <div class="count font-bold text-3xl">{{ usersCount }}</div>
                <div class="title text-2xl mt-2">Users</div>
            </div>

            <div class="news border border-gray p-3 m-3 rounded-md text-center">
                <div class="count font-bold text-3xl">{{ newsCount }}</div>
                <div class="title text-2xl mt-2">News</div>
            </div>
            <div class="impacts border border-gray p-3 m-3 rounded-md text-center">
                <div class="count font-bold text-3xl">{{ impactsCount }}</div>
                <div class="title text-2xl mt-2">Impacts</div>
            </div>

            <div class="impacts border border-gray p-3 m-3 rounded-md text-center">
                <div class="count font-bold text-3xl">{{ messagesCount }}</div>
                <div class="title text-2xl mt-2">Messages</div>
            </div>
        </div>
    </AuthLayout>
</template>
