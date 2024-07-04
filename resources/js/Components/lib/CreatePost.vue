<script setup>
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import PostModal from '@/Components/lib/PostModal.vue'

const authUser = usePage().props.auth.user
const showCreateModal = ref(false)
const newPost = ref({
    id: null,
    body: '',
    user: authUser
})

const submitForm = () => {

}

const showCreatePostModal = () => {
    console.log('true')
    showCreateModal.value = true
}

</script>


<template>
    <div class="py-4 px-3 bg-white rounded-lg border border-gray-200 mb-2">
        <div class="w-full p-0 z-50" @click="showCreatePostModal">
            <TextInput :more-class="['w-full border-gray-300 py-1 px-2 dark:border-gray-700 dark:bg-gray-900',
                'dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 ',
                'dark:focus:ring-indigo-600 focus:ring-indigo-500 rounded-md shadow-sm overflow-hidden',
            ]" placeholder="Start Here to Create Post" :rows="1" v-model="newPost.body" :auto-resize="true">
            </TextInput>
        </div>
        <!-- <pre>{{ newPost.body }}</pre> -->
        <!-- <div  class="flex gap-2 justify-between">
            <button type="button" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white 
                shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 
                focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative">
                Attach Files
                <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0" />
            </button>
            <button @click="submitForm" type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white 
                shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 
                focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Save
            </button>
        </div> -->
        <PostModal :post="newPost" v-model="showCreateModal" />
    </div>
</template>


<style scoped></style>