<script setup>
import axios from 'axios';
import { computed, ref } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();
const formData = ref({
    name: '',
    email: '',
    subject: '',
    message: ''
});
const errors = ref({
    name: '',
    email: '',
    subject: '',
    message: ''
});

const isFormValid = computed(() => {
    return Object.values(errors.value).every(error => error === '');
});

function validateName(value) {
    if (value.length < 3) {
        return "Your name must contain at least 3 characters";
    }
    if (!/^[a-zA-Z ]+$/.test(value)) {
        return "Please enter a valid name (letters and spaces only)";
    }
    return "";
}
function validateEmail(value) {
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
        return "Please enter a valid email address";
    }
    return "";
}
function validateField(value, fieldName) {
    if (value === "") {
        return `Please enter your ${fieldName}`;
    }
    if (value.length < 10 && fieldName !== 'name') {
        return `${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)} must be at least 10 characters`;
    }
    return "";
}
function handleInput(field) {
    if (field === 'name') {
        errors.value.name = validateName(formData.value.name);
    } else if (field === 'email') {
        errors.value.email = validateEmail(formData.value.email);
    } else {
        errors.value[field] = validateField(formData.value[field], field);
    }
}
function submitForm() {
    errors.value.name = validateName(formData.value.name);
    errors.value.email = validateEmail(formData.value.email);
    errors.value.subject = validateField(formData.value.subject, 'subject');
    errors.value.message = validateField(formData.value.message, 'message');

    if (!isFormValid.value) {
        toast.error("Please fix the errors in the form");
        return;
    }
    try {
        const apiBase = import.meta.env.VITE_API_BASE_URL;
        const data = {
            name: formData.value.name,
            email: formData.value.email,
            subject: formData.value.subject,
            message: formData.value.message
        };
        axios.post(`${apiBase}/contacts/`, data)
            .then(res => {
                if (res.data.success) {
                    toast.success("Your message was sent successfully!");
                    formData.value = {
                        name: '',
                        email: '',
                        subject: '',
                        message: ''
                    };
                    errors.value = {
                        name: '',
                        email: '',
                        subject: '',
                        message: ''
                    };
                } else {
                    toast.error(res.data.message || "Failed to send message");
                }
            })
            .catch(() => {
                toast.error("An error occurred while processing your request");
            });
    } catch (error) {
        toast.error("An error occurred while processing your request");
    }
}

</script>

<template>
    <form class="form relative" @submit.prevent="submitForm">
        <div class="field relative block">
            <img class="icon w-6 h-6 absolute left-[-25px] top-[15px]" src="/icons/user-solid.svg" alt="">
            <input
                class="input p-[10px] outline-0 rounded-[20px] shadow-2xl border-0 m-[5px] w-full bg-bg text-text-main"
                type="text" v-model="formData.name" @input="handleInput('name')" placeholder="Your Name" required>
        </div>
        <p class="name-error"
            :class="errors.name ? 'block p-[5px_10px] text-start m-[0_0_10px_10px] text-danger text-sm' : 'hidden'">
            {{ errors.name }}
        </p>

        <div class="field relative block">
            <img class="icon w-6 h-6 absolute left-[-25px] top-[15px]" src="/icons/envelope-solid.svg" alt="">
            <input
                class="input p-[10px] outline-0 rounded-[20px] shadow-2xl border-0 m-[5px] w-full bg-bg text-text-main"
                type="email" v-model="formData.email" @input="handleInput('email')" placeholder="Your email" required>
        </div>
        <p class="email-error"
            :class="errors.email ? 'block p-[5px_10px] text-start m-[0_0_10px_10px] text-danger text-sm' : 'hidden'">
            {{ errors.email }}
        </p>

        <div class="field relative block">
            <img class="icon w-6 h-6 absolute left-[-25px] top-[15px]" src="/icons/comment-regular.svg" alt="">
            <input
                class="input p-[10px] outline-0 rounded-[20px] shadow-2xl border-0 m-[5px] w-full bg-bg text-text-main"
                type="text" v-model="formData.subject" @input="handleInput('subject')" placeholder="Your subject"
                required>
        </div>
        <p class="subject-error"
            :class="errors.subject ? 'block p-[5px_10px] text-start m-[0_0_10px_10px] text-danger text-sm' : 'hidden'">
            {{ errors.subject }}
        </p>

        <div class="field relative block">
            <img class="icon w-6 h-6 absolute left-[-25px] top-[15px]" src="/icons/message-solid.svg" alt="">
            <textarea rows="5"
                class="input p-[10px] outline-0 rounded-[20px] shadow-2xl border-0 m-[5px] w-full bg-bg text-text-main resize-none"
                v-model="formData.message" @input="handleInput('message')" placeholder="Your message"
                required></textarea>
        </div>
        <p class="message-error"
            :class="errors.message ? 'block p-[5px_10px] text-start m-[0_0_10px_10px] text-danger text-sm' : 'hidden'">
            {{ errors.message }}
        </p>

        <button type="submit"
            class="submit p-[10px_20px] m-[10px] cursor-pointer border border-primary outline-0 bg-text-sec text-primary rounded-[20px] hover:bg-primary hover:text-text-sec hover:outline hover:outline-text-main disabled:cursor-not-allowed disabled:bg-gray disabled:text-danger"
            :disabled="!isFormValid">
            Send
        </button>
    </form>
</template>
