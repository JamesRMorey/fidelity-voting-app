<script setup>
import { computed, onMounted, ref } from 'vue'
import HeadingSmall from '@/components/layout/headings/HeadingSmall.vue'
import RadioInput from '@/components/forms/inputs/RadioInput.vue'
import Api from '@/services/api'

const api = new Api();

const config = ref({
	loading: false,
	errors: [],
	errorMessage: null,
	showError: false,
	showThankYou: false,
})
const formData = ref({
	question_option_id: null,
});
const question = ref(null);
const options = computed(() => {
	return question.value?.options.map((option, i) => {
		return {
			value: option.id,
			label: option.description,
		}
	});
});

const getQuestion = async () => {
	try {
		config.value.loading = true;

		const response = await api.getRandomQuestion();
		question.value = response;
	} catch (error) {
		config.value.errorMessage = error.message;
		config.value.showError = true;
	} finally {
		config.value.loading = false;
	}
}

const handleVote = async () => {
	try {
		config.value.loading = true;
		config.value.errors = [];

		const vote = await api.vote(question.value.id, formData.value.question_option_id);

		config.value = {
			...config.value,
			showError: false,
			errorMessage: null,
			errors: [],
			showThankYou: true,
		}
	} catch (error) {
		if ( error.errors ) {
			config.value.errors = error.errors;
		} else {
			config.value.errorMessage = error.message;
			config.value.showError = true;
		}
	} finally {
		config.value.loading = false;
	}			
}

onMounted(() => {
	getQuestion();
});

</script>

<template>
	<div class="bg-teal-400">
		<div class="custom-container h-full flex flex-col items-center justify-center gap-16">
			<HeadingSmall />
			<div v-if="config.showError" class="card w-full lg:w-2/3 flex flex-col gap-10">
				<div class="flex flex-col gap-6">
					<p class="form-error-text text-center">{{ config.errorMessage }}</p>
				</div>
			</div>
			<div v-else-if="config.showThankYou" class="card w-full lg:w-2/3 flex flex-col gap-10">
				<div class="flex flex-col gap-6">
					<p class="text-center">Thank you for voting!</p>
				</div>
			</div>
			<form v-else class="card w-full lg:w-2/3 flex flex-col gap-10" @submit.prevent="handleVote">
				<div class="flex flex-col gap-6">
					<RadioInput
						v-if="options"
						label="Full Name" 
						type="text" 
						id="name" 
						name="favourite_colour"
						placeholder="Full Name"
						v-model="formData.question_option_id"
						:options="options"
						:errors="config.errors.question_option_id"
					/>
					<div v-else class="flex flex-col gap-6">
						<p class="form-error-text text-center">Loading...</p>
					</div>
				</div>	
				<div class="w-full flex justify-center">
					<button type="submit" class="btn btn-primary w-48">
						<span v-if="!config.loading">Vote</span>
						<span v-else class="animate-spin">X</span>
					</button>
				</div>
			</form>
			<div class="flex flex-col md:flex-row gap-5 md:gap-10 w-full justify-center items-center">
				<RouterLink :to="{ name: 'home' }" class="btn btn-tertiary w-4/5 md:w-48">Home</RouterLink>
			</div>
		</div>
	</div>
</template>
