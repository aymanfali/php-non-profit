<template>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-bg rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-auto">
            <div class="p-6">
                <slot/>
            </div>
        </div>
    </div>
</template>
