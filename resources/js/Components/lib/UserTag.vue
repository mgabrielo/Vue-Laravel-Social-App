<template>
    <div class="flex items-center">
        <a href="javascript:void(0)" v-if="!props.commentOwnerTag">
            <img v-if="props.commentUserTag && props.commentUser ? props.commentUser.avatar_url : props.post?.user?.avatar_url"
                class="size-12 p-1 rounded-full ring-0 hover:ring-2 hover:ring-blue-400"
                :src="props.commentUserTag && props.commentUser ? props.commentUser.avatar_url : props.post?.user?.avatar_url" />
        </a>
        <a href="javascript:void(0)" v-if="props.commentOwnerTag && $props.commentOwner">
            <img class="size-12 p-1 rounded-full ring-0 hover:ring-2 hover:ring-blue-400"
                :src="props.commentOwner?.user.avatar_url" />
        </a>
        <div>
            <h4 class="font-semibold " v-if="showName">
                <a href="javascript:void(0)" class="hover:underline">
                    {{ props.commentUserTag && props.commentUser ? props.commentUser.name : props.post?.user?.name }}
                </a>
                <template v-if="!props.commentUserTag && props.post?.group?.name">
                    <a href="javascript:void(0)" class="hover:underline">
                        {{ props.post.group.name }}
                    </a>
                </template>
            </h4>
            <small v-if="showTime && !props.commentUserTag" class="text-gray-400">
                {{ props.post?.updated_at }}
            </small>
        </div>
        <div v-if="props.commentOwner && props.commentOwnerTag">
            <h4 class="font-semibold " v-if="showName">
                <a href="javascript:void(0)" class="hover:underline">
                    {{ props.commentOwner?.user?.name }}
                </a>
            </h4>
            <small v-if="showTime && props.commentUserTag" class="text-gray-400">
                {{ props.commentOwner?.updated_at }}
            </small>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    post: {
        type: Object,
        required: false
    },
    showTime: {
        type: Boolean,
        required: false,
        default: true
    },
    showName: {
        type: Boolean,
        required: false,
        default: true
    },
    commentUserTag: {
        type: Boolean,
        required: false,
        default: false
    },
    commentUser: {
        type: Object,
        required: false
    },
    commentOwner: {
        type: Object,
        required: false
    },
    commentOwnerTag: {
        type: Boolean,
        required: false,
        default: false
    },
})

</script>

<style lang="scss" scoped></style>