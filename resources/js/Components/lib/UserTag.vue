<template>
    <div class="flex items-center">
        <a href="javascript:void(0)">
            <img v-if="props.post?.user?.avatar_url"
                class="size-12 p-1 rounded-full ring-0 hover:ring-2 hover:ring-blue-400"
                :src="props.post.user.avatar_url" />
        </a>
        <div>
            <h4 class="font-semibold " v-if="showName">
                <a href="javascript:void(0)" class="hover:underline">
                    {{ props.post?.user?.name }}
                </a>
                <template v-if="props.post?.group?.name">
                    >{{ " " }}
                    <a href="javascript:void(0)" class="hover:underline">
                        {{ props.post.group.name }}
                    </a>
                </template>
            </h4>
            <small v-if="showTime" class="text-gray-400">{{ props.post?.updated_at }}</small>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    post: {
        type: Object,
        required: true
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
})
</script>

<style lang="scss" scoped></style>