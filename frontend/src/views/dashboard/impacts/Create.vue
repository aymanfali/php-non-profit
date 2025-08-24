<script>
import CancelBtn from '@/components/Dashboard/Buttons/CancelBtn.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
    components: {
        PrimaryBtn,
        CancelBtn
    },
    emits: ['save', 'cancel'],
    setup() {
        const toast = useToast();
        return { toast };
    },
    data() {
        return {
            impact: {
                id: '',
                title: '',
                date: new Date().toISOString().split('T')[0],
                image: '',
                content: ''
            },
            errors: {}
        }
    },
    methods: {
        isValidUrl(url) {
            try {
                new URL(url);
                return true;
            } catch (_) {
                return false;
            }
        },
        validateForm() {
            this.errors = {};
            let isValid = true;
            if (!this.impact.title.trim()) {
                this.errors.title = 'Title is required';
                isValid = false;
            }
            if (!this.impact.image.trim()) {
                this.errors.image = 'Image URL is required';
                isValid = false;
            } else if (!this.isValidUrl(this.impact.image)) {
                this.errors.image = 'Image URL is not valid';
                isValid = false;
            }
            if (!this.impact.content.trim()) {
                this.errors.content = 'Content is required';
                isValid = false;
            }
            if (!isValid) {
                this.toast.error('Please fix the form errors');
            }
            return isValid;
        },
        async handleSubmit() {
            if (this.validateForm()) {
                try {
                    const apiBase = import.meta.env.VITE_API_BASE_URL;
                    const data = {
                        title: this.impact.title,
                        image: this.impact.image,
                        content: this.impact.content,
                    };
                    const res = await axios.post(`${apiBase}/dashboard/impacts`, data);
                    if (res.data.success) {
                        this.toast.success('Impact added successfully');
                        this.$emit('save', res.data.impact || { ...this.impact });
                    } else {
                        this.toast.error(res.data.message || 'Failed to add impact');
                    }
                } catch (error) {
                    this.toast.error('Error adding impact');
                }
            }
        },
        handleCancel() {
            this.$emit('cancel');
        }
    }
}
</script>

<template>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-bg p-6 rounded-lg shadow-md mb-6 w-full md:w-1/2">
            <h2 class="text-xl font-semibold mb-4">Add New Impact</h2>

            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="title">Title</label>
                    <input id="title" v-model="impact.title" type="text"
                        class="w-full px-3 py-2 bg-primary/20 outline-0 rounded"
                        :class="{ 'border-red-500': errors.title }" placeholder="Enter impact title" />
                    <p v-if="errors.title" class="text-red-500 text-sm mt-1">{{ errors.title }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="image">Image URL</label>
                    <input id="image" v-model="impact.image" type="url"
                        class="w-full px-3 py-2 bg-primary/20 outline-0 rounded"
                        :class="{ 'border-red-500': errors.image }" placeholder="https://example.com/image.jpg" />
                    <p v-if="errors.image" class="text-red-500 text-sm mt-1">{{ errors.image }}</p>
                    <div v-if="impact.image" class="mt-2">
                        <img :src="impact.image" class="h-20 w-20 object-cover rounded">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="content">Content</label>
                    <textarea id="content" cols="5" v-model="impact.content"
                        class="w-full px-3 py-2 bg-primary/20 outline-0 rounded"
                        :class="{ 'border-red-500': errors.content }" placeholder="Enter impact content" />
                    <p v-if="errors.content" class="text-red-500 text-sm mt-1">{{ errors.content }}</p>
                </div>

                <div class="flex justify-end space-x-3">
                    <CancelBtn type="button" @click="handleCancel" name="Cancel" />
                    <PrimaryBtn type="submit" name="Add" />
                </div>
            </form>
        </div>
    </div>
</template>
