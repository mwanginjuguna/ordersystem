<script setup>

import BaseLayout from "../../Layouts/BaseLayout.vue";
import {computed, defineProps, nextTick, onMounted, reactive, ref} from "vue";
import {Link, useForm, usePage} from "@inertiajs/inertia-vue3";
import OrdersCard from "../../Components/OrdersCard.vue";
import Modal from "../../Components/Modal.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import {useFlash} from "@/Composables/useFlash";
import TextInput from "../../Components/TextInput.vue";
import InputError from "../../Components/InputError.vue";

function showComplete() {
    return (orderObject.status in ['pending', 'new', 'submitted', 'cancelled']);
}

let { flash } = useFlash();
const pageUser = computed(() => {
    return usePage().props.value.auth.user;
})

let changeInstructions = ref(false);
const instructionsInput = ref(null);
const orderObject = reactive(props.order);
let confirmComplete = ref(false);
let confirmRevision = ref(false);
let confirmCancel = ref(false);
let confirmAssign = ref(false);
let confirmExtend = ref(false);
let confirmDispute = ref(false);
let showMessage = ref(false);
const receiver = ref('')

const props = defineProps({
    order: Object,
    level: String,
    spacing: String,
    subject: String,
    service: String,
    style: String,
    discount: String,
    language: String,
    writerCategory: String,
    user: String,
    client_id: Number,
    writers: Object,
    writer: String,
    writer_id: Number,
    deadline: String,
    discountAmount: Number,
    currencySymbol: String,
    files: Array,
    senderMessages: Object,
    adminMessages: Object,
    response: String
});

const form = useForm({
    'instructions': orderObject.instructions,
    'status': orderObject.status,
    'assigned_to': orderObject.assigned_to ?? '',
    'revision_instructions': orderObject.revision_instructions,
    'cancel_reason': orderObject.cancel_reason,
    'hours': 0,
    'review': '',
    'stars': 5,
    'writerDeadline': '',
    'message': '',
    'files': [],
    'fileType': ''
});

const orderForm = useForm({
    'file': ''
})

function uploadFiles(id) {
    form.post(route('admin.orders.upload-file', id), {
        onFinish: () => form.reset(),
    });
    form.files = [];
}

function downloadFile(id, filename) {
    fetch(route('admin.files.download', id))
        .then( (response) => {
            return response.blob()
        }).then( (data) => {
            console.log(data)
        let blob = new Blob([data]);
            const url = URL.createObjectURL(blob);
            const a = Object.assign(
                document.createElement('a'),
                {
                    href: url,
                    style:"display: none",
                    download:filename
                });
            console.log(a)
            document.body.appendChild(a);
            a.click();
            URL.revokeObjectURL(url);
            a.remove();
    })
    ;
    //route('admin.files.download', id);
}

function updateInstructions(id) {
    console.log(id);
    form.post(route('admin.orders.show', id), {
        preserveScroll: true,
        onSuccess: () => modalClose(),
        onError: () => instructionsInput.value.focus(),
        onFinish: () => form.reset(),
    });
}

function modalShow() {
    changeInstructions.value = true;
    nextTick(() => instructionsInput.value.focus());
}

function modalClose() {
    changeInstructions.value = false;
}

function deleteOrder(id) {
    if (confirm("Are you sure? Order will be completely deleted from the records.")) {
        form.delete(route('admin.orders.delete', id));
    }
}

function extendDeadline(id) {
    if (confirm("You are adjusting the deadline of the order. Continue?")) {
        form.patch(route('admin.orders.extend', id),
            {
                onSuccess: () => confirmExtend.value = false,
                onFinish: () => form.reset()
            }
        );
    }
}

function markCompleted(id) {
        if (confirm("Confirmation. This Order will be marked as completed.")) {
        form.patch(route('admin.orders.complete', id),
            {
                onSuccess: () => confirmComplete.value = false,
                onFinish: () => form.reset()
            }
        );
    }
}

function assignWriter(id) {
    form.patch(route('admin.orders.assign', id),
        {
            onSuccess: () => confirmAssign.value = false,
            onFinish: () => form.reset()
        }
    );
}

function cancelOrder(id) {
    if (confirm("Confirmation. This Order will be cancelled.")) {
        form.patch(route('admin.orders.cancel', id),
            {
                onSuccess: () => confirmCancel.value = false,
                onFinish: () => form.reset()
            }
        );
    }
}

function disputeOrder(id) {
    if (confirm("Confirmation. This Order will be cancelled.")) {
        form.patch(route('admin.orders.dispute', id),
            {
                onSuccess: () => confirmDispute.value = false,
                onFinish: () => form.reset()
            }
        );
    }
}

function requestRevision(id) {
    if (confirm("Confirmation. This Order will be placed under revision.")) {
        form.post(route('admin.orders.revisionRequest', id),
            {
                onSuccess: () => confirmRevision.value = false,
                onFinish: () => form.reset(),
            }
        );
    }
}

const messages = ref([]);
const orderMessages = ref([]);
onMounted(() => {
    loadMessages();
    // let orderMessages = loadMessages();
    // messages.value = Array.from( orderMessages);
})

function loadMessages() {
    return fetch(route('show.messages', props.order.id), {
        method: 'post',
        body: JSON.stringify({
            'order_id': props.order.id,
            'user_id': pageUser.value.id,
            'writer_id': props.writer_id,
            'receiver': receiver.value
        })
    }).then(function(res) {
        return res.json();
    }).then(function(messageData) {
        orderMessages.value = [];
        console.log(JSON.stringify(messageData));
        orderMessages.value.push(messageData);
        messages.value = orderMessages.value[0].messages;
        console.log("order messages: "+ JSON.stringify(orderMessages.value));
        return messageData;
    });
    // showMessage.value = true;
}

function sendMessage() {
    fetch(route('send.message', props.order.id), {
        method: 'post',
        body: JSON.stringify({
            'order_id': props.order.id,
            'user_id': pageUser.value.id,
            'writer_id': props.writer_id,
            'receiver': receiver.value,
            'message': form.message
        })
    }).then(function(res) {
        return res.json();
    }).then(function(messageData) {
        form.reset('message');
        console.log(messageData);
        orderMessages.value = messageData
        messages.value = orderMessages.value[0].messages;
        console.log("order messages: "+orderMessages)
        return messageData;
    });
    showMessage.value = false;
    loadMessages();
    showMessage.value = true;
}

function toggleMessage()
{
    showMessage.value = true;
}

function getTime(timestamp) {
    const dateString = timestamp;
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / (1000 * 60));
    const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
    const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));

    if (diffMins < 60) {
        return (diffMins + " minutes ago");
    } else if (diffHours < 24) {
        return (diffHours + " hours ago");
    } else {
        return (diffDays + " days ago");
    }
}
</script>

<template>
    <BaseLayout>
        <template #header>
            <h1 class="font-bold sm:font-extrabold text-indigo-900 leading-8 text-center text-xl md:text-4xl">
                <span class="font-bold">Order #{{order.id}}: </span>{{ order.title }}.
            </h1>
            <p class="justify-self-center text-center text-base text-gray-500 p-4 border-b border-purple-100">
                Order Details
            </p>
        </template>
        <OrdersCard>
            <div class="mx-auto p-4 lg:py-5 lg:px-8 grid grid-cols-3 gap-3 lg:flex lg:flex-wrap lg:space-x-6">
                <button
                    @click.prevent="toggleMessage()"
                    class="text-lime-500 hover:text-lime-600 font-semibold underline px-4 py-2 bg-slate-800 hover:bg-slate-900 rounded-lg flex flex-wrap">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#33d420" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></span>
                    <span class="pl-2">Order Messages</span>
                </button>
                <button @click.prevent="deleteOrder( order.id )" class="text-red-500 hover:text-red-600 underline">
                    Delete Order
                </button>

                <button @click.prevent="confirmExtend = true" class="text-fuchsia-500 hover:text-fuchsia-600 underline">Extend Deadline
                </button>

                <button @click.prevent="confirmAssign = true"
                        v-if="!writer"
                        class="text-purple-500 hover:text-purple-600 underline">
                    Assign Writer
                </button>

                <button @click="confirmComplete = true" v-if="order.status !== 'completed'" class="text-green-500 hover:text-green-600 underline">
                    Mark Complete
                </button>

                <button @click.prevent="confirmRevision = true" class="text-sky-500 hover:text-sky-600 underline">
                    Request Revision
                </button>

                <button  @click.prevent="confirmCancel = true" class="text-yellow-500 hover:text-yellow-600 underline">
                    Cancel
                </button>

                <button @click="confirmDispute = true"
                        v-if="order.status === 'cancelled'"
                        class="text-sky-500 hover:text-sky-600 underline">
                    Dispute
                </button>

            </div>
            <section class="mt-5 grid md:grid-cols-2 rounded font-serif py-2 px-3 lg:py-5 lg:px-8">

                <!--order details-->
                <div class="col-span-1">
                    <div class="p-3 grid gap-2">
                        <h3 class="text-md md:text-lg font-semibold lg:font-bold mb-3">
                            Order Details
                        </h3>
                        <div class="flex flex-col space-y-2.5 text-sm lg:px-4">
                            <p class="border-b">Academic Level:
                                <span class="ml-4 md:text-sm text-gray-600">{{ level }}</span></p>
                            <p class="border-b">Service Type:
                                <span class="ml-4 md:text-sm text-gray-600">{{ service }}</span></p>
                            <p class="border-b">Subject:
                                <span class="ml-4 md:text-sm text-gray-600">{{ subject }}</span></p>
                            <p class="border-b">Spacing:
                                <span class="ml-4 md:text-sm text-gray-600">{{ spacing }}</span></p>
                            <p class="border-b">Referencing Style:
                                <span class="ml-4 md:text-sm text-gray-600">{{ style }}</span></p>
                            <p class="border-b">Sources:
                                <span class="ml-4 md:text-sm text-gray-600">{{ order.sources }} references/sources</span></p>
                            <p class="border-b" v-if="order.pages > 0">Pages:
                                <span class="ml-4 md:text-sm text-gray-600">{{order.pages}} Pages/{{ order.pages*275 }} words</span></p>
                            <p class="border-b" v-if="order.slides > 0">Slides:
                                <span class="ml-4 md:text-sm text-gray-600">{{order.slides}} Slides</span></p>
                            <p class="border-b">Deadline:
                                <span v-if="deadline.endsWith('ago')" class="ml-4 md:text-sm text-red-600">
                                    {{ deadline }}</span>
                                <span v-if="deadline.endsWith('now')" class="ml-4 md:text-sm text-lime-600">
                                    {{ deadline }}</span>
                            </p>
                            <p class="border-b">Language:
                                <span class="ml-4 md:text-sm text-gray-600">{{ language }}</span></p>
                        </div>
                    </div>
                </div>

                <!--administrative details-->
                <div class="col-span-1 border-l">
                    <div class="p-3 grid gap-3 lg:p-4">
                        <h3 class="text-md md:text-lg font-semibold lg:font-bold mb-3">
                            Administrative Details
                        </h3>
                        <div class="flex flex-col space-y-2.5 text-sm text-gray-800 lg:px-5">
                            <p class="border-b">Writer:
                                <span class="ml-4 md:text-sm text-gray-600" v-if="writer">{{ writer }}</span>
                                <span class="ml-4 md:text-sm text-gray-600" v-else>Not Assigned</span>

                            </p>
                            <p class="border-b">Writer Category:
                                <span class="ml-4 md:text-sm text-gray-600">{{ writerCategory }}</span>
                            </p>
                            <p class="border-b">Client:
                                <span class="ml-4 md:text-sm text-gray-600">{{ user }}</span>
                            </p>
                            <p class="border-b">Paid:
                                <span v-if="order.paid === 1" class="ml-4 md:text-sm text-green-600">
                                    Yes
                                </span>
                                <span v-else class="ml-4 md:text-sm text-red-600">
                                    No
                                </span>
                            </p>
                            <p class="border-b">Amount:
                                <span v-if="order.paid === 1" class="ml-4 md:text-sm text-green-600">
                                    {{currencySymbol}} {{ order.amount }}
                                </span>
                                <span v-else-if="order.amount_due" class="ml-4 md:text-sm text-red-600">
                                    {{currencySymbol}} {{order.amount_due}}
                                </span>
                            </p>
                            <p class="border-b">Status:
                                <span class="ml-4 md:text-sm text-gray-600">{{ order.status }}</span>
                            </p>
                            <p class="border-b" v-if="discountAmount">Discount:
                                <span class="ml-4 md:text-sm text-gray-600">
                                    "{{ discount }}" - {{ discountAmount }}% OFF
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!--Files-->
                <div class="col-span-2" v-if="files.length > 0">
                    <h3 class="font-bold">Files:</h3>
                    <div class="p-2.5 py-6 grid grid-cols-1 gap-x-4 gap-y-3 mt-4 mb-6 bg-slate-700 max-w-2xl text-white mx-auto rounded-lg border border-fuchsia-200">
                        <label class="font-semibold px-6 mx-auto">Add files</label>
                        <input multiple
                               class="text-black bg-white pl-1.5 py-1.5 my-auto mx-auto rounded-lg"
                               type="file" id="files"
                               @input="form.files = $event.target.files"
                               name="files[]">
                        <select v-model="form.fileType" class="text-slate-900 mx-auto rounded-md">
                            File Type:
                            <option value="">Select File Type</option>
                            <option value="Draft">Draft</option>
                            <option value="Final Copy">Final Copy</option>
                            <option value="Plagiarism Report">Plagiarism Report</option>
                        </select>
                        <button class="bg-white text-green-500 font-semibold px-3 py-1.5 rounded-lg hover:underline flex flex-wrap mt-4 mx-auto" @click.prevent="uploadFiles(order.id)">
                            Upload
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#18e516" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.2 15c.7-1.2 1-2.5.7-3.9-.6-2-2.4-3.5-4.4-3.5h-1.2c-.7-3-3.2-5.2-6.2-5.6-3-.3-5.9 1.3-7.3 4-1.2 2.5-1 6.5.5 8.8m8.7-1.6V21"/><path d="M16 16l-4-4-4 4"/></svg>
                        </button>
                    </div>
                    <div class="grid md:grid-cols-3 grid-cols-2 md:gap-4 max-w-2xl md:text-sm border-b border-gray-200 py-1.5" v-for="file in files">
                        <Link class="hover:text-violet-600 underline text-violet-900 "
                              @click="downloadFile(file.id, file.name)"
                        >{{ file.name }}</Link>
                        <p>File Type:
                            <span v-if="file.uploaded_by === 'U'" class="pl-3 text-blue-500"> Order File </span>
                            <span v-else class="pl-3 text-green-600 font-semibold text-xs underline"> {{ file.type }} </span>
                        </p>
                        <p>Uploaded by:
                            <span v-if="file.uploaded_by === 'U'" class="pl-3 text-blue-500"> Client </span>
                            <span v-else-if="file.uploaded_by === 'A'" class="pl-3 text-blue-600 font-semibold text-xs underline"> Admin </span>
                            <span v-else class="pl-3 text-green-600 font-semibold text-xs underline"> Quality Assurance </span>
                        </p>
                    </div>

                </div>

                <!--Instructions-->
                <div class="mt-6 col-span-2">
                    <div class="rounded bg-white text-black min-w-2/3 m-2 md:mx-5 p-3 px-6">
                        <div class=" flex justify-between">
                            <h3 class="text-lg font-bold">
                                Order Instructions
                            </h3>
                            <div class="flex flex-wrap align-baseline underline text-cyan-500 gap-2">
                                <button @click="modalShow">Edit</button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#49eefc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon><line x1="3" y1="22" x2="21" y2="22"></line></svg>
                            </div>

                            <!--Instructions Edit Modal-->
                            <Modal :show="changeInstructions">
                                <template #default>
                                    <div class="mt-4 py-4 px-5">
                                        <h2 class="text-lg font-medium text-gray-900">
                                            Edit Instructions
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-600">
                                            <span class="font-semibold mr-3">Old Instructions: </span><br>
                                        </p>
                                        <div class="my-6 text-justify">
                                            <pre class="whitespace-pre-wrap">
                                                {{ order.instructions }}
                                            </pre>
                                        </div>


                                        <!--instructions-->
                                        <div class="mt-6 mb-8 m-4">
                                            <label for="instructions" class="block mb-2 text-sm font-semibold dark:text-white">
                                                Instructions:<span class="text-red-500"> *</span>
                                            </label>
                                            <textarea id="instructions"
                                                      name="instructions" rows="8"
                                                      ref="instructionsInput"
                                                      v-model="form.instructions"
                                                      class="block p-2.5 w-full text-sm md:text-md shadow-sm shadow-purple-300 bg-white rounded-lg border border-gray-200 focus:ring-blue-300 focus:border-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            </textarea>
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <SecondaryButton @click="modalClose"> Cancel </SecondaryButton>

                                            <PrimaryButton @click="updateInstructions(order.id)" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Update Instructions
                                            </PrimaryButton>
                                        </div>
                                    </div>
                                </template>


                            </Modal>
                        </div>

                        <hr class="border-1 w-full mx-auto border-blue-900 mb-4">
                        <h3 class="text-md text-fuchsia-900 font-semibold mr-4 border-b border-gray-200">#{{order.id}} | Order title:
                            <span class="text-fuchsia-900 font-medium">{{order.title}}</span>
                        </h3>
                        <p class="my-6 text-justify leading-tight decoration-1 whitespace-pre-wrap">
                            {{ order.instructions }}
                        </p>
                    </div>
                </div>
            </section>
            <Modal :show="confirmComplete" @close="modalClose">
                <div class="mt-4 py-4 px-5">
                    <h2 class="text-lg font-medium text-gray-900">
                        Please Rate the Writer to Complete the order.
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Rate your overall satisfaction with the order you received.
                    </p>

                    <div class="mt-6">
                        <TextInput id="name" ref="nameInput" v-model="form.review"
                                   type="text" class="mt-1 block w-3/4" placeholder="Leave a Review"
                        />

                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="flex">
                        <label class="block mr-2">
                            <input type="radio" name="rating" value="1" v-model="rating" class="form-checkbox" />
                            <span class="ml-2 text-xs">1 star</span>
                        </label>
                        <label class="block mr-2">
                            <input type="radio" name="rating" value="1" v-model="rating" class="form-checkbox" />
                            <span class="ml-2 text-xs">2 star</span>
                        </label>
                        <label class="block mr-2">
                            <input type="radio" name="rating" value="1" v-model="rating" class="form-checkbox" />
                            <span class="ml-2 text-xs">3 star</span>
                        </label>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="confirmComplete = false"> Cancel </SecondaryButton>

                        <PrimaryButton @click="markCompleted(order.id)" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Mark Complete
                        </PrimaryButton>
                    </div>
                </div>

            </Modal>
            <Modal :show="confirmCancel" @close="modalClose">
                <div class="mt-4 py-4 px-5">
                    <h2 class="text-lg font-medium text-gray-900">
                        Enter a reason for this action to continue.
                    </h2>

                    <div class="mt-6">
                        <textarea id="cancel_reason"
                                  name="cancel_reason" rows="8"
                                  ref="cancelInput"
                                  v-model="form.cancel_reason"
                                  class="block p-2.5 w-full text-sm md:text-md shadow-sm shadow-purple-300 bg-white rounded-lg border border-gray-200 focus:ring-blue-300 focus:border-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </textarea>
                    </div>


                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="confirmCancel = false"> Cancel </SecondaryButton>

                        <PrimaryButton @click="cancelOrder(order.id)" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Cancel Order
                        </PrimaryButton>
                    </div>
                </div>

            </Modal>
            <Modal :show="confirmDispute" @close="modalClose">
                <div class="mt-4 py-4 px-5">
                    <h2 class="text-lg font-medium text-gray-900">
                        Enter a reason for this action to continue.
                    </h2>

                    <div class="mt-6">
                        <textarea id="cancel_reason"
                                  name="cancel_reason" rows="8"
                                  ref="cancelInput"
                                  v-model="form.cancel_reason"
                                  class="block p-2.5 w-full text-sm md:text-md shadow-sm shadow-purple-300 bg-white rounded-lg border border-gray-200 focus:ring-blue-300 focus:border-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </textarea>
                    </div>


                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="confirmDispute = false"> Cancel </SecondaryButton>

                        <PrimaryButton @click="disputeOrder(order.id)" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Add Dispute
                        </PrimaryButton>
                    </div>
                </div>

            </Modal>
            <Modal :show="confirmRevision" @close="modalClose">
                <div class="mt-4 py-4 px-5">
                    <h2 class="text-lg font-medium text-gray-900">
                        Enter instructions to be followed to complete the revision.
                    </h2>

                    <div class="mt-6">
                        <textarea id="cancel_reason"
                                  name="cancel_reason" rows="8"
                                  ref="cancelInput"
                                  v-model="form.revision_instructions"
                                  class="block p-2.5 w-full text-sm md:text-md shadow-sm shadow-purple-300 bg-white rounded-lg border border-gray-200 focus:ring-blue-300 focus:border-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </textarea>
                    </div>


                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="confirmRevision = false"> Cancel </SecondaryButton>

                        <PrimaryButton @click="requestRevision(order.id)" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Request Revision
                        </PrimaryButton>
                    </div>
                </div>

            </Modal>
            <Modal :show="confirmExtend" @close="modalClose">
                <div class="mt-4 py-4 px-5">
                    <h2 class="text-lg font-medium text-gray-900">
                        Enter amount of hours.
                    </h2>

                    <div class="mt-6">
                        <input type="number"
                               id="hours"
                               name="hours"
                               ref="hoursInput"
                               v-model="form.hours"
                               class="block w-full rounded text-gray-900 text-sm">
                    </div>


                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="confirmExtend = false"> Cancel </SecondaryButton>

                        <PrimaryButton @click="extendDeadline(order.id)" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Add Hours
                        </PrimaryButton>
                    </div>
                </div>

            </Modal>
            <Modal :show="showMessage" @close="modalClose">
                <div class="mt-4 py-4 px-5 font-serif max-h-screen scroll-auto overflow-y-auto mb-12">

                    <div class="mx-12 my-3 bg-amber-50 px-10 py-6 rounded">
                        <h2 class="text-lg text-center font-bold text-gray-900">
                            Messages for Order #{{ order.id }} {{ pageUser.id }}.
                        </h2>

                        <div v-for="message in messages">
                            <div class="flex flex-col place-items-start m-2 py-2" v-if="message.user_id !== pageUser.id">
                                <div class="bg-green-200 px-4 py-2 rounded-xl max-w-xs">
                                <p class="text-lime-700 underline text-end text-sm">
                                    {{ props.user ?? 'Sender' }} - <span class="text-xs text-gray-700">{{ getTime(message.created_at) }}</span>
                                </p>
                                    {{ message.message }}
                                </div>

                            </div>
                            <div class="flex flex-col place-items-end m-2 py-2" v-else>
                                <div class="bg-indigo-200 px-2.5 py-3 rounded-xl max-w-xs">
                                <p class="text-lime-700 font-semibold underline -mt-2.5 text-end text-sm">
                                    Me ~ <span class="text-xs text-gray-700">{{ getTime(message.created_at) }}</span>
                                </p>
                                    {{ message.message }}
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="m-6 py-4 px-8 mx-12 bg-amber-200 rounded-xl">
                        <label for="instructions" class="block mb-2 text-sm font-semibold dark:text-white">
                            New Message:
                        </label>
                        <textarea
                            id="message"
                            name="message" rows="5"
                            ref="instructionsInput"
                            v-model="form.message"
                            class="block p-2.5 w-full text-sm md:text-md shadow-sm shadow-purple-300 bg-white rounded-lg border border-gray-200 focus:ring-blue-300 focus:border-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </textarea>
                        <div class="flex flex-wrap space-x-8 m-3 text-sm">
                            <p>Send To: {{ receiver }} </p>
                            <select class="rounded" name="receiver" v-model="receiver">
                                <option value="">Select Receiver</option>
                                <option value="client">Client</option>
                                <option value="writer">Writer</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="showMessage = false"> Cancel </SecondaryButton>

                        <PrimaryButton @click="sendMessage(order.id)" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Send Message
                        </PrimaryButton>
                    </div>
                </div>
            </Modal>
            <Modal :show="confirmAssign" @close="modalClose">
                <div class="mt-4 py-4 px-5">
                    <h2 class="text-lg font-medium text-gray-900">
                        Select Writer.
                    </h2>
                    <div class="mt-6">
                        <select id="assigned_to"
                                v-model="form.assigned_to"
                                class="block w-full rounded text-gray-900 text-sm"
                                name="assigned_to" autofocus>
                            <option disabled value="">Select a writer</option>
                            <option class="text-slate-900" v-for="wr in writers" :value="wr.id">{{ wr.name }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-bold mt-4 p-4">
                            Select Deadline
                        </label>
                        <input type="datetime-local" v-model="form.writerDeadline" class="mt-4 px-4 rounded text-gray-900 text-sm">
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="confirmAssign = false"> Cancel </SecondaryButton>

                        <PrimaryButton @click="assignWriter(order.id)" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Assign Writer
                        </PrimaryButton>
                    </div>
                </div>

            </Modal>
        </OrdersCard>
    </BaseLayout>
</template>
