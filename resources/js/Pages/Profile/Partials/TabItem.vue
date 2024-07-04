<template>
    <button :class="[
        'w-full py-2.5 text-sm font-medium leading-5',
        selected
            ? 'bg-white text-blue-700 outline-none ring-offset-0 text-sm border-b-2 border-blue-500'
            : 'text-gray-700 hover:text-blue-500  ',
    ]">
        {{ text }}
    </button>
</template>

<script setup>
defineProps({
    selected: Boolean,
    text: String
})
</script>

<style lang="scss" scoped></style>