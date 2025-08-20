<script setup>
import CancelBtn from './Buttons/CancelBtn.vue';
import DangerBtn from './Buttons/DangerBtn.vue';

defineProps({
    show: { type: Boolean, required: true },
    title: { type: String, required: true },
    message: { type: String, required: true },
    confirmText: { type: String, default: 'Confirm' },
    cancelText: { type: String, default: 'Cancel' },
});

const emit = defineEmits(['confirm', 'cancel']);
</script>

<template>
    <div v-if="show" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-bg rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-bold mb-2">{{ title }}</h3>
            <p class="text-text-main mb-6">{{ message }}</p>

            <div class="flex justify-end space-x-3">
                <CancelBtn @click="$emit('cancel')" :name="cancelText"/>
                <DangerBtn @click="$emit('confirm')">Delete</DangerBtn>
            </div>
        </div>
    </div>
</template>
