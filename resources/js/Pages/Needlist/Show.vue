<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';

export default {
    layout: AuthenticatedLayout,
};
</script>

<script setup>
import { Head } from '@inertiajs/vue3'
import Needlist from '@/Components/Needlist.vue';
import OrganisationProfile from '@/Components/OrganisationProfile.vue';
import Comment from '@/Components/Comment.vue';

const props = defineProps({
    inquiry: Object,
    needlist: Object,
    comment: Object,
});
</script>

<template>
    <Head title="IZTool" />
    <div class="space-y-24">
        <OrganisationProfile :needlist="inquiry" />
        <Needlist :needlist="needlist" />
        <Comment :comment="comment" />
    </div>
</template>
