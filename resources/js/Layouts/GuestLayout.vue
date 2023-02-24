<script setup>
import NavLink from '@/Components/NavLink.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';

</script>

<template>
    <div class="min-h-screen sm:pt-0 bg-white">
        <div class="flex justify-between px-6 py-2 bg-slate-100">
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
            <div>
                <div v-if="$page.props.auth.user"  class="flex mt-3 flex-wrap space-x-4 lg:space-x-8">
                    <Link href="/" >
                        Home
                    </Link>

                    <Link :href="route('dashboard')" >
                        Dashboard
                    </Link>

                    <Link :href="route('logout')" method="post" as="button" >
                        Logout
                    </Link>


                </div>

                <div v-else class="flex flex-wrap space-x-4 mt-3 lg:space-x-8">
                    <NavLink :href="route('login')" :active="route().current('login')">
                        Login
                    </NavLink>
                    <NavLink :href="route('register')" :active="route().current('register')">
                        Register
                    </NavLink>
                    <NavLink :href="`/`">
                        Home
                    </NavLink>
                </div>

            </div>

        </div>



        <div class="mt-2 px-6 py-4 overflow-hidden sm:rounded-lg">
            <header v-if="$slots.header" class="mb-4">
                <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
            <slot />
        </div>
    </div>
</template>
