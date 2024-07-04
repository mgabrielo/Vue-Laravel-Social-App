<script setup>
defineProps({
    image: String,
    title: String,
})
</script>


<template>
    <div class="flex items-start mb-3 cursor-pointer rounded-md hover:bg-gray-200">
        <div class="flex items-start p-2 gap-2">
            <img class="size-[32px] rounded-full" :src="image" alt="flower">
            <div>
                <h3 class="font-semibold text-lg">{{ title }}</h3>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
