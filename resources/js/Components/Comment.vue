<script setup>
import CustomTable from '@/Components/CustomTable.vue';

defineProps({
    comment: String,
});
</script>

<template>
    <CustomTable>
        <template #headers="{ thFirstClasses, thClasses }">
            <th scope="col" :class="thFirstClasses">Further Remarks:</th>
        </template>

       
        <template #rows="{ tdFirstClasses }">    
            
            <td :class="tdFirstClasses">
                    <div class="flex items-end space-x-4">
                        <div> {{ comment }}</div>
                    </div>
                    
                </td>            
                
        </template>
    </CustomTable>
</template>
