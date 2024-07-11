<script setup>
import { computed } from 'vue'
import { DocumentIcon, ArrowDownTrayIcon, HandThumbUpIcon, ChatBubbleLeftRightIcon } from '@heroicons/vue/24/solid'
import { PaperAirplaneIcon, HandThumbUpIcon as HandThumbUpOutline, ArrowUturnLeftIcon } from '@heroicons/vue/24/outline'
import { Disclosure, DisclosureButton, DisclosurePanel, } from '@headlessui/vue'
import TextInput from '@/Components/TextInput.vue';
import UserTag from '@/Components/lib/UserTag.vue'
import PostItemAttachment from '@/Components/lib/PostItemAttachment.vue'
import { usePage, router } from '@inertiajs/vue3'
import { isImage } from '@/utils.js'
import axiosClient from '@/axiosClient';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import ReadLessOrMore from '@/Components/lib/ReadLessOrMore.vue';
import EditDeleteMenu from '@/Components/lib/EditDeleteMenu.vue';
import CommentList from '@/Components/lib/CommentList.vue';
import { watch } from 'vue';

const props = defineProps({
    post: Object
})

const authUser = usePage().props.auth.user
const allComments = ref(props.post?.comments);
const isYourProfile = computed(() => authUser && authUser.id === props.post.user.id)
const computedAttachmentLength = computed(() => props.post.attachments.length - 4)
const newCommentValue = ref('')
const emit = defineEmits(['editClick', 'attachmentClick'])
const editingComment = ref(null)
const editingCommentId = ref(null)
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
const openAttachmentPreview = ({ attachments, index }) => {
    emit('attachmentClick', { attachments, index })
}

const sendReaction = async () => {
    await axiosClient.post(route('post.reaction', props.post), { reaction: 'like' }).then((res) => {
        if (res.status == 200 && res.data && props.post) {
            props.post.has_reaction = res.data?.has_reaction;
            props.post.num_of_reactions = res.data?.num_of_reactions
        }
    })
}
const createUserComment = async () => {
    await axiosClient.post(route('post.comment.create', props.post), { comment: newCommentValue.value }).then((res) => {
        if (res.data?.comment && props.post) {
            newCommentValue.value = ''
            allComments.value = [res.data.comment, ...allComments.value]
            props.post.num_of_comments++;
        }
    })
}
const deleteComment = async (comment) => {
    if (!window.confirm('Are you sure you want to delete this comment..?')) {
        return false;
    }
    await axiosClient.delete(route('post.comment.delete', comment.id),).then((res) => {
        if (res.status == 200) {

            allComments.value = allComments.value.filter(c => c.id !== comment.id)
            props.post.num_of_comments--;
        }
    })
}
const editComment = (comment) => {
    editingCommentId.value = comment.id
    editingComment.value = {
        id: comment.id,
        comment: comment.comment.replace(/<br\s*\/?>/gi, '\n')
    }
}

const updateComment = async () => {
    await axiosClient.put(route('post.comment.update', editingCommentId.value), { comment: editingComment.value.comment })
        .then((res) => {
            if (res.status == 200) {
                props.post.comments = props.post.comments.map((comment_item) => {
                    if (comment_item.id == res.data.id) {
                        return res.data
                    }
                    return comment_item
                });
                props.post.num_of_comments--;
                editingComment.value = null
            }
        })
}

const sendCommentReactionLike = async (comment) => {
    await axiosClient.post(route('post.comment.reaction', comment.id), { reaction: 'like' })
        .then((res) => {
            if (res.data) {
                allComments.value = props.post.comments.map((c) => {
                    if (c.id === res.data?.comment?.id) {
                        c.has_comment_reaction = res.data?.has_comment_reaction
                        c.num_of_comment_reactions = res.data?.num_of_comment_reactions
                    }
                    return c;
                });
            }
        })
}
const sendCommentReactionReply = async () => {
    console.log('send')
    // await axiosClient.put(route('post.comment.reaction', props.post), { reaction: 'like' })
    //     .then((res) => {
    //         console.log(res.data)
    //     })
}

const createSubComment = () => {

}
watch(() => props.post?.comments, () => {
    allComments.value = props.post?.comments
}, { deep: true });

</script>


<template>
    <div class="bg-white border rounded-lg p-4 shadow-sm mb-2">
        <div class="flex justify-between items-center mb-2 ">
            <UserTag :post="props.post" class="gap-2" />
            <div class="justify-end">
                <EditDeleteMenu @edit="openEditModal" @delete="submitDelete" :is-your-profile="isYourProfile" />
            </div>
        </div>
        <div>
            <ReadLessOrMore :body="post.body" />
        </div>
        <!-- Attachment Section -->
        <div @click="openAttachment" :class="['gap-2 my-1',
            props.post?.attachments.length === 1 ? 'grid grid-cols-1' :
                props.post?.attachments.length % 2 === 0 ? ' grid grid-cols-2' :
                    props.post?.attachments.length % 2 !== 0 && 'grid grid-rows-2 grid-flow-col',
            props.post?.attachments?.length > 0 && 'size-full aspect-square',
        ]">
            <PostItemAttachment @openAttachmentPreviewClick="openAttachmentPreview" :attachments="props.post?.attachments"
                :computed-attachment-length="computedAttachmentLength" />
        </div>
        <!-- Attachment Section -->

        <!-- comment section -->
        <Disclosure v-slot="{ open }">
            <div class="flex py-2 px-2 gap-2">
                <button @click="sendReaction" :class="['flex flex-1 justify-center gap-2 group items-center p-2 rounded-lg',
                    post?.has_reaction ? 'text-blue-600 hover:text-blue-800 bg-blue-200' : 'text-gray-500 hover:text-gray-700 bg-gray-200'
                ]">
                    <HandThumbUpIcon class="size-5" />
                    <span class="text-gray-600 group-hover:text-gray-800 font-medium">
                        {{ post.num_of_reactions }} {{ post.num_of_reactions === 1 ? 'Like' : 'Likes' }}
                    </span>
                </button>
                <DisclosureButton
                    class="flex flex-1 justify-center gap-2  group items-center text-gray-500 hover:text-gray-700 p-2  bg-gray-200 rounded-lg ">
                    <ChatBubbleLeftRightIcon class="size-5" />
                    <span class="text-gray-600 group-hover:text-gray-800 font-medium">
                        {{ post.num_of_comments > 0 ? post.num_of_comments : '' }}
                    </span>
                </DisclosureButton>
            </div>
            <DisclosurePanel class="px-4 pb-2 pt-4 text-sm text-gray-500">
                <!-- <pre>{{ props.post.comment }}</pre> -->
                <CommentList :post="props.post" :data="{ comments: props.post?.comments }" />
            </DisclosurePanel>
        </Disclosure>
        <!-- comment section -->
        <div>
        </div>
    </div>
</template>


<style scoped></style>