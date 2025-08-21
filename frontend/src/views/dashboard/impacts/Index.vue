<script setup>
import { ref, onMounted } from 'vue';
import Table from '@/components/Dashboard/Table.vue';
import AuthLayout from '../AuthLayout.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import Create from './Create.vue';
import Edit from './Edit.vue';
import View from './View.vue';
import { useToast } from 'vue-toastification';
import axios from 'axios';
import ConfirmModal from '@/components/Dashboard/ConfirmModal.vue';


const toast = useToast();

const showCreateForm = ref(false);
const showEditForm = ref(false);
const currentImpact = ref({
    id: '',
    title: '',
    image: '',
    created_at: ''
});
const viewingImpact = ref(null);
const showConfirmModal = ref(false);
const confirmModalConfig = ref({
    title: '',
    message: '',
    confirmText: 'Confirm',
    cancelText: 'Cancel'
});
const impactToDelete = ref(null);
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

const impacts = ref([]);
async function fetchImpacts() {
    try {
        const res = await axios.get(`${apiBaseUrl}/impacts`);
        impacts.value = res.data;
    } catch (err) {
        impacts.value = [];
        toast.error('Failed to fetch impacts');
    }
}

onMounted(fetchImpacts);

function handleAdd() {
    showCreateForm.value = true;
    showEditForm.value = false;
}
function handleEdit(impact) {
    currentImpact.value = { ...impact }
    showEditForm.value = true;
    showCreateForm.value = false;
}
function handleDelete(impact) {
    impactToDelete.value = impact;
    showConfirmModal.value = true;
    confirmModalConfig.value = {
        title: 'Delete user',
        message: `Are you sure you want to delete ${impact.title}?`,
        confirmText: 'Delete',
        cancelText: 'Cancel'
    };
}
async function handleConfirm() {
    try {
        const res = await axios.post(`${apiBaseUrl}/impacts/delete/${impactToDelete.value.id}`)
        if (res.data.success) {
            impacts.value = impacts.value.filter(i => i.id !== impactToDelete.value.id);
            toast.success('Impact deleted successfully.');
        } else {
            toast.error('Error deleting impact');
        }
    } catch (error) {
        toast.error('Failed to delete impact');
    }
    showConfirmModal.value = false;
    impactToDelete.value = null;
}
function handleCancel() {
    showConfirmModal.value = false;
    impactToDelete.value = null;
}
function viewDetails(impact) {
    viewingImpact.value = { ...impact };
}
function handleCreate(impact) {
    try {
        impacts.value.unshift(impact);
        showCreateForm.value = false;
    } catch (error) {
        toast.error('Failed to create impact');
    }
}
function handleUpdate(impact) {
    try {
        const index = impacts.value.findIndex(i => i.id === currentImpact.value.id);
        if (index !== -1) {
            impacts.value[index] = impact;
            showEditForm.value = false;
        }
        toast.success('Impact updated successfully');
    } catch (error) {
        toast.error('Failed to update impact');
    }
}
function closeForms() {
    showCreateForm.value = false;
    showEditForm.value = false;
}
function closeView() {
    viewingImpact.value = null;
}

</script>

<template>
    <AuthLayout>
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-6">Impacts</h1>
            <PrimaryBtn name="Add Impact" @click="handleAdd" />
        </div>

        <Create v-if="showCreateForm" @save="handleCreate" @cancel="closeForms" />
        <Edit v-if="showEditForm" :impact="currentImpact" @save="handleUpdate" @cancel="closeForms" />
        <Table :headers="['Title', 'Image', 'Created_At']" :items="impacts" @edit="handleEdit" @delete="handleDelete"
            @view="viewDetails" :filterableColumns="[
                { key: 'title', label: 'Title' },
                { key: 'created_at', label: 'Date', type: 'date' },
            ]" />

        <View v-if="viewingImpact" :impact="viewingImpact" @close="closeView" />

        <ConfirmModal :show="showConfirmModal" :title="confirmModalConfig.title" :message="confirmModalConfig.message"
            :confirmText="confirmModalConfig.confirmText" :cancelText="confirmModalConfig.cancelText"
            @confirm="handleConfirm" @cancel="handleCancel" />
    </AuthLayout>
</template>
