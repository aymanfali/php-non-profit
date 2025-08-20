<template>
    <div class="bg-bg p-3 m-3 border-l-2 border-danger">
        <div class="border border-danger rounded-lg p-4 md:flex justify-between items-center">
            <div class="">
                <h3 class="font-medium text-danger/70 mb-2">{{ title }}</h3>
                <p class="text-text-main mb-4">
                    {{ description }}
                </p>
            </div>
            <DangerBtn @click="handleReset">
                {{ buttonText }}
            </DangerBtn>
        </div>
    </div>
</template>

<script>
import DangerBtn from './Buttons/DangerBtn.vue';

export default {
    components: {
        DangerBtn
    },
    props: {
        title: {
            type: String,
            default: "Reset Site Data"
        },
        description: {
            type: String,
            default: "This will clear all locally stored data including impacts, news, and contact submissions."
        },
        buttonText: {
            type: String,
            default: "Reset Data"
        }
    },
    methods: {
        handleReset() {
            this.$emit('reset');
        }
    }
}
</script>
