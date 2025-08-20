<script>
import Table from '@/components/Dashboard/Table.vue';
import AuthLayout from '../AuthLayout.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
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
        View,
        ConfirmModal: defineAsyncComponent(() => import('@/components/Dashboard/ConfirmModal.vue'))
    },
    data() {
        return {
            contacts: [],
            currentContact: {
                name: '',
                email: '',
                subject: '',
                message: '',
                date: ''
            },
            viewingContact: null,
            showConfirmModal: false,
            confirmModalConfig: {
                title: '',
                message: '',
                confirmText: 'Confirm',
                cancelText: 'Cancel'
            },
            contactToDelete: null
        }
    },
    created() {
        this.loadContacts();
    },
    methods: {
        generateId() {
            return Date.now().toString(36) + Math.random().toString(36).substr(2);
        },
        loadContacts() {
            const savedContacts = localStorage.getItem('contactFormSubmissions');
            if (savedContacts) {
                this.contacts = JSON.parse(savedContacts);
                this.contacts.forEach(contact => {
                    if (!contact.id) {
                        contact.id = this.generateId()
                    }
                })
                this.saveContacts();
            }
        },
        saveContacts() {
            localStorage.setItem('contactFormSubmissions', JSON.stringify(this.contacts));
        },
        handleDelete(contact) {
            this.contactToDelete = contact;
            this.showConfirmModal = true;
            this.confirmModalConfig = {
                title: 'Delete contact',
                message: 'Are you sure you want to delete this contact?',
                confirmText: 'Delete',
                cancelText: 'Cancel'
            };
        },
        handleConfirm() {
            try {
                this.contacts = this.contacts.filter(c => c.id !== this.contactToDelete.id);
                this.saveContacts();
                this.toast.success('Contact deleted successfully');

                this.showConfirmModal = false;
                this.contactToDelete = null;
            } catch (error) {
                this.toast.error('Failed to delete contact');
            }
        },

        handleCancel() {
            this.showConfirmModal = false;
            this.contactToDelete = null;
        },
        viewDetails(contact) {
            this.viewingContact = { ...contact };
        },
        closeView() {
            this.viewingContact = null;
        }
    }
}
</script>

<template>
    <AuthLayout>
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-6">Contact Submissions</h1>
        </div>

        <Table :headers="['Name', 'Email', 'Subject', 'Date']" :items="contacts" :allow-edit="false"
            @delete="handleDelete" @view="viewDetails" :filterableColumns="[
                { key: 'name', label: 'Name' },
                { key: 'email', label: 'Email' },
                { key: 'subject', label: 'Subject' },
                { key: 'date', label: 'Date', type: 'date' },

            ]" />

        <View v-if="viewingContact" :contact="viewingContact" @close="closeView" />

        <ConfirmModal :show="showConfirmModal" :title="confirmModalConfig.title" :message="confirmModalConfig.message"
            :confirmText="confirmModalConfig.confirmText" :cancelText="confirmModalConfig.cancelText"
            @confirm="handleConfirm" @cancel="handleCancel" />
    </AuthLayout>
</template>
