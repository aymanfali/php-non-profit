<script setup>
import { ref, onMounted } from 'vue'
import AuthLayout from '../AuthLayout.vue'
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue'
import { useToast } from 'vue-toastification';

const toast = useToast();

const formData = ref({
    history: '',
    values: ''
})

const handleSubmit = (event) => {
    event.preventDefault()

    // Save to localStorage
    localStorage.setItem('aboutFormData', JSON.stringify(formData.value))

    toast.success('About data updated successfully');
}

// Load saved data when component mounts
const loadSavedData = () => {
    const savedData = localStorage.getItem('aboutFormData')
    if (savedData) {
        formData.value = JSON.parse(savedData)
    }
}

// Call the load function when component mounts
onMounted(() => {
    loadSavedData()
})
</script>

<template>
    <AuthLayout>
        <div class=" mx-auto p-3">
            <h1 class="text-3xl font-bold mb-8 text-center">About</h1>

            <form @submit="handleSubmit" class="space-y-6">
                <div>
                    <label for="history" class="block font-bold  mb-2">
                        History
                    </label>
                    <textarea id="history" v-model="formData.history" name="history" rows="6"
                        class="w-full px-3 py-2 border border-gray rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                        placeholder="Enter your history here..." required></textarea>
                </div>

                <div>
                    <label for="values" class="block font-bold mb-2">
                        Values
                    </label>
                    <textarea id="values" v-model="formData.values" name="values" rows="6"
                        class="w-full px-3 py-2 border border-gray rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                        placeholder="Enter your values here..." required></textarea>
                </div>

                <div class="flex justify-end">
                    <PrimaryBtn type="submit" name="Save Data" />
                </div>
            </form>
        </div>
    </AuthLayout>
</template>
