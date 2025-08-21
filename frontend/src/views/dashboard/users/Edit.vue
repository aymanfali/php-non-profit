<script setup>
import { ref, watch } from 'vue';
import { useToast } from 'vue-toastification';
import axios from 'axios';
import CancelBtn from '@/components/Dashboard/Buttons/CancelBtn.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';

const props = defineProps({
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
});
const emit = defineEmits(['save', 'cancel']);
const toast = useToast();

const localUser = ref({ ...props.user });
const password = ref('');
const confirmPassword = ref('');
const showPassword = ref(false);
const showConfirmPassword = ref(false);
const passwordError = ref('');

watch(() => props.user, (newUser) => {
    localUser.value = { ...newUser };
});

async function handleSubmit() {
    if (validateForm()) {
        const userData = {};
        if (localUser.value.name && localUser.value.name.trim() !== '') userData.name = localUser.value.name;
        if (localUser.value.email && localUser.value.email.trim() !== '') userData.email = localUser.value.email;
        if (localUser.value.role && localUser.value.role.trim() !== '') userData.role = localUser.value.role;
        if (password.value && password.value.trim() !== '') userData.password = password.value;
        userData.id = localUser.value.id;
        try {
            const apiBase = import.meta.env.VITE_API_BASE_URL;
            const res = await axios.post(`${apiBase}/users/update/${localUser.value.id}`, userData);
            if (res.data.success) {
                toast.success('User updated successfully');
                emit('save', userData);
            } else {
                toast.error('Update failed');
            }
        } catch (err) {
            toast.error('Error updating user');
        }
    }
}

function handleCancel() {
    emit('cancel');
}

function validateForm() {
    passwordError.value = '';
    if (!localUser.value.name.trim()) {
        toast.error('Please enter a name');
        return false;
    }
    if (!localUser.value.email.trim() || !isValidEmail(localUser.value.email)) {
        toast.error('Please enter a valid email');
        return false;
    }
    if (password.value || confirmPassword.value) {
        if (password.value.length < 6) {
            passwordError.value = 'Password must be at least 6 characters';
            toast.error(passwordError.value);
            return false;
        }
        if (password.value !== confirmPassword.value) {
            passwordError.value = 'Passwords do not match';
            toast.error(passwordError.value);
            return false;
        }
    }
    return true;
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function togglePasswordVisibility(field) {
    if (field === 'password') {
        showPassword.value = !showPassword.value;
    } else {
        showConfirmPassword.value = !showConfirmPassword.value;
    }
}
</script>

<template>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-bg p-6 rounded-lg shadow-md mb-6 w-full md:w-1/2">
            <h2 class="text-xl font-semibold mb-4">Edit User</h2>

            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <label class="block mb-2" for="name">Name</label>
                    <input id="name" v-model="localUser.name" type="text" class="w-full px-3 py-2 bg-primary/20 outline-0 rounded"
                        required placeholder="Enter user name" />
                </div>

                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="email">Email</label>
                    <input id="email" v-model="localUser.email" type="email" class="w-full px-3 py-2 bg-primary/20 outline-0 rounded"
                        required placeholder="Enter user email" />
                </div>

                <!-- New Password Fields -->
                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="password">New Password</label>
                    <div class="relative">
                        <input id="password" v-model="password" :type="showPassword ? 'text' : 'password'"
                            class="w-full px-3 py-2 bg-primary/20 outline-0 rounded pr-10" placeholder="Enter new password" />
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
                            class="w-full px-3 py-2 bg-primary/20 outline-0 rounded pr-10" placeholder="Confirm new password" />
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
                    <select id="role" v-model="localUser.role" class="w-full px-3 py-2 bg-primary/20 outline-0 rounded"
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
