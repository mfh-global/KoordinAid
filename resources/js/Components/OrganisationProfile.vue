<script setup>
import { Link } from '@inertiajs/vue3';
import { MailIcon, PhoneIcon, HomeIcon, CalendarIcon } from '@heroicons/vue/solid';
import Badge from '@/Components/Badge.vue';
import UpdateInquiry from '@/Components/UpdateInquiry.vue';
import { computed } from 'vue'



const submittedAt = computed(() => {
    if (!props.needlist) return ''
        
    return new Date(props.needlist.created_at).toLocaleDateString('en-EN', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    })
})
const props = defineProps({
    needlist: Object,
});

const lookup = {
    new: 'pink',
    in_progress: 'yellow',
    closed: 'green',
};

const formatTimestamp = (timestamp) => {
    if (timestamp) return new Date(timestamp).toLocaleDateString();
    return '';
};
</script>

<template>
    <div
        class="bg-white rounded-lg shadow hover:ring-2 hover:ring-purple-500 divide-y divide-gray-200"
    >
        <UpdateInquiry :needlist="needlist" />
        <Link :href="route('needlist.show', props.needlist)" class="block">
            <div class="w-full flex items-center justify-between p-6 space-x-6">
                <div class="flex-1 truncate">
                    <div class="flex justify-between items-center">
                        <h3 class="text-gray-900 text-sm font-medium truncate">
                            NGO Name:
                            {{ needlist.organisation.organisation }}
                        </h3>
                        <Badge
                            :label="needlist.status"
                            :color="lookup[needlist.status]"
                        />
                    </div>
                    <div class="mt-4 space-y-2">
                        <div class="flex items-start">
                            <HomeIcon
                                class="w-4 h-4 text-gray-400"
                                aria-hidden="true"
                            />
                            <p
                                class="text-gray-500 text-sm truncate ml-2 -mt-0.5"
                            >
                                {{ needlist.organisation.address }}<br />
                                {{ needlist.organisation.zipcode }}
                                {{ needlist.organisation.city }} <br />
                                {{ needlist.organisation.state }}
                                {{ needlist.organisation.country }}
                            </p>
                        </div>
                        <div class="flex items-center">
                            <MailIcon
                                class="w-4 h-4 text-gray-400"
                                aria-hidden="true"
                            />
                            <p class="text-gray-500 text-sm truncate ml-2">
                                {{ needlist.organisation.e_mail }}
                            </p>
                        </div>
                        <div class="flex items-center">
                            <PhoneIcon
                                class="w-4 h-4 text-gray-400"
                                aria-hidden="true"
                            />
                            <p class="text-gray-500 text-sm truncate ml-2">
                                {{ needlist.organisation.phone_number }}
                            </p>
                        </div>
                        <div
                            class="flex items-center" 
                            v-if="needlist.delivery_from || needlist.delivery_until"
                        >
                            <CalendarIcon
                                class="w-4 h-4 text-gray-400"
                                aria-hidden="true"
                            />
                            <p class="text-gray-500 text-sm truncate ml-2">
                                Delivery Expected 
                                {{ formatTimestamp(needlist.delivery_from) }} -
                                {{ formatTimestamp(needlist.delivery_until) }}
                            </p>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Submitted at {{ submittedAt }}
                        </p>
                    </div>
                </div>
            </div>
        </Link>
    </div>
</template>
