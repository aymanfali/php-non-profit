<script setup>
import { ref, watch } from 'vue';
import { useToast } from 'vue-toastification';
import axios from 'axios';
import CancelBtn from '@/components/Dashboard/Buttons/CancelBtn.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';

const props = defineProps({
    impact: {
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

const localImpact = ref({ ...props.impact });
const errorMsg = ref('');

watch(() => props.impact, (newImpact) => {
    localImpact.value = { ...newImpact };
});

async function handleSubmit() {
    errorMsg.value = '';
    if (!localImpact.value.title || !localImpact.value.title.trim()) {
        errorMsg.value = 'Title is required.';
        toast.error(errorMsg.value);
        return;
    }
    if (!localImpact.value.image || !localImpact.value.image.trim()) {
        errorMsg.value = 'Image URL is required.';
        toast.error(errorMsg.value);
        return;
    }
    if (!localImpact.value.content || !localImpact.value.content.trim()) {
        errorMsg.value = 'Content is required.';
        toast.error(errorMsg.value);
        return;
    }
    const apiBase = import.meta.env.VITE_API_BASE_URL;
    try {
        const res = await axios.post(`${apiBase}/dashboard/impacts/update/${localImpact.value.id}`, localImpact.value);
        if (res.data.success) {
            emit('save', { ...localImpact.value });
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
            <h2 class="text-xl font-semibold mb-4">Edit Impact</h2>

            <form @submit.prevent="handleSubmit">
                <div class="mb-4" v-if="localImpact">
                    <label class="block text-gray/70 mb-2" for="title">Title</label>
                    <input id="title" v-model="localImpact.title" type="text"
                        class="w-full px-3 py-2 bg-primary/20 outline-0 rounded" required />
                </div>

                <div class="mb-4" v-if="localImpact">
                    <label class="block text-gray/70 mb-2" for="image">Image URL</label>
                    <input id="image" v-model="localImpact.image" type="url"
                        class="w-full px-3 py-2 bg-primary/20 outline-0 rounded" required />
                    <div class="mt-2 flex items-center space-x-4">
                        <div>
                            <p class="text-sm">Current Image:</p>
                            <img v-if="props.impact && props.impact.image" :src="props.impact.image" class="h-20 w-20 object-cover rounded">
                        </div>
                        <div v-if="props.impact && localImpact.image !== props.impact.image">
                            <p class="text-sm">New Image:</p>
                            <img v-if="localImpact.image" :src="localImpact.image" class="h-20 w-20 object-cover rounded">
                        </div>
                    </div>
                </div>

                <div class="mb-4" v-if="localImpact">
                    <label class="block text-text-main mb-2" for="content">Content</label>
                    <textarea id="content" cols="5" v-model="localImpact.content"
                        class="w-full px-3 py-2 bg-primary/20 outline-0 rounded" required placeholder="Enter impact content" />
                </div>

                <div class="flex justify-end space-x-3">
                    <CancelBtn type="button" @click="handleCancel" name="Cancel" />
                    <PrimaryBtn type="submit" name="Update" />
                </div>
            </form>
        </div>
    </div>

</template>
