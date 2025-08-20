<script>
import CancelBtn from '@/components/Dashboard/Buttons/CancelBtn.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import { useToast } from 'vue-toastification';

export default {
    components: {
        CancelBtn,
        PrimaryBtn
    },
    props: {
        user: {
            type: Object,
            required: true,
            default: () => ({
                name: '',
                email: '',
                role: 'user',
                id: ''
            })
        }
    },
    emits: ['save', 'cancel'],
    setup() {
        const toast = useToast();
        return { toast };
    },
    data() {
        return {
            localUser: { ...this.user },
            password: '',
            confirmPassword: '',
            showPassword: false,
            showConfirmPassword: false,
            passwordError: ''
        }
    },
    watch: {
        user(newUser) {
            this.localUser = { ...newUser };
        }
    },
    methods: {
        handleSubmit() {
            if (this.validateForm()) {
                const userData = {
                    ...this.localUser,
                    ...(this.password ? { password: this.password } : {})
                };
                this.$emit('save', userData);
            }
        },
        handleCancel() {
            this.$emit('cancel');
        },
        validateForm() {
            // Clear previous errors
            this.passwordError = '';

            // Basic validation
            if (!this.localUser.name.trim()) {
                this.toast.error('Please enter a name');
                return false;
            }

            if (!this.localUser.email.trim() || !this.isValidEmail(this.localUser.email)) {
                this.toast.error('Please enter a valid email');
                return false;
            }

            // Password validation only if password fields are not empty
            if (this.password || this.confirmPassword) {
                if (this.password.length < 6) {
                    this.passwordError = 'Password must be at least 6 characters';
                    this.toast.error(this.passwordError);
                    return false;
                }

                if (this.password !== this.confirmPassword) {
                    this.passwordError = 'Passwords do not match';
                    this.toast.error(this.passwordError);
                    return false;
                }
            }

            return true;
        },
        isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        },
        togglePasswordVisibility(field) {
            if (field === 'password') {
                this.showPassword = !this.showPassword;
            } else {
                this.showConfirmPassword = !this.showConfirmPassword;
            }
        }
    }
}
</script>
<template>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-bg p-6 rounded-lg shadow-md mb-6 w-full md:w-1/2">
            <h2 class="text-xl font-semibold mb-4">Edit User</h2>

            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <label class="block text-gray/70 mb-2" for="name">Name</label>
                    <input id="name" v-model="localUser.name" type="text" class="w-full px-3 py-2 border rounded"
                        required placeholder="Enter user name" />
                </div>

                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="email">Email</label>
                    <input id="email" v-model="localUser.email" type="email" class="w-full px-3 py-2 border rounded"
                        required placeholder="Enter user email" />
                </div>

                <!-- New Password Fields -->
                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="password">New Password (leave blank to keep
                        current)</label>
                    <div class="relative">
                        <input id="password" v-model="password" :type="showPassword ? 'text' : 'password'"
                            class="w-full px-3 py-2 border rounded pr-10" placeholder="Enter new password"/>
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500"
                            @click="togglePasswordVisibility('password')">
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
                </div>

                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="confirmPassword">Confirm New Password</label>
                    <div class="relative">
                        <input id="confirmPassword" v-model="confirmPassword"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            class="w-full px-3 py-2 border rounded pr-10" placeholder="Confirm new password"/>
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500"
                            @click="togglePasswordVisibility('confirm')">
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
                    <p v-if="passwordError" class="text-red-500 text-sm mt-1">{{ passwordError }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="role">Role</label>
                    <select id="role" v-model="localUser.role" class="w-full px-3 py-2 border rounded"
                        aria-label="User role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3">
                    <CancelBtn type="button" @click="handleCancel" name="Cancel" />
                    <PrimaryBtn type="submit" name="Update" />
                </div>
            </form>
        </div>
    </div>
</template>
