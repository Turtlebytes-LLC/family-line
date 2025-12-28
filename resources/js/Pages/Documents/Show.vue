<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    document: Object,
});

const confirmingDeletion = ref(false);

const deleteDocument = () => {
    router.delete(route('documents.destroy', props.document.id));
};
</script>

<template>
    <AppLayout title="View Document">
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <Link :href="route('documents.index')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </Link>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ document.title }}
                    </h2>
                </div>
                <div class="flex space-x-2">
                    <Link
                        :href="route('documents.edit', document.id)"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Edit
                    </Link>
                    <DangerButton v-if="!confirmingDeletion" @click="confirmingDeletion = true">
                        Delete
                    </DangerButton>
                    <template v-else>
                        <SecondaryButton @click="confirmingDeletion = false">
                            Cancel
                        </SecondaryButton>
                        <DangerButton @click="deleteDocument">
                            Confirm Delete
                        </DangerButton>
                    </template>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                By {{ document.user.name }} &middot;
                                Created {{ new Date(document.created_at).toLocaleDateString() }}
                                <span v-if="document.updated_at !== document.created_at">
                                    &middot; Updated {{ new Date(document.updated_at).toLocaleDateString() }}
                                </span>
                            </div>
                            <span
                                v-if="document.is_published"
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100"
                            >
                                Published
                            </span>
                            <span
                                v-else
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300"
                            >
                                Draft
                            </span>
                        </div>

                        <div class="prose dark:prose-invert max-w-none">
                            <div v-if="document.content" class="whitespace-pre-wrap text-gray-700 dark:text-gray-300">{{ document.content }}</div>
                            <p v-else class="text-gray-400 dark:text-gray-500 italic">No content yet.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
