<template>
    <teleport to='body'>
        <TransitionRoot appear :show="show" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-50">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                    leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-1 text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="w-full max-w-2xl transform overflow-hidden rounded-lg bg-white p-3 text-left align-middle shadow-xl transition-all">
                                <div
                                    class="w-full flex justify-between items-center border-b-[1px] border-b-slate-200 pb-3">
                                    <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 ">
                                        <span> Attachment Preview</span>
                                    </DialogTitle>
                                    <button @click="closeModal">
                                        <XMarkIcon class="size-5 font-bold" />
                                    </button>
                                </div>
                                <div
                                    class="flex w-full gap-2 relative max-w-full aspect-square items-center justify-center rounded-lg">
                                    <div class="w-auto h-full left-0 flex flex-col justify-center items-center">
                                        <div @click="previousPreview"
                                            class="border border-gray-800 rounded-full p-1 cursor-pointer">
                                            <ChevronLeftIcon class="size-12 text-black" />
                                        </div>
                                    </div>

                                    <div class="size-full flex flex-col justify-center items-center">
                                        <img v-if="isImage(attachment)" :src="attachment?.url"
                                            :class="['aspect-square rounded-md object-cover',]" />

                                        <div v-else
                                            class="size-full bg-blue-200 flex flex-col items-center justify-center my-3 rounded-md">
                                            <PaperClipIcon class="size-10 text-gray-400" />
                                            <small class="text-center">
                                                {{ attachment?.name }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class=" h-full right-0 flex flex-col justify-center items-center">
                                        <div @click="nextPreview"
                                            class="border border-gray-800 rounded-full p-1 cursor-pointer">
                                            <ChevronRightIcon class="size-12 text-black" />
                                        </div>
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>
  
<script setup>
import { ref, computed, watch } from 'vue'

import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import { XMarkIcon, PaperClipIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/solid'
import { isImage } from '@/utils.js'

const props = defineProps({
    attachments: Array,
    index: Number,
    modelValue: Boolean
})

const emit = defineEmits(['update:modelValue', 'update:index'])

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

const currentIndex = ref(props.index)

const attachment = computed(() => {
    if (props.attachments?.length > 0 && typeof currentIndex.value === 'number' && currentIndex.value >= 0) {
        return props.attachments[currentIndex.value];
    }
})

function closeModal() {
    show.value = false
}

function nextPreview() {
    if (currentIndex.value < props.attachments.length - 1) {
        currentIndex.value++;
        emit('update:index', currentIndex.value)
    }
}

function previousPreview() {
    if (currentIndex.value > 0) {
        currentIndex.value--;
        emit('update:index', currentIndex.value)
    }
}

watch(() => props.index, (newIndex) => {
    currentIndex.value = newIndex
})
</script>
  