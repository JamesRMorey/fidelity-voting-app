<script setup>
import { defineProps, toRefs, ref, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        required: false,
        default: '',
    },
    label: {
        type: String,
        required: false,
        default: '',
    },
    errors: {
        type: Array,
        required: false,
        default: () => [],
    },
    placeholder: {
        type: String,
        required: false,
        default: '',
    },
    type: {
        type: String,
        required: false,
        default: 'text',
    },
    id: {
        type: String,
        required: false,
        default: '',
    },
});

const { errors, modelValue, placeholder, label, type, id } = toRefs(props);
const emit = defineEmits(['update:modelValue']);

const current = ref(modelValue.value ?? null);

watch(modelValue, (value) => {
    if (value === current.value) return;
    current.value = value;
});

watch(current, (value) => {
    emit('update:modelValue', value);
});

</script>

<template>
    <div class="flex flex-col gap-1 form-group group">
        <div class="flex flex-row justify-start items-center gap-3">
            <label v-if="label" :for="id">{{ label }}</label>
            <p v-if="errors.length > 0" class="hidden lg:inline-block form-error-text">{{ errors[0] }}</p>
        </div>
        <input 
            class="form-input"
            :type="type"
            :placeholder="placeholder"
            v-model="current"
            :id="id"
            :class="{ 'form-error': errors.length > 0 }"
        />
        <p v-if="errors.length > 0" class="lg:hidden form-error-text">{{ errors[0] }}</p>
    </div>
</template>