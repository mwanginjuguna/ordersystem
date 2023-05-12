<script setup>
import ClientLayout from '@/Layouts/ClientLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Panel from "../Components/Panel.vue";
import {defineProps} from "vue";

defineProps({
    orders: Object
})

function formatTime(time) {
    // Create a new Date object from the given time string.
    const date = new Date(time);

    // Get the difference between the current time and the given time.
    const diff = date.getTime() - Date.now();

    // Convert the difference to days, hours, and minutes.
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

    // Check if the given time is in the past or future.
    const isPast = diff < 0;

    // Return a human readable string of the time difference.
    return `${days ? days + " days " : ""}${hours ? hours + " hrs " : ""}${minutes} min ${isPast ? "ago" : "from now"}`;
}
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
                    <Link
                        :href="route('orders.new')"
                        class="p-2 px-4 mr-12 bg-purple-200 text-slate-900 hover:underline border border-slate-700 rounded hover:bg-purple-300 hover:text-slate-800 active:bg-purple-400 active:ring-slate-900 transition ease-in-out hover:duration-500 active:duration-500"
                    >
                        New Order
                    </Link>
                </div>
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Panel class="bg-fuchsia-50 lg:px-8 lg:py-6 col-span-2">
                        <template v-slot:heading>
                            <h4 class="font-bold px-3 border-b border-purple-200">Recent Activity</h4>
                        </template>
                        <template v-slot:default>
                            <section class="grid divide-y gap-y-5">
                                <div class="" v-for="order in orders" :key="order.id">
                                    <div class="px-3 pt-2 grid grid-cols-4 gap-x-2 text-sm place-content-center" >
                                        <Link :href="route('orders.show', order.id)" class="col-span-4 py-2 text-blue-800 hover:underline underline-offset-4 font-semibold">Order #{{ order.id }} - {{ order.title }}</Link>
                                        <p class="text-slate-500">Status: <span class="text-slate-800 font-semibold">{{ order.status }}</span></p>
                                        <p class="col-span-2">Deadline: <span class="text-slate-700 text-xs">{{ formatTime(order.due_at) }}</span></p>
                                        <Link :class="`pl-3 text-sky-500 hover:text-sky-700 hover:font-semibold underline`"
                                              :href="route('orders.show', order.id)"
                                        >
                                            View
                                        </Link>
                                    </div>
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
