<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <div class="min-h-screen flex">
        <!-- Left Side - Content -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-amber-500 to-orange-600 p-12 flex-col justify-between">
            <div>
                <Link href="/" class="flex items-center space-x-2">
                    <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    <span class="text-2xl font-bold text-white">Family Line</span>
                </Link>
            </div>

            <div class="space-y-8">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-4">
                        Start Your Family's Story
                    </h1>
                    <p class="text-amber-100 text-lg">
                        Join thousands of families preserving their precious memories for generations to come.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Create Your Timeline</h3>
                            <p class="text-amber-100 text-sm">Document births, weddings, milestones, and everyday moments</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Invite Your Family</h3>
                            <p class="text-amber-100 text-sm">Collaborate with relatives to build a complete picture</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Preserve Forever</h3>
                            <p class="text-amber-100 text-sm">Your stories are safe and accessible for generations</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-amber-100 text-sm">
                Preserving memories, connecting generations.
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50 dark:bg-gray-900">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 text-center">
                    <Link href="/" class="inline-flex items-center space-x-2">
                        <svg class="h-10 w-10 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">Family Line</span>
                    </Link>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create your account</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            Already have an account?
                            <Link :href="route('login')" class="text-amber-600 hover:text-amber-700 dark:text-amber-400 font-medium">
                                Sign in
                            </Link>
                        </p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-5">
                        <div>
                            <InputLabel for="name" value="Full Name" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="John Smith"
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div>
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                                autocomplete="username"
                                placeholder="you@example.com"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div>
                            <InputLabel for="password" value="Password" />
                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div>
                            <InputLabel for="password_confirmation" value="Confirm Password" />
                            <TextInput
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                            <label class="flex items-start">
                                <Checkbox id="terms" v-model:checked="form.terms" name="terms" required class="mt-1" />
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                                    I agree to the
                                    <a target="_blank" :href="route('terms.show')" class="text-amber-600 hover:text-amber-700 dark:text-amber-400">Terms of Service</a>
                                    and
                                    <a target="_blank" :href="route('policy.show')" class="text-amber-600 hover:text-amber-700 dark:text-amber-400">Privacy Policy</a>
                                </span>
                            </label>
                            <InputError class="mt-2" :message="form.errors.terms" />
                        </div>

                        <PrimaryButton
                            class="w-full justify-center py-3 bg-amber-600 hover:bg-amber-700 focus:bg-amber-700 active:bg-amber-800 focus:ring-amber-500"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Create Account
                        </PrimaryButton>
                    </form>
                </div>

                <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
                    <Link href="/" class="hover:text-amber-600 dark:hover:text-amber-400">
                        &larr; Back to home
                    </Link>
                </p>
            </div>
        </div>
    </div>
</template>
