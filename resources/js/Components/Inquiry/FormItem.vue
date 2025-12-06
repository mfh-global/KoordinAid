<script setup>
import { computed } from 'vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import snakeCase from 'lodash/snakeCase';
import startCase from 'lodash/startCase';
import InputError from '@/Components/InputError.vue';

let props = defineProps({
    form: Object,
    label: String,
    type: String
});

let formKey = computed(() => {
    return snakeCase(props.label);
});
</script>

<template>
    <div
        class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
    >
        <BreezeLabel
            class="sm:mt-px sm:pt-2"
            :for="formKey"
            :value="startCase(label)"
        />
        <div class="mt-1 sm:mt-0 sm:col-span-2">
            <BreezeInput
                :id="formKey"
                :type="type"
                class="sm:max-w-xs"
                v-model="form[formKey]"
            />
            <InputError class="mt-1" :message="form.errors[formKey]" />
        </div>
    </div>
</template>
