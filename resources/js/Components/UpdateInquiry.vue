<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import Badge from '@/Components/Badge.vue';

const props = defineProps({
    needlist: Object,
});

const newState = ref(props.needlist.status);

const form = useForm({
    status: newState,
});

const showModal = ref(false);

const handleClose = () => {
    newState.value = props.needlist.status;
    showModal.value = false;
};

const handleConfirm = () => {
    showModal.value = false;
    form.status = newState;
    form.put(route('needlist.update', props.needlist), {
        preserveScroll: true,
    });
};

const lookup = {
    new: 'pink',
    in_progress: 'yellow',
    closed: 'green',
};
</script>

<template>
    <Modal
        :open="showModal"
        @close="handleClose"
        @confirm="handleConfirm"
        buttonLabel="Update status"
    >
        <template #title>Update status</template>
        <template #content>
            <div class="my-8 space-x-4">
                <Badge
                    v-for="(value, key) in lookup"
                    :label="key"
                    :color="lookup[key]"
                    @click="newState = key"
                    class="hover:cursor-pointer"
                    :class="{
                        'outline outline-offset-4': newState === key,
                    }"
                />
            </div>
        </template>
    </Modal>

    <div class="flex justify-end px-6 py-2">
        <button
            @click="showModal = true"
            class="text-sm text-indigo-600 hover:text-indigo-500"
        >
            Update status
        </button>
    </div>
</template>
