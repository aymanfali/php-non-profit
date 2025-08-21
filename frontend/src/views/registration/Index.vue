<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import Logo from '@/components/Logo.vue';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
const username = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const role = ref('user');
const isLoading = ref(false);
const showPassword = ref(false);
const showConfirmPassword = ref(false);
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
        // If error, stay on registration page
    }
});

function validateEmail(emailVal) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(emailVal);
}

async function handleRegistration() {
    if (!username.value || !email.value || !password.value) {
        toast.error('Please fill all fields');
        return;
    }
    if (!validateEmail(email.value)) {
        toast.error('Please enter a valid email');
        return;
    }
    if (password.value.length < 6) {
        toast.error('Password should be at least 6 characters');
        return;
    }
    if (password.value !== confirmPassword.value) {
        toast.error('Passwords do not match');
        return;
    }
    isLoading.value = true;
    try {
        const response = await fetch(`${API_BASE_URL}/auth/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                name: username.value,
                email: email.value,
                password: password.value,
                password2: confirmPassword.value,
                role: role.value
            })
        });
        const result = await response.json();
        if (response.ok && result.success) {
            toast.success('Registration Successful');
            router.push('/login');
        } else {
            toast.error(result.error || 'Registration failed.');
        }
    } catch (error) {
        toast.error('Registration failed. Please try again.');
        console.error(error);
    } finally {
        isLoading.value = false;
    }
}

function togglePasswordVisibility() {
    showPassword.value = !showPassword.value;
}

function toggleConfirmPasswordVisibility() {
    showConfirmPassword.value = !showConfirmPassword.value;
}
</script>

<template>
    <div class="flex flex-col justify-center items-center h-screen text-text-main m-5">
        <div class="bg-horizontal-line">
            <Logo />
        </div>
        <div class="border border-horizontal-line/20 p-4 m-3 rounded-lg w-full max-w-md">
            <h1 class="text-center text-3xl font-bold m-2">Register</h1>
            <form @submit.prevent="handleRegistration" class="flex flex-col">
                <input type="text" v-model="username" placeholder="Username"
                    class="bg-primary/20 px-4 py-3 my-2 rounded-lg text-center outline-horizontal-line" required>
                <input type="email" v-model="email" placeholder="Email"
                    class="bg-primary/20 px-4 py-3 my-2 rounded-lg text-center outline-horizontal-line" required>

                <!-- Password field with toggle -->
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" v-model="password" placeholder="Password"
                        class="bg-primary/20 px-4 py-3 my-2 rounded-lg text-center outline-horizontal-line w-full"
                        required>
                    <button type="button" @click="togglePasswordVisibility"
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

                <!-- Confirm Password field with toggle -->
                <div class="relative">
                    <input :type="showConfirmPassword ? 'text' : 'password'" v-model="confirmPassword"
                        placeholder="Confirm Password"
                        class="bg-primary/20 px-4 py-3 my-2 rounded-lg text-center outline-horizontal-line w-full"
                        required>
                    <button type="button" @click="toggleConfirmPasswordVisibility"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-sm text-horizontal-line hover:text-text-main focus:outline-none">
                        <div class="" v-if="showConfirmPassword">
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

                <PrimaryBtn type="submit" :name="isLoading ? 'Registering...' : 'Register'" :disabled="isLoading" />
            </form>
        </div>
        <p>
            Already have an account? <router-link to="/login"
                class="text-horizontal-line hover:underline">Login</router-link>
        </p>
    </div>
</template>
