<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import Logo from '@/components/Logo.vue';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
const email = ref('');
const password = ref('');
const showPassword = ref(false);
const toast = useToast();
const router = useRouter();

onMounted(async () => {
    try {
        const res = await fetch(`${API_BASE_URL}/auth/check`, {
            method: 'GET',
            credentials: 'include'
        });
        const result = await res.json();
        if (result.loggedIn) {
            router.push('/');
            return;
        }
    } catch (e) {
        // If error, stay on login page
        
    }
});


async function handleLogin() {
    try {
        const response = await fetch(`${API_BASE_URL}/auth/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email.value,
                password: password.value
            }),
            credentials: 'include'
        });
        const result = await response.json();
        if (response.ok && result.success) {
            toast.success('Login Successful');
            router.push('/dashboard/');
        } else {
            toast.error(result.error || 'Invalid Credentials!');
        }
    } catch (error) {
        toast.error('Login failed. Please try again.');
    }
}

function toggleShowPassword() {
    showPassword.value = !showPassword.value;
}
</script>

<template>
    <div class="flex flex-col justify-center items-center h-screen text-text-main m-5">
        <div class="bg-horizontal-line">
            <Logo />
        </div>
        <div class="border border-horizontal-line/20 p-4 m-3 rounded-lg  w-full max-w-md">
            <h1 class="text-center text-3xl font-bold m-2">Login</h1>
            <form @submit.prevent="handleLogin" class="flex flex-col ">
                <input type="email" v-model="email" placeholder="Email"
                    class="bg-primary/20 px-4 py-3 my-2 rounded-lg text-center outline-horizontal-line" required>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" v-model="password" placeholder="Password"
                        class="bg-primary/20 px-4 py-3 my-2 rounded-lg text-center outline-horizontal-line w-full"
                        required>
                    <button type="button" @click="toggleShowPassword"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-sm text-horizontal-line hover:text-text-main focus:outline-none">
                        <div v-if="showPassword">
                            <span class="material-symbols-outlined">
                                visibility
                            </span>
                        </div>
                        <div v-else>
                            <span class="material-symbols-outlined">
                                visibility_off
                            </span>
                        </div>
                    </button>
                </div>
                <PrimaryBtn type="submit" name="Login" />
            </form>
        </div>
        <p>
            Don't have an account? <router-link to="/register"
                class="text-horizontal-line hover:underline">Register</router-link>
        </p>
    </div>
</template>
