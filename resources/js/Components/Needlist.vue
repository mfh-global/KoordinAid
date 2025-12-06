<script setup>
import CustomTable from '@/Components/CustomTable.vue';

const calculateTotal = (sizes) => {
    let total = 0;
    sizes.forEach((item) => {
        total += item.pivot.number_of_items;
    });
    return total;
};

defineProps({
    needlist: Array,
});
</script>

<template>
    <CustomTable>
        <template #headers="{ thFirstClasses, thClasses }">
            <th scope="col" :class="thFirstClasses">Product</th>
            <th scope="col" :class="thClasses">Gender</th>
            <th scope="col" :class="thClasses">Requested</th>
        </template>

        <template #rows="{ tdFirstClasses, tdClasses }">
            <tr v-for="inquiry in needlist" :key="inquiry.id">
                <td :class="tdFirstClasses">
                    {{ inquiry.product.name }}
                </td>
                <td :class="tdClasses">
                    {{ inquiry.product.gender }}
                </td>
                <td :class="tdClasses">
                    <div class="flex items-end space-x-4">
                        <div>total: {{ calculateTotal(inquiry.sizes) }}</div>
                    </div>
                    <ul>
                        <li v-for="size in inquiry.sizes">
                            {{ size.name }}: {{ size.pivot.number_of_items }}
                        </li>
                    </ul>
                </td>
            </tr>
        </template>
    </CustomTable>
</template>
