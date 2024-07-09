<template>
    <Menu v-if="props.isYourProfile" as="div" class="relative inline-block text-left">
        <div>
            <MenuButton class="inline-flex w-full z-10">
                <EllipsisVerticalIcon class="size-5 font-semibold" />
            </MenuButton>
        </div>
        <transition enter-active-class="transition duration-100 ease-out" enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
            <MenuItems
                class="absolute right-0 mt-2 z-30 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                    <button :class="[
                        active ? 'bg-slate-100' : 'bg-transparent',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm text-gray-900',
                    ]" @click="$emit('edit')">
                        <PencilIcon :active="active" class="mr-2 h-5 w-5 text-slate-700" aria-hidden="true" />
                        Edit
                    </button>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                    <button :class="[
                        active ? 'bg-slate-100' : 'bg-transparent',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm text-gray-900',
                    ]" @click="$emit('delete')">
                        <TrashIcon :active="active" class="mr-2 h-5 w-5 text-slate-700" aria-hidden="true" />
                        Delete
                    </button>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { EllipsisVerticalIcon } from '@heroicons/vue/24/solid'

defineEmits(['edit', 'delete'])

const props = defineProps({
    isYourProfile: {
        type: Boolean,
        required: true,
    }
})
</script>

<style lang="scss" scoped></style>