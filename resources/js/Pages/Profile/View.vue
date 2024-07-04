
<template>
    <AuthenticatedLayout>

        <div class="container h-full w-auto lg:w-[800px] mx-auto overflow-auto">
            <div class="mt-0 relative bg-white group">
                <img class="w-full h-[200px] object-cover"
                    :src="coverImgSrc || user.cover_url || 'https://cdn.pixabay.com/photo/2018/07/09/04/07/art-3525343_1280.png'"
                    alt="" />
                <!-- profile cover -->
                <div v-if="isYourProfile" class="absolute top-2 right-2">
                    <button v-if="!coverImgSrc" class=" flex gap-1 items-center 
                        bg-gray-50 opacity-0 group-hover:opacity-100 transition-all
                        hover:bg-slate-100 text-gray-700 px-2 py-1 text-sm rounded-full">
                        <PhotoIcon class="size-5" />
                        <span>Update Cover</span>
                        <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                            @change="onCoverChange" />
                    </button>
                    <div v-else class="flex flex-row gap-2 mt-2">
                        <button @click="cancelCoverImg" class="flex w-full gap-1 items-center justify-center
                            bg-gray-50 opacity-0 group-hover:opacity-100 transition-all
                            hover:bg-slate-100 text-gray-700 px-2 py-1 text-sm rounded-full">
                            <XMarkIcon class="size-4" />
                            <span>Cancel</span>
                        </button>
                        <button @click="submitCoverImg" class="flex w-full gap-1 items-center justify-center
                            bg-gray-700 opacity-0 group-hover:opacity-100 transition-all
                            hover:bg-slate-900 text-gray-100 px-3 py-1 text-sm rounded-full">
                            <CheckCircleIcon class="size-5" />
                            <span>Submit</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 bg-white ">
                <div
                    class="flex items-center justify-center relative group/avatar ml-[45px] -mt-[50px] size-[100px] rounded-full">
                    <img class="w-full h-full rounded-full object-cover"
                        :src="avatarImgSrc || user.avatar_url || 'https://cdn.pixabay.com/photo/2019/08/11/18/59/icon-4399701_1280.png'" />
                    <!-- profile avatar  -->
                    <button v-show="isYourProfile" v-if="!avatarImgSrc"
                        class="absolute left-0 right-0 top-0 bottom-0 flex 
                        items-center justify-center group-hover/avatar:opacity-50 group-hover/avatar:bg-gray-200 rounded-full">
                        <CameraIcon class="size-0 group-hover/avatar:text-gray-700 group-hover/avatar:size-8 opacity-75" />
                        <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                            @change="onAvatarChange" />
                    </button>
                    <div v-else class=" absolute inset-0 flex gap-2 justify-center items-center">
                        <button v-show="isYourProfile" @click="cancelAvatarImg"
                            class="size-6 bg-red-500 flex justify-center items-center rounded-full">
                            <XMarkIcon class="size-6 text-white" />
                        </button>
                        <button v-show="isYourProfile" @click="submitAvatarImg"
                            class="size-6 bg-green-500 flex justify-center items-center rounded-full">
                            <CheckCircleIcon class="size-6 text-white" />
                        </button>
                    </div>
                </div>
                <div class="flex p-3 justify-between flex-1 items-center">
                    <h2 class="font-semibold text-lg">
                        {{ user.name }}
                    </h2>
                    <PrimaryButton class="text-sm" v-if="isYourProfile">
                        <PencilSquareIcon class="size-4 mr-2" />
                        Edit profile
                    </PrimaryButton>
                </div>
            </div>
            <!-- Profile Notification -->
            <div v-if="showNotification" :class="['flex bg-white justify-center text-md font-semibold text-green-600 dark:text-green-400',
                props.status === 'cover-image-updated' || props.status === 'avatar-image-updated' ? 'p-2' : 'p-0'
            ]">
                <span v-if="props.status === 'cover-image-updated'">Your Cover image is updated.</span>
                <span v-if="props.status === 'avatar-image-updated'">Your Avatar image is updated.</span>
            </div>
            <div v-show="showErrorResult && props.errors.cover"
                class="flex py-2 bg-white justify-center text-md font-semibold text-red-600 dark:text-red-400">
                <span> {{ props.errors.cover }}</span>
            </div>
            <div v-show="showErrorResult && props.errors.avatar"
                class="flex py-2 bg-white justify-center text-md font-semibold text-red-600 dark:text-red-400">
                <span> {{ props.errors.avatar }}</span>
            </div>
            <!--Profile Notification -->
            <div>
                <TabGroup>
                    <TabList class="flex space-x-1 bg-white text-blue-500 p-1">
                        <Tab v-if="isYourProfile" as="template" v-slot="{ selected }">
                            <TabItem text="Bio" :selected="selected" />
                        </Tab>
                        <Tab as="template" v-slot="{ selected }">
                            <TabItem text="Posts" :selected="selected" />
                        </Tab>
                        <Tab as="template" v-slot="{ selected }">
                            <TabItem text="Followers" :selected="selected" />
                        </Tab>
                        <Tab as="template" v-slot="{ selected }">
                            <TabItem text="Followings" :selected="selected" />
                        </Tab>
                        <Tab as="template" v-slot="{ selected }">
                            <TabItem text="Photos" :selected="selected" />
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-0">
                        <TabPanel v-if="isYourProfile" class='bg-white px-3 py-4'>
                            <Edit :must-verify-email="props.mustVerifyEmail" :status="props.status" />
                        </TabPanel>
                        <TabPanel class='bg-white px-3 py-4'>
                            Posts Content
                        </TabPanel>
                        <TabPanel class='bg-white px-3 py-4'>
                            Followers Content
                        </TabPanel>
                        <TabPanel class='bg-white px-3 py-4'>
                            Followings Content
                        </TabPanel>
                        <TabPanel class='bg-white px-3 py-4'>
                            Photos Content
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TabItem from '@/Pages/Profile/Partials/TabItem.vue'
import Edit from './Edit.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { PencilSquareIcon, PhotoIcon, CheckCircleIcon, } from '@heroicons/vue/24/outline'
import { XMarkIcon, CameraIcon } from '@heroicons/vue/24/solid'
import { computed } from 'vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: {
        type: Object
    },
    errors: Object
});

const authUser = usePage().props.auth.user
const isYourProfile = computed(() => authUser && authUser.id === props.user.id)
const imagesForm = useForm({
    avatar: null,
    cover: null,
})
const coverImgSrc = ref('')
const avatarImgSrc = ref('')
const showErrorResult = ref(true)
const showNotification = ref(true)

const onCoverChange = (event) => {
    imagesForm.cover = event.target.files[0];
    if (imagesForm.cover) {
        const reader = new FileReader();
        reader.onload = () => {
            console.log('on load cover img')
            coverImgSrc.value = reader.result
        }
        reader.readAsDataURL(imagesForm.cover)
    }
}
const onAvatarChange = (event) => {
    imagesForm.avatar = event.target.files[0];
    if (imagesForm.avatar) {
        const reader = new FileReader();
        reader.onload = () => {
            console.log('on load avatar img')
            avatarImgSrc.value = reader.result
        }
        reader.readAsDataURL(imagesForm.avatar)
    }
}

const cancelCoverImg = () => {
    imagesForm.cover = null
    coverImgSrc.value = null
}
const cancelAvatarImg = () => {
    avatarImgSrc.value = null
    imagesForm.avatar = null
}

const submitCoverImg = () => {
    imagesForm.post(route('profile.updateImages'), {
        onSuccess: () => {
            cancelCoverImg()
            setTimeout(() => {
                showNotification.value = false
            }, 3000)
            showNotification.value = true
        }, onError: (error) => {
            if (error.cover) {
                cancelCoverImg()
                setTimeout(() => {
                    showErrorResult.value = false
                }, 3000)
                showErrorResult.value = true
            }
        }
    })
}
const submitAvatarImg = () => {
    imagesForm.post(route('profile.updateImages'), {
        onSuccess: () => {
            cancelAvatarImg()
            setTimeout(() => {
                showNotification.value = false
            }, 3000)
            showNotification.value = true
        }, onError: (error) => {
            if (error.avatar) {
                cancelAvatarImg()
                setTimeout(() => {
                    showErrorResult.value = false
                }, 3000)
                showErrorResult.value = true
            }
        }
    })
}

</script>




<style scoped></style>