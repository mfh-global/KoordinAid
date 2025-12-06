<script setup>
import { ref } from 'vue';
import CustomTable from '@/Components/CustomTable.vue';
import { InformationCircleIcon } from '@heroicons/vue/outline';

const calculateTotal = (requested) =>
    Object.values(requested).reduce((a, b) => a + b, 0);

const active = ref(false);

const showDetails = (id) => {
    if (active.value === id) {
        return (active.value = false);
    }

    active.value = id;
};

defineProps({
    products: Object,
});
</script>
<template>
    <CustomTable>
        <template #headers="{ thFirstClasses, thClasses }">
            <th scope="col" :class="thFirstClasses">Product</th>
            <th scope="col" :class="thClasses">Gender</th>
            <th scope="col" :class="thClasses">Stock</th>
            <th scope="col" :class="thClasses">Requested</th>
            <th scope="col" :class="thClasses">
                <span class="sr-only">Update</span>
            </th>
            <th scope="col" :class="thClasses">
                <span class="sr-only">Delete</span>
            </th>
        </template>

        <template #rows="{ tdFirstClasses, tdClasses }">
            <tr
                v-if="products.length > 0"
                v-for="product in products"
                :key="product.id"
            >
                <td :class="tdFirstClasses">
                    {{ product.name }}
                </td>
                <td :class="tdClasses">
                    {{ product.gender }}
                </td>
                <td :class="tdClasses">
                    {{ product.in_stock }}
                </td>
                <td :class="tdClasses">
                    <div class="flex items-end space-x-4">
                        <div>
                            total: {{ calculateTotal(product.requested) }}
                            <br />
                            (click <strong>i</strong> to show size detail)
                        </div>
                        <div @click="showDetails(product.id)">
                            <InformationCircleIcon
                                class="h-6 w-6 text-gray-400 hover:text-gray-800"
                                aria-hidden="true"
                            />
                        </div>
                    </div>
                    <ul v-if="active === product.id">
                        <li v-for="size in product.sizes">
                            {{ size.name }}: {{ product.requested[size.id] }}
                        </li>
                    </ul>
                </td>
                <td
                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8"
                >
                    <button
                        type="button"
                        @click="$emit('update', product)"
                        class="text-indigo-600 hover:text-indigo-900"
                    >
                        change amount
                    </button>
                </td>
                <td
                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8"
                >
                    <button
                        type="button"
                        @click="$emit('delete', product)"
                        class="text-indigo-600 hover:text-indigo-900"
                    >
                        delete
                    </button>
                </td>
            </tr>
            <tr v-else>
                <td colspan="20" class="text-gray-600 text-center p-4">
                    empty
                </td>
            </tr>
        </template>
    </CustomTable>
</template>
