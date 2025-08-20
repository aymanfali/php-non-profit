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
            username: '',
            email: '',
            password: '',
            confirmPassword: '',
            role: 'user',
            isLoading: false,
            showPassword: false, // Added for password visibility toggle
            showConfirmPassword: false // Added for confirm password visibility toggle
        }
    },
    methods: {
        validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        },
        async handleRegistration() {
            if (!this.username || !this.email || !this.password) {
                this.toast.error('Please fill all fields');
                return;
            }
            if (!this.validateEmail(this.email)) {
                this.toast.error('Please enter a valid email');
                return;
            }
            if (this.password.length < 6) {
                this.toast.error('Password should be at least 6 characters');
                return;
            }
            if (this.password !== this.confirmPassword) {
                this.toast.error('Passwords do not match');
                return;
            }
            this.isLoading = true;
            try {
                // POST to backend API
                const response = await fetch(`${API_BASE_URL}/auth/register`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name: this.username,
                        email: this.email,
                        password: this.password,
                        password2: this.confirmPassword,
                        role: this.role
                    })
                });
                const result = await response.json();
                if (response.ok && result.success) {
                    this.toast.success('Registration Successful');
                    this.$router.push('/login');
                } else {
                    this.toast.error(result.error || 'Registration failed.');
                }
            } catch (error) {
                this.toast.error('Registration failed. Please try again.');
                console.error(error);
            } finally {
                this.isLoading = false;
            }
        },
        togglePasswordVisibility() { // Added for password toggle
            this.showPassword = !this.showPassword;
        },
        toggleConfirmPasswordVisibility() { // Added for confirm password toggle
            this.showConfirmPassword = !this.showConfirmPassword;
        }
    }
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
