<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    entries: Object,
    eventTypes: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const showFilters = ref(false);
const localFilters = ref({
    event_type: props.filters.event_type || '',
    date_from: props.filters.date_from || '',
    date_to: props.filters.date_to || '',
    search: props.filters.search || '',
    person: props.filters.person || '',
});

const hasActiveFilters = computed(() => {
    return Object.values(localFilters.value).some(v => v);
});

const applyFilters = () => {
    router.get(route('timeline.index'), localFilters.value, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    localFilters.value = {
        event_type: '',
        date_from: '',
        date_to: '',
        search: '',
        person: '',
    };
    applyFilters();
};

const getEventTypeColor = (type) => {
    const colors = {
        story: 'bg-amber-100 text-amber-800 dark:bg-amber-800 dark:text-amber-100',
        birth: 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
        death: 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        marriage: 'bg-pink-100 text-pink-800 dark:bg-pink-800 dark:text-pink-100',
        milestone: 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
        photo: 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100',
        other: 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
    };
    return colors[type] || colors.story;
};

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <AppLayout title="Family Timeline">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Family Timeline
                </h2>
                <div class="flex items-center space-x-3">
                    <button
                        @click="showFilters = !showFilters"
                        :class="[
                            'inline-flex items-center px-3 py-2 border rounded-md text-sm font-medium transition',
                            hasActiveFilters
                                ? 'border-amber-500 text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20'
                                : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'
                        ]"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filters
                        <span v-if="hasActiveFilters" class="ml-2 w-2 h-2 bg-amber-500 rounded-full"></span>
                    </button>
                    <Link
                        :href="route('timeline.create')"
                        class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Entry
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12 relative">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Timeline -->
                <div v-if="entries.data.length === 0" class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">
                        {{ hasActiveFilters ? 'No entries match your filters.' : 'No timeline entries yet. Start documenting your family history!' }}
                    </p>
                    <Link
                        v-if="!hasActiveFilters"
                        :href="route('timeline.create')"
                        class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-md font-medium transition"
                    >
                        Create your first entry
                    </Link>
                    <button
                        v-else
                        @click="clearFilters"
                        class="text-amber-600 hover:text-amber-700 dark:text-amber-400 font-medium"
                    >
                        Clear filters
                    </button>
                </div>

                <div v-else class="relative">
                    <!-- Timeline line -->
                    <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-amber-400 via-amber-300 to-amber-200 dark:from-amber-600 dark:via-amber-700 dark:to-amber-800"></div>

                    <!-- Timeline entries -->
                    <div class="space-y-8">
                        <div
                            v-for="entry in entries.data"
                            :key="entry.id"
                            class="relative pl-20"
                        >
                            <!-- Timeline dot -->
                            <div class="absolute left-6 w-4 h-4 rounded-full bg-amber-500 border-4 border-white dark:border-gray-900 shadow"></div>

                            <!-- Entry card -->
                            <Link :href="route('timeline.show', entry.id)" class="block">
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition border-l-4 border-transparent hover:border-amber-400">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <span
                                                :class="getEventTypeColor(entry.event_type)"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mb-2"
                                            >
                                                {{ eventTypes[entry.event_type] }}
                                            </span>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ entry.title }}
                                            </h3>
                                        </div>
                                        <div class="text-right text-sm text-gray-500 dark:text-gray-400">
                                            <div v-if="entry.event_date" class="font-medium">
                                                {{ formatDate(entry.event_date) }}
                                            </div>
                                            <div v-if="entry.location" class="text-xs mt-1 flex items-center justify-end">
                                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ entry.location }}
                                            </div>
                                        </div>
                                    </div>

                                    <p v-if="entry.content" class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                        {{ entry.content.substring(0, 200) }}{{ entry.content.length > 200 ? '...' : '' }}
                                    </p>

                                    <div class="mt-3 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                        <span>By {{ entry.user?.name || 'Unknown' }}</span>
                                        <div class="flex items-center space-x-3">
                                            <span v-if="entry.has_audio" class="flex items-center text-purple-600 dark:text-purple-400">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                                </svg>
                                                Audio
                                            </span>
                                            <span v-if="entry.people_involved?.length" class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ entry.people_involved.length }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="entries.links && entries.links.length > 3" class="mt-8 flex justify-center">
                    <nav class="flex space-x-2">
                        <template v-for="link in entries.links" :key="link.label">
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                class="px-3 py-2 text-sm rounded-md transition"
                                :class="{
                                    'bg-amber-600 text-white': link.active,
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

            <!-- Slide-out Filter Panel -->
            <Transition
                enter-active-class="transition-transform duration-300 ease-out"
                enter-from-class="translate-x-full"
                enter-to-class="translate-x-0"
                leave-active-class="transition-transform duration-200 ease-in"
                leave-from-class="translate-x-0"
                leave-to-class="translate-x-full"
            >
                <div
                    v-show="showFilters"
                    class="fixed right-0 top-0 h-full w-80 bg-white dark:bg-gray-800 shadow-2xl z-50 overflow-y-auto"
                >
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filters</h3>
                            <button
                                @click="showFilters = false"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                            >
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Search
                                </label>
                                <input
                                    v-model="localFilters.search"
                                    type="text"
                                    placeholder="Search titles, content..."
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                />
                            </div>

                            <!-- Event Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Event Type
                                </label>
                                <select
                                    v-model="localFilters.event_type"
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                >
                                    <option value="">All Types</option>
                                    <option v-for="(label, value) in eventTypes" :key="value" :value="value">
                                        {{ label }}
                                    </option>
                                </select>
                            </div>

                            <!-- Person -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Person Involved
                                </label>
                                <input
                                    v-model="localFilters.person"
                                    type="text"
                                    placeholder="e.g., Mom, Grandpa"
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                />
                            </div>

                            <!-- Date Range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Date Range
                                </label>
                                <div class="space-y-2">
                                    <input
                                        v-model="localFilters.date_from"
                                        type="date"
                                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                    />
                                    <div class="text-center text-gray-400 text-sm">to</div>
                                    <input
                                        v-model="localFilters.date_to"
                                        type="date"
                                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-8 space-y-3">
                            <button
                                @click="applyFilters"
                                class="w-full py-2 px-4 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-md transition"
                            >
                                Apply Filters
                            </button>
                            <button
                                v-if="hasActiveFilters"
                                @click="clearFilters"
                                class="w-full py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-md transition"
                            >
                                Clear All
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>

            <!-- Backdrop -->
            <Transition
                enter-active-class="transition-opacity duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-show="showFilters"
                    @click="showFilters = false"
                    class="fixed inset-0 bg-black/30 z-40"
                ></div>
            </Transition>
        </div>
    </AppLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
