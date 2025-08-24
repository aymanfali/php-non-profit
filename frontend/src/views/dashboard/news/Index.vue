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
const currentNews = ref({
    id: '',
    title: '',
    image: '',
    created_at: ''
});
const viewingNews = ref(null);
const showConfirmModal = ref(false);
const confirmModalConfig = ref({
    title: '',
    message: '',
    confirmText: 'Confirm',
    cancelText: 'Cancel'
});
const newsToDelete = ref(null);
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

const news = ref([]);
async function fetchNews() {
    try {
        const res = await axios.get(`${apiBaseUrl}/dashboard/news`);
        news.value = res.data;
    } catch (err) {
        news.value = [];
        toast.error('Failed to fetch news');
    }
}

onMounted(fetchNews);

function handleAdd() {
    showCreateForm.value = true;
    showEditForm.value = false;
}
function handleEdit(news) {
    currentNews.value = { ...news }
    showEditForm.value = true;
    showCreateForm.value = false;
}
function handleDelete(news) {
    newsToDelete.value = news;
    showConfirmModal.value = true;
    confirmModalConfig.value = {
        title: 'Delete user',
        message: `Are you sure you want to delete ${news.title}?`,
        confirmText: 'Delete',
        cancelText: 'Cancel'
    };
}
async function handleConfirm() {
    try {
        const res = await axios.post(`${apiBaseUrl}/dashboard/news/delete/${newsToDelete.value.id}`)
        if (res.data.success) {
            news.value = news.value.filter(i => i.id !== newsToDelete.value.id);
            toast.success('News deleted successfully.');
        } else {
            toast.error('Error deleting news');
        }
    } catch (error) {
        toast.error('Failed to delete news');
    }
    showConfirmModal.value = false;
    newsToDelete.value = null;
}
function handleCancel() {
    showConfirmModal.value = false;
    newsToDelete.value = null;
}
function viewDetails(news) {
    viewingNews.value = { ...news };
}
function handleCreate(_news) {
    try {
        news.value.unshift(_news);
        showCreateForm.value = false;
    } catch (error) {
        toast.error('Failed to create news');
    }
}
function handleUpdate(_news) {
    try {
        const index = news.value.findIndex(i => i.id === currentNews.value.id);
        if (index !== -1) {
            news.value[index] = _news;
            showEditForm.value = false;
        }
        toast.success('News updated successfully');
    } catch (error) {
        toast.error('Failed to update news');
    }
}
function closeForms() {
    showCreateForm.value = false;
    showEditForm.value = false;
}
function closeView() {
    viewingNews.value = null;
}

</script>


<template>
    <AuthLayout>
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-6">News</h1>
            <PrimaryBtn name="Add News" @click="handleAdd" />
        </div>

        <Create v-if="showCreateForm" @save="handleCreate" @cancel="closeForms" />

        <Edit v-if="showEditForm" :news="currentNews" @save="handleUpdate" @cancel="closeForms" />

        <Table :headers="['Title', 'Image', 'Created_At']" :items="news" :filterableColumns="[
            { key: 'title', label: 'Title' },
            { key: 'created_at', label: 'Created_At', type: 'date' },
        ]" @edit="handleEdit" @delete="handleDelete" @view="viewDetails" />

        <View v-if="viewingNews" :news="viewingNews" @close="closeView" />

        <ConfirmModal :show="showConfirmModal" :title="confirmModalConfig.title" :message="confirmModalConfig.message"
            :confirmText="confirmModalConfig.confirmText" :cancelText="confirmModalConfig.cancelText"
            @confirm="handleConfirm" @cancel="handleCancel" />
    </AuthLayout>
</template>
