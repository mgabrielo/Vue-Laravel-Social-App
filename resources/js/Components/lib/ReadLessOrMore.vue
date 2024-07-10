<template>
    <Disclosure v-slot="{ open }" v-if="props.body" as="div" class="flex flex-col w-full">
        <div class="ck-content text-lg" v-if="!open && props.body.length < 100" v-html="props.body" />
        <div class="ck-content text-lg" v-if="!open && props.body.length > 100"
            v-html="props.body.substring(0, 100) + '...'" />
        <DisclosurePanel>
            <div class="ck-content text-lg" v-html="props.body" />
        </DisclosurePanel>
        <div class="flex justify-end px-3">
            <DisclosureButton v-if="props.body.length > 100" class="text-lg text-blue-500 mt-2 hover:underline">
                <span>{{ !open ? "Read More" : "Read Less" }}</span>
            </DisclosureButton>
        </div>
    </Disclosure>
</template>

<script setup>
import {
    Disclosure, DisclosureButton, DisclosurePanel,
} from '@headlessui/vue'

const props = defineProps({
    body: {
        type: String,
        required: false
    },
})
</script>

<style lang="scss" scoped></style>