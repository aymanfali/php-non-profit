<script setup>
import { ref, watch } from 'vue';
import { useToast } from 'vue-toastification';
import axios from 'axios';
import CancelBtn from '@/components/Dashboard/Buttons/CancelBtn.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';

const props = defineProps({
    news: {
        type: Object,
        required: true,
        default: () => ({
            title: '',
            image: '',
            content: '',
            id: ''
        })
    }
});
const emit = defineEmits(['save', 'cancel']);
const toast = useToast();

const localNews = ref({ ...props.news });
const errorMsg = ref('');

watch(() => props.news, (newNews) => {
    localNews.value = { ...newNews };
});

async function handleSubmit() {
    errorMsg.value = '';
    if (!localNews.value.title || !localNews.value.title.trim()) {
        errorMsg.value = 'Title is required.';
        toast.error(errorMsg.value);
        return;
    }
    if (!localNews.value.image || !localNews.value.image.trim()) {
        errorMsg.value = 'Image URL is required.';
        toast.error(errorMsg.value);
        return;
    }
    if (!localNews.value.content || !localNews.value.content.trim()) {
        errorMsg.value = 'Content is required.';
        toast.error(errorMsg.value);
        return;
    }
    const apiBase = import.meta.env.VITE_API_BASE_URL;
    try {
        const res = await axios.post(`${apiBase}/dashboard/news/update/${localNews.value.id}`, localNews.value);
        if (res.data.success) {
            emit('save', { ...localNews.value });
        } else {
            toast.error('Update failed');
        }
    } catch (err) {
        toast.error('Error updating impact');
    }
}

function handleCancel() {
    emit('cancel');
}

</script>


<template>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-bg p-6 rounded-lg shadow-md mb-6 w-full md:w-1/2">
            <h2 class="text-xl font-semibold mb-4">Edit news</h2>

            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <label class="block text-gray/70 mb-2" for="title">Title</label>
                    <input id="title" v-model="localNews.title" type="text" class="w-full px-3 py-2 bg-primary/20 outline-0 rounded"
                        required />
                </div>

                <div class="mb-4">
                    <label class="block text-gray/70 mb-2" for="image">Image URL</label>
                    <input id="image" v-model="localNews.image" type="url" class="w-full px-3 py-2 bg-primary/20 outline-0 rounded"
                        required />
                    <div class="mt-2 flex items-center space-x-4">
                        <div>
                            <p class="text-sm text-gray/50">Current Image:</p>
                            <img :src="news.image" class="h-20 w-20 object-cover rounded">
                        </div>
                        <div v-if="localNews.image !== news.image">
                            <p class="text-sm text-gray/50">New Image:</p>
                            <img :src="localNews.image" class="h-20 w-20 object-cover rounded">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-text-main mb-2" for="content">Cotent</label>
                        <textarea id="content" cols="5" v-model="localNews.content"
                            class="w-full px-3 py-2 bg-primary/20 outline-0 rounded" required placeholder="Enter news content" />
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <CancelBtn type="button" @click="handleCancel" name="Cancel"/>
                    <PrimaryBtn type="submit" name="Update"/>
                </div>
            </form>
        </div>
    </div>

</template>
