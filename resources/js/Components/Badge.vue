<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: String,
    color: String,
});

const sharedClasses =
    'flex-shrink-0 inline-block px-2 py-0.5 text-xs font-medium rounded-full';

let colorSpecificClasses = computed(() => {
    if (props.color === 'green') {
        return 'text-green-800 bg-green-100';
    }

    if (props.color === 'yellow') {
        return 'text-yellow-800 bg-yellow-100';
    }

    if (props.color === 'pink') {
        return 'text-pink-800 bg-pink-100';
    }
});
</script>

<template>
    <span :class="[sharedClasses, colorSpecificClasses]">
        {{ label }}
    </span>
</template>
