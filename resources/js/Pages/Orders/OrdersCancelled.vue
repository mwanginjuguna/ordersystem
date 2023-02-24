<script setup>
import BaseLayout from "../../Layouts/BaseLayout.vue";
import OrdersCard from "../../Components/OrdersCard.vue";
import {Link} from "@inertiajs/inertia-vue3";
import {defineProps} from "vue";


defineProps({
    cancelledOrders: Object
})

function deleteOrder(id) {
    route('orders.delete', id)
}

function getOrder(id) {
    route('orders.show', id)
}
</script>

<template>
    <BaseLayout>
        <template #header>
            <h1 class="font-bold sm:font-extrabold text-indigo-900 leading-8 text-center text-xl md:text-4xl">
                Cancelled Orders
            </h1>
            <p class="justify-self-center text-center text-xs text-gray-500 p-4 border-b border-purple-500">
                <span class="font-bold">About: </span>Cancelled orders due to dispute, refund or other issues.
            </p>
        </template>
        <section>
            <OrdersCard>
                <section class="bg-white text-gray-900 rounded">
                    <div class="m-3 ml-4 p-4 lg:pt-6">
                        <Link
                            href="/orders/new"
                            class="mx-auto p-2 px-4 bg-slate-200 text-purple-900 hover:underline border border-slate-700 rounded hover:bg-slate-300 hover:text-purple-800 active:bg-slate-400 active:ring-purple-900 transition ease-in-out hover:duration-500 active:duration-500"
                        >
                            New Order
                        </Link>
                    </div>
                    <!--All Recent Orders-->
                    <div>
                        <div class="p-3 lg:py-10 lg:px-8 m-2 md:grid md:grid-cols-3 lg:mx-8 lg:my-4">
                            <div class="text-center underline text-red-500 col-span-3">
                                <h3>All Cancelled Orders</h3>
                            </div>
                            <div class="md:col-span-2 lg:col-span-3 text-sm md:text-md space-y-6">
                                <div v-for="cancelled in cancelledOrders"
                                     class="flex justify-between md:max-w-2/3 lg:w-full mx-auto border-b border-indigo-400">
                                    <div>
                                        <p>Order Topic: {{ cancelled.title }}</p>
                                        <p class="text-xs">Order Id: <span>#{{ cancelled.id }}</span></p>
                                    </div>
                                    <div class="p-2">
                                        <Link :href="route('orders.show', cancelled.id)"
                                              class="text-sky-400 hover:text-sky-500 underline mx-2">
                                            view
                                        </Link>
                                        <Link :href="route('orders.delete', cancelled.id)" class="text-red-400 hover:text-red-500 underline mx-2">Delete</Link>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </section>
            </OrdersCard>
        </section>
    </BaseLayout>
</template>
