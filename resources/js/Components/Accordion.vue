<script setup>
import {defineProps, ref} from "vue";

let isOpen = ref(props.show)
function toggle() {
    isOpen.value = !isOpen.value
}

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <div class="bg-gray-800 hover:text-white rounded p-2">
        <a href="" @click.prevent="toggle" class="border-b text-gray-200 border-gray-500 flex justify-between">
            <slot name="title" />
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#e0e0e0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </a>
        <div v-if="$slots.content" v-show="isOpen" class="text-sm mt-2 grid grid-cols-1 divide-y divide-gray-500">
            <slot name="content" />
        </div>

    </div>
</template>
