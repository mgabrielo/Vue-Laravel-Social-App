<script setup>
import { onMounted, ref, watch } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

const props = defineProps({
    placeholder: {
        type: String,
        required: false
    },
    autoResize: {
        type: Boolean,
        required: false
    },
    rows: {
        type: Number,
        required: false
    },
    moreClass: {
        type: Array,
        required: false
    },
    readonly: {
        type: Boolean,
        required: false,
        default: false
    }
})

function adjustInputHeight() {
    if (props.autoResize && input.value) {
        input.value.style.height = 'auto'
        input.value.style.height = input.value.scrollHeight + 'px'
    }
}

defineExpose({ focus: () => input.value.focus() });

function onInputChange() {
    adjustInputHeight()
}

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
    adjustInputHeight()
});

watch(() => model.value, () => {
    setTimeout(() => {
        adjustInputHeight()
    }, 10);
})

</script>

<template>
    <div v-if="!autoResize" class="w-full">
        <input
            class="w-full border-gray-300 py-1 px-2 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            v-model="model" ref="input" :placeholder="props.placeholder" />
    </div>
    <div v-if="autoResize" class="w-full">
        <textarea :class="[
            moreClass ?
                moreClass :
                'w-full overflow-hidden border-gray-300 py-1 px-2 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'
        ]" v-model="model" ref="input" :placeholder="props.placeholder" @input="onInputChange" :rows="1"
            :readonly="readonly"></textarea>
    </div>
</template>
