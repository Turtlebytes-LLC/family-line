<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalEntries: 0,
            thisMonth: 0,
            teamMembers: 0,
        }),
    },
    recentEntries: {
        type: Array,
        default: () => [],
    },
});

const eventTypeColors = {
    birth: 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
    death: 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
    marriage: 'bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-400',
    milestone: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
    story: 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
    photo: 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
    other: 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
};

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-amber-100 dark:bg-amber-900/30 rounded-full">
                                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Timeline Entries</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.totalEntries }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Added This Month</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.thisMonth }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Family Members</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.teamMembers }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                        <div class="flex flex-wrap gap-4">
                            <Link
                                :href="route('timeline.create')"
                                class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Timeline Entry
                            </Link>
                            <Link
                                :href="route('timeline.index')"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-lg transition"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                View Timeline
                            </Link>
                            <Link
                                :href="route('teams.show', $page.props.auth.user.current_team)"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-lg transition"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Invite Family
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Recent Entries -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Timeline Entries</h3>
                            <Link
                                :href="route('timeline.index')"
                                class="text-amber-600 dark:text-amber-400 hover:underline text-sm font-medium"
                            >
                                View all
                            </Link>
                        </div>

                        <div v-if="recentEntries.length === 0" class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">No timeline entries yet</p>
                            <Link
                                :href="route('timeline.create')"
                                class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition"
                            >
                                Create your first entry
                            </Link>
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="entry in recentEntries"
                                :key="entry.id"
                                class="flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                            >
                                <div class="flex-shrink-0">
                                    <span :class="[eventTypeColors[entry.event_type] || eventTypeColors.other, 'px-2 py-1 text-xs font-medium rounded-full']">
                                        {{ entry.event_type }}
                                    </span>
                                </div>
                                <div class="ml-4 flex-1 min-w-0">
                                    <Link :href="route('timeline.show', entry.id)" class="block">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate hover:text-amber-600 dark:hover:text-amber-400">
                                            {{ entry.title }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ formatDate(entry.event_date) }}
                                            <span v-if="entry.location"> &middot; {{ entry.location }}</span>
                                        </p>
                                    </Link>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <Link
                                        :href="route('timeline.edit', entry.id)"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
