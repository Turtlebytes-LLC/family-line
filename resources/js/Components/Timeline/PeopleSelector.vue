<script setup>
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

const model = defineModel({ type: Array, default: () => [] });

const newPerson = ref('');

const addPerson = () => {
    if (newPerson.value.trim() && !model.value.includes(newPerson.value.trim())) {
        model.value.push(newPerson.value.trim());
        newPerson.value = '';
    }
};

const removePerson = (index) => {
    model.value.splice(index, 1);
};
</script>

<template>
    <div>
        <div class="flex space-x-2">
            <TextInput
                v-model="newPerson"
                type="text"
                class="flex-1"
                placeholder="Add a person's name"
                @keydown.enter.prevent="addPerson"
            />
            <button
                type="button"
                @click="addPerson"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition"
            >
                Add
            </button>
        </div>
        <div v-if="model.length" class="mt-2 flex flex-wrap gap-2">
            <span
                v-for="(person, index) in model"
                :key="index"
                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200"
            >
                {{ person }}
                <button
                    type="button"
                    @click="removePerson(index)"
                    class="ml-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"
                >
                    &times;
                </button>
            </span>
        </div>
    </div>
</template>
