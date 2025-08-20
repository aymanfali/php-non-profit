<script>
import Table from '@/components/Dashboard/Table.vue';
import AuthLayout from '../AuthLayout.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import Create from './Create.vue';
import Edit from './Edit.vue';
import View from './View.vue';
import { useToast } from 'vue-toastification';
import { defineAsyncComponent } from 'vue';

export default {
    setup() {
        const toast = useToast();
        return { toast }
    },
    components: {
        Table,
        AuthLayout,
        PrimaryBtn,
        Create,
        Edit,
        View,
        ConfirmModal: defineAsyncComponent(() => import('@/components/Dashboard/ConfirmModal.vue'))
    },
    data() {
        return {
            news: [],
            showCreateForm: false,
            showEditForm: false,
            currentNews: {
                title: '',
                image: '',
                date: ''
            },
            viewingNews: null,

            showConfirmModal: false,
            confirmModalConfig: {
                title: '',
                message: '',
                confirmText: 'Confirm',
                cancelText: 'Cancel'
            },
            NewsToDelete: null
        }
    },
    created() {
        this.loadNews();
    },
    methods: {
        loadNews() {
            const savedNews = localStorage.getItem('news');
            if (savedNews) {
                this.news = JSON.parse(savedNews);
            }
        },
        saveNews() {
            localStorage.setItem('news', JSON.stringify(this.news));
        },
        handleAdd() {
            this.showCreateForm = true;
            this.showEditForm = false;
        },
        handleEdit(news) {
            this.currentNews = { ...news };
            this.showEditForm = true;
            this.showCreateForm = false;
        },
        handleDelete(news) {
            this.NewsToDelete = news
            this.showConfirmModal = true
            this.confirmModalConfig = {
                title: 'Delete News',
                message: 'Are you sure you want to delete this News?',
                confirmText: 'Delete',
                cancelText: 'Cancel'
            }
        },
        handleConfirm() {
            try {
                this.news = this.news.filter(i => i.title !== this.NewsToDelete.title);
                this.saveNews();
                this.toast.success('News deleted successfully');
                this.showConfirmModal = false;
                this.NewsToDelete = null;
            } catch (error) {
                this.toast.error('Failed to delete News');
            }
        },
        handleCancel() {
            this.showConfirmModal = false;
            this.NewsToDelete = null;
        },
        viewDetails(news) {
            this.viewingNews = { ...news };
        },
        handleCreate(news) {
            try {
                this.news.unshift(news);
                this.saveNews();
                this.showCreateForm = false;
                this.toast.success('News created successfully');
            } catch (error) {
                this.toast.error('Failed to create news');
            }
        },
        handleUpdate(news) {
            try {
                const index = this.news.findIndex(i => i.title === this.currentNews.title);
                if (index !== -1) {
                    this.news[index] = news;
                }
                this.saveNews();
                this.showEditForm = false;
                this.toast.success('News updated successfully');
            } catch (error) {
                this.toast.error('Failed to update news');
            }
        },
        closeForms() {
            this.showCreateForm = false;
            this.showEditForm = false;
        },
        closeView() {
            this.viewingNews = null;
        },
        showConfirmDialog(message) {
            return new Promise((resolve) => {
                const confirmed = window.confirm(message);
                resolve(confirmed);
            });
        }
    }
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

        <Table :headers="['Title', 'Image', 'Date']" :items="news" :filterableColumns="[
            { key: 'title', label: 'Title' },
            { key: 'date', label: 'Date', type: 'date' },
        ]" @edit="handleEdit" @delete="handleDelete" @view="viewDetails" />

        <View v-if="viewingNews" :news="viewingNews" @close="closeView" />

        <ConfirmModal :show="showConfirmModal" :title="confirmModalConfig.title" :message="confirmModalConfig.message"
            :confirmText="confirmModalConfig.confirmText" :cancelText="confirmModalConfig.cancelText"
            @confirm="handleConfirm" @cancel="handleCancel" />
    </AuthLayout>
</template>
