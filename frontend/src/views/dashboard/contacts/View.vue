<script>
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue'
import DetailsModal from '@/components/Dashboard/DetailsModal.vue'

export default {
    components: {
        PrimaryBtn
    },
    props: {
        contact: {
            type: Object,
            required: true,
            validator: (value) => {
                return ['name', 'email', 'subject', 'message'].every(prop => prop in value)
            }
        }
    },
    emits: ['close'],
    methods: {
        formatDate(dateString) {
            if (!dateString) return 'No date available'
            try {
                return new Date(dateString).toLocaleString()
            } catch {
                return dateString
            }
        },
        handleKeydown(e) {
            if (e.key === 'Escape') {
                this.$emit('close')
            }
        }
    },
    mounted() {
        document.addEventListener('keydown', this.handleKeydown)
    },
    beforeUnmount() {
        document.removeEventListener('keydown', this.handleKeydown)
    }
}
</script>

<template>
    <DetailsModal>
        <div class="flex justify-between items-start mb-6">
            <h2 class="text-2xl font-bold">
                Subject: {{ contact.subject }}
            </h2>
            <button @click="$emit('close')" class="text-gray hover:text-gray/70 focus:outline-none"
                aria-label="Close modal">
                <span class="text-2xl">&times;</span>
            </button>
        </div>

        <div class="space-y-4">
            <!-- Sender Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-medium">From</h3>
                    <p class="mt-1 text-sm">{{ contact.name }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium">Email</h3>
                    <p class="mt-1 text-sm break-all">
                        <a :href="`mailto:${contact.email}`" class=" hover:underline">
                            {{ contact.email }}
                        </a>
                    </p>
                </div>
            </div>

            <!-- Date Information -->
            <div>
                <h3 class="text-sm font-medium ">Received</h3>
                <p class="mt-1 text-sm ">
                    {{ formatDate(contact.date) }}
                </p>
            </div>

            <!-- Message Content -->
            <div>
                <h3 class="text-sm font-medium">Message</h3>
                <div class="mt-1 p-3 bg-bg/50 rounded-md">
                    <p class="text-sm whitespace-pre-wrap">{{ contact.message }}</p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <PrimaryBtn @click="$emit('close')" name="Close" />
        </div>
    </DetailsModal>
</template>

<style scoped>
/* Smooth transitions for modal */
.fixed {
    transition: opacity 0.3s ease;
}

/* Better focus styles for accessibility */
button:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px #3b82f6;
}
</style>
