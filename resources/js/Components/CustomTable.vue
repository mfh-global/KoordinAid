<script setup>
const thFirstClasses =
    'py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6';
const thClasses = 'px-3 py-3.5 text-left text-sm font-semibold text-gray-900 ';

const tdFirstClasses =
    'whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6';
const tdClasses = 'whitespace-nowrap px-3 py-4 text-sm text-gray-500';
</script>

<template>
    <div class="shadow overflow-hidden rounded-lg">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <slot
                                name="headers"
                                v-bind="{ thFirstClasses, thClasses }"
                            />
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <slot
                            name="rows"
                            v-bind="{ tdFirstClasses, tdClasses }"
                        />
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
