<script setup>
import Accordion from './Accordion.vue';
import NavLink from "../Components/NavLink.vue";
import {Link} from "@inertiajs/inertia-vue3";

</script>

<template>
    <div>
        <h4 class="font-bold">Sidebar</h4>
    </div>
    <div class="flex flex-col space-y-6 mt-3">
        <div class="flex items-center">
            <Link href="/orders/new" class="bg-purple-600 text-xs lg:text-base hover:bg-purple-700 underline flex items-center justify-center text-gray-100 py-2 rounded lg:space-x-2 transition duration-150 px-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>New Order</span>
            </Link>
        </div>
        <Accordion :show="true">
            <template v-slot:title>
                <span class="font-semibold"> Orders</span>
            </template>
            <template v-slot:content>
                <Link :href="route('orders.pending')" class="pt-3 flex flex-wrap space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#49eefc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
                    <span>Pending</span>
                </Link>
                <Link href="/orders/recents" class="pt-3 flex flex-wrap space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#c10bf5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 17l5-5-5-5"/><path d="M13.8 12H3m9 10a10 10 0 1 0 0-20"/></svg>
                    <span>Recent</span>
                </Link>
                <Link :href="route('orders.submitted')" class="pt-3 flex flex-wrap space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#0b19f5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5"/></svg>
                    <span>Submitted</span>
                </Link>

                <Link :href="route('orders.completed')" class="pt-3 flex flex-wrap space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#0bf519" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>Completed</span>
                </Link>

                <Link :href="route('orders.running')" class="pt-3 flex flex-wrap space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#0bf5c4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon><line x1="3" y1="22" x2="21" y2="22"></line></svg>
                    <span>In Progress</span>
                </Link>

                <Link :href="route('orders.revision')" class="pt-3 flex flex-wrap space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#f5cf0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 2v6h6M2.66 15.57a10 10 0 1 0 .57-8.38"/></svg>
                    <span>Revisions</span>
                </Link>

                <Link :href="route('orders.disputed')" class="pt-3 flex flex-wrap space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    <span>Disputed</span>
                </Link>

                <Link href="/orders/cancelled" class="pt-3 flex flex-wrap space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#f5230b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                    <span>Cancelled</span>
                </Link>

            </template>
        </Accordion>

        <ul class="mt-2 flex flex-col space-y-3">
            <li>
                <Link class="pt-3 flex flex-wrap space-x-4 bg-gray-700 rounded p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#d946ef" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <span>Messages</span>
                </Link>
            </li>
            <li>
                <Link class="pt-3 flex flex-wrap space-x-4 bg-gray-700 rounded p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                    <span>Emails</span>
                </Link>
            </li>
            <li>
                <Link class="pt-3 flex flex-wrap space-x-4 bg-gray-700 rounded p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#6d28d9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                    <span>Tasks</span>
                </Link>
            </li>
            <li>
                <Link href="/client/writers" class="pt-3 flex flex-wrap space-x-4 bg-gray-700 rounded p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#28d9ba" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Writers</span>
                </Link>
            </li>
        </ul>

    </div>
</template>
