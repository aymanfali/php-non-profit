<script>
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import Logo from '@/components/Logo.vue';
import { useToast } from 'vue-toastification';
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

export default {
    components: {
        PrimaryBtn,
        Logo
    },
    setup() {
        const toast = useToast();
        return { toast }
    },
    data() {
        return {
            email: '',
            password: '',
            showPassword: false // Add this new data property
        }
    },
    methods: {
        async handleLogin() {
            try {
                const response = await fetch(`${API_BASE_URL}/auth/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: this.email,
                        password: this.password
                    }),
                    credentials: 'include'
                });
                const result = await response.json();
                if (response.ok && result.success) {
                    this.toast.success('Login Successful');
                    this.$router.push('/dashboard/');
                } else {
                    this.toast.error(result.error || 'Invalid Credentials!');
                }
            } catch (error) {
                this.toast.error('Login failed. Please try again.');
            }
        },
        toggleShowPassword() { // Add this new method
            this.showPassword = !this.showPassword;
        }
    }
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
                        <div class="" v-if="showPassword">
                            <span class="material-symbols-outlined">
                                visibility
                            </span>
                        </div>
                        <div class="" v-else>
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
