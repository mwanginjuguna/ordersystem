<script setup>
import BaseLayout from '../../Layouts/BaseLayout.vue';
import OrdersCard from '../../Components/OrdersCard.vue';
import {Head, Link} from "@inertiajs/inertia-vue3";
import Panel from "../../Components/Panel.vue";
import NavLink from "../../Components/NavLink.vue";
import {useReadableTime} from "@/Composables/useReadableTime";
import {watch, reactive, computed} from "vue";

defineProps({
    orders: Object
})

let { readableTime } = useReadableTime();
</script>

<template>
    <Head title="Admin Page" />
    <BaseLayout>
        <template v-slot:header>
            <h1 class="font-bold text-xl lg:text-4xl text-indigo-900">Admin Page</h1>
        </template>

        <template v-slot:default>
            <OrdersCard>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 border-b border-sky-300 p-4">
                    <div class="col-span-2 xl:col-span-3 md:mx-8 flex flex-wrap justify-between">
                        <h4 class="font-bold text-xl text-indigo-900 font-serif">
                            Orders
                        </h4>
                        <Link
                            :href=" route('orders.new') "
                            class="p-2 px-4 mr-12 bg-purple-200 text-slate-900 hover:underline border border-slate-700 rounded hover:bg-purple-300 hover:text-slate-800 active:bg-purple-400 active:ring-slate-900 transition ease-in-out hover:duration-500 active:duration-500"
                        >
                            New Order
                        </Link>
                    </div>

                    <div class="col-span-1 pl-8 flex flex-col space-y-3 p-4 rounded">
                        <h4 class="font-semibold text-lg px-3 border-b border-purple-200">New Orders</h4>
                        <div class="mt-3 px-3 text-white flex flex-col space-y-5">
                           <Link :href="route('admin.orders.pending')"
                                      class="p-2 px-3 text-center rounded bg-purple-900 hover:bg-purple-700 underline"
                                >Bidding</Link>
                            <Link :href="route('admin.orders.pending')"
                                      class="p-2 px-3 text-center rounded bg-cyan-900 underline hover:bg-cyan-700"
                                >Pending</Link>
                            <Link :href="route('admin.orders.recents')"
                                      class="p-2 px-3 text-center rounded bg-blue-900 underline hover:bg-blue-700"
                                >Recent/New</Link>
                        </div>
                    </div>

                    <Panel class="col-span-2 pl-8 lg:pl-24">
                        <template v-slot:heading>
                            <h4 class="font-bold text-lg px-3 border-b border-purple-200">Processing Orders...</h4>
                        </template>
                        <template v-slot:default>
                            <div class="mt-3 px-3 text-white flex flex-col space-y-5">
                                <div class="grid grid-cols-2 gap-4">
                                    <Link :href="route('admin.orders.running')"
                                          class="p-2 px-3 text-center rounded bg-sky-900 w-32 hover:bg-sky-700 underline"
                                    >In Progress</Link>
                                    <Link :href="route('admin.orders.submitted')"
                                          class="p-2 px-3 text-center rounded bg-purple-900 w-32 underline hover:bg-purple-700"
                                    >Submitted</Link>
                                    <Link :href="route('admin.orders.completed')"
                                          class="p-2 px-3 text-center rounded w-32 bg-green-900 underline hover:bg-green-700"
                                    >Completed</Link>
                                    <Link :href="route('admin.orders.revision')"
                                          class="p-2 px-3 text-center rounded w-32 bg-amber-900 underline hover:bg-amber-700"
                                    >Revision</Link>
                                    <Link :href="route('admin.orders.disputed')"
                                          class="p-2 px-3 text-center rounded w-32 bg-yellow-900 underline hover:bg-yellow-700"
                                    >Disputed</Link>
                                    <Link :href="route('admin.orders.cancelled')"
                                          class="w-32 p-2 px-3 text-center rounded bg-red-900 underline hover:bg-red-700"
                                    >Cancelled</Link>
                                </div>

                            </div>

                        </template>
                    </Panel>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 md:divide-x mt-8 bg-slate-50">
                    <Panel class="col-span-3">
                        <template v-slot:heading>
                            <h4 class="font-bold text-center text-lg px-3 border-b border-purple-200">Recent Activity</h4>
                        </template>
                        <template v-slot:default>
                            <section class="grid divide-y">
                                <div class="" v-for="order in orders" :key="order.id">
                                    <p class="text-sm flex justify-between space-y-2 items-center py-2 px-3" >
                                        <span class="font-semibold">Order #{{ order.id }}</span>
                                        <span>{{ order.status }}</span>
                                        <span>{{ readableTime(order.due_at) }}</span>
                                        <Link :class="`text-sky-500 hover:text-sky-700 hover:underline`"
                                              :href="route('orders.show', order.id)"
                                        >View</Link>
                                    </p>
                                </div>
                            </section>

                        </template>
                    </Panel>
                    <Panel class="col-span-2">
                        <template #heading>
                            <h4 class="font-semibold px-3 border-b border-purple-200">
                                Tasks - Things todo
                            </h4>
                        </template>
                        <template #default>
                            <section class="grid divide-y">
                                <p class="text-sm flex justify-between space-y-2 items-center py-2 px-3">Do thing 1</p>
                                <p class="text-sm flex justify-between space-y-2 items-center py-2 px-3">Do another thing</p>
                                <p class="text-sm flex justify-between space-y-2 items-center py-2 px-3">Do the last thing</p>
                                <p class="text-sm flex justify-between space-y-2 items-center py-2 px-3">This todo item can be done tomorrow</p>
                            </section>
                        </template>
                        <template #footer>
                            <NavLink>Add New Task</NavLink>
                        </template>
                    </Panel>
                    <div class="col-span-1 flex flex-col space-y-3 p-4 pl-8 rounded">
                        <h4 class="font-semibold px-3 border-b border-purple-200">Users</h4>
                        <div class="mt-3 px-3 text-black flex flex-col space-y-5">
                            <Link :href="route('admin.orders.running')"
                                  class="p-2 px-3 text-center font-bold rounded bg-teal-50 w-32 hover:bg-teal-200 underline"
                            >Clients</Link>
                            <Link :href="route('admin.orders.running')"
                                  class="p-2 px-3 text-center font-bold rounded bg-emerald-50 w-32 hover:bg-emerald-200 underline"
                            >Writers</Link>
                            <Link :href="route('admin.orders.running')"
                                  class="p-2 px-3 text-center font-bold rounded bg-lime-50 w-32 hover:bg-lime-200 underline"
                            >Editors</Link>
                        </div>
                    </div>
                </div>

            </OrdersCard>
        </template>
    </BaseLayout>
</template>
