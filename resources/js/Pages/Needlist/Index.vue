<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';

export default {
    layout: AuthenticatedLayout,
};
</script>

<script setup>
import { watch } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import OrganisationProfile from '@/Components/OrganisationProfile.vue';
import Select from '@/Components/Select.vue';

const props = defineProps({
    filters: Object,
    needlists: Array,
});

const form = useForm({
    status: props.filters.status,
});

watch(
    () => form.status,
    () => {
        form.get(route('needlist'));
    }
);
</script>

<template>
    <Head title="IZTool" />
    <div class="space-y-24">
        <Select v-model="form.status" />
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 xl:grid-cols-3">
            <div v-for="needlist in needlists">
                <OrganisationProfile :needlist="needlist" />
            </div>
        </div>
    </div>
</template>
