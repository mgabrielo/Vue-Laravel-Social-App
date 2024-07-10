<template>
    <template v-for="attachment, index of attachments.slice(0, 4)" class="max-w-full truncate">
        <div @click="$emit('openAttachmentPreviewClick', { attachments, index })"
            v-if="index === 0 && attachments.length === 3 && attachments.length % 2 !== 0"
            class="row-start-1 row-end-3 group relative cursor-pointer">
            <img v-if="isImage(attachment)" :src="attachment?.url" class="w-full h-full rounded-md object-cover" />
            <button
                class="opacity-0 group-hover:opacity-100 z-20 transition-all absolute bg-slate-700 rounded-md p-1 top-2 right-2 text-gray-400 cursor-pointer">
                <ArrowDownTrayIcon class="size-5" />
            </button>
        </div>
        <div v-else @click="$emit('openAttachmentPreviewClick', { attachments, index })"
            :class="[index > 0 && index < 3 && attachments.length === 3 ? 'flex flex-col' : '']">
            <div
                class="group max-w-full truncate text-wrap relative aspect-square cursor-pointer bg-blue-100 flex flex-col items-center justify-center gap-3 rounded-lg size-full">

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
</template>

<script setup>
import { DocumentIcon, ArrowDownTrayIcon } from '@heroicons/vue/24/solid'
import { isImage } from '@/utils.js'

defineProps({
    attachments: Array,
    computedAttachmentLength: Number
})

defineEmits(['openAttachmentPreviewClick'])
</script>

<style lang="scss" scoped></style>