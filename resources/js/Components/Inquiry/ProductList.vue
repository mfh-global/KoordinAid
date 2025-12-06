<script setup>
import { ref } from 'vue';
import CustomTable from '@/Components/CustomTable.vue';
import { InformationCircleIcon } from '@heroicons/vue/outline';



const props = defineProps({
    products: Object,
    requestedProductsIds: Array,
});

const alreadyRequested = (product) => {
    return props.requestedProductsIds.includes(product.product_id);
};

const active = ref(false);

const showDetails = (id) => {
    if (active.value === id) {
        return (active.value = false);
    }

    active.value = id;
};
</script>

<template>
    <CustomTable>
        <template #headers="{ thFirstClasses, thClasses }">
            <th style="width:20%" scope="col" :class="thFirstClasses">Category</th>
            <th style="width:48%" scope="col" :class="thFirstClasses">Product</th>
            <th style="width:16%" scope="col" :class="thClasses">Gender</th>
            <th style="width:16%" scope="col" :class="thClasses">
                <span class="sr-only">Select</span>
            </th>
        </template>

        <template #rows="{ tdFirstClasses, tdClasses }">
            <tr v-for="product in products.data" :key="product.id">
                <td :class="tdFirstClasses">
                    {{ product.category }}
                </td>

                <td :class="tdFirstClasses">
                    <div class="flex items-end space-x-4">
                        <div>
                            {{ product.name }}
                            <br />
                            <span v-if="product.description" class="text-sm font-normal text-slate-700 whitespace-normal">
                                (click <strong>i</strong> for product description)
                            </span>
                        </div>
                        <div v-if="product.description" @click="showDetails(product.id)">
                            <InformationCircleIcon
                                class="h-6 w-6 text-gray-400 hover:text-gray-800"
                                aria-hidden="true"
                            />
                        </div>
                    </div>

                    <div v-if="active === product.id" class="mt-0.5">
                        <span class="text-sm font-light text-slate-700 whitespace-normal">{{product.description}}</span>
                    </div>

                </td>
                <td :class="tdClasses">
                    {{ product.gender }}
                </td>
                <td
                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8"
                >
                    <button
                        @click="$emit('select', product)"
                        type="button"
                        class="text-indigo-600 hover:text-indigo-900"
                        :class="{ 'opacity-50' : alreadyRequested(product) }"
                        :disabled="alreadyRequested(product)"
                    >
                        Select
                    </button>
                </td>
            </tr>
        </template>
    </CustomTable>
</template>
