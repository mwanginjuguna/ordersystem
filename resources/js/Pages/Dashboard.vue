<script setup>
import ClientLayout from '@/Layouts/ClientLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Panel from "../Components/Panel.vue";
import {defineProps} from "vue";

defineProps({
    orders: Object
})
</script>

<template>
    <Head title="Dashboard" />

    <ClientLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="col-span-2 xl:col-span-3 md:mx-8 flex flex-wrap justify-between">
                    <h4 class="font-bold text-xl text-indigo-900 font-serif">
                        Orders
                    </h4>
                    <a
                        href="{{ route('orders.new') }}"
                        class="p-2 px-4 mr-12 bg-purple-200 text-slate-900 hover:underline border border-slate-700 rounded hover:bg-purple-300 hover:text-slate-800 active:bg-purple-400 active:ring-slate-900 transition ease-in-out hover:duration-500 active:duration-500"
                    >
                        New Order
                    </a>
                </div>
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Panel class="bg-fuchsia-50 lg:px-8 lg:py-6 col-span-2">
                        <template v-slot:heading>
                            <h4 class="font-bold px-3 border-b border-purple-200">Recent Activity</h4>
                        </template>
                        <template v-slot:default>
                            <section class="grid divide-y gap-y-5 w-3/4">
                                <div class="" v-for="order in orders" :key="order.id">
                                    <p class="text-sm flex justify-between px-3" >
                                        <span class="font-semibold">Order #{{ order.id }}</span>
                                        <span>{{ order.status }}</span>
                                        <span>{{ order.deadline }} Hours</span>
                                        <Link :class="`text-sky-500 hover:text-sky-700 hover:underline`"
                                              :href="route('orders.show', order.id)"
                                        >View</Link>
                                    </p>
                                </div>
                            </section>
                        </template>
                        <template v-slot:footer>
                            <Link :href="route('orders.running')"
                                  :class="`text-purple-500 hover:text-purple-700 underline`"
                            >
                                Orders in Progress
                            </Link>
                        </template>
                    </Panel>
                </div>
            </div>
        </div>
    </ClientLayout>
</template>
