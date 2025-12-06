<script setup>
import FormItem from '@/Components/Inquiry/FormItem.vue';

defineProps({
    form: Object,
    orgFields: Object,
    shippingFields: Object,
    shippingTimeFields: Object,
});
</script>

<template>
    <div class="bg-white p-8 rounded-lg">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div class="space-y-6 lg:space-y-10">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Basic Information
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Use a permanent address where you can receive mail.
                    </p>
                </div>
                <fieldset class="rounded border border-gray-200 p-4">
                    <legend class="font-extralight">Contact Information</legend>
                    <div class="space-y-6 sm:space-y-5">
                        <FormItem
                            v-for="field in Object.keys(orgFields)"
                            :key="field"
                            :form="form"
                            type="text"
                            :label="field"
                        />
                    </div>
                </fieldset>

                <fieldset class="rounded border border-gray-200 p-4">
                    <legend class="font-extralight">Shipping Address</legend>
                    <div class="space-y-6 sm:space-y-5">
                        <FormItem
                            v-for="field in Object.keys(shippingFields)"
                            :key="field"
                            :form="form"
                            type="text"
                            :label="field"
                        />
                    </div>
                </fieldset>
                <fieldset class="rounded border border-gray-200 p-4">
                    <legend class="font-extralight">Shipping Timeframe (Optional)</legend>
                    <div class="space-y-6 sm:space-y-5">
                        <FormItem
                            v-for="field in Object.keys(shippingTimeFields)"
                            :key="field"
                            :form="form"
                            type="date"
                            :label="field"
                        />
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</template>
