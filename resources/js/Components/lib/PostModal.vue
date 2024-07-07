<template>
    <teleport to='body'>
        <TransitionRoot appear :show="show" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-50">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                    leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-2 text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-lg bg-white p-3 text-left align-middle shadow-xl transition-all">
                                <div
                                    class="w-full flex justify-between items-center border-b-[1px] border-b-slate-200 pb-3">
                                    <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 ">
                                        <span> {{ form.id ? 'Update Post' : 'Create Post' }}</span>
                                    </DialogTitle>
                                    <button @click="closeModal">
                                        <XMarkIcon class="size-5 font-bold" />
                                    </button>
                                </div>
                                <div class="flex flex-col w-full mt-4 gap-2">
                                    <div class="h-full w-full">
                                        <UserTag :post="props.post" :show-name="true" :show-time="false"
                                            :class="['gap-2']" />
                                    </div>
                                    <div class="py-3 w-full">
                                        <!-- Input Editor -->
                                        <ckeditor :editor="editor" v-model="form.body" :config="editorConfig"></ckeditor>

                                        <!--attachment -->
                                        <div :class="['gap-2 my-1',
                                            attachmentFiles.length === 1 ? 'grid grid-cols-1' :
                                                attachmentFiles.length % 2 === 0 ? ' grid grid-cols-2' :
                                                    attachmentFiles.length % 2 !== 0 && ' grid grid-cols-2'
                                        ]">
                                            <template v-for="attachment, index of attachmentFiles.slice(0, 4)">
                                                <div
                                                    class="group relative max-w-full truncate aspect-square bg-blue-100 flex flex-col items-center justify-center rounded-lg">
                                                    <div v-if="index === 3 && createdAttachmentLength > 0"
                                                        class="absolute inset-0 flex justify-center items-center text-xl z-10 bg-black/30 text-white">
                                                        +{{ createdAttachmentLength }} more

                                                    </div>
                                                    <button @click="removeAttachedFile(attachment)"
                                                        class="opacity-0 z-20 group-hover:opacity-100 transition-all absolute bg-white rounded-full p-1 top-2 right-2 font-semibold text-gray-800 cursor-pointer">
                                                        <XMarkIcon class="size-5" />
                                                    </button>
                                                    <img v-if="isImage(attachment.file)" :src="attachment?.url"
                                                        class="aspect-square rounded-md object-cover" />

                                                    <div v-else class="flex flex-col items-center justify-center ">
                                                        <PaperClipIcon class="size-10 text-gray-400" />
                                                        <small class="text-center" v-if="attachment?.file.name.length < 15">
                                                            {{ attachment?.file.name }}
                                                        </small>
                                                        <small class="text-center"
                                                            v-else="attachment?.file.name.length > 15">
                                                            {{ attachment?.file.name.substring(0, 15) + '...' }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div v-if="index === 2 && attachmentFiles.length === 3 && attachmentFiles.length % 2 !== 0"
                                                    class="group relative max-w-full truncate aspect-square bg-blue-100 flex flex-col items-center justify-center gap-3 rounded-lg">
                                                    <PlusCircleIcon class="size-12 text-slate-400" />
                                                    <span class="text-slate-600">Add More</span>
                                                    <input @click.stop @change="onAttachmentChosen" type="file" multiple
                                                        class="absolute inset-0 w-full opacity-0" />
                                                </div>
                                            </template>
                                        </div>
                                        <!-- Notification -->
                                        <div v-if="notificationError && showNotification"
                                            class="w-full justify-center text-center text-md font-semibold pt-5 text-red-600">
                                            {{ notificationError }}
                                        </div>
                                        <!-- duplicate -->
                                        <div :class="['gap-2 my-3',
                                            computedAttachments.length === 1 ? 'grid grid-cols-1' :
                                                computedAttachments.length % 2 === 0 ? ' grid grid-cols-2' :
                                                    computedAttachments.length % 2 !== 0 && ' grid grid-cols-2'
                                        ]">
                                            <template v-if="computedAttachments"
                                                v-for="attachment, index of computedAttachments.slice(0, 4)">
                                                <div
                                                    class="group relative max-w-full truncate aspect-square bg-blue-100 flex flex-col items-center justify-center rounded-lg">
                                                    <div v-if="index === 3 && computedAttachments.length > 4"
                                                        class="absolute inset-0 flex justify-center items-center text-xl z-10 bg-black/30 text-white">
                                                        +{{ computedAttachments.length }} more

                                                    </div>
                                                    <div v-if="attachment.deleted" @click="undoDeleteAttachment(attachment)"
                                                        class="flex justify-between items-center cursor-pointer absolute left-0 right-0 bottom-0 p-2 bg-black/80 text-slate-300">
                                                        To be Deleted
                                                        <ArrowUturnLeftIcon class="size-5 text-white" />
                                                    </div>
                                                    <button @click="removeAttachedFile(attachment)"
                                                        class="opacity-0 z-20 group-hover:opacity-100 transition-all absolute bg-white rounded-full p-1 top-2 right-2 font-semibold text-gray-800 cursor-pointer">
                                                        <XMarkIcon class="size-5" />
                                                    </button>

                                                    <img v-if="attachment && !attachment?.file ? isImage(attachment) : isImage(attachment.file)"
                                                        :src="attachment?.url"
                                                        :class="['size-full aspect-square rounded-md object-cover',]" />

                                                    <div v-else class="flex flex-col items-center justify-center">
                                                        <PaperClipIcon class="size-10 text-gray-400" />
                                                        <small class="text-center"
                                                            v-if="attachment || !attachment?.file && (attachment || attachment?.file)?.name.length < 15">
                                                            {{ (attachment || attachment?.file)?.name }}
                                                        </small>
                                                        <small class="text-center"
                                                            v-else="attachment || !attachment?.file && (attachment || attachment?.file)?.length > 15">
                                                            {{ (attachment || attachment?.file)?.name.substring(0, 15) +
                                                                '...' }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div v-if="index === 2 && computedAttachments.length === 3 && computedAttachments.length % 2 !== 0"
                                                    class="group relative max-w-full z-50 truncate aspect-square bg-blue-100 flex cursor-pointer flex-col items-center justify-center gap-3 rounded-lg">
                                                    <PlusCircleIcon class="size-12 text-slate-400" />
                                                    <span class="text-slate-600">Add More</span>
                                                    <input @click.stop @change="onAttachmentChosen" type="file" multiple
                                                        class="absolute inset-0 w-full opacity-0" />
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex mt-4 gap-2 items-center">
                                    <button type="button"
                                        class="w-full inline-flex items-center gap-2 justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2"
                                        @click="submitPost">
                                        <CheckCircleIcon class="size-5" />
                                        <span>
                                            {{ form.id ? 'Update Changes' : 'Create Post' }}
                                        </span>
                                    </button>
                                    <button type="button"
                                        class="w-full relative inline-flex items-center  gap-2 justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                                        <PaperClipIcon class="size-5" />
                                        <span>
                                            Attach Files
                                        </span>
                                        <input @click.stop @change="onAttachmentChosen" type="file" multiple
                                            class="absolute inset-0 w-full opacity-0" />
                                    </button>
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
import { ClassicEditor, Bold, Essentials, Italic, Table, Paragraph, Undo, Link, List, Heading, Indent, BlockQuote } from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';

import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import UserTag from '@/Components/lib/UserTag.vue'
import { XMarkIcon, PaperClipIcon, ArrowUturnLeftIcon } from '@heroicons/vue/24/solid'
import { CheckCircleIcon, DocumentIcon, PlusCircleIcon } from '@heroicons/vue/24/outline'
import { useForm } from '@inertiajs/vue3';
import { isImage } from '@/utils.js'

const props = defineProps({
    post: {
        type: Object,
        required: true
    },
    modelValue: Boolean
})

const editor = ClassicEditor
const editorConfig = {
    plugins: [Bold, Essentials, Italic, Paragraph, Undo, Link, List, Table, Heading, Indent, BlockQuote],
    toolbar: ['heading',
        'bold', 'italic', 'link',
        'numberedList', 'bulletedList',
        'insertTable', 'indent', 'outdent',
        'blockQuote', 'undo', 'redo',
    ]
}

const showNotification = ref(true)
const notificationError = ref(null)

const emit = defineEmits(['update:modelValue'])
const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})
const attachmentFiles = ref([])

const computedAttachments = computed(() => {
    if (props?.post?.attachments && attachmentFiles.value) {
        return [...props?.post?.attachments, ...attachmentFiles.value]
    }
    return []
});

const form = useForm({
    id: null,
    body: '',
    attachments: [],
    deletedFileIds: [],
    _method: 'POST'
})

const createdAttachmentLength = computed(() => attachmentFiles.value.length - 4)

const onAttachmentChosen = async (event) => {
    for (const file of event.target.files) {
        const attachedFile = {
            file: file,
            url: await readFile(file)
        }
        attachmentFiles.value.push(attachedFile)
    }
    event.target.value = null
}

const removeAttachedFile = (selectedFile) => {
    if (selectedFile.file) {
        attachmentFiles.value = attachmentFiles.value.filter((file) => file !== selectedFile)
    } else {
        if (!form.deletedFileIds.includes(selectedFile.id)) {
            form.deletedFileIds.push(selectedFile.id);
        }
        selectedFile.deleted = true
    }
}

const readFile = async (file) => {
    return new Promise((resolve, reject) => {
        if (isImage(file)) {
            const reader = new FileReader();
            reader.onload = () => {
                resolve(reader.result)
            }
            reader.onerror = reject
            reader.readAsDataURL(file)
        } else {
            resolve(null)
        }
    })
}
const undoDeleteAttachment = (selectedFile) => {
    selectedFile.deleted = false
    form.deletedFileIds = form.deletedFileIds.filter((id) => id === selectedFile.id)
}
function closeModal() {
    show.value = false
    form.reset()
    attachmentFiles.value = []
    form.deletedFileIds = []
    if (props.post?.attachments) {
        props.post?.attachments?.forEach((file) => {
            file.deleted = false
        });
    }
}

function submitPost() {
    form.attachments = attachmentFiles.value.map((attachment) => attachment.file)
    if (props.post?.id) {
        form._method = 'PUT'
        form.post(route('post.update', props.post), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: (err) => {
                if (err) {
                    Object.keys(err).forEach(key => {
                        const messages = Array.isArray(err[key]) ? err[key] : [err[key]];
                        messages.forEach(message => {
                            notificationError.value = message;
                        });
                    });
                }
                setTimeout(() => {
                    showNotification.value = false
                    notificationError.value = null
                }, 5000)
                showNotification.value = true
            }
        })
    } else {
        // create post
        form.post(route('post.store'), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
            },
            onError: (err) => {
                if (err) {
                    Object.keys(err).forEach(key => {
                        const messages = Array.isArray(err[key]) ? err[key] : [err[key]];
                        messages.forEach(message => {
                            notificationError.value = message;
                        });
                    });
                }
                setTimeout(() => {
                    showNotification.value = false
                    notificationError.value = null
                    form.reset()
                }, 5000)
                showNotification.value = true
            }
        })
    }
}

watch(() => props.post, () => {
    form.id = props.post?.id
    form.body = props.post?.body ?? ''
}, { deep: true })

</script>
  