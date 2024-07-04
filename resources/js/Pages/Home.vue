<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GroupList from '@/Components/lib/GroupList.vue'
import FollowingList from '@/Components/lib/FollowingList.vue';
import PostList from '@/Components/lib/PostList.vue';
import CreatePost from '@/Components/lib/CreatePost.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    posts: Object
});

</script>

<template>
    <Head title="Social-App" />
    <AuthenticatedLayout>
        <!-- <pre>{{ props.posts.data }}</pre> -->
        <div class="grid lg:grid-cols-12 gap-2 p-3 h-full">
            <div class="lg:col-span-3  lg:order-1 h-full overflow-hidden">
                <GroupList />
            </div>
            <div class="lg:col-span-3 lg:order-3 h-full overflow-hidden">
                <FollowingList />
            </div>
            <div class="lg:col-span-6 lg:order-2 h-full overflow-hidden flex flex-col">
                <CreatePost />
                <PostList :posts="props.posts.data" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
