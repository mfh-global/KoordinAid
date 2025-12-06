<script setup>
defineProps(['modelValue']);
defineEmits(['update:modelValue']);

const states = ['new', 'in_progress', 'closed'];
</script>

<template>
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">
            Filter by status
        </label>
        <select
            id="status"
            name="status"
            class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        >
            <option value="">all</option>
            <option v-for="status in states" :value="status">
                {{ status }}
            </option>
        </select>
    </div>
</template>
