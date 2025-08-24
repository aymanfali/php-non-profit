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
            news: {
                id: '',
                date: new Date().toISOString().split('T')[0],
                title: '',
                image: '',
                content: ''
            },
            errors: {},
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
            if (!this.news.title.trim()) {
                this.errors.title = 'Title is required';
                isValid = false;
            }
            if (!this.news.image.trim()) {
                this.errors.image = 'Image URL is required';
                isValid = false;
            } else if (!this.isValidUrl(this.news.image)) {
                this.errors.image = 'Image URL is not valid';
                isValid = false;
            }
            if (!this.news.content.trim()) {
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
                        title: this.news.title,
                        image: this.news.image,
                        content: this.news.content,
                    };
                    const res = await axios.post(`${apiBase}/dashboard/news`, data);
                    if (res.data.success) {
                        this.toast.success('News added successfully');
                        this.$emit('save', res.data.news || { ...this.news });
                    } else {
                        this.toast.error(res.data.message || 'Failed to add news');
                    }
                } catch (error) {
                    this.toast.error('Error adding news');
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
            <h2 class="text-xl font-semibold mb-4">Add New news</h2>

            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="title">Title</label>
                    <input id="title" v-model="news.title" type="text"
                        class="w-full px-3 py-2 bg-primary/20 outline-0 rounded" placeholder="Enter news title" />

                    <p v-if="errors.title" class="text-red-500 text-sm mt-1">{{ errors.title }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-text-main mb-2" for="image">Image URL</label>
                    <input id="image" v-model="news.image" type="url"
                        class="w-full px-3 py-2 bg-primary/20 outline-0 rounded"
                        placeholder="https://example.com/image.jpg" />
                    <p v-if="errors.image" class="text-red-500 text-sm mt-1">{{ errors.image }}</p>
                    <div v-if="news.image" class="mt-2">
                        <img :src="news.image" class="h-20 w-20 object-cover rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-text-main mb-2" for="content">Cotent</label>
                        <textarea id="content" cols="5" v-model="news.content"
                            class="w-full px-3 py-2 bg-primary/20 outline-0 rounded" placeholder="Enter news content" />
                        <p v-if="errors.content" class="text-red-500 text-sm mt-1">{{ errors.content }}</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <CancelBtn type="button" @click="handleCancel" name="Cancel" />
                    <PrimaryBtn type="submit" name="Add" />
                </div>
            </form>
        </div>
    </div>
</template>
