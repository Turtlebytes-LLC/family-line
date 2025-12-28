<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Family Line - Preserve Your Family Stories" />
    <div class="bg-gradient-to-br from-amber-50 to-orange-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="relative min-h-screen flex flex-col">
            <!-- Navigation -->
            <header class="w-full">
                <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <svg class="h-10 w-10 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">Family Line</span>
                    </div>
                    <div v-if="canLogin" class="flex items-center space-x-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="text-gray-700 dark:text-gray-300 hover:text-amber-600 dark:hover:text-amber-400 font-medium transition"
                        >
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="text-gray-700 dark:text-gray-300 hover:text-amber-600 dark:hover:text-amber-400 font-medium transition"
                            >
                                Log in
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg font-medium transition"
                            >
                                Get Started
                            </Link>
                        </template>
                    </div>
                </nav>
            </header>

            <!-- Hero Section -->
            <main class="flex-grow flex items-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div class="text-center">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight">
                            Preserve Your Family's
                            <span class="text-amber-600 dark:text-amber-400">Stories</span>
                        </h1>
                        <p class="mt-6 text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                            Create a living timeline of your family's history. Record memories, share stories, and connect generations through the moments that matter most.
                        </p>
                        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                            <Link
                                v-if="canRegister && !$page.props.auth.user"
                                :href="route('register')"
                                class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition shadow-lg"
                            >
                                Start Your Timeline
                            </Link>
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('timeline.index')"
                                class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition shadow-lg"
                            >
                                View Your Timeline
                            </Link>
                            <a
                                href="#features"
                                class="border-2 border-amber-600 text-amber-600 dark:text-amber-400 dark:border-amber-400 hover:bg-amber-50 dark:hover:bg-gray-700 px-8 py-3 rounded-lg font-semibold text-lg transition"
                            >
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Features Section -->
            <section id="features" class="bg-white dark:bg-gray-800 py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">
                        Everything You Need to Preserve Your Legacy
                    </h2>
                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="text-center p-6">
                            <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Timeline View</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                See your family's history unfold chronologically. From births to milestones, every moment finds its place.
                            </p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="text-center p-6">
                            <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Family Collaboration</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Invite family members to contribute their memories. Build your story together, across generations.
                            </p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="text-center p-6">
                            <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Audio Recordings</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Capture stories in your loved ones' own voices. Some memories are best heard, not just read.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="bg-amber-600 dark:bg-amber-700 py-16">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">
                        Start Preserving Your Family's Story Today
                    </h2>
                    <p class="text-amber-100 text-lg mb-8">
                        Every family has a story worth telling. Don't let yours fade away.
                    </p>
                    <Link
                        v-if="canRegister && !$page.props.auth.user"
                        :href="route('register')"
                        class="bg-white text-amber-600 hover:bg-amber-50 px-8 py-3 rounded-lg font-semibold text-lg transition shadow-lg inline-block"
                    >
                        Create Your Free Account
                    </Link>
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="bg-white text-amber-600 hover:bg-amber-50 px-8 py-3 rounded-lg font-semibold text-lg transition shadow-lg inline-block"
                    >
                        Go to Dashboard
                    </Link>
                </div>
            </section>

            <!-- Footer -->
            <footer class="bg-gray-900 text-gray-400 py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <p>Family Line - Preserving memories, connecting generations.</p>
                </div>
            </footer>
        </div>
    </div>
</template>
