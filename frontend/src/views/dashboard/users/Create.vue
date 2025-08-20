<script>
import CancelBtn from '@/components/Dashboard/Buttons/CancelBtn.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import { useToast } from 'vue-toastification';
import axios from 'axios';

export default {
    components: {
        PrimaryBtn,
        CancelBtn
    },
    emits: ['save', 'cancel'],
    setup() {
        const toast = useToast();
        return { toast };
    },
    data() {
        return {
            user: { 
                id: '',
                date: new Date().toISOString().split('T')[0],
                name: '',
                email: '',
                password: '',
                confirmPassword: '',
                role: 'user'
            },
            showPassword: false,
            showConfirmPassword: false,
            errors: {}
        }
    },
    methods: {
        generateUniqueId() {
            return Date.now().toString(36) + Math.random().toString(36).substring(2);
        },
        validateForm() {
            this.errors = {};
            let isValid = true;

            // Name validation
            if (!this.user.name.trim()) {
                this.errors.name = 'Name is required';
                isValid = false;
            }

            // Email validation
            if (!this.user.email.trim()) {
                this.errors.email = 'Email is required';
                isValid = false;
            } else if (!this.validateEmail(this.user.email)) {
                this.errors.email = 'Please enter a valid email';
                isValid = false;
            }

            // Password validation
            if (!this.user.password) {
                this.errors.password = 'Password is required';
                isValid = false;
            } else if (this.user.password.length < 6) {
                this.errors.password = 'Password must be at least 6 characters';
                isValid = false;
            }

            // Confirm password validation
            if (this.user.password !== this.user.confirmPassword) {
                this.errors.confirmPassword = 'Passwords do not match';
                isValid = false;
            }

            if (!isValid) {
                this.toast.error('Please fix the form errors');
            }

            return isValid;
        },
        validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        },
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
        toggleConfirmPasswordVisibility() {
            this.showConfirmPassword = !this.showConfirmPassword;
        },
        async handleSubmit() {
            if (this.validateForm()) {
                try {
                    const apiBase = import.meta.env.VITE_API_BASE_URL;
                    const payload = {
                        name: this.user.name,
                        email: this.user.email,
                        role: this.user.role,
                        password: this.user.password
                    };
                    const res = await axios.post(`${apiBase}/users`, payload);
                    if (res.data.success) {
                        this.toast.success('User added successfully');
                        this.$emit('save', res.data.user || { ...this.user });
                    } else {
                        this.toast.error(res.data.message || 'Failed to add user');
                    }
                } catch (err) {
                    this.toast.error('Error adding user');
                }
            }
        },
        handleCancel() {
            this.$emit('cancel');
        }
    }
}
</script>

<template>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-bg p-6 rounded-lg shadow-md mb-6 w-full md:w-1/2">
            <h2 class="text-xl font-semibold mb-4">Add New User</h2>

            <form @submit.prevent="handleSubmit">
                <!-- Name Field -->
                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="name">Name</label>
                    <input id="name" v-model="user.name" type="text"
                        class="w-full px-3 py-2 outline-0 rounded bg-primary/20"
                        :class="{ 'border-red-500': errors.name }" placeholder="Enter user name" />
                    <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</p>
                </div>

                <!-- Email Field -->
                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="email">Email</label>
                    <input id="email" v-model="user.email" type="email"
                        class="w-full px-3 py-2 outline-0 rounded bg-primary/20"
                        :class="{ 'border-red-500': errors.email }" placeholder="Enter user email" />
                    <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="password">Password</label>
                    <div class="relative">
                        <input id="password" v-model="user.password" :type="showPassword ? 'text' : 'password'"
                            class="w-full px-3 py-2 outline-0 rounded bg-primary/20 pr-10"
                            :class="{ 'border-red-500': errors.password }" placeholder="Enter password" />
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500"
                            @click="togglePasswordVisibility" aria-label="Toggle password visibility">
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
                    <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="confirmPassword">Confirm Password</label>
                    <div class="relative">
                        <input id="confirmPassword" v-model="user.confirmPassword" :type="showConfirmPassword ? 'text' : 'password'"
                            class="w-full px-3 py-2 outline-0 rounded bg-primary/20 pr-10"
                            :class="{ 'border-red-500': errors.confirmPassword }" placeholder="Confirm password" />
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500"
                            @click="toggleConfirmPasswordVisibility" aria-label="Toggle confirm password visibility">
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
                    <p v-if="errors.confirmPassword" class="text-red-500 text-sm mt-1">{{ errors.confirmPassword }}</p>
                </div>

                <!-- Role Field -->
                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="role">Role</label>
                    <select id="role" v-model="user.role" class="w-full px-3 py-2 outline-0 rounded bg-primary/20">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3">
                    <CancelBtn type="button" @click="handleCancel" name="Cancel" />
                    <PrimaryBtn type="submit" name="Add User" />
                </div>
            </form>
        </div>
    </div>
</template>
