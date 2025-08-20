<script>
import CancelBtn from '@/components/Dashboard/Buttons/CancelBtn.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';

export default {
    components: {
        CancelBtn,
        PrimaryBtn
    },
    props: {
        news: {
            type: Object,
            required: true
        }
    },
    emits: ['save', 'cancel'],
    data() {
        return {
            localnews: { ...this.news }
        }
    },
    watch: {
        news(newnews) {
            this.localnews = { ...newnews };
        }
    },
    methods: {
        handleSubmit() {
            this.$emit('save', { ...this.localnews });
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
            <h2 class="text-xl font-semibold mb-4">Edit news</h2>

            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <label class="block text-gray/70 mb-2" for="title">Title</label>
                    <input id="title" v-model="localnews.title" type="text" class="w-full px-3 py-2 border rounded"
                        required />
                </div>

                <div class="mb-4">
                    <label class="block text-gray/70 mb-2" for="image">Image URL</label>
                    <input id="image" v-model="localnews.image" type="url" class="w-full px-3 py-2 border rounded"
                        required />
                    <div class="mt-2 flex items-center space-x-4">
                        <div>
                            <p class="text-sm text-gray/50">Current Image:</p>
                            <img :src="news.image" class="h-20 w-20 object-cover rounded">
                        </div>
                        <div v-if="localnews.image !== news.image">
                            <p class="text-sm text-gray/50">New Image:</p>
                            <img :src="localnews.image" class="h-20 w-20 object-cover rounded">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-text-main mb-2" for="content">Cotent</label>
                        <textarea id="content" cols="5" v-model="localnews.content"
                            class="w-full px-3 py-2 border rounded" required placeholder="Enter news content" />
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
