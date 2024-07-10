<template>
    <div>
        <div class="flex w-full h-full justify-between gap-2">
            <div class="h-full flex flex-col">
                <UserTag :comment-user-tag="true" :comment-user="authUser" :show-name="false" :show-time="false"
                    :class="['p-0']" />
            </div>
            <div class="flex-1 self-center mt-2">
                <TextInput :auto-resize="true" :rows="1" placeholder="Enter Your Comment Here" v-model="newCommentValue"
                    :more-class="['py-0 mb-2']" />
            </div>
            <div class="self-center">
                <div class="bg-indigo-600 rounded-full p-2 cursor-pointer mb-1 justify-center" @click="createUserComment">
                    <PaperAirplaneIcon class="size-4 text-white" />
                </div>
            </div>
        </div>
        <!-- comments -->
        <div>
            <div v-if="props.post.comments.length > 0" v-for="comment of allComments" :key="comment.id">
                <div class="flex flex-col w-full h-full gap-2 my-2">
                    <div class="flex justify-between gap-2 items-center">

                        <div class="h-full flex flex-col" v-if="comment && comment?.user?.avatar_url">
                            <UserTag :comment-user-tag="true" :comment-owner="comment" :show-name="true" :show-time="true"
                                :comment-owner-tag="true" :class="['gap-1 text-lg']" />

                        </div>
                        <div v-if="!editingComment">
                            <EditDeleteMenu @edit="editComment(comment)" @delete="deleteComment(comment)"
                                :is-your-profile="comment?.user?.id ? comment?.user?.id === authUser?.id : false"
                                class="justify-self-end" />
                        </div>

                    </div>
                    <div v-if="editingComment && comment.id === editingCommentId" class="pl-12">
                        <TextInput :auto-resize="true" :rows="2" placeholder="Enter Your Comment Here"
                            v-model="editingComment.comment" />
                    </div>
                    <div class="pl-12 flex justify-between gap-2">
                        <div class="flex gap-3" v-if="editingComment && comment.id === editingCommentId">
                            <button @click="sendCommentReactionLike(comment)"
                                :class="['flex gap-2 items-center text-lg pt-1', comment.has_comment_reaction ? 'text-indigo-800' : 'text-indigo-300']">
                                <HandThumbUpOutline class="size-4 font-bold" />
                                {{ comment.num_of_comment_reactions }} {{ comment.num_of_comment_reactions === 1 ?
                                    'like' : 'likes' }}
                            </button>
                            <button @click="handleReactionReply"
                                class="flex gap-2 items-center pt-1 text-indigo-400 text-lg">
                                <ArrowUturnLeftIcon class="size-4 font-bold" />
                                <span>reply</span>
                            </button>
                        </div>
                        <div v-if="editingComment && comment.id === editingCommentId" class="flex justify-end gap-2">
                            <PrimaryButton class="bg-indigo-600 flex gap-2" @click="updateComment(comment)">
                                <span class="capitalize text-white font-bold text-md">Update Comment</span>
                            </PrimaryButton>
                            <PrimaryButton class="bg-transparent flex gap-2 hover:bg-transparent"
                                @click="editingComment = null">
                                <span class="capitalize text-red-600 font-bold text-md">Cancel</span>
                            </PrimaryButton>
                        </div>
                    </div>
                    <Disclosure as="div" class="pl-12 w-full">
                        <div v-if="!editingComment" class="flex flex-1">
                            <ReadLessOrMore :body="comment.comment" />
                        </div>
                        <div class="flex gap-3" v-if="!editingComment">
                            <button @click="sendCommentReactionLike(comment)"
                                :class="['flex gap-2 items-center text-lg pt-1', comment.has_comment_reaction ? 'text-indigo-800' : 'text-indigo-300']">
                                <HandThumbUpOutline class="size-4 font-bold" />
                                {{ comment.num_of_comment_reactions }} {{ comment.num_of_comment_reactions === 1 ?
                                    'like' : 'likes' }}
                            </button>
                            <DisclosureButton class="flex gap-2 items-center pt-1 text-indigo-400 text-lg">
                                <ArrowUturnLeftIcon class="size-4 font-bold" />
                                <span>reply</span>
                            </DisclosureButton>
                        </div>

                        <DisclosurePanel>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex-1">
                                    <TextInput :auto-resize="true" :rows="1" placeholder="Enter Your Comment Here"
                                        v-model="newCommentValue" :more-class="['py-0']" />
                                </div>
                                <div class="">
                                    <div class="bg-indigo-600 rounded-full p-2 cursor-pointer mb-1 justify-center"
                                        @click="createSubComment">
                                        <PaperAirplaneIcon class="size-4 text-white" />
                                    </div>
                                </div>
                            </div>
                        </DisclosurePanel>
                    </Disclosure>

                    <div class="mt-2 border border-b-slate-300" />
                </div>
            </div>
        </div>
        <!-- comments -->
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { PaperAirplaneIcon, HandThumbUpIcon as HandThumbUpOutline, ArrowUturnLeftIcon } from '@heroicons/vue/24/outline'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { usePage } from '@inertiajs/vue3'
import axiosClient from '@/axiosClient';
import UserTag from '@/Components/lib/UserTag.vue'
import EditDeleteMenu from '@/Components/lib/EditDeleteMenu.vue';
import ReadLessOrMore from '@/Components/lib/ReadLessOrMore.vue';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';

const props = defineProps({
    post: Object
})
const authUser = usePage().props.auth.user
const allComments = ref(props.post?.comments);
const newCommentValue = ref('')
const editingComment = ref(null)
const editingCommentId = ref(null)

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

const createSubComment = () => {
    console.log('send sub comment')
}

watch(() => props.post?.comments, () => {
    allComments.value = props.post?.comments
}, { deep: true });
</script>

<style lang="scss" scoped></style>