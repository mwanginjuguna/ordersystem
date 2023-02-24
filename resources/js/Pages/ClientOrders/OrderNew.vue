<script setup>

import GuestLayout from "../../Layouts/GuestLayout.vue";
import Accordion from "../../Components/Accordion.vue";
import Modal from "../../Components/Modal.vue";
import InputError from "../../Components/InputError.vue";
import InputLabel from "../../Components/InputLabel.vue";
import TextInput from "../../Components/TextInput.vue";
import Checkbox from "../../Components/Checkbox.vue";
import {defineProps, onMounted, ref} from "vue";
import {useForm, Link} from "@inertiajs/inertia-vue3";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import {parseInt} from "lodash/string";


const amount = ref(null);
const baseRate = ref(null);
const levelRate = ref(null);
const serviceRate = ref(null);
const subjectRate = ref(null);
const spacingRate = ref(null);
const writerRate = ref(null);
const extrasRate = ref(null);
const currencyRate = ref(null);
const discountRate = ref(null);
const discountCode = ref(null);
const discountInvalid = ref(false);
const currencySymbol = ref(null);
const loginUser = ref(false);
const authUser = ref(false);
const registerUser = ref(true);

const props = defineProps({
    order: Object,
    errors: Object,
    services: Object,
    levels: Object,
    subjects: Object,
    rates: Object,
    spacings: Object,
    styles: Object,
    writerCategories: Object,
    extras: Object,
    languages: Object,
    currencies: Object,
    discounts: Object,
});

const form = useForm(
    {
        'title': '',
        'academic_level_id': 2,
        'subject_id': 1,
        'service_type_id': 1,
        'deadline': 336,
        'pages': 1,
        'slides': 0,
        'sources': 1,
        'instructions': '',
        'referencing_style_id': 1,
        'spacing_id': 1,
        'writer_category_id': 1,
        'discount_id': '',
        'currency_id': 2,
        'language_id': 1, 'extra': '',
        'files': [],
        'amount': '',
        'name': '',
        'email': '',
        'password': '',
        'password_confirmation': '',
    }
);

const addOrder = () => {
    // ask user to register or save order to localStorage
    form.post(route('orders.new'), {
        onError: () => { modalClose(); },
        preserveScroll: false,
        onFinish: () => { form.reset(); },

    });
}

onMounted(getPrice);

function checkDiscount()
{
    if (discountCode)
    {
        const discountItem = Object.values(props.discounts).find( (x) => Object.values(x).includes(discountCode.value) );

        if (discountItem !== null && discountItem !== undefined)
        {
            discountInvalid.value = false;
            form.discount_id = Object.values(props.discounts).find((x) => Object.values(x).includes(discountCode.value)).id;
            discountRate.value = Object.values(props.discounts).find((x) => Object.values(x).includes(discountCode.value)).rate;

            getPrice();
        } else
        {
            discountRate.value = null;
            discountInvalid.value = true;
            getPrice();

        }
    }
}

function getPrice() {
    let total = parseInt(Object.values(props.rates).find((x) => Object.values(x).includes(form.deadline)).amount ?? 0);
    baseRate.value = total;
    levelRate.value = Object.values(props.levels).find( (x)=> Object.values(x).includes(form.academic_level_id) ).rate ?? 0;
    subjectRate.value = Object.values(props.subjects).find( (x)=> Object.values(x).includes(form.subject_id) ).rate ?? 0;
    serviceRate.value = Object.values(props.services).find( (x)=> Object.values(x).includes(form.service_type_id) ).rate ?? 0;
    spacingRate.value = Object.values(props.spacings).find( (x)=> Object.values(x).includes(form.spacing_id) ).rate ?? 0;
    writerRate.value = Object.values(props.writerCategories).find( (x)=> Object.values(x).includes(form.writer_category_id) ).rate ?? 0;
    currencyRate.value = Object.values(props.currencies).find( (x)=> Object.values(x).includes(form.currency_id) ).rate ?? 0;
    currencySymbol.value = Object.values(props.currencies).find( (x)=> Object.values(x).includes(form.currency_id) ).symbol;

    let rateTotal = total + total*(levelRate.value/100) + total*(subjectRate.value/100) + total*(serviceRate.value/100) + total*(spacingRate.value/100) + total*(writerRate.value/100)

    let pages = form.pages;
    let slides = form.slides;

    total = (Math.round(
        ((rateTotal * pages) + (rateTotal * slides)
        ) * 100)/ 100)
        .toFixed(2);
    total = total / (currencyRate.value)

    amount.value = total;
    if (discountRate.value !== null)
    {
        amount.value = (Math.round(
            (total - ((discountRate.value / 100) * total))
            * 100)/ 100)
            .toFixed(2);
        form.amount = amount.value;
    } else
    {
        amount.value = (Math.round(total * 100)/ 100)
            .toFixed(2);
        form.amount = amount.value;
    }
}

function modalClose() {
    authUser.value = false;
}

function authenticateUser ()
{
    authUser.value = true;
}

function toggleLoginRegister(value) {
    if (value === 'login') {
        loginUser.value = true;
        registerUser.value = false;
    } else {
        loginUser.value = false;
        registerUser.value = true;
    }
}
const showCalculator = ref(true);
function toggleCalculator() {
    showCalculator.value = !showCalculator.value;
}
</script>

<template>
    <GuestLayout>
        <template #header>
            <h1 class="font-bold sm:font-extrabold text-indigo-900 lg:pr-12 leading-8 text-center text-xl md:text-4xl">
                Create a New Order
            </h1>
            <p class="justify-self-center text-center text-xs text-gray-500 p-4">
                <span class="font-bold">About: </span>Place an order for an assignment or a task.
            </p>
        </template>
            <section>
                <div class="mx-3 md:mx-8 sm:m-2 p-2">
                    <form>
                        <section class="grid grid-cols-7 gap-4">
                            <div class="col-span-7 lg:col-span-5 lg:col-start-2 px-4 py-5 sm:p-6 bg-white md:bg-slate-50 rounded-lg shadow-md shadow-purple-900">
                                <div class="mx-4 mb-4">
                                    <label class="text-sm lg:text-base font-semibold">
                                        Title/Topic <span class="text-red-500 text-xs">* required</span>
                                    </label><br>
                                    <input type="text"
                                           class="border-1 p-2 w-full md:w-4/5 border-gray-400 text-sm rounded"
                                           v-model="form.title"
                                           ref="titleInput"
                                           name="title" id="title"
                                           placeholder="Enter Topic of your Assignment/Paper" required>
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">

                                    <!--Academic Level-->
                                    <div class="mx-4">
                                        <label for="academic_level" class="font-semibold text-sm">
                                            Academic Level
                                        </label>
                                        <select id="academic_level"
                                                v-model="form.academic_level_id"
                                                @change="getPrice"
                                                class="block w-full rounded text-gray-900 text-sm"
                                                name="academic_level" autofocus>
                                            <option disabled value="">Select your school level</option>
                                            <option v-for="level in levels" :value="level.id">{{ level.name }}</option>
                                        </select>
                                    </div>

                                    <!--Service TYpes-->
                                    <div class="mx-4">
                                        <label for="service_type" class="font-semibold text-sm">
                                            Type of Service
                                        </label>

                                        <select id="service_type"
                                                v-model="form.service_type_id"
                                                @change="getPrice"
                                                class="block w-full rounded text-gray-900 text-sm"
                                                name="service_type" autofocus>
                                            <option disabled value="">Select type of service</option>
                                            <option v-for="service in services" :value="service.id">{{ service.name }}</option>
                                        </select>
                                    </div>

                                    <!--Subjects-->
                                    <div class="mx-4">
                                        <label for="subject" class="font-semibold text-sm">
                                            Subject
                                        </label>

                                        <select id="subject"
                                                v-model="form.subject_id"
                                                @change="getPrice"
                                                class="block w-full rounded text-gray-900 text-sm"
                                                name="subject" autofocus>
                                            <option disabled value="">Select your area of study</option>
                                            <option v-for="subject in subjects" :value="subject.id">{{ subject.name }}</option>
                                        </select>
                                    </div>

                                    <!--Deadline-->
                                    <div class="mx-4">
                                        <label for="deadline" class="font-semibold text-sm">
                                            Deadline: <span class="text-red-500 text-xs">* required</span>
                                        </label>

                                        <select id="deadline"
                                                v-model="form.deadline"
                                                @change="getPrice"
                                                class="block w-full rounded text-gray-900 text-sm"
                                                name="deadline" autofocus>
                                            <option disabled value="">Select the deadline</option>
                                            <option v-for="rate in rates" :value="rate.hours">{{ rate.name }}</option>
                                        </select>
                                    </div>

                                    <!--Pages-->
                                    <div class="mx-4">
                                        <label for="pages" class="font-semibold text-sm">
                                            Pages
                                        </label>

                                        <select id="pages"
                                                v-model="form.pages"
                                                @change="getPrice"
                                                class="block w-full rounded text-gray-900 text-sm"
                                                name="pages" autofocus>
                                            <option disabled value="">Select number of Pages</option>
                                            <option :value="0">0 Pages/ 0 words</option>
                                            <option v-for="page in 200" :key="page" :value="page">{{ page }} page(s) / {{ page * 275 }} words</option>
                                        </select>
                                    </div>

                                    <!--slides-->
                                    <div class="mx-4">
                                        <label for="slides" class="font-semibold text-sm">
                                            Slides
                                        </label>

                                        <input id="slides"
                                               v-model="form.slides"
                                               @change="getPrice"
                                               type="number"
                                               class="block w-full rounded text-gray-900 text-sm"
                                               name="slides" autofocus>
                                    </div>

                                    <!--Referencing styles-->
                                    <div class="mx-4">
                                        <label for="referencing_style" class="font-semibold text-sm">
                                            Referencing Style
                                        </label>

                                        <select id="referencing_style"
                                                v-model="form.referencing_style_id"
                                                class="block w-full rounded text-gray-900 text-sm"
                                                name="referencing_style" autofocus>
                                            <option disabled value="">Select Referencing Style</option>
                                            <option v-for="style in styles" :value="style.id">{{ style.name }}</option>
                                        </select>
                                    </div>

                                    <!--Line Spacing-->
                                    <div class="mx-4">
                                        <label for="spacing" class="font-semibold text-sm">
                                            Line Spacing
                                        </label>

                                        <select id="spacing"
                                                v-model="form.spacing_id"
                                                @change="getPrice"
                                                class="block w-full rounded text-gray-900 text-sm"
                                                name="spacing" autofocus>
                                            <option disabled value="">Select line spacing</option>
                                            <option v-for="spacing in spacings" :value="spacing.id">{{ spacing.name }}</option>
                                        </select>
                                    </div>

                                    <!--sources-->
                                    <div class="mx-4">
                                        <label for="sources" class="font-semibold text-sm">
                                            Sources
                                        </label>

                                        <input id="sources"
                                               v-model="form.sources"
                                               type="number"
                                               class="block w-full rounded text-gray-900 text-sm"
                                               name="sources" autofocus>
                                    </div>
                                    <!--Writer Category-->
                                    <div class="m-4">
                                        <label for="writer_category" class="text-sm">
                                            Writer Category:
                                        </label>
                                        <select id="writer_category" class="block w-full md:w-4/5 rounded text-gray-900 text-sm"
                                                v-model="form.writer_category_id"
                                                @change="getPrice"
                                                name="writer_category" autofocus>
                                            <option disabled value="">Select preferred Writer group</option>
                                            <option v-for="category in writerCategories" :value="category.id">{{ category.name }}</option>
                                        </select>
                                    </div>
                                    <!--language-->
                                    <div class="m-4">
                                        <label for="language" class="text-sm">
                                            Language:
                                        </label>
                                        <select id="language"
                                                class="block w-full md:w-4/5 rounded text-gray-900 text-sm"
                                                v-model="form.language_id"
                                                name="language" autofocus>
                                            <option disabled value="">Select preferred Language</option>
                                            <option v-for="language in languages" :value="language.id">{{ language.name }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!--instructions-->
                                <div class="mb-8 m-4">
                                    <label for="instructions" class="block mb-2 text-sm font-semibold dark:text-white">
                                        Instructions:<span class="text-red-500 text-xs">* required</span>
                                    </label>
                                    <textarea id="instructions"
                                              name="instructions" rows="8"
                                              v-model="form.instructions"
                                              class="block p-2.5 w-full text-sm md:text-md shadow-sm shadow-purple-300 bg-white rounded-lg border border-gray-200 focus:ring-blue-300 focus:border-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                              placeholder="Write or Copy-and-Paste Instructions here. You can also attach additional files below ...">
                                    </textarea>
                                    <InputError class="mt-2" :message="form.errors.instructions" />
                                </div>

                                <div class="grid sm:grid-cols-2 md:grid-cols-3">
                                    <div class="m-4">
                                        <p class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">
                                            Additional Features:<span class="text-gray-500 text-xs"> Optional</span>
                                        </p>

                                        <div v-for="extra in extras" class="flex justify-between">
                                            <label for="{{extra.id}}" class="text-sm">
                                                {{extra.name}}:
                                            </label>
                                            <input type="checkbox" id="{{ extra.id }}" name="additional_features"
                                                   v-model="form.extra"
                                                   :value="extra.name"
                                                   class="ml-4 text-sm">
                                        </div>
                                    </div>
                                    <div class="block">
                                        <div class="m-4 mx-8">
                                            <label for="files">Files</label>
                                            <div class="mt-3 text-sm">
                                                <input multiple
                                                       class="text-black"
                                                       type="file" id="files"
                                                       @input="form.files = $event.target.files"
                                                       name="files[]">
                                            </div>

                                        </div>

                                    </div>
                                    <div class="m-4">
                                        <p>Order Price: $ {{ amount }}</p>
                                        <input hidden v-model="form.amount" >
                                    </div>
                                </div>
                                <div class="grid mx-auto my-4">
                                    <div class="">
                                        <PrimaryButton @click="addOrder"
                                                       v-if="$page.props.auth.user"
                                                       class="mx-4 px-8"
                                                       :class="{ 'opacity-25': form.processing }"
                                                       :disabled="form.processing">
                                            Create Order
                                        </PrimaryButton>
                                        <button
                                            @click.prevent="authenticateUser"
                                            v-else
                                            class="mx-4 px-8 font-bold bg-slate-900 text-white p-2 px-4 rounded-lg">
                                            Place Order
                                        </button>
                                    </div>

                                </div>
                            </div>

                            <!--price calculator-->
                            <div class="col-span-6 lg:col-span-1 py-4 px-3">
                                <div class="hidden md:block rounded-lg mx-auto max-w-sm fixed top-56 lg:top-28 right-0 lg:right-12">
                                    <Accordion :show="true" class="text-green-500 text-xs lg:text-sm hover:text-green-500 bg-slate-900 font-semibold bg-opacity-90 p-3 px-6">
                                        <template #title>
                                            <h2 class="font-bold text-center text-green-500 uppercase">Price Calculator</h2>
                                        </template>
                                        <template #content>
                                            <div class="flex-col divide-y items-center lg:mx-auto space-y-1.5 py-2">
                                                <div v-if="levelRate > 0" class="flex flex-row space-x-4 pt-1.5">
                                                    <p>Academic Level Rate</p>
                                                    <p>{{ levelRate }}%</p>
                                                </div>

                                                <div v-if="subjectRate > 0" class="flex justify-between pt-1.5">
                                                    <p>Subject Rate</p><p>{{ subjectRate }}%</p>
                                                </div>
                                                <div  v-if="serviceRate > 0" class="flex justify-between pt-1.5">
                                                    <p>Service Rate</p>
                                                    <p>{{ serviceRate }}%</p>
                                                </div>
                                                <div class="flex justify-between pt-1.5">
                                                    <p>Deadline Rate</p>
                                                    <p>$ {{ baseRate }}</p>
                                                </div>
                                                <div v-if="form.pages > 0" class="flex justify-between pt-1.5">
                                                    <p>Pages Rate</p>
                                                    <p>price x {{ form.pages }}</p>
                                                </div>
                                                <div  v-if="form.slides > 0" class="flex justify-between pt-1.5">
                                                    <p>Slides Rate</p> =
                                                    <p>price x {{ form.slides }}</p>
                                                </div>
                                                <div v-if="writerRate > 0" class="flex justify-between pt-1.5">
                                                    <p>Wr Category Rate</p>
                                                    <p>{{ writerRate }}%</p>
                                                </div>
                                                <div v-if="currencyRate !== 0" class="flex justify-between pt-1.5">
                                                    <p>Currency</p>
                                                    <p>{{ currencyRate }}</p>
                                                </div>
                                                <div v-if="spacingRate > 0" class="flex justify-between pt-1.5">
                                                    <p>Line-spacing Rate</p>
                                                    <p>{{ spacingRate }}%</p>
                                                </div>
                                                <div v-if="extrasRate > 0" class="flex justify-between pt-1.5">
                                                    <p>Extra-features Rate</p>
                                                    <p>$ {{ extrasRate }}</p>
                                                </div>
                                                <div class="pt-1.5">
                                                    <!--Discount-->
                                                    <div>
                                                        <input type="text"
                                                               class="border-1 p-2 w-full text-black border-gray-400 text-sm rounded"
                                                               name="discount" id="discount" v-model="discountCode"
                                                               @change="checkDiscount"
                                                               placeholder="Enter a Discount Code">
                                                        <p v-show="discountInvalid" class="text-xs text-red-400">Invalid/Expired code</p>
                                                    </div>
                                                    <div v-if="discountRate > 0" class="flex justify-between text-green-600">
                                                        <p>Discount </p>
                                                        <p class="font-semibold">{{ discountRate }}% OFF</p>
                                                    </div>

                                                </div>
                                                <div class="flex">
                                                    <div>
                                                        <label for="currency" class="text-sm">
                                                            Currency:
                                                            <select id="currency"
                                                                    class="block w-full md:w-4/5 rounded text-gray-900 text-sm"
                                                                    name="currency"
                                                                    @change="getPrice"
                                                                    v-model="form.currency_id"
                                                                    autofocus>
                                                                <option disabled value="">Select default Currency</option>
                                                                <option v-for="currency in currencies" :value="currency.id">{{ currency.name }} ({{ currency.symbol }})</option>
                                                            </select>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between pt-1.5">
                                                    <p>Total Price</p>
                                                    <p> {{currencySymbol ?? '$'}} <span>{{amount}}</span></p>
                                                </div>
                                            </div>
                                        </template>
                                    </Accordion>
                                </div>
                                <div class="rounded-lg md:hidden mx-auto max-w-sm fixed top-20 right-0 ">
                                    <Accordion :show="false" class="text-green-500 text-xs lg:text-sm hover:text-green-500 bg-slate-900 font-semibold bg-opacity-90 p-3 px-6">
                                        <template #title>
                                            <div>
                                                <h2 @click="toggleCalculator" class="font-bold text-center text-white uppercase">
                                                    <span v-if="showCalculator">Show</span>
                                                    <span v-else>Hide</span>
                                                    Price Calculator</h2>
                                            </div>
                                        </template>
                                        <template #content>
                                            <div class="flex-col divide-y items-center lg:mx-auto space-y-1.5 py-2">
                                                <div v-if="levelRate > 0" class="flex flex-row space-x-4 pt-1.5">
                                                    <p>Academic Level Rate</p>
                                                    <p>{{ levelRate }}%</p>
                                                </div>

                                                <div v-if="subjectRate > 0" class="flex justify-between pt-1.5">
                                                    <p>Subject Rate</p><p>{{ subjectRate }}%</p>
                                                </div>
                                                <div  v-if="serviceRate > 0" class="flex justify-between pt-1.5">
                                                    <p>Service Rate</p>
                                                    <p>{{ serviceRate }}%</p>
                                                </div>
                                                <div class="flex justify-between pt-1.5">
                                                    <p>Deadline Rate</p>
                                                    <p>$ {{ baseRate }}</p>
                                                </div>
                                                <div v-if="form.pages > 0" class="flex justify-between pt-1.5">
                                                    <p>Pages Rate</p>
                                                    <p>price x {{ form.pages }}</p>
                                                </div>
                                                <div  v-if="form.slides > 0" class="flex justify-between pt-1.5">
                                                    <p>Slides Rate</p> =
                                                    <p>price x {{ form.slides }}</p>
                                                </div>
                                                <div v-if="writerRate > 0" class="flex justify-between pt-1.5">
                                                    <p>Wr Category Rate</p>
                                                    <p>{{ writerRate }}%</p>
                                                </div>
                                                <div v-if="currencyRate !== 0" class="flex justify-between pt-1.5">
                                                    <p>Currency</p>
                                                    <p>{{ currencyRate }}</p>
                                                </div>
                                                <div v-if="spacingRate > 0" class="flex justify-between pt-1.5">
                                                    <p>Line-spacing Rate</p>
                                                    <p>{{ spacingRate }}%</p>
                                                </div>
                                                <div v-if="extrasRate > 0" class="flex justify-between pt-1.5">
                                                    <p>Extra-features Rate</p>
                                                    <p>$ {{ extrasRate }}</p>
                                                </div>
                                                <div class="pt-1.5">
                                                    <!--Discount-->
                                                    <div>
                                                        <input type="text"
                                                               class="border-1 p-2 w-full text-black border-gray-400 text-sm rounded"
                                                               name="discount" id="discount" v-model="discountCode"
                                                               @change="checkDiscount"
                                                               placeholder="Enter a Discount Code">
                                                        <p v-show="discountInvalid" class="text-xs text-red-400">Invalid/Expired code</p>
                                                    </div>
                                                    <div v-if="discountRate > 0" class="flex justify-between text-green-600">
                                                        <p>Discount </p>
                                                        <p class="font-semibold">{{ discountRate }}% OFF</p>
                                                    </div>

                                                </div>
                                                <div class="flex">
                                                    <div>
                                                        <label for="currency" class="text-sm">
                                                            Currency:
                                                            <select id="currency"
                                                                    class="block w-full md:w-4/5 rounded text-gray-900 text-sm"
                                                                    name="currency"
                                                                    @change="getPrice"
                                                                    v-model="form.currency_id"
                                                                    autofocus>
                                                                <option disabled value="">Select default Currency</option>
                                                                <option v-for="currency in currencies" :value="currency.id">{{ currency.name }} ({{ currency.symbol }})</option>
                                                            </select>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between pt-1.5">
                                                    <p>Total Price</p>
                                                    <p> {{currencySymbol ?? '$'}} <span>{{amount}}</span></p>
                                                </div>
                                            </div>
                                        </template>
                                    </Accordion>
                                </div>
                            </div>

                        </section>


                        <!--user_register-->
                        <Modal :show="authUser" @close="modalClose" >
                            <div class="flex flex-wrap mx-auto justify-center my-12">
                                <button @click.prevent="toggleLoginRegister('login')"
                                        class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white hover:underline rounded-l-md">
                                    Login
                                </button>
                                <button @click.prevent="toggleLoginRegister('register')"
                                        class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white hover:underline rounded-r-md">
                                    Register
                                </button>
                            </div>
                            <div v-show="registerUser === true" class="max-w-md my-12 mx-auto shadow-md p-8 rounded-lg">
                                <div>
                                    <div>
                                        <div class="flex">
                                            <InputLabel for="name" value="Name" /> <span class="text-red-500 text-xs">* required</span>
                                        </div>

                                        <TextInput
                                            id="name"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.name"
                                            required
                                            autofocus
                                            autocomplete="name"
                                        />

                                        <InputError class="mt-2" :message="form.errors.name" />
                                    </div>

                                    <div class="mt-4">
                                        <div class="flex">
                                            <InputLabel for="email" value="Email" />
                                            <span class="text-red-500 text-xs">* required</span>
                                        </div>


                                        <TextInput
                                            id="email"
                                            type="email"
                                            class="mt-1 block w-full"
                                            v-model="form.email"
                                            required
                                            autocomplete="username"
                                        />

                                        <InputError class="mt-2" :message="form.errors.email" />
                                    </div>

                                    <div class="mt-4">
                                        <div class="flex">
                                            <InputLabel for="password" value="Password" />
                                            <span class="text-red-500 text-xs">* required</span>
                                        </div>


                                        <TextInput
                                            id="password"
                                            type="password"
                                            class="mt-1 block w-full"
                                            v-model="form.password"
                                            required
                                            autocomplete="new-password"
                                        />

                                        <InputError class="mt-2" :message="form.errors.password" />
                                    </div>

                                    <div class="mt-4">
                                        <div class="flex">
                                            <InputLabel for="password_confirmation" value="Confirm Password" />
                                            <span class="text-red-500 text-xs">* required</span>
                                        </div>

                                        <TextInput
                                            id="password_confirmation"
                                            type="password"
                                            class="mt-1 block w-full"
                                            v-model="form.password_confirmation"
                                            required
                                            autocomplete="new-password"
                                        />

                                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        <PrimaryButton @click="addOrder" class="mx-auto py-4 lg:font-semibold bg-green-600 hover:bg-green-500 hover:underline lg:text-base text-teal-50" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Register and Proceed to Checkout >>>
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </div>
                            <div v-if="loginUser === true" class="max-w-md my-12 mx-auto shadow-md p-8 rounded-lg">
                                <form>
                                    <div>
                                        <div class="flex">
                                            <InputLabel for="email" value="Email" />
                                            <span class="text-red-500 text-xs">* required</span>
                                        </div>


                                        <TextInput
                                            id="email"
                                            type="email"
                                            class="mt-1 block w-full"
                                            v-model="form.email"
                                            required
                                            autofocus
                                            autocomplete="username"
                                        />

                                        <InputError class="mt-2" :message="form.errors.email" />
                                    </div>

                                    <div class="mt-4">
                                        <div class="flex">
                                            <InputLabel for="password" value="Password" />
                                            <span class="text-red-500 text-xs">* required</span>
                                        </div>


                                        <TextInput
                                            id="password"
                                            type="password"
                                            class="mt-1 block w-full"
                                            v-model="form.password"
                                            required
                                            autocomplete="current-password"
                                        />

                                        <InputError class="mt-2" :message="form.errors.password" />
                                    </div>

                                    <div class="block mt-4">
                                        <label class="flex items-center">
                                            <Checkbox name="remember" v-model:checked="form.remember" />
                                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        <Link
                                            :href="route('password.request')"
                                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Forgot your password?
                                        </Link>

                                        <PrimaryButton class="ml-4" @click.prevent="addOrder" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Log in
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </Modal>
                        <!--user-login-->

                    </form>
                </div>
            </section>
    </GuestLayout>
</template>
