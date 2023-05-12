<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted } from 'vue'

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
    <div class="min-h-screen sm:pt-0 bg-white">
        <!--navbar-->
        <div style="z-index: 10" class="hidden sm:block min-w-full sticky top-0 right-0 px-6 py-2 place-content-end bg-purple-400 text-white font-semibold" >
            <div class="max-w-5xl mx-auto grid grid-cols-2 place-content-center">
                <!--logo and primary menu items-->
                <div class="flex flex-wrap gap-x-3">
                    <img :class="imgClass" alt="logo" :src="`https://gatewayassignment.com/wp-content/uploads/2023/05/default.png`">
                    <div class="flex gap-x-6 place-self-center">
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


        <div class="mt-2 px-6 py-4 overflow-hidden sm:rounded-lg">
            <header v-if="$slots.header" class="mb-4">
                <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!--content-->
            <slot />

            <!--footer-->
            <footer class="mt-6 lg:mt-12 border-t pb-6">
                <div class="grid md:grid-cols-3 gap-x-6 max-w-5xl mx-auto p-6">
                    <div class="text-slate-600 font-medium text-sm md:text-base flex flex-col gap-y-3">
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

                    <div class="text-slate-600 font-medium text-sm md:text-base flex flex-col gap-y-3">
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

                    <div class="pl-5 text-slate-600 font-medium text-sm md:text-base flex flex-col gap-y-3">
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
