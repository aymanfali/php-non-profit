<script setup>
import { ref, onMounted } from 'vue';
import AuthLayout from '../AuthLayout.vue';
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import { useToast } from 'vue-toastification';
import axios from 'axios';

const toast = useToast();
const aboutUsData = ref({
    our_history: '',
    our_values: '',
    our_history_image: '',
    our_values_image: '',
});

const originalData = ref({
    our_history: '',
    our_values: '',
    our_history_image: '',
    our_values_image: '',
});

const errors = ref({}); // Reactive object to store validation errors
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

async function fetchData() {
    try {
        const res = await axios.get(`${apiBaseUrl}/dashboard/about_us/1`);
        aboutUsData.value = res.data;
        originalData.value = { ...res.data };
    } catch (err) {
        aboutUsData.value = {
            our_history: '',
            our_values: '',
            our_history_image: '',
            our_values_image: '',
        };
        toast.error('Failed to fetch data');
    }
}

onMounted(fetchData);

function validateForm() {
    let isValid = true;
    errors.value = {}; // Reset errors at the start of validation

    if (!aboutUsData.value.our_history) {
        errors.value.our_history = 'History is required.';
        isValid = false;
    }

    if (!aboutUsData.value.our_values) {
        errors.value.our_values = 'Values are required.';
        isValid = false;
    }

    if (!aboutUsData.value.our_history_image) {
        errors.value.our_history_image = 'History image URL is required.';
        isValid = false;
    }

    if (!aboutUsData.value.our_values_image) {
        errors.value.our_values_image = 'Values image URL is required.';
        isValid = false;
    }

    return isValid;
}

async function handleSubmit() {
    if (!validateForm()) {
        toast.error('Please fix the validation errors.');
        return; // Stop submission if validation fails
    }

    try {
        const res = await axios.post(`${apiBaseUrl}/dashboard/about_us/update/${aboutUsData.value.id}`, aboutUsData.value);

        if (res.data.success) {
            toast.success('About Us data updated successfully!');
            originalData.value = { ...aboutUsData.value };
        } else {
            toast.error('Update failed');
        }
    } catch (err) {
        toast.error('Error updating About Us info');
    }
}
</script>

<template>
    <AuthLayout>
        <div class="mx-auto p-3">
            <h1 class="text-3xl font-bold mb-8 text-center">About</h1>
            <form @submit.prevent="handleSubmit" class="space-y-6">
                <div>
                    <label for="history" class="block font-bold mb-2">
                        History
                    </label>
                    <div class="mb-4">
                        <input id="ourHistoryImage" placeholder="history image url"
                            v-model="aboutUsData.our_history_image" type="url"
                            class="w-full px-3 py-2 focus:outline-1 outline-primary bg-primary/20 outline-0 rounded"
                             />
                        <p v-if="errors.our_history_image" class="text-red-500 text-sm mt-1">{{ errors.our_history_image
                            }}</p>
                        <div class="mt-2 flex justify-center items-center space-x-4">
                            <div>
                                <p class="text-sm">Current Image:</p>
                                <img v-if="originalData && originalData.our_history_image"
                                    :src="originalData.our_history_image" class="h-65 w-65 border object-cover rounded">
                            </div>
                            <div
                                v-if="aboutUsData.our_history_image && aboutUsData.our_history_image !== originalData.our_history_image">
                                <p class="text-sm">New Image:</p>
                                <img :src="aboutUsData.our_history_image" class="h-65 w-65 border object-cover rounded">
                            </div>
                        </div>
                    </div>
                    <textarea id="history" v-model="aboutUsData.our_history" name="history" rows="6"
                        class="w-full px-3 py-2 focus:outline-1 outline-primary bg-primary/20 outline-0 rounded-md shadow-sm"
                        placeholder="Enter your history here..." ></textarea>
                    <p v-if="errors.our_history" class="text-red-500 text-sm mt-1">{{ errors.our_history }}</p>
                </div>

                <div>
                    <label for="values" class="block font-bold mb-2">
                        Values
                    </label>
                    <div class="mb-4">
                        <input id="ourValuesImage" placeholder="values image url" v-model="aboutUsData.our_values_image"
                            type="url"
                            class="w-full px-3 py-2 focus:outline-1 outline-primary bg-primary/20 outline-0 rounded"
                             />
                        <p v-if="errors.our_values_image" class="text-red-500 text-sm mt-1">{{ errors.our_values_image
                            }}</p>
                        <div class="mt-2 flex justify-center items-center space-x-4">
                            <div>
                                <p class="text-sm">Current Image:</p>
                                <img v-if="originalData && originalData.our_values_image"
                                    :src="originalData.our_values_image" class="h-65 w-65 border object-cover rounded">
                            </div>
                            <div
                                v-if="aboutUsData.our_values_image && aboutUsData.our_values_image !== originalData.our_values_image">
                                <p class="text-sm">New Image:</p>
                                <img :src="aboutUsData.our_values_image" class="h-65 w-65 border object-cover rounded">
                            </div>
                        </div>
                    </div>
                    <textarea id="values" v-model="aboutUsData.our_values" name="values" rows="6"
                        class="w-full px-3 py-2 focus:outline-1 outline-primary rounded-md shadow-sm bg-primary/20 outline-0"
                        placeholder="Enter your values here..." ></textarea>
                    <p v-if="errors.our_values" class="text-red-500 text-sm mt-1">{{ errors.our_values }}</p>
                </div>

                <div class="flex justify-end">
                    <PrimaryBtn type="submit" name="Save Data" />
                </div>
            </form>
        </div>
    </AuthLayout>
</template>
