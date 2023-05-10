<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import SubForm from "@/Pages/SubForm.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative min-h-screen bg-gray-50 dark:bg-gray-900 sm:pt-0"
    >
        <!--navbar-->
        <div v-if="canLogin" style="z-index: 10" class="hidden min-w-full sticky top-0 right-0 px-6 py-4 sm:block place-content-end bg-slate-200" >
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="text-sm text-gray-700 dark:text-gray-500 underline"
                >Dashboard</Link
            >

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"
                    >Register</Link
                >
            </template>
        </div>

        <div class="sm:px-6 lg:px-12 py-4 lg:py-12">
            <div class="max-w-7xl grid lg:grid-cols-3 h-full pt-8 sm:pt-0 gap-2">
                <div class="pb-10 px-8 lg:col-span-2">
                    <h1 class="text-center lg:text-left text-3xl  lg:text-5xl text-slate-700 font-extrabold font-serif uppercase">Technical Case Study Experts</h1>

                    <p class="mt-9 md:py-2 px-4 text-justify text-slate-600 font-medium text-xl border-l-4">
                        Looking for case study writing assistance? Our team of talented and experienced writers can help with custom writing, editing, and research services. <br>
                        Our case study writers, analysts, and researchers are Ph.D. experts dedicated to providing technical case study help across the world.
                    </p>

                    <button type="submit" class="mt-9 mb-4 p-2 bg-purple-600 hover:bg-purple-700 text-slate-50 rounded-md text-xl font-bold font-serif flex flex-row">
                        Write My Case Study
                        <span id="blinking-cursor" class="text-sm pl-1">|</span>
                    </button>

                    <div class="mt-9">
                        <p class="text-slate-600 text-lg font-medium">We have served <span class="text-xl font-bold text-purple-900">450+</span> happy customers.</p>
                        <p class="mt-3 text-purple-500 font-semibold underline underline-offset-4">Starts at $14.00 per page (275 words)</p>
                    </div>

                    <!--stats-->
                    <div class="mt-3 pt-8 grid lg:grid-cols-2 gap-5 text-sm border-t">

                        <div class="flex flex-row gap-x-6 border rounded-md border-purple-500 p-1 px-3 bg-white">
                            <svg class="h-[34px] w-[34px] place-self-center" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 58 58" xml:space="preserve" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle style="fill:#6b21a8;" cx="29" cy="29" r="29"></circle> <path style="fill:#FFFFFF;" d="M10,32c-1.104,0-2-0.896-2-2c0-7.72,6.28-14,14-14h14c1.104,0,2,0.896,2,2s-0.896,2-2,2H22 c-5.514,0-10,4.486-10,10C12,31.104,11.104,32,10,32z"></path> <path style="fill:#FFFFFF;" d="M26.002,28c-0.618,0-1.228-0.285-1.619-0.823c-0.65-0.894-0.452-2.145,0.44-2.794L33.6,18 l-8.776-6.383c-0.893-0.649-1.091-1.9-0.44-2.794c0.648-0.892,1.899-1.091,2.794-0.44L40.4,18l-13.224,9.617 C26.821,27.876,26.409,28,26.002,28z"></path> <path style="fill:#FFFFFF;" d="M35,42H21c-1.104,0-2-0.896-2-2s0.896-2,2-2h14c5.514,0,10-4.486,10-10c0-1.104,0.896-2,2-2 s2,0.896,2,2C49,35.72,42.72,42,35,42z"></path> <path style="fill:#FFFFFF;" d="M30.998,50c-0.407,0-0.819-0.124-1.175-0.383L16.6,40l13.224-9.617 c0.895-0.652,2.144-0.452,2.794,0.44c0.65,0.894,0.452,2.145-0.44,2.794L23.4,40l8.776,6.383c0.893,0.649,1.091,1.9,0.44,2.794 C32.227,49.715,31.616,50,30.998,50z"></path> </g></svg>
                            <div>
                                <p class="pb-1 border-b border-purple-200 w-full text-base font-semibold text-purple-700">
                                    200+ Returning Customers
                                </p>
                                <p><strong>Tested and Trusted</strong> by over 200 individuals and businesses.</p>
                            </div>
                        </div>

                        <div class="flex flex-row gap-x-6 border rounded-md border-purple-500 p-1 px-3 bg-white">
                            <svg class="h-[34px] w-[34px] place-self-center" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 58 58" xml:space="preserve" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle style="fill:#6b21a8;" cx="29" cy="29" r="29"></circle> <path style="fill:#FFFFFF;" d="M10,32c-1.104,0-2-0.896-2-2c0-7.72,6.28-14,14-14h14c1.104,0,2,0.896,2,2s-0.896,2-2,2H22 c-5.514,0-10,4.486-10,10C12,31.104,11.104,32,10,32z"></path> <path style="fill:#FFFFFF;" d="M26.002,28c-0.618,0-1.228-0.285-1.619-0.823c-0.65-0.894-0.452-2.145,0.44-2.794L33.6,18 l-8.776-6.383c-0.893-0.649-1.091-1.9-0.44-2.794c0.648-0.892,1.899-1.091,2.794-0.44L40.4,18l-13.224,9.617 C26.821,27.876,26.409,28,26.002,28z"></path> <path style="fill:#FFFFFF;" d="M35,42H21c-1.104,0-2-0.896-2-2s0.896-2,2-2h14c5.514,0,10-4.486,10-10c0-1.104,0.896-2,2-2 s2,0.896,2,2C49,35.72,42.72,42,35,42z"></path> <path style="fill:#FFFFFF;" d="M30.998,50c-0.407,0-0.819-0.124-1.175-0.383L16.6,40l13.224-9.617 c0.895-0.652,2.144-0.452,2.794,0.44c0.65,0.894,0.452,2.145-0.44,2.794L23.4,40l8.776,6.383c0.893,0.649,1.091,1.9,0.44,2.794 C32.227,49.715,31.616,50,30.998,50z"></path> </g></svg>
                            <div>
                                <p class="pb-1 border-b border-purple-200 w-full text-base font-semibold text-purple-700">
                                    7K+ Approved Case Studies
                                </p>
                                <p>
                                    Professional case studies delivered to our esteemed customers. We are <em>Growing Fast!</em>
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-row gap-x-6 border rounded-md border-purple-500 p-1 px-3 bg-white">
                            <svg class="h-[34px] w-[34px] place-self-center" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 58 58" xml:space="preserve" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle style="fill:#6b21a8;" cx="29" cy="29" r="29"></circle> <path style="fill:#FFFFFF;" d="M10,32c-1.104,0-2-0.896-2-2c0-7.72,6.28-14,14-14h14c1.104,0,2,0.896,2,2s-0.896,2-2,2H22 c-5.514,0-10,4.486-10,10C12,31.104,11.104,32,10,32z"></path> <path style="fill:#FFFFFF;" d="M26.002,28c-0.618,0-1.228-0.285-1.619-0.823c-0.65-0.894-0.452-2.145,0.44-2.794L33.6,18 l-8.776-6.383c-0.893-0.649-1.091-1.9-0.44-2.794c0.648-0.892,1.899-1.091,2.794-0.44L40.4,18l-13.224,9.617 C26.821,27.876,26.409,28,26.002,28z"></path> <path style="fill:#FFFFFF;" d="M35,42H21c-1.104,0-2-0.896-2-2s0.896-2,2-2h14c5.514,0,10-4.486,10-10c0-1.104,0.896-2,2-2 s2,0.896,2,2C49,35.72,42.72,42,35,42z"></path> <path style="fill:#FFFFFF;" d="M30.998,50c-0.407,0-0.819-0.124-1.175-0.383L16.6,40l13.224-9.617 c0.895-0.652,2.144-0.452,2.794,0.44c0.65,0.894,0.452,2.145-0.44,2.794L23.4,40l8.776,6.383c0.893,0.649,1.091,1.9,0.44,2.794 C32.227,49.715,31.616,50,30.998,50z"></path> </g></svg>
                            <div>
                                <p class="pb-1 border-b border-purple-200 w-full font-semibold text-base text-purple-700">
                                    3.1k+ Average Monthly Users
                                </p>
                                <p>
                                    Our case study services have a global audience of more than 3K readers and customers.
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-row gap-x-6 border rounded-md border-purple-500 p-1 px-3 bg-white">
                            <svg class="h-[34px] w-[34px] place-self-center" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 58 58" xml:space="preserve" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle style="fill:#6b21a8;" cx="29" cy="29" r="29"></circle> <path style="fill:#FFFFFF;" d="M10,32c-1.104,0-2-0.896-2-2c0-7.72,6.28-14,14-14h14c1.104,0,2,0.896,2,2s-0.896,2-2,2H22 c-5.514,0-10,4.486-10,10C12,31.104,11.104,32,10,32z"></path> <path style="fill:#FFFFFF;" d="M26.002,28c-0.618,0-1.228-0.285-1.619-0.823c-0.65-0.894-0.452-2.145,0.44-2.794L33.6,18 l-8.776-6.383c-0.893-0.649-1.091-1.9-0.44-2.794c0.648-0.892,1.899-1.091,2.794-0.44L40.4,18l-13.224,9.617 C26.821,27.876,26.409,28,26.002,28z"></path> <path style="fill:#FFFFFF;" d="M35,42H21c-1.104,0-2-0.896-2-2s0.896-2,2-2h14c5.514,0,10-4.486,10-10c0-1.104,0.896-2,2-2 s2,0.896,2,2C49,35.72,42.72,42,35,42z"></path> <path style="fill:#FFFFFF;" d="M30.998,50c-0.407,0-0.819-0.124-1.175-0.383L16.6,40l13.224-9.617 c0.895-0.652,2.144-0.452,2.794,0.44c0.65,0.894,0.452,2.145-0.44,2.794L23.4,40l8.776,6.383c0.893,0.649,1.091,1.9,0.44,2.794 C32.227,49.715,31.616,50,30.998,50z"></path> </g></svg>
                            <div>
                                <p class="pb-1 border-b border-purple-200 w-full font-semibold text-base text-purple-700">
                                    17 Top Writers and Analysts
                                </p>
                                <p>
                                    A diverse team of Talented Writers and Researchers 7 countries collaborating remotely.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!--mini form-->
                <div class="lg:col-span-1 px-2 mx-auto">
                    <!--subform-->
                    <SubForm
                        :levels="$page.props.levels"
                        :rates="$page.props.rates"
                        :services="$page.props.services"
                        :currencies="$page.props.currencies"
                    ></SubForm>
                </div>
            </div>

            <div class="lg:mt-16 mt-36 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6 my-auto">
                        <h2 class="pb-10 text-slate-800 font-extrabold text-4xl lg:text-[4rem] font-serif">Our Services</h2>
                        <div class="pb-3 flex flex-row gap-4">
                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                class="w-5 h-5 text-gray-500"
                            >
                                <path
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                ></path>
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold">
                                <a href="orders/new" class="underline text-gray-900 dark:text-white"
                                    >Professional Research and Writing Case Study Services</a
                                >
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Our services are academic-based, specifically designed to help students with homework and assignments from school. We diversify these services into three major groups.
                            </div>
                        </div>
                    </div>

                    <div class="border">
                        <div class="grid divide-y divide-purple-300">
                            <div class="grid grid-cols-5 p-1 px-3 bg-gray-100">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 504 504" xml:space="preserve" height="64px" class="place-self-center" width="64px" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect x="26" y="2" style="fill:#ffffff;" width="368" height="496"></rect> <rect x="26" y="2" style="fill:#33A5D2;" width="368" height="68"></rect> <polygon style="fill:#d100ca;" points="483.6,438 462,497.2 440,438 "></polygon> <rect x="438" y="34" style="fill:#5200a3;" width="44" height="404"></rect> <path style="fill:#d100ca;" d="M482,34.8V10.4c0-6.4-4-8.8-10.8-8.8h-18.8c-6.8,0-14.4,2.4-14.4,8.8v24.4H482z"></path> <path d="M392,504H24c-2.4,0-4-1.6-4-4V4c0-2.4,1.6-4,4-4h368c2.4,0,4,1.6,4,4v496C396,502.4,394.4,504,392,504z M28,496h360V8H28 V496z"></path> <path d="M392,76H24c-2.4,0-4-1.6-4-4V4c0-2.4,1.6-4,4-4h368c2.4,0,4,1.6,4,4v68C396,74.4,394.4,76,392,76z M28,68h360V8H28V68z"></path> <path d="M350,148H70c-2.4,0-4-1.6-4-4s1.6-4,4-4h280c2.4,0,4,1.6,4,4S352.4,148,350,148z"></path> <path d="M126,188H70c-2.4,0-4-1.6-4-4s1.6-4,4-4h56c2.4,0,4,1.6,4,4S128.4,188,126,188z"></path> <path d="M350,188H162c-2.4,0-4-1.6-4-4s1.6-4,4-4h188c2.4,0,4,1.6,4,4S352.4,188,350,188z"></path> <path d="M350,228h-32c-2.4,0-4-1.6-4-4s1.6-4,4-4h32c2.4,0,4,1.6,4,4S352.4,228,350,228z"></path> <path d="M282,228H70c-2.4,0-4-1.6-4-4s1.6-4,4-4h212c2.4,0,4,1.6,4,4S284.4,228,282,228z"></path> <path d="M350,268H70c-2.4,0-4-1.6-4-4s1.6-4,4-4h280c2.4,0,4,1.6,4,4S352.4,268,350,268z"></path> <path d="M350,388H70c-2.4,0-4-1.6-4-4s1.6-4,4-4h280c2.4,0,4,1.6,4,4S352.4,388,350,388z"></path> <path d="M126,308H70c-2.4,0-4-1.6-4-4s1.6-4,4-4h56c2.4,0,4,1.6,4,4S128.4,308,126,308z"></path> <path d="M350,308H162c-2.4,0-4-1.6-4-4s1.6-4,4-4h188c2.4,0,4,1.6,4,4S352.4,308,350,308z"></path> <path d="M350,348h-32c-2.4,0-4-1.6-4-4s1.6-4,4-4h32c2.4,0,4,1.6,4,4S352.4,348,350,348z"></path> <path d="M282,348H70c-2.4,0-4-1.6-4-4s1.6-4,4-4h212c2.4,0,4,1.6,4,4S284.4,348,282,348z"></path> <path d="M126,428H70c-2.4,0-4-1.6-4-4s1.6-4,4-4h56c2.4,0,4,1.6,4,4S128.4,428,126,428z"></path> <path d="M350,428H162c-2.4,0-4-1.6-4-4s1.6-4,4-4h188c2.4,0,4,1.6,4,4S352.4,428,350,428z"></path> <path d="M458,498.8c-1.6,0-3.2-1.2-3.6-2.8l-22-59.2c0-0.4-0.4-0.8-0.4-1.2V34c0-2.4,1.6-4,4-4s4,1.6,4,4v400.4l18,48.4l18-48.4V34 c0-2.4,1.6-4,4-4c2.4,0,4,1.6,4,4v401.2c0,0.4,0,0.8-0.4,1.2l-22,59.2C461.2,497.6,459.6,498.8,458,498.8z"></path> <path d="M478,444h-40c-2.4,0-4-1.6-4-4s1.6-4,4-4h40c2.4,0,4,1.6,4,4S480.4,444,478,444z"></path> <path d="M480,42c-2.4,0-4-1.6-4-4V10.8c0-1.2,0-2,0-2.4C475.2,8,472.8,8,471.2,8h-23.6c-7.6,0-7.6,0.8-7.6,2.8V38c0,2.4-1.6,4-4,4 s-4-1.6-4-4V10.8C432,0,442,0,447.6,0h23.6c6.4,0,12.8,0,12.8,10.8V38C484,40.4,482.4,42,480,42z"></path> <path d="M478,40h-40c-2.4,0-4-1.6-4-4s1.6-4,4-4h40c2.4,0,4,1.6,4,4S480.4,40,478,40z"></path> <path d="M466,428h-28c-2.4,0-4-1.6-4-4s1.6-4,4-4h28c2.4,0,4,1.6,4,4S468.4,428,466,428z"></path> </g></svg>
                                <div class="mt-2 col-span-4">
                                    <p class="text-2xl font-semibold text-purple-900 underline underline-offset-4">Case Study Writing Service</p>
                                    <p class="py-2">
                                        Get a Professionally researched, analyzed, and articulated case study for your next project. Our talented team of researchers and writers will help you in writing any case study your specific use case.
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-5 p-1 px-3 bg-gray-100">
                                <svg class="place-self-center" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 507.6 507.6" xml:space="preserve" width="64px" height="64px" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier">
                                    <path style="fill:#EF934A;" d="M461.4,473.6c0,17.6-14.4,28-32,28h-356c-17.6,0-24-10.4-24-28v-396c0-17.6,6.4-32,24-32h356 c17.6,0,32,14.4,32,32V473.6z"></path> <rect x="81.4" y="69.6" style="fill:#F4EFEF;" width="348" height="404"></rect> <path style="fill:#FFC52F;" d="M353.4,89.6V56.8c0-17.6-11.6-31.2-29.2-31.2H283C279.4,13.6,269,6,256.2,6 c-12.4,0-23.2,7.6-26.8,19.6h-41.6c-17.6,0-34.8,13.6-34.8,31.2v32.8H353.4z"></path> <path style="fill:#F4EFEF;" d="M256.6,40.8c-6.8,0-12-5.2-12-12s5.2-12,12-12s12,5.2,12,12S263,40.8,256.6,40.8z"></path> <path d="M427.4,479.6h-348c-2.4,0-4-1.6-4-4v-404c0-2.4,1.6-4,4-4h70c2.4,0,4,1.6,4,4s-1.6,4-4,4h-66v396h340v-396h-70 c-2.4,0-4-1.6-4-4s1.6-4,4-4h74c2.4,0,4,1.6,4,4v404C431.4,477.6,429.8,479.6,427.4,479.6z"></path> <path d="M432.6,507.6h-356c-19.2,0-32.8-14.8-32.8-35.2V77.2c0-20,13.2-33.6,32.8-33.6h73.2c2.4,0,4,1.6,4,4s-1.6,4-4,4H76.6 c-15.2,0-24.8,10-24.8,25.6v395.2c0,16,10.4,27.2,24.8,27.2h356c16.8,0,23.2-14,23.2-27.2V77.2c0-16.4-8.4-25.6-23.2-25.6h-78.8 c-2.4,0-4-1.6-4-4s1.6-4,4-4h78.8c19.2,0,31.2,12.8,31.2,33.6v395.2C463.4,493.6,451.4,507.6,432.6,507.6z"></path> <path d="M256.6,44.8c-8.8,0-16-7.2-16-16s7.2-16,16-16s16,7.2,16,16S265.4,44.8,256.6,44.8z M256.6,20.8c-4.4,0-8,3.6-8,8s3.6,8,8,8 s8-3.6,8-8S261,20.8,256.6,20.8z"></path> <path d="M351.4,91.6h-200c-2.4,0-4-1.6-4-4V52.8c0-20,21.2-33.2,40.8-33.2H227C231.8,7.6,243,0,256.6,0s24.8,7.6,29.6,19.6h38.4 c19.2,0,31.2,12.8,31.2,33.2v34.8C355.4,89.6,353.8,91.6,351.4,91.6z M155.4,83.6h192V52.8c0-16-8.4-25.2-23.2-25.2H283 c-1.6,0-3.2-1.2-4-2.8C276.2,14.4,267,8,256.2,8s-20,6.4-22.8,16.8c-0.4,1.6-2,2.8-4,2.8h-41.6c-16,0-32.8,10-32.8,25.2v30.8H155.4z "></path> <path d="M390.6,195.6h-164c-2.4,0-4-1.6-4-4s1.6-4,4-4h164c2.4,0,4,1.6,4,4S393,195.6,390.6,195.6z"></path> <path d="M274.6,259.6h-48c-2.4,0-4-1.6-4-4s1.6-4,4-4h48c2.4,0,4,1.6,4,4S277,259.6,274.6,259.6z"></path> <path d="M390.6,259.6h-80c-2.4,0-4-1.6-4-4s1.6-4,4-4h80c2.4,0,4,1.6,4,4S393,259.6,390.6,259.6z"></path> <path d="M390.6,387.6h-48c-2.4,0-4-1.6-4-4s1.6-4,4-4h48c2.4,0,4,1.6,4,4S393,387.6,390.6,387.6z"></path> <path d="M306.6,387.6h-80c-2.4,0-4-1.6-4-4s1.6-4,4-4h80c2.4,0,4,1.6,4,4S309,387.6,306.6,387.6z"></path> <path d="M390.6,323.6h-164c-2.4,0-4-1.6-4-4s1.6-4,4-4h164c2.4,0,4,1.6,4,4S393,323.6,390.6,323.6z"></path> <path d="M157,205.2c-1.2,0-2-0.4-2.8-1.2l-19.6-19.6c-1.6-1.6-1.6-4,0-5.6s4-1.6,5.6,0l16.8,16.8l33.2-33.2c1.6-1.6,4-1.6,5.6,0 s1.6,4,0,5.6l-36,36C159,204.8,158.2,205.2,157,205.2z"></path> <path d="M157,269.2c-1.2,0-2-0.4-2.8-1.2l-19.6-19.6c-1.6-1.6-1.6-4,0-5.6s4-1.6,5.6,0l16.8,16.8l33.2-33.2c1.6-1.6,4-1.6,5.6,0 s1.6,4,0,5.6l-36,36C159,268.8,158.2,269.2,157,269.2z"></path> <path d="M157,332.8c-1.2,0-2-0.4-2.8-1.2L134.6,312c-1.6-1.6-1.6-4,0-5.6s4-1.6,5.6,0l16.8,16.8l33.2-33.2c1.6-1.6,4-1.6,5.6,0 s1.6,4,0,5.6l-36,36C159,332.4,158.2,332.8,157,332.8z"></path> <path d="M157,396.8c-1.2,0-2-0.4-2.8-1.2L134.6,376c-1.6-1.6-1.6-4,0-5.6s4-1.6,5.6,0l16.8,16.8l33.2-33.2c1.6-1.6,4-1.6,5.6,0 s1.6,4,0,5.6l-36,36C159,396.8,158.2,396.8,157,396.8z"></path> </g></svg>
                                <div class="mt-2 col-span-4">
                                    <p class="text-2xl font-semibold text-purple-900 underline underline-offset-4">Case Study Proofreading and Editing</p>
                                    <p class="py-2">
                                        Adding professional tone, settings, details, ensuring grammatical errors, and setting the mood to ensure your case study and reports deliver the intended message to your audience.
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-5 p-1 px-3 bg-gray-100">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 504 504" xml:space="preserve"
                                     class="place-self-center"
                                     width="64px"
                                     height="64px"
                                     fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0">
                                    </g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier">
                                    <rect x="32" y="57" style="fill:#F4EFEF;" width="440" height="324"></rect> <rect x="16" y="25" style="fill:#E36D60;" width="472" height="32"></rect> <path style="fill:#54B265;" d="M363.6,218.6c0,61.2-49.6,110.4-110.4,110.4c-61.2,0-110.4-49.6-110.4-110.4 c0-61.2,49.6-110.4,110.4-110.4C314,107.8,363.6,157.4,363.6,218.6z"></path> <path style="fill:#F4EFEF;" d="M234.8,267.8c-7.6,5.2-14.8,2-14.8-7.2v-84.4c0-8.8,7.2-12,14.8-7.2l60,40c7.6,5.2,7.6,13.2-0.4,18.4 L234.8,267.8z"></path> <path d="M470,387H30c-2.4,0-4-1.6-4-4V61c0-2.4,1.6-4,4-4s4,1.6,4,4v318h432V61c0-2.4,1.6-4,4-4s4,1.6,4,4v322 C474,385.4,472.4,387,470,387z"></path> <path d="M486,63h-34c-2.4,0-4-1.6-4-4s1.6-4,4-4h30V31H18v24h398c2.4,0,4,1.6,4,4s-1.6,4-4,4H14c-2.4,0-4-1.6-4-4V27 c0-2.4,1.6-4,4-4h472c2.4,0,4,1.6,4,4v32C490,61.4,488.4,63,486,63z"></path> <path d="M500,31H4c-2.4,0-4-1.6-4-4s1.6-4,4-4h496c2.4,0,4,1.6,4,4S502.4,31,500,31z"></path> <path d="M250,29c-2.4,0-4-1.6-4-4V5c0-2.4,1.6-4,4-4s4,1.6,4,4v20C254,27.4,252.4,29,250,29z"></path> <path d="M250,501c-2.4,0-4-1.6-4-4V385c0-2.4,1.6-4,4-4s4,1.6,4,4v112C254,499.4,252.4,501,250,501z"></path> <path d="M368,503H136c-2.4,0-4-1.6-4-4s1.6-4,4-4h232c2.4,0,4,1.6,4,4S370.4,503,368,503z"></path> <path d="M226.4,273.8c-2,0-4.4-0.4-6-1.6c-4-2.4-6.4-6.4-6.4-12v-84.4c0-5.2,2.4-9.6,6.4-12c4.4-2.4,10.4-2,15.6,1.6l60.4,40 c4.8,3.2,7.2,7.2,7.2,12s-2.8,9.6-8,12.8l-60,40l0,0C232.8,273,229.6,273.8,226.4,273.8z M226.4,171c-0.8,0-1.6,0-2.4,0.4 c-2,1.2-2.4,3.6-2.4,4.8v84.4c0,1.2,0.4,4,2.4,4.8s4.8,0.4,7.2-1.2l60-40c2.8-1.6,4.4-4,4.4-6s-1.2-4-3.6-5.6l-60.4-40 C230,171.4,228,171,226.4,171z"></path> <path d="M252.8,333c-63.2,0-114.4-51.2-114.4-114.4c0-63.2,51.2-114.4,114.4-114.4s114.4,51.2,114.4,114.4 C367.6,281.4,316,333,252.8,333z M252.8,111.8c-58.8,0-106.4,47.6-106.4,106.4S194,324.6,252.8,324.6c58.8,0,106.4-47.6,106.4-106.4 C359.6,159.8,311.6,111.8,252.8,111.8z"></path> </g></svg>
                                <div class="mt-2 col-span-4">
                                    <p class="text-2xl font-semibold text-purple-900 underline underline-offset-4">
                                        Slides/PowerPoint Presentations
                                    </p>
                                    <p class="py-2">
                                        Confidence Gains! Deliver powerful presentation and showcase the results or summaries of your case study with professionally designed PowerPoint Presentations. Our returning customers use our services to deliver successful presentations of their case studies in shows, talks, conferences, and corporate events.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-3 md:mt-6 py-4 md:py-10 md:px-10 lg:px-16 px-3 md:col-span-2 font-serif">
                <div class="px-3 py-20 border rounded-md text-slate-700">
                    <h3 class="text-slate-700 text-center font-bold text-3xl">
                        How It Works: <span class="text-purple-700 italic">Simple. Secure. Confidential.</span>
                    </h3>

                    <ol class="mt-6 px-6 md:pl-14 max-w-4xl grid place-content-center">
                        <li>
                            <div class="pl-2 mt-3 pb-3 flex gap-x-6 border-b">
                                <svg class="place-self-center" height="30px" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 392.566 392.566" xml:space="preserve" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#56ACE0;" d="M311.857,285.43h-73.374c-17.39,29.737-31.547,51.523-33.099,53.915 c-4.331,6.659-13.964,6.659-18.295,0c-1.552-2.392-15.709-24.178-33.099-53.915H80.681l-50.618,85.333h332.412L311.857,285.43z"></path> <path style="fill:#FFFFFF;" d="M102.855,115.216c2.78,49.907,79.968,176.485,93.414,197.948 c32.582-52.17,93.414-157.543,93.414-197.947c0-51.523-41.891-93.414-93.414-93.414S100.01,63.758,102.855,115.216z"></path> <path style="fill:#7e38ff;" d="M196.269,43.588c-39.499,0-71.628,32.129-71.628,71.628c0,10.667,6.788,30.319,17.648,54.368h60.38 c6.206,0,11.313,5.042,11.313,11.313c0,6.206-5.042,11.313-11.313,11.313h-49.713c2.651,5.301,5.43,10.796,8.275,16.291h21.204 c6.271,0,11.313,5.042,11.313,11.313c0,6.271-5.042,11.313-11.313,11.313h-9.18c7.37,13.382,15.063,26.958,23.014,40.339 c38.012-64.065,71.628-132.267,71.628-156.186C267.897,75.717,235.768,43.588,196.269,43.588z"></path> <g> <path style="fill:#194F82;" d="M391.049,376.065l-63.612-107.119c-1.939-3.297-5.56-5.301-9.374-5.301h-66.974 c28.768-51.006,60.444-114.877,60.444-148.428c0-63.547-51.717-115.2-115.2-115.2s-115.2,51.717-115.2,115.2 c0,33.552,31.677,97.422,60.444,148.428H74.54c-3.879,0-7.434,2.004-9.374,5.301L1.554,376.065 c-4.331,7.24,0.905,16.485,9.374,16.485H381.61C390.079,392.55,395.315,383.37,391.049,376.065z M102.855,115.216 c-2.844-51.459,41.891-93.414,93.414-93.414s93.414,41.891,93.414,93.414c0,40.404-60.768,145.842-93.414,197.948 C182.823,291.766,105.635,165.123,102.855,115.216z M30.063,370.764L30.063,370.764l50.618-85.333h73.309 c17.39,29.737,31.547,51.523,33.099,53.915c4.331,6.659,13.964,6.659,18.295,0c1.552-2.392,15.709-24.178,33.099-53.915h73.309 l50.618,85.333H30.063z"></path> <path style="fill:#194F82;" d="M140.544,102.416h12.671v20.04c0,5.56-3.556,6.206-4.848,6.206c-2.78,0-5.495-1.422-8.016-4.202 l-4.978,6.788c3.814,3.879,8.275,5.883,13.382,5.883c4.073,0,13.964-1.487,13.964-15.127V94.271h-22.174 C140.544,94.271,140.544,102.416,140.544,102.416z"></path> <path style="fill:#194F82;" d="M257.231,124.978c0.323-7.37-6.012-9.762-8.663-10.279c0.711-0.323,6.271-2.069,6.271-9.18 c0-11.313-12.218-11.313-15.063-11.313h-16.549v42.602h18.618C247.663,136.808,256.778,135.321,257.231,124.978z M232.665,102.158 h4.59c2.78,0,4.784,0.323,5.947,0.905c1.164,0.582,1.745,1.939,1.745,3.814c0,1.939-0.646,3.168-1.939,3.685 c-1.228,0.517-3.232,0.84-5.883,0.84h-4.461L232.665,102.158L232.665,102.158z M232.665,128.727H232.6v-9.762h5.624 c3.103,0,5.43,0.323,6.853,0.905c1.487,0.646,2.133,1.875,2.133,3.879c0,1.939-0.646,3.232-2.004,3.943 c-1.293,0.711-3.426,1.034-6.077,1.034H232.665z"></path> <path style="fill:#194F82;" d="M215.081,115.216c0-8.339-5.883-22.044-22.303-22.044c-14.869,0-22.303,11.83-22.303,22.044 c0,8.339,5.947,22.044,22.303,22.044C207.582,137.261,215.081,125.43,215.081,115.216z M192.713,128.921 c-6.465,0-12.606-5.689-12.671-13.705h0.065c0-6.594,4.848-13.705,12.671-13.705c6.594,0,12.671,5.689,12.606,13.705 C205.384,121.81,200.471,128.921,192.713,128.921z"></path> </g> </g></svg>
                                <p class="max-w-xl place-self-center text-justify">
                                    <span class="text-lg font-bold text-slate-700 font-mono">Place an Order: </span>Select the service you need and provide us with the necessary details, such as the topic, deadline, and any specific requirements.
                                </p>
                            </div>
                        </li>

                        <li>
                            <div class="pl-2 mt-3 pb-3 flex gap-x-6 border-b">
                                <svg class="place-self-center" height="30px" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 392.591 392.591" xml:space="preserve" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#FFFFFF;" d="M207.35,258.844c0-38.271,31.16-69.366,69.366-69.366c8.986,0,17.519,1.745,25.471,4.913V31.483 c0-5.301-4.331-9.632-9.632-9.632H77.928c-5.301,0-9.632,4.331-9.632,9.632v263.499c0,5.301,4.331,9.632,9.632,9.632h146.877 C213.944,292.461,207.35,276.493,207.35,258.844z"></path> <path style="fill:#FFC10D;" d="M263.463,123.927c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925h16.808 V82.683H243.94c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925h36.331v-6.4 c0-6.012-4.848-10.925-10.925-10.925H100.942c-6.012,0-10.925,4.848-10.925,10.925v217.471c0,6.012,4.848,10.925,10.925,10.925 h110.739c-2.78-7.499-4.396-15.58-4.396-24.048c0-38.271,31.16-69.366,69.366-69.366c1.228,0,2.457,0.065,3.62,0.129v-65.681 h-16.808V123.927z"></path> <g> <path style="fill:#FFFFFF;" d="M163.455,102.4c6.594,0,11.96-5.301,11.96-11.96c0-6.659-5.43-11.96-11.96-11.96 s-11.96,5.43-11.96,11.96S156.926,102.4,163.455,102.4z"></path> <path style="fill:#FFFFFF;" d="M201.338,172.154c0-3.168-1.681-6.077-4.396-7.564c-3.814-2.069-7.822-3.814-11.96-5.172 l-14.222,16.097c-4.202,4.655-12.218,4.655-16.291,0l-14.222-16.097c-4.202,1.422-8.21,3.103-11.96,5.172 c-2.715,1.487-4.396,4.396-4.396,7.564v18.941h77.64v-18.941H201.338z"></path> </g> <g> <path style="fill:#56ACE0;" d="M262.752,326.788v31.806l7.046-5.818c4.008-3.232,9.762-3.232,13.77,0l7.046,5.818v-31.806 c-4.461,0.905-9.18,1.422-13.899,1.422C271.867,328.275,267.213,327.693,262.752,326.788z"></path> <path style="fill:#56ACE0;" d="M276.651,211.329c-26.182,0-47.515,21.333-47.515,47.515c0,26.182,21.333,47.515,47.515,47.515 s47.515-21.333,47.515-47.515C324.296,232.663,302.962,211.329,276.651,211.329z"></path> </g> <g> <path style="fill:#194F82;" d="M163.455,124.186c18.618,0,33.745-15.127,33.745-33.745s-15.127-33.81-33.745-33.81 S129.71,71.758,129.71,90.376S144.837,124.186,163.455,124.186z M163.455,78.416c6.594,0,11.96,5.43,11.96,11.96 s-5.43,11.96-11.96,11.96s-11.96-5.301-11.96-11.96C151.496,83.717,156.926,78.416,163.455,78.416z"></path> <path style="fill:#194F82;" d="M207.35,145.39c-7.37-4.008-15.321-7.046-23.661-8.986c-3.943-0.905-7.952,0.388-10.667,3.426 l-10.602,11.96l-10.602-11.96c-2.651-3.038-6.723-4.331-10.667-3.426c-8.339,1.939-16.291,4.978-23.661,8.986 c-9.762,5.301-15.774,15.515-15.774,26.764v29.802c0,6.012,4.848,10.925,10.925,10.925h99.426c6.012,0,10.925-4.848,10.925-10.925 v-29.802C223.124,160.97,217.112,150.691,207.35,145.39z M201.209,191.095h-77.511v-18.941c0-3.168,1.681-6.077,4.396-7.564 c3.814-2.069,7.822-3.814,11.96-5.172l14.222,16.097c4.202,4.655,12.218,4.655,16.291,0l14.222-16.097 c4.202,1.422,8.21,3.103,11.96,5.172c2.715,1.487,4.396,4.396,4.396,7.564v18.941H201.209z"></path> <path style="fill:#194F82;" d="M185.177,245.786h-68.008c-6.012,0-10.925,4.848-10.925,10.925c0,6.012,4.848,10.925,10.925,10.925 h68.008c6.012,0,10.925-4.848,10.925-10.925C196.102,250.634,191.189,245.786,185.177,245.786z"></path> <path style="fill:#194F82;" d="M323.973,208.226V31.547C323.973,14.158,309.815,0,292.554,0H77.928 c-17.39,0-31.547,14.158-31.547,31.547v263.499c0,17.39,14.158,31.547,31.547,31.547h163.038v55.079 c0,9.18,10.667,14.287,17.778,8.404l18.036-14.675l18.036,14.675c7.111,5.818,17.778,0.776,17.778-8.404v-63.418 c20.105-12.154,33.616-34.133,33.616-59.345C346.082,238.933,337.548,220.897,323.973,208.226z M224.676,304.679H77.928 c-5.43,0-9.762-4.331-9.762-9.632V31.547c0-5.301,4.331-9.632,9.632-9.632H292.36c5.301,0,9.632,4.331,9.632,9.632v162.909 c-7.887-3.168-16.485-4.913-25.471-4.913c-38.271,0-69.366,31.16-69.366,69.366C207.221,276.428,213.88,292.461,224.676,304.679z M290.744,358.594h-0.065l-7.046-5.818c-4.008-3.232-9.762-3.232-13.77,0l-7.046,5.818v-31.806 c4.461,0.905,9.18,1.422,13.964,1.422c4.784,0,9.438-0.453,13.899-1.422v31.806H290.744z M276.651,306.36 c-26.182,0-47.515-21.333-47.515-47.515c0-26.182,21.333-47.515,47.515-47.515s47.515,21.333,47.515,47.515 C324.296,285.026,302.962,306.36,276.651,306.36z"></path> </g> </g></svg>
                                <p class="max-w-xl place-self-center text-justify">
                                    <span class="text-lg font-bold text-slate-700 font-mono">Assigning the Expert: </span>We match your project with the most qualified writer/editor/designer in your field, ensuring that they understand your industry and can deliver exceptional results.
                                </p>
                            </div>
                        </li>

                        <li>
                            <div class="pl-2 mt-3 pb-3 flex gap-x-6 border-b">
                                <svg class="place-self-center" height="30px" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 392.598 392.598" xml:space="preserve" fill="#000000">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#FFC10D;" d="M86.885,72.663c13.964,0,25.406-11.442,25.406-25.406s-11.442-25.406-25.406-25.406 S61.479,33.293,61.479,47.257S72.921,72.663,86.885,72.663z"></path> <g> <path style="fill:#56ACE0;" d="M140.929,145.519c-7.37-4.008-15.127-7.176-23.337-9.438l-20.428,57.341 c-3.426,9.632-17.067,9.632-20.558,0l-20.558-57.341c-8.21,2.263-15.903,5.43-23.337,9.438 c-6.788,3.685-11.055,11.119-11.055,19.329v48.42H151.79v-48.42h0.129C151.984,156.638,147.717,149.204,140.929,145.519z"></path> <path style="fill:#56ACE0;" d="M305.778,179.265c-13.964,0-25.406,11.442-25.406,25.406c0,13.964,11.378,25.406,25.406,25.406 c13.964,0,25.406-11.442,25.406-25.406C331.184,190.707,319.741,179.265,305.778,179.265z"></path> </g> <path style="fill:#FFC10D;" d="M370.812,322.327c0-8.21-4.267-15.58-11.055-19.329c-7.37-4.008-15.127-7.176-23.337-9.438 l-20.299,57.277c-3.426,9.632-17.067,9.632-20.558,0l-20.558-57.341c-8.21,2.263-15.903,5.43-23.337,9.438 c-6.788,3.685-11.055,11.119-11.055,19.329v48.42h130.133v-48.356H370.812z"></path> <g> <path style="fill:#6741be;" d="M86.885,94.449c26.053,0,47.192-21.204,47.192-47.192c0-26.053-21.204-47.192-47.192-47.192 S39.693,21.269,39.693,47.257S60.897,94.449,86.885,94.449z M86.885,21.786c13.964,0,25.406,11.442,25.406,25.406 s-11.442,25.406-25.406,25.406S61.479,61.22,61.479,47.192S72.921,21.786,86.885,21.786z"></path> <path style="fill:#6741be;" d="M173.77,224.194v-59.345c0-16.226-8.598-30.966-22.432-38.465 c-11.96-6.594-25.018-11.184-38.659-13.834c-5.236-1.034-10.537,2.004-12.347,7.046l-13.446,37.689l-13.446-37.689 c-1.745-5.107-7.046-8.016-12.347-7.046c-13.705,2.651-26.634,7.24-38.659,13.834C8.598,133.883,0,148.622,0,164.849v59.345 c0,6.012,4.848,10.925,10.925,10.925h151.919C168.921,235.055,173.77,230.206,173.77,224.194z M152.113,213.269H21.851v-48.42 c0-8.21,4.267-15.58,11.055-19.329c7.37-4.008,15.127-7.176,23.337-9.438L76.8,193.422c3.491,9.632,17.067,9.632,20.558,0 l20.428-57.341c8.21,2.263,15.903,5.43,23.337,9.438c6.788,3.685,11.055,11.119,11.055,19.329v48.42H152.113z"></path> <path style="fill:#6741be;" d="M370.166,283.798c-11.96-6.594-25.018-11.184-38.659-13.834c-5.236-1.034-10.537,2.004-12.348,7.046 l-13.446,37.689l-13.446-37.689c-1.745-5.107-7.046-8.016-12.347-7.046c-13.705,2.651-26.634,7.24-38.659,13.834 c-13.834,7.499-22.432,22.238-22.432,38.465v59.345c0,6.012,4.848,10.925,10.925,10.925h151.919 c6.012,0,10.925-4.848,10.925-10.925v-59.281C392.598,306.101,384,291.297,370.166,283.798z M370.941,370.747H240.679v-48.42 c0-8.21,4.267-15.58,11.055-19.329c7.37-4.008,15.127-7.176,23.337-9.438l20.558,57.341c3.491,9.632,17.067,9.632,20.558,0 l20.428-57.341c8.21,2.263,15.903,5.43,23.337,9.438c6.788,3.685,11.055,11.119,11.055,19.329v48.42H370.941z"></path> <path style="fill:#6741be;" d="M258.521,204.671c0,26.053,21.204,47.192,47.192,47.192c26.053,0,47.192-21.204,47.192-47.192 c0-26.053-21.204-47.192-47.192-47.192S258.521,178.618,258.521,204.671z M331.184,204.671c0,13.964-11.442,25.406-25.406,25.406 c-13.964,0-25.406-11.442-25.406-25.406c0-13.964,11.378-25.406,25.406-25.406C319.741,179.265,331.184,190.707,331.184,204.671z"></path> <path style="fill:#6741be;" d="M181.204,315.087c-9.956,6.788-26.182,9.891-37.43,7.952c-17.842-2.457-33.099-12.606-42.085-27.798 l-0.259-0.453l17.713,4.461c5.883,1.487,11.766-2.069,13.188-7.887c1.487-5.883-2.069-11.766-7.887-13.188l-43.766-11.055 c-5.883-1.487-11.766,2.069-13.188,7.887l-11.055,43.766c-1.487,5.883,2.069,11.766,7.887,13.188 c5.883,1.487,11.766-2.069,13.188-7.887l4.784-18.747c10.925,17.778,27.669,31.612,47.774,37.172 c35.556,9.051,58.246-6.335,61.802-8.339c5.301-3.038,7.176-9.826,4.008-15.063C192.84,313.923,186.376,312.242,181.204,315.087z"></path> <path style="fill:#6741be;" d="M248.889,69.301c17.842,2.457,33.099,12.606,42.085,27.798l0.259,0.453l-17.713-4.461 c-5.883-1.487-11.766,2.069-13.188,7.887c-1.487,5.883,2.069,11.766,7.887,13.188l43.766,11.055 c5.883,1.487,11.766-2.069,13.188-7.887l11.055-43.766c1.487-5.883-2.069-11.766-7.887-13.188 c-5.883-1.487-11.766,2.069-13.188,7.887l-4.784,18.747c-10.925-17.778-27.669-31.612-47.774-37.172 c-35.556-9.051-58.246,6.335-61.802,8.339c-5.301,3.038-7.176,9.826-4.008,15.063c3.038,5.107,9.568,6.788,14.675,3.943 C221.414,70.465,237.64,67.362,248.889,69.301z"></path> </g> </g></svg>
                                <p class="max-w-xl place-self-center text-justify">
                                    <span class="text-lg font-bold text-slate-700 font-mono">Collaboration and Communication: </span>Stay in touch with your assigned expert throughout the process. You can provide feedback, ask questions, and monitor the progress of your case study.
                                </p>
                            </div>
                        </li>

                        <li>
                            <div class="pl-2 mt-3 pb-3 flex gap-x-6">
                                <svg class="place-self-center" height="30px" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 392.792 392.792" xml:space="preserve" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#FFFFFF;" d="M21.851,269.244h181.592c-2.069-6.723-3.232-13.899-3.232-21.398 c0-39.693,32.323-72.016,72.016-72.016s72.016,32.323,72.016,72.016c0,7.434-1.164,14.61-3.232,21.398h29.802V21.907H21.851V269.244 z"></path> <path style="fill:#8c26f2;" d="M344.048,245.713c2.909-1.939,4.978-5.301,4.978-9.115V54.683c0-6.012-4.848-10.925-10.925-10.925 H54.626c-6.012,0-10.925,4.848-10.925,10.925v181.915c0,6.012,4.848,10.925,10.925,10.925H200.21"></path> <g> <path style="fill:#FFC10D;" d="M257.293,318.311v37.495l7.176-7.046c4.267-4.202,10.99-4.202,15.192,0l7.176,7.046v-37.495 c-4.784,1.034-9.762,1.552-14.869,1.552C267.119,319.862,262.141,319.345,257.293,318.311z"></path> <path style="fill:#FFC10D;" d="M322.392,247.911c0-27.669-22.497-50.23-50.23-50.23c-16.485,0-31.095,8.016-40.275,20.299 c6.659,0,14.545-0.065,21.915-0.065h0.065c6.012,0,10.925,4.848,10.925,10.796c0.065,6.012-4.784,10.99-10.796,10.99 c-9.568,0.065-28.962,0.065-31.354,0.065c-0.453,2.65-0.711,5.301-0.711,8.145c0,2.844,0.323,5.495,0.711,8.21 c3.879,0,9.051-0.065,13.834-0.065c6.271-0.065,10.99,4.719,11.055,10.731c0.065,6.012-4.719,10.99-10.731,11.055 c-1.745,0-3.297,0.065-4.848,0.065c9.18,12.283,23.725,20.234,40.21,20.234C299.895,298.076,322.392,275.58,322.392,247.911z"></path> </g> <g> <path style="fill:#194F82;" d="M324.396,74.012H68.267c-6.012,0-10.925-4.848-10.925-10.925s4.848-10.925,10.925-10.925h256 c6.012,0,10.925,4.848,10.925,10.925S330.408,74.012,324.396,74.012z"></path> <path style="fill:#194F82;" d="M324.396,114.157H68.267c-6.012,0-10.925-4.848-10.925-10.925c0-6.077,4.848-10.925,10.925-10.925 h256c6.012,0,10.925,4.848,10.925,10.925C335.192,109.244,330.408,114.157,324.396,114.157z"></path> <path style="fill:#194F82;" d="M324.396,154.303H68.267c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925 h256c6.012,0,10.925,4.848,10.925,10.925C335.192,149.39,330.408,154.303,324.396,154.303z"></path> <path style="fill:#194F82;" d="M178.101,194.448H68.267c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925 h109.834c6.012,0,10.925,4.848,10.925,10.925C188.962,189.535,184.113,194.448,178.101,194.448z"></path> <path style="fill:#194F82;" d="M174.287,234.529H68.267c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925 h106.02c6.012,0,10.925,4.848,10.925,10.925C185.212,229.616,180.364,234.529,174.287,234.529z"></path> <path style="fill:#194F82;" d="M381.737,0.121H10.925C4.913,0.121,0,4.969,0,11.046v269.123c0,6.012,4.848,10.925,10.925,10.925 h203.766c5.624,7.499,12.735,13.834,20.816,18.683v71.952c0,9.632,11.572,14.545,18.554,7.822l18.101-17.713l18.166,17.713 c6.853,6.723,18.554,1.875,18.554-7.822v-71.952c8.145-4.784,15.127-11.184,20.881-18.683h52.105 c6.012,0,10.925-4.848,10.925-10.925V10.982C392.598,4.969,387.749,0.121,381.737,0.121z M287.03,355.806l-7.176-7.046 c-4.267-4.202-10.99-4.202-15.192,0l-7.176,7.046v-37.495c4.784,1.034,9.762,1.552,14.869,1.552c5.107,0,10.02-0.517,14.869-1.552 v37.495H287.03z M272.226,298.076c-16.485,0-31.095-7.952-40.21-20.234c1.552,0,3.103,0,4.848-0.065 c6.012-0.065,10.796-5.042,10.731-11.055c-0.065-6.012-4.784-10.796-11.055-10.731c-4.784,0.065-9.956,0.065-13.834,0.065 c-0.453-2.715-0.711-5.43-0.711-8.21c0-2.78,0.323-5.495,0.711-8.145c2.327,0.065,21.721,0,31.354-0.065 c6.012-0.065,10.925-4.913,10.796-10.99c-0.065-6.012-4.913-10.796-10.925-10.796h-0.065c-7.434,0.065-15.386,0.065-21.915,0.065 c9.18-12.283,23.725-20.299,40.275-20.299c27.669,0,50.23,22.497,50.23,50.23C322.392,275.58,299.895,298.076,272.226,298.076z M370.812,269.244H341.01c2.069-6.723,3.232-13.899,3.232-21.398c0-39.693-32.323-72.016-72.016-72.016 s-72.016,32.388-72.016,72.081c0,7.434,1.164,14.61,3.232,21.398H21.851V21.907h348.962L370.812,269.244L370.812,269.244z"></path> </g> </g></svg>
                                <p class="max-w-xl place-self-center text-justify">
                                    <span class="text-lg font-bold text-slate-700 font-mono">Delivery and Revisions: </span>We deliver the completed work within the agreed-upon timeframe. If you require any revisions, we'll be happy to make them until you're completely satisfied.
                                </p>
                            </div>
                        </li>
                    </ol>

                </div>
            </div>
        </div>
    </div>
</template>
