<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/24/solid'
import GroupItem from '@/Components/lib/GroupItem.vue'
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

const seacrhKeyWord = ref('')
</script>

<template>
    <div class="w-full bg-white py-2 px-3 rounded-lg h-auto lg:h-fit border border-gray-200 flex flex-col">
        <Disclosure v-slot="{ open }">
            <DisclosureButton class="flex text-left lg:hidden justify-between items-center">
                <h2 class="text-xl font-bold px-3">My Groups</h2>
                <div v-if="open">
                    <ChevronUpIcon class="size-5" />
                </div>
                <div v-else>
                    <ChevronDownIcon class="size-5" />
                </div>
            </DisclosureButton>

            <DisclosurePanel class="h-full block lg:hidden">
                <div class="w-full py-2">
                    <TextInput v-model="seacrhKeyWord" placeholder="Type to Search" />
                </div>
                <div class="h-[125px] lg:flex-1 overflow-auto mt-2">
                    <div v-if="false" class="w-full text-gray-400 text-center p-3 justify-center">
                        You're yet to join a Group
                    </div>
                    <div v-else class="">
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                        <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                            title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>
        <div class="hidden lg:block">
            <h2 class="text-xl font-bold px-3">My Groups</h2>
            <div class="w-full py-2">
                <TextInput v-model="seacrhKeyWord" placeholder="Type to Search" />
            </div>
            <div class="h-[350px] lg:flex-1 overflow-auto mt-2">
                <div v-if="false" class="w-full text-gray-400 text-center p-3 justify-center">
                    You're yet to join a Group
                </div>
                <div v-else class="">
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Laravel men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                    <GroupItem image="https://cdn.pixabay.com/photo/2017/02/18/01/42/cube-2076347_1280.png"
                        title="Vue Js men" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped></style>