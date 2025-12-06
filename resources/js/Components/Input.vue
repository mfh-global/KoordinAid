<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue']);

const emit = defineEmits(['update:modelValue']);
const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

const emitEvent = (e) => {
    e.srcElement.reportValidity();
    emit('update:modelValue', e.target.value);
};
</script>

<template>
    <input
        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
        :value="modelValue"
        @input="emitEvent"
        ref="input"
    />
</template>
