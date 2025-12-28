<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    documents: Object,
});
</script>

<template>
    <AppLayout title="Documents">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Documents
                </h2>
                <Link
                    :href="route('documents.create')"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                >
                    New Document
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="documents.data.length === 0" class="text-gray-500 dark:text-gray-400 text-center py-8">
                            No documents yet. Create your first document!
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="document in documents.data"
                                :key="document.id"
                                class="border dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                            >
                                <Link :href="route('documents.show', document.id)" class="block">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                {{ document.title }}
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                By {{ document.user.name }} &middot;
                                                {{ new Date(document.created_at).toLocaleDateString() }}
                                            </p>
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
                                </Link>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div v-if="documents.links.length > 3" class="mt-6 flex justify-center">
                            <nav class="flex space-x-2">
                                <template v-for="link in documents.links" :key="link.label">
                                    <Link
                                        v-if="link.url"
                                        :href="link.url"
                                        class="px-3 py-2 text-sm rounded-md"
                                        :class="{
                                            'bg-gray-800 text-white dark:bg-gray-200 dark:text-gray-800': link.active,
                                            'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700': !link.active
                                        }"
                                        v-html="link.label"
                                    />
                                    <span
                                        v-else
                                        class="px-3 py-2 text-sm text-gray-400 dark:text-gray-600"
                                        v-html="link.label"
                                    />
                                </template>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
