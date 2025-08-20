<script setup>
import { ref, onMounted } from 'vue';
import Table from '@/components/Dashboard/Table.vue';
import AuthLayout from '../AuthLayout.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import Create from './Create.vue';
import Edit from './Edit.vue';
import View from './View.vue';
import { useToast } from 'vue-toastification';
import { defineAsyncComponent } from 'vue';
import axios from 'axios';
import ConfirmModal from '@/components/Dashboard/ConfirmModal.vue';

const showCreateForm = ref(false);
const showEditForm = ref(false);
const currentUser = ref({
    id: '',
    name: '',
    email: '',
    date: '',
    role: 'user',
});
const viewingUser = ref(null);
const showConfirmModal = ref(false);
const confirmModalConfig = ref({
    title: '',
    message: '',
    confirmText: 'Confirm',
    cancelText: 'Cancel'
});
const userToDelete = ref(null);
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
const toast = useToast();


const users = ref([]);
async function fetchUsers() {
    try {
        const res = await axios.get(`${apiBaseUrl}/users`);
        users.value = res.data;
    } catch (err) {
        users.value = [];
        toast.error('Failed to fetch users');
    }
}

onMounted(fetchUsers);

function handleAdd() {
    showCreateForm.value = true;
    showEditForm.value = false;
}
function handleEdit(user) {
    currentUser.value = { ...user };
    showEditForm.value = true;
    showCreateForm.value = false;
}
function handleDelete(user) {
    userToDelete.value = user;
    showConfirmModal.value = true;
    confirmModalConfig.value = {
        title: 'Delete user',
        message: `Are you sure you want to delete ${user.name}?`,
        confirmText: 'Delete',
        cancelText: 'Cancel'
    };
}
function handleConfirm() {
    users.value = users.value.filter(u => u.id !== userToDelete.value.id);
    showConfirmModal.value = false;
    userToDelete.value = null;
    toast.success('User deleted successfully');
}
function handleCancel() {
    showConfirmModal.value = false;
    userToDelete.value = null;
}
function viewDetails(user) {
    viewingUser.value = { ...user };
}
function handleCreate(user) {
    const userWithId = {
        ...user,
        id: Date.now().toString(36) + Math.random().toString(36).substr(2)
    };
    users.value.unshift(userWithId);
    showCreateForm.value = false;
    toast.success('User created successfully');
}
function handleUpdate(updatedUser) {
    const index = users.value.findIndex(u => u.id === currentUser.value.id);
    if (index !== -1) {
        users.value[index] = updatedUser;
        showEditForm.value = false;
        toast.success('User updated successfully');
    }
}
function closeForms() {
    showCreateForm.value = false;
    showEditForm.value = false;
}
function closeView() {
    viewingUser.value = null;
}
</script>

<template>
    <AuthLayout>
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-6">Users</h1>
            <PrimaryBtn name="Add User" @click="handleAdd" />
        </div>

        <Create v-if="showCreateForm" @save="handleCreate" @cancel="closeForms" />

        <Edit v-if="showEditForm" :user="currentUser" @save="handleUpdate" @cancel="closeForms" />

        <Table :headers="['Name', 'Email', 'Role', 'Date']" :items="users" :filterableColumns="[
            { key: 'name', label: 'Name' },
            { key: 'email', label: 'Email' },
            { key: 'role', label: 'Role' },
            { key: 'date', label: 'Date', type: 'date' },

        ]" @edit="handleEdit" @delete="handleDelete" @view="viewDetails" />

        <View v-if="viewingUser" :user="viewingUser" @close="closeView" />

        <ConfirmModal :show="showConfirmModal" :title="confirmModalConfig.title" :message="confirmModalConfig.message"
            :confirmText="confirmModalConfig.confirmText" :cancelText="confirmModalConfig.cancelText"
            @confirm="handleConfirm" @cancel="handleCancel" />
    </AuthLayout>
</template>
