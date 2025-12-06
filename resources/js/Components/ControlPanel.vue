<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from '@vue/reactivity';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
const user = computed(() => usePage().props.auth.user);
</script>

<template>
    <BreezeDropdown align="right" width="96">
        <template #trigger>
            <button type="button">
                <img
                    class="w-8 h-8 rounded-full"
                    :src="user.avatar"
                    alt="user photo"
                    referrerpolicy="noreferrer"
                    rel="noreferrer"
                />
            </button>
        </template>
        <template #content>
            <div
                class="border-b border-gray-100 block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
            >
                <p class="text-sm">Signed in as</p>
                <p class="text-sm font-medium text-gray-900 truncate">
                    {{ user.email }}
                </p>
            </div>
            <BreezeDropdownLink :href="route('logout')" as="button">
                Log Out
            </BreezeDropdownLink>
        </template>
    </BreezeDropdown>
</template>
