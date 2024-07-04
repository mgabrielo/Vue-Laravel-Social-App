<script setup>
import GroupItem from '@/Components/lib/GroupItem.vue'
import TextInput from '@/Components/TextInput.vue';
import FollowingItem from './FollowingItem.vue';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/24/solid'

import { ref } from 'vue';

const seacrhKeyWord = ref('')
</script>

<template>
    <div class="w-full px-3 py-2 bg-white rounded-lg lg:h-fit border border-gray-200 flex flex-col">
        <Disclosure v-slot="{ open }">
            <DisclosureButton class="flex text-left lg:hidden justify-between items-center transition-all">
                <h2 class="text-xl font-bold px-3">My Followings</h2>
                <div v-if="open">
                    <ChevronUpIcon class="size-5 transition-all" />
                </div>
                <div v-else>
                    <ChevronDownIcon class="size-5 transition-all" />
                </div>
            </DisclosureButton>

            <DisclosurePanel class="block lg:hidden">
                <div class="w-full py-2">
                    <TextInput v-model="seacrhKeyWord" placeholder="Type to Search" />
                </div>
                <div class="h-[125px] lg:flex-1 overflow-auto mt-2">
                    <div v-if="false" class="text-gray-400 flex text-center p-3">
                        You're yet to have any followers
                    </div>
                    <div v-else>
                        <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Jason Scott" />
                        <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Jack Grey" />
                        <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Jason Scott" />
                        <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Jack Grey" />
                        <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Jason Scott" />
                        <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Jack Grey" />
                        <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Jason Scott" />
                        <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Jack Grey" />
                        <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Jason Scott" />
                        <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Jack Grey" />
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>
        <div class="hidden lg:block">
            <h2 class="text-xl font-bold px-3">My Followings</h2>
            <div class="w-full py-2">
                <TextInput v-model="seacrhKeyWord" placeholder="Type to Search" />
            </div>
            <div class="h-[350px] lg:flex-1 overflow-auto mt-2">
                <div v-if="false" class="text-gray-400 flex text-center p-3">
                    You're yet to have any followers
                </div>
                <div v-else>
                    <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Jason Scott" />
                    <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Jack Grey" />
                    <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Jason Scott" />
                    <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Jack Grey" />
                    <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Jason Scott" />
                    <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Jack Grey" />
                    <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Jason Scott" />
                    <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Jack Grey" />
                    <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Jason Scott" />
                    <FollowingItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Jack Grey" />
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped></style>