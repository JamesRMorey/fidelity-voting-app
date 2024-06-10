<script setup>
import { defineProps, toRefs, ref, watch } from 'vue';

const props = defineProps({
    modelValue: {
        required: false,
        default: '',
    },
    errors: {
        type: Array,
        required: false,
        default: () => [],
    },
    options: {
        type: Array,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
});

const { options, errors, modelValue, name } = toRefs(props);
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
    <div class="flex flex-col form-group gap-5">
        <div
            v-for="(option, i) in options"
            class="flex gap-5 items-center"
        >
            <input  
                type="radio" 
                :id="`${name}_${i}`" 
                :name="name" 
                :value="option.value"
                v-model="current"
            />
            <label class="form-radio flex justify-center items-center" :for="`${name}_${i}`">
                <font-awesome-icon v-if="current == option.value" :icon="['fas', 'check']" class="fa-lg"/>
            </label>
            <p class="text-2xl font-semibold">{{ option.label }}</p>
        </div>
        <p v-if="errors.length > 0" class="form-error-text">{{ errors[0] }}</p>
    </div>
</template>