<script>
import GuestLayout from '@/Layouts/Guest.vue';

export default {
    layout: GuestLayout,
};
</script>

<script setup>
import { computed, ref, watch } from 'vue';
import throttle from 'lodash/throttle';
import { router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3'
import Form from '@/Components/Inquiry/Form.vue';
import ProductList from '@/Components/Inquiry/ProductList.vue';
import Modal from '@/Components/Modal.vue';
import BreezeInput from '@/Components/Input.vue';
import RequestedList from '@/Components/Inquiry/RequestedList.vue';
import Pagination from '@/Components/Inquiry/Pagination.vue';
import { isString } from 'lodash';

const props = defineProps({
    products: Object,
    filters: Object,
    size: Object,
});

const orgFields = {
    full_name: null,
    organisation: null,
    phone_number: null,
    e_mail: null,
};

const shippingFields = {
    address: null,
    city: null,
    zipcode: null,
    state: null,
    country: null,
};

const shippingTimeFields = {
    delivery_from: null,
    delivery_until: null,
}

const requestedProducts = ref([]);

const form = useForm({
    ...orgFields,
    ...shippingFields,
    ...shippingTimeFields,
    search: props.filters.search,
    size: props.size,
    comment: '',
    products: computed(() => {
        return requestedProducts.value.map((product) => {
            return {
                id: product.id,
                requested: product.requested,
            };
        });
    }),
});

watch(
    () => form.search,
    throttle(() => {
        router.get(
            route('inquiry.create'),
            { search: form.search },
            {
                preserveState: true,
                preserveScroll: true,
            }
        );
    }, 150)
);

const showModal = ref(false);
const chosenProduct = ref(null);
const chosenAmount = ref({});

const requestedProductsIds = computed(() => {
    return requestedProducts.value.map(
        (requestedProduct) => requestedProduct.id
    );
});

const select = async (product) => {
    if (!product.sizes) {
        product.sizes = await axios
            .get(route('inquiry.sizes', { product: product.id }))
            .then((response) => {
                return response.data;
            })
            .catch((error) => {
                console.log(error);
            });
    }

    showModal.value = true;
    chosenProduct.value = product;

    if (product.requested) {
        chosenAmount.value = product.requested;
    }
};

const add = () => {
    showModal.value = false;
    let amount = { ...chosenAmount.value };
    chosenAmount.value = {};

    // vue-model.number returns an empty string if no value is given for a size
    // this removes sizes with no input or input == 0 and deletes products with 0 requested items
    let productTotalRequested = 0;
    for (let key in amount) {
        if (!amount.hasOwnProperty(key)) return;
        if (isString(amount[key]) || amount[key] === 0) {
            delete amount[key];
        } else {
            productTotalRequested += amount[key]
        }
    }
    if (productTotalRequested === 0) {
        deleteRequestedProduct(chosenProduct.value);
        return;
    }

    chosenProduct.value.requested = amount;
    if (requestedProductsIds.value.includes(chosenProduct.value.id)) {
        return;
    }

    requestedProducts.value.push(chosenProduct.value);
};

const deleteRequestedProduct = (product) => {
    product.requested = [];
    const index = requestedProducts.value.findIndex(
        (requestedProduct) => requestedProduct.id == product.id
    );
    if (index !== -1) {
        requestedProducts.value.splice(index, 1);
    }
};

const updateProduct = (product) => {
    chosenProduct.value = product;
    chosenAmount.value = product.requested;
    showModal.value = true;
};

const buttonLabel = computed(() => {
    if (chosenProduct.value) {
        return requestedProductsIds.value.includes(chosenProduct.value.id)
            ? 'Update'
            : 'Add';
    }
});
</script>

<template>
    <Head title="New Inquiry" />
    <Modal
        :open="showModal"
        @close="showModal = false"
        @confirm="add"
        :buttonLabel="buttonLabel"
    >
        <template #title>
            {{ chosenProduct.name }}
        </template>
        <template #content>
            <div class="space-y-4">
                <p class="text-sm text-gray-500">
                    {{ chosenProduct.gender }}
                </p>
                <div class="text-sm flex">
                    <div class="w-1/3">Size</div>
                    <div class="w-1/3">Amount</div>
                </div>
                <div
                    v-for="(size, id) in chosenProduct.sizes"
                    class="flex items-center"
                >
                    <label class="text-sm font-bold text-gray-500 w-1/3">
                        {{ size.name }}
                    </label>
                    <BreezeInput
                        class="amount w-1/3"
                        type="number"
                        placeholder="Amount"
                        label="Foo"
                        min="0"
                        v-model.number="chosenAmount[size.id]"
                    />
                </div>
            </div>
        </template>
    </Modal>
    <InputError
        v-if="form.errors.products"
        class="p-8"
        :message="Object.values(form.errors.products)[0]"
    />
    <form @submit.prevent="form.post('/inquiry')">
        <div class="space-y-12">
            <Form
                :orgFields="orgFields"
                :shippingFields="shippingFields"
                :shippingTimeFields="shippingTimeFields"
                :form="form"
            />
            <div>
                <div class="min-h-[650px] space-y-4">
                    <BreezeInput
                        id="search"
                        placeholder="Search for products"
                        type="text"
                        v-model="form.search"
                    />
                    <ProductList
                        :products="products"
                        @select="select"
                        :requestedProductsIds="requestedProductsIds"
                    />
                    <div>
                        <Pagination :links="props.products.links" />
                    </div>
                </div>
            </div>
            <RequestedList
                :products="requestedProducts"
                @delete="deleteRequestedProduct"
                @update="updateProduct"
            />

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <label class="text-sm font-bold text-gray-500 w-1/3">
                    Further remarks or other needs that are not listed above:
                </label>
                <BreezeInput
                    id="comment"
                    type="text"
                    v-model="form.comment"/>
            </div>
            <button
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2"
                type="submit"
            >
                Submit Needlist
            </button>
            
        </div>
    </form>
</template>
