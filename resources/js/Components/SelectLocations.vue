<script setup>
defineProps(['modelValue', 'locations']);
defineEmits(['update:modelValue']);

</script>

<template>
    <div>
        <label for="location" class="block text-sm font-medium text-gray-700">
            Choose the Boxtribute location for which the cargo lists should be created        </label>
        <select
            id="location"
            name="location"
            class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        >
            <option value="">all</option>
            <option v-for="location in locations" :value="location.id">
                {{ location.name }}
            </option>
        </select>

    </div>
</template>
