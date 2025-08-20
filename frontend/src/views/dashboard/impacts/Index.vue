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
            impacts: [],
            showCreateForm: false,
            showEditForm: false,
            currentImpact: {
                title: '',
                image: '',
                date: ''
            },
            viewingImpact: null,
            showConfirmModal: false,
            confirmModalConfig: {
                title: '',
                message: '',
                confirmText: 'Confirm',
                cancelText: 'Cancel'
            },
            impactToDelete: null
        }
    },
    created() {
        this.loadImpacts();
    },
    methods: {
        loadImpacts() {
            const savedImpacts = localStorage.getItem('impacts');
            if (savedImpacts) {
                this.impacts = JSON.parse(savedImpacts);
            }
        },
        saveImpacts() {
            localStorage.setItem('impacts', JSON.stringify(this.impacts));
        },
        handleAdd() {
            this.showCreateForm = true;
            this.showEditForm = false;
        },
        handleEdit(impact) {
            this.currentImpact = { ...impact };
            this.showEditForm = true;
            this.showCreateForm = false;
        },
        handleDelete(impact) {
            this.impactToDelete = impact;
            this.showConfirmModal = true;
            this.confirmModalConfig = {
                title: 'Delete Impact',
                message: 'Are you sure you want to delete this impact?',
                confirmText: 'Delete',
                cancelText: 'Cancel'
            };
        },
        handleConfirm() {
            try {
                this.impacts = this.impacts.filter(i => i.title !== this.impactToDelete.title);
                this.saveImpacts();
                this.toast.success('Impact deleted successfully');
                this.showConfirmModal = false;
                this.impactToDelete = null;
            } catch (error) {
                this.toast.error('Failed to delete impact');
            }
        },
        handleCancel() {
            this.showConfirmModal = false;
            this.impactToDelete = null;
        },
        viewDetails(impact) {
            this.viewingImpact = { ...impact };
        },
        handleCreate(impact) {
            try {
                this.impacts.unshift(impact);
                this.saveImpacts();
                this.showCreateForm = false;
                this.toast.success('Impact created successfully');
            } catch (error) {
                this.toast.error('Failed to create impact');
            }
        },
        handleUpdate(impact) {
            try {
                const index = this.impacts.findIndex(i => i.title === this.currentImpact.title);
                if (index !== -1) {
                    this.impacts[index] = impact;
                }
                this.saveImpacts();
                this.showEditForm = false;
                this.toast.success('Impact updated successfully');
            } catch (error) {
                this.toast.error('Failed to update impact');
            }
        },
        closeForms() {
            this.showCreateForm = false;
            this.showEditForm = false;
        },
        closeView() {
            this.viewingImpact = null;
        }
    }
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
        <Table :headers="['Title', 'Image', 'Date']" :items="impacts" @edit="handleEdit" @delete="handleDelete"
            @view="viewDetails" :filterableColumns="[
                { key: 'title', label: 'Title' },
                { key: 'date', label: 'Date', type: 'date' },
            ]" />

        <View v-if="viewingImpact" :impact="viewingImpact" @close="closeView" />

        <ConfirmModal :show="showConfirmModal" :title="confirmModalConfig.title" :message="confirmModalConfig.message"
            :confirmText="confirmModalConfig.confirmText" :cancelText="confirmModalConfig.cancelText"
            @confirm="handleConfirm" @cancel="handleCancel" />
    </AuthLayout>
</template>
