<script setup>
import { computed } from 'vue'
import { DocumentIcon, ArrowDownTrayIcon, HandThumbUpIcon, ChatBubbleLeftRightIcon, EllipsisVerticalIcon } from '@heroicons/vue/24/solid'
import { PencilIcon, TrashIcon, PlusCircleIcon } from '@heroicons/vue/24/outline'
import {
    Disclosure, DisclosureButton, DisclosurePanel,
    Menu, MenuButton, MenuItems, MenuItem,
} from '@headlessui/vue'
import UserTag from '@/Components/lib/UserTag.vue'
import { usePage, router } from '@inertiajs/vue3'
import { isImage } from '@/utils.js'
import axiosClient from '@/axiosClient';

const props = defineProps({
    post: Object
})

const authUser = usePage().props.auth.user
const isYourProfile = computed(() => authUser && authUser.id === props.post.user.id)
const computedAttachmentLength = computed(() => props.post.attachments.length - 4)

const emit = defineEmits(['editClick', 'attachmentClick'])

function openEditModal() {
    emit('editClick', props.post)
}



function submitDelete() {
    if (window.confirm('Are you sure you want to delete this post..?')) {
        router.delete(route('post.delete', props), {
            preserveScroll: true
        })
    }
}
const openAttachmentPreview = (attachment, index) => {
    const result = { attachment, index }
    emit('attachmentClick', result)
}

const sendReaction = async () => {
    await axiosClient.post(route('post.reaction', props.post), { reaction: 'like' }).then((res) => {
        if (res.status == 200 && res.data && props.post) {
            props.post.has_reaction = res.data?.has_reaction;
            props.post.num_of_reactions = res.data?.num_of_reactions
        }
    })
}
</script>


<template>
    <div class="bg-white border rounded-lg p-4 shadow-sm mb-2">
        <div class="flex justify-between items-center mb-2 ">
            <UserTag :post="props.post" class="gap-2" />
            <div class="justify-end">
                <Menu v-if="isYourProfile" as="div" class="relative inline-block text-left z-30">
                    <div>
                        <MenuButton class="inline-flex w-full">
                            <EllipsisVerticalIcon class="size-5 font-semibold" />
                        </MenuButton>
                    </div>
                    <transition enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
                        <MenuItems
                            class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                            <div class="px-1 py-1">
                                <MenuItem v-slot="{ active }">
                                <button :class="[
                                    active ? 'bg-slate-100' : 'bg-transparent',
                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm text-gray-900',
                                ]" @click="openEditModal">
                                    <PencilIcon :active="active" class="mr-2 h-5 w-5 text-slate-700" aria-hidden="true" />
                                    Edit
                                </button>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                <button :class="[
                                    active ? 'bg-slate-100' : 'bg-transparent',
                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm text-gray-900',
                                ]" @click="submitDelete">
                                    <TrashIcon :active="active" class="mr-2 h-5 w-5 text-slate-700" aria-hidden="true" />
                                    Delete
                                </button>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
        </div>
        <div>
            <Disclosure v-slot="{ open }" v-if="props.post?.body">
                <div class="ck-content" v-if="!open && props.post?.body.length < 100" v-html="props.post?.body" />
                <div class="ck-content" v-if="!open && props.post?.body.length > 100"
                    v-html="props.post?.body.substring(0, 100) + '...'" />
                <DisclosurePanel>
                    <div class="ck-content" v-html="props.post?.body" />
                </DisclosurePanel>
                <div class="flex justify-end px-3">
                    <DisclosureButton v-if="props.post?.body.length > 100" class="text-blue-500 mt-2 hover:underline">
                        <span>{{ !open ? "Read More" : "Read Less" }}</span>
                    </DisclosureButton>
                </div>
            </Disclosure>

        </div>
        <div @click="openAttachment" :class="['gap-2 my-1',
            props.post?.attachments.length === 1 ? 'grid grid-cols-1' :
                props.post?.attachments.length % 2 === 0 ? ' grid grid-cols-2' :
                    props.post?.attachments.length % 2 !== 0 && 'grid grid-rows-2 grid-flow-col',
            props.post?.attachments?.length > 0 && 'size-full aspect-square',
        ]">
            <template v-for="attachment, index of props.post?.attachments.slice(0, 4)" class="max-w-full truncate">

                <div @click="openAttachmentPreview(props.post?.attachments, index)"
                    v-if="index === 0 && props.post?.attachments.length === 3 && props.post?.attachments.length % 2 !== 0"
                    class="row-start-1 row-end-3 group relative cursor-pointer">
                    <img v-if="isImage(attachment)" :src="attachment?.url" class="w-full h-full rounded-md object-cover" />
                    <button
                        class="opacity-0 group-hover:opacity-100 z-20 transition-all absolute bg-slate-700 rounded-md p-1 top-2 right-2 text-gray-400 cursor-pointer">
                        <ArrowDownTrayIcon class="size-5" />
                    </button>
                </div>
                <div v-else @click="openAttachmentPreview(props.post?.attachments, index)"
                    :class="[index > 0 && index < 3 && props.post?.attachments.length === 3 ? 'flex flex-col' : '']">
                    <div
                        class="group max-w-full truncate text-wrap relative aspect-square cursor-pointer bg-blue-100 flex flex-col items-center justify-center gap-3 rounded-lg size-full">
                        <!-- Attachment -->
                        <div v-if="index === 3 && computedAttachmentLength > 0"
                            class="absolute inset-0 flex justify-center items-center text-xl z-10 bg-black/30 text-white">
                            +{{ computedAttachmentLength }} more
                        </div>
                        <a :href="route('post.download', attachment)"
                            class="opacity-0 group-hover:opacity-100 z-20 transition-all absolute bg-slate-700 rounded-md p-1 top-2 right-2 text-gray-400 cursor-pointer">
                            <ArrowDownTrayIcon class="size-5" />
                        </a>
                        <img v-if="isImage(attachment)" :src="attachment?.url"
                            class="size-full aspect-square rounded-md object-cover" />
                        <div v-else class="size-full flex flex-col items-center justify-center text-wrap">
                            <DocumentIcon class="size-20 text-gray-400" />
                            <span class="text-center text-sm" v-if="attachment.name.length < 20">
                                {{ attachment.name }}
                            </span>
                            <small class="text-center text-sm" v-else="attachment.name.length > 20">
                                {{ attachment.name.substring(0, 15) + '.' + attachment.mime.split('/')[1] }}
                            </small>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div class="flex py-2 px-2 gap-2">
            <button @click="sendReaction" :class="['flex flex-1 justify-center gap-2 group items-center p-2 rounded-lg',
                post?.has_reaction ? 'text-blue-600 hover:text-blue-800 bg-blue-200' : 'text-gray-500 hover:text-gray-700 bg-gray-200'
            ]">
                <HandThumbUpIcon class="size-5" />
                <span class="text-gray-600 group-hover:text-gray-800 font-medium">
                    {{ post?.has_reaction ? 'Unlike' : 'Like' }}
                </span>
            </button>
            <button
                class="flex flex-1 justify-center gap-2  group items-center text-gray-500 hover:text-gray-700 p-2  bg-gray-200 rounded-lg ">
                <ChatBubbleLeftRightIcon class="size-5" />
                <span class="text-gray-600 group-hover:text-gray-800 font-medium">Comment</span>
            </button>
        </div>
    </div>
</template>


<style scoped></style>