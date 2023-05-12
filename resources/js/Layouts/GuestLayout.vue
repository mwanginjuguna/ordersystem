<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted } from 'vue'
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

const showingNavigationDropdown = ref(false);
const scrollY = ref(0)
const imgClass = ref('max-w-[4rem]')

// Update the image class based on scroll position
window.addEventListener('scroll', () => {
    scrollY.value = window.scrollY

    if (scrollY.value > 0) {
        imgClass.value = 'max-w-[2rem] h-[2rem] transition-all duration-300'
    } else {
        imgClass.value = 'max-w-[4rem] h-[4rem] transition-all duration-300'
    }
})

onMounted(() => {
    // Initial scroll position
    scrollY.value = window.scrollY
});

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

</script>

<template>
    <div class="relative min-h-screen sm:pt-0 bg-white">
        <!--navbar-->
        <div class="relative">
            <div style="z-index: 10" class="hidden sm:block min-w-full sticky top-0 right-0 px-6 py-2 place-content-center bg-purple-400 text-white font-semibold flex" >
                <div class="flex flex-row gap-x-3">
                    <div class="max-w-5xl mx-auto grid grid-cols-2 place-content-center">
                        <!--logo and primary menu items-->
                        <div class="flex flex-row gap-x-1.5 md:gap-x-3">
                            <img :class="imgClass" alt="logo" :src="`https://gatewayassignment.com/wp-content/uploads/2023/05/default.png`">
                            <div class="flex gap-x-2 md:gap-x-6 place-self-center">
                                <Link :href="`/`" class="p-1 hover:underline underline-offset-4 decoration-dashed">
                                    Home
                                </Link>
                                <Link :href="`/`" class="p-1 hover:underline underline-offset-4 decoration-dashed">
                                    Services
                                </Link>
                                <Link :href="`/`" class="p-1 hover:underline underline-offset-4 decoration-dashed">
                                    Samples
                                </Link>
                                <Link :href="`/`" class="p-1 hover:underline underline-offset-4 decoration-dashed">
                                    Resources
                                </Link>
                            </div>
                        </div>

                        <!--profile info and order now button-->
                        <div class="flex justify-end gap-x-6">
                            <!--auth-->
                            <div class="place-self-center">
                                <Link
                                    v-if="$page.props.auth.user"
                                    :href="route('dashboard')"
                                    class="text-sm text-gray-700 dark:text-gray-500 underline"
                                >Dashboard</Link
                                >

                                <template v-else>
                                    <Link :href="route('login')" class="text-gray-700 dark:text-gray-500 underline">Log in</Link>

                                    <Link
                                        :href="route('register')"
                                        class="ml-4 text-gray-700 dark:text-gray-500 underline"
                                    >Register</Link
                                    >
                                </template>
                            </div>

                            <Link :href="`/orders/new`" class="place-self-center p-2 px-4 font-semibold text-sm md:text-base bg-amber-500 text-white hover:bg-amber-600 rounded-lg shadow-md">
                                Order Now <span class="text-xs">></span>
                            </Link>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Hamburger -->
            <div class="fixed top-0 right-0 sm:hidden z-20 -mr-2 flex place-self-end right-4">
                <button
                    @click="showingNavigationDropdown = !showingNavigationDropdown"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 bg-gray-200 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path
                            :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
            <!-- Responsive Navigation Menu -->
            <div
                :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                class="sm:hidden max-w-xs w-fit shadow-sm rounded-md fixed right-2 top-14 bg-gray-200 p-1"
                style="z-index: 19"
            >
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                        Home
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        My Orders
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('orders.new')" :active="route().current('orders.new')">
                        New Order
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div v-if="$page.props.auth.user" class="px-4">
                        <div class="font-medium text-base text-gray-800">
                            {{ $page.props.auth.user.name  }}
                        </div>
                        <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                            Log Out
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </div>

        <!--main content-->
        <div class="overflow-hidden">
            <header v-if="$slots.header" class="mb-4">
                <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!--content-->
            <slot />

            <!--footer-->
            <footer class="mt-6 lg:mt-12 border-t pb-6">
                <div class="grid md:grid-cols-3 gap-6 divide-y md:divide-y-0 max-w-5xl mx-auto p-6">
                    <div class="pt-3 text-slate-600 font-medium text-sm md:text-base flex flex-col gap-y-3">
                        <p class="pb-6 font-bold text-lg text-slate-700">Company</p>

                        <Link :href="`/about`" class="hover:text-blue-500 hover:underline underline-offset-4">
                            What We Do
                        </Link>

                        <Link :href="`/services`" class="hover:text-blue-500 hover:underline underline-offset-4">
                            Resources
                        </Link>

                        <Link :href="`/blog`" class="hover:text-blue-500 hover:underline underline-offset-4">
                            Blog
                        </Link>

                        <Link :href="`/orders/new`" class="hover:text-blue-500 hover:underline underline-offset-4">
                            Order Now
                        </Link>

                    </div>

                    <div class="pt-3 text-slate-600 font-medium text-sm md:text-base flex flex-col gap-y-3">
                        <p class="pb-6 font-bold text-lg text-slate-700">Links</p>

                        <Link :href="`/sample-case-studies`" class="hover:text-blue-500 hover:underline underline-offset-4">
                            Sample Case Studies
                        </Link>

                        <Link :href="`/orders/new`" class="hover:text-blue-500 hover:underline underline-offset-4">
                            Write My Case Study
                        </Link>

                        <Link :href="`/case-study-assignment-help`" class="hover:text-blue-500 hover:underline underline-offset-4">
                            Case Study Assignment Help
                        </Link>

                        <Link :href="`/faq`" class="hover:text-blue-500 hover:underline underline-offset-4">
                            FAQ
                        </Link>

                    </div>

                    <div class="pt-3 md:pl-5 text-slate-600 font-medium text-sm md:text-base flex flex-col gap-y-3">
                        <p class="pb-6 font-bold text-lg text-slate-700">Contact Us</p>

                        <Link :href="`mailto:info@casestudypro.com`" class="hover:text-blue-500 hover:underline underline-offset-4">
                            info@casestudypro.com
                        </Link>

                        <Link :href="`/orders/new`" class="hover:text-blue-500 underline underline-offset-4">
                            Place an Order
                        </Link>

                        <Link :href="`/orders/new`" class="p-2 px-3 w-fit hover:text-slate-50 text-slate-200 font-semibold bg-purple-500 hover:bg-purple-600 border rounded shadow-md hover:underline underline-offset-4">
                            Chat with an expert
                        </Link>

                    </div>

                </div>
            </footer>
        </div>
    </div>
</template>
