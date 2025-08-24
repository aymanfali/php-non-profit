<script setup>
import DangerZone from '@/components/Dashboard/DangerZone.vue';
import AuthLayout from '../AuthLayout.vue';
import ConfirmModal from '@/components/Dashboard/ConfirmModal.vue';
import { useToast } from "vue-toastification";
import { ref } from 'vue';
import axios from 'axios';

const toast = useToast();
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

// Modal state
const showConfirmModal = ref(false);
const modalConfig = ref({
    title: '',
    message: '',
    confirmText: 'Confirm',
    cancelText: 'Cancel',
    action: () => { }
});

// Actions
const resetSiteData = () => {
    try {
        localStorage.clear();
        toast.success('Site data has been reset successfully!');
    } catch (error) {
        toast.error('Failed reseting site data');
    }
};

const clearUsersData = async () => {
    try {
        const res = await axios.post(`${apiBaseUrl}/dashboard/settings/delete_users`)
        if (res.data.success) {
            toast.success('Users data has been deleted successfully!');
        } else {
            toast.error('Error deleting users');
        }
    } catch (error) {
        toast.error('Failed deleting users');
    }
};

const clearNewsData = async () => {
    try {
        const res = await axios.post(`${apiBaseUrl}/dashboard/settings/delete_news`)
        if (res.data.success) {
            toast.success('News data has been deleted successfully!');
        } else {
            toast.error('Error deleting news');
        }
    } catch (error) {
        toast.error('Failed deleting news');
    }
};

const clearImpactsData = async () => {
    try {
        const res = await axios.post(`${apiBaseUrl}/dashboard/settings/delete_impacts`)
        if (res.data.success) {
            toast.success('Impacts data has been deleted successfully!');
        } else {
            toast.error('Error deleting impacts');
        }
    } catch (error) {
        toast.error('Failed deleting impacts');
    }
};

const clearContactsData = async () => {
    try {
        const res = await axios.post(`${apiBaseUrl}/dashboard/settings/delete_contacts`)        
        if (res.data.success) {            
            toast.success('Contacts data has been deleted successfully!');
        } else {
            toast.error('Error deleting contacts');
        }
    } catch (error) {
        toast.error('Failed deleting contacts');
    }
};

// Confirmation handler
const confirmAction = (title, message, action, confirmText, cancelText) => {
    modalConfig.value = {
        title,
        message,
        action,
        confirmText: confirmText || 'Confirm',
        cancelText: cancelText || 'Cancel'
    };
    showConfirmModal.value = true;
};

// Execute confirmed action
const executeConfirmedAction = () => {
    modalConfig.value.action();
    showConfirmModal.value = false;
};
</script>

<template>
    <AuthLayout>
        <div class="space-y-6">
            <h1 class="text-3xl font-bold">Settings</h1>

            <h2 class="text-xl font-semibold mb-4">Danger Zone</h2>
            <DangerZone title="Reset Site Data"
                description="This will clear all locally stored website data NOT including impacts, news, or contact submissions."
                buttonText="Reset Data" @reset="confirmAction(
                    'Reset All Site Data?',
                    'This will permanently delete ALL locally stored data. This action cannot be undone.',
                    resetSiteData,
                    'Reset All Data'
                )" />

            <DangerZone title="Delete Users Data" description="This will clear all locally stored Users data except admin."
                buttonText="Clear Users Data" @reset="confirmAction(
                    'Delete All Users Data?',
                    'This will permanently delete all Users data except admin. This action cannot be undone.',
                    clearUsersData
                )" />

            <DangerZone title="Delete News Data" description="This will clear all locally stored news data."
                buttonText="Clear News Data" @reset="confirmAction(
                    'Delete All News Data?',
                    'This will permanently delete all news data. This action cannot be undone.',
                    clearNewsData
                )" />

            <DangerZone title="Delete Impacts Data" description="This will clear all locally stored Impacts data."
                buttonText="Clear Impacts Data" @reset="confirmAction(
                    'Delete All Impacts Data?',
                    'This will permanently delete all impacts data. This action cannot be undone.',
                    clearImpactsData
                )" />

            <DangerZone title="Delete Contacts Submissions Data"
                description="This will clear all locally stored Contacts Submissions data."
                buttonText="Clear Contacts Data" @reset="confirmAction(
                    'Delete All Contact Submissions?',
                    'This will permanently delete all contact messages. This action cannot be undone.',
                    clearContactsData
                )" />

            <ConfirmModal :show="showConfirmModal" :title="modalConfig.title" :message="modalConfig.message"
                :confirm-text="modalConfig.confirmText" :cancel-text="modalConfig.cancelText"
                @confirm="executeConfirmedAction" @cancel="showConfirmModal = false" />
        </div>
    </AuthLayout>
</template>
