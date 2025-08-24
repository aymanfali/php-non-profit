<script setup>
import Table from '@/components/Dashboard/Table.vue';
import AuthLayout from '../AuthLayout.vue';
import View from './View.vue';
import { useToast } from 'vue-toastification';
import axios from 'axios'
import { onMounted, ref } from 'vue';
import ConfirmModal from '@/components/Dashboard/ConfirmModal.vue';
const toast = useToast();

const currentContact = ref(
    {
        name: '',
        email: '',
        subject: '',
        message: '',
        date: ''
    }
);
const viewingContact = ref(null);
const showConfirmModal = ref(false);
const confirmModalConfig = ref({
    title: '',
    message: '',
    confirmText: 'Confirm',
    cancelText: 'Cancel'
});
const contactToDelete = ref(null)
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
const contacts = ref([])
async function fetchContacts() {
    try {
        const res = await axios.get(`${apiBaseUrl}/dashboard/contacts`);
        contacts.value = res.data;
    } catch (err) {
        contacts.value = [];
        toast.error('Failed to fetch contacts');
    }
}

onMounted(fetchContacts);

function handleDelete(contact) {
    contactToDelete.value = contact;
    showConfirmModal.value = true;
    confirmModalConfig.value = {
        title: 'Delete user',
        message: `Are you sure you want to delete ${contact.title}?`,
        confirmText: 'Delete',
        cancelText: 'Cancel'
    };
}
async function handleConfirm() {
    try {
        const res = await axios.post(`${apiBaseUrl}/dashboard/contacts/delete/${contactToDelete.value.id}`)
        if (res.data.success) {
            contacts.value = contacts.value.filter(i => i.id !== contactToDelete.value.id);
            toast.success('Contact deleted successfully.');
        } else {
            toast.error('Error deleting contact');
        }
    } catch (error) {
        toast.error('Failed to delete contact');
    }
    showConfirmModal.value = false;
    contactToDelete.value = null;
}
function handleCancel() {
    showConfirmModal.value = false;
    contactToDelete.value = null;
}
function viewDetails(contact) {
    viewingContact.value = { ...contact };
}


function closeView() {
    viewingContact.value = null;
}

</script>

<template>
    <AuthLayout>
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-6">Contact Submissions</h1>
        </div>

        <Table :headers="['Name', 'Email', 'Subject', 'Created_At']" :items="contacts" :allow-edit="false"
            @delete="handleDelete" @view="viewDetails" :filterableColumns="[
                { key: 'name', label: 'Name' },
                { key: 'email', label: 'Email' },
                { key: 'subject', label: 'Subject' },
                { key: 'created_at', label: 'Created_At', type: 'date' },

            ]" />

        <View v-if="viewingContact" :contact="viewingContact" @close="closeView" />

        <ConfirmModal :show="showConfirmModal" :title="confirmModalConfig.title" :message="confirmModalConfig.message"
            :confirmText="confirmModalConfig.confirmText" :cancelText="confirmModalConfig.cancelText"
            @confirm="handleConfirm" @cancel="handleCancel" />
    </AuthLayout>
</template>
