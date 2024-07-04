<script setup>
import PostItem from '@/Components/lib/PostItem.vue';
import PostModal from '@/Components/lib/PostModal.vue'

import { ref } from 'vue'
import AttachmentPreviewModal from './AttachmentPreviewModal.vue';

const props = defineProps({
    posts: Array
})
const post1 = {
    user: {
        id: 1,
        name: 'jackson smith',
        avatar: 'https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_1280.png'
    },
    body: `<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
Ut enim ad minim veniam,Duis aute irure dolor in reprehenderit in 
voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>`,
    created_at: '2023-11-08 16:45',
    group: null,
    attachments: [
        {
            id: 1,
            name: 'test.png',
            mime: 'image/png',
            url: 'https://cdn.pixabay.com/photo/2022/07/24/23/46/artificial-intelligence-7342613_1280.jpg'
        },
        {
            id: 2,
            name: 'test2.png',
            mime: 'image/png',
            url: 'https://cdn.pixabay.com/photo/2021/07/03/20/06/woman-6384768_1280.jpg'
        },
        {
            id: 2,
            name: 'MyDoc.docx',
            mime: 'application/msword',
            url: '#'
        },
    ]
}

const post2 = {
    user: {
        id: 2,
        name: 'james bond',
        avatar: 'https://cdn.pixabay.com/photo/2017/01/10/03/54/avatar-1968236_1280.png'
        // avatar: 'https://cdn.pixabay.com/photo/2014/04/02/10/25/man-303792_1280.png'
    },
    body: `<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
Ut enim ad minim veniam,Duis aute irure dolor in reprehenderit in 
voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>`,
    created_at: '2023-11-08 16:45',
    group: {
        name: 'Laravel Men'
    },
}
const showEditModal = ref(false)
const showAttachmentPreviewModal = ref(false)
const editPost = ref({})
const attachmentPreviewPost = ref({
    attachments: [],
    index: null
})

const openEditModal = (post) => {
    editPost.value = post
    showEditModal.value = true
}

const openAttachmentPreviewModal = (res) => {
    console.log({ post: res?.attachment, index: res?.index })
    attachmentPreviewPost.value = {
        attachments: res?.attachment,
        index: res?.index,
    }
    showAttachmentPreviewModal.value = true
}
</script>


<template>
    <div class="overflow-auto">
        <AttachmentPreviewModal :attachments="attachmentPreviewPost?.attachments" :index="attachmentPreviewPost?.index"
            v-model="showAttachmentPreviewModal" />
        <PostItem v-for="post of props.posts" :key="post.id" :post="post" @edit-click="openEditModal"
            @attachment-click="openAttachmentPreviewModal" />
        <PostModal :post="editPost" v-model="showEditModal" />
    </div>
</template>


<style scoped></style>