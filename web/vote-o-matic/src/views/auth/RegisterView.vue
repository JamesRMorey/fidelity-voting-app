<script setup>
import { ref } from 'vue'
import HeadingSmall from '@/components/layout/headings/HeadingSmall.vue'
import TextInput from '@/components/forms/inputs/TextInput.vue'
import { useAppStore } from '@/stores/app-store'
import { useRouter } from 'vue-router'

const appStore = useAppStore();
const router = useRouter();

const config = ref({
	loading: false,
	errors: [],
})
const data = ref({
	name: '',
	email: '',
	password: '',
	confirmPassword: ''
});

const handleRegister = async () => {
	try {
		config.value.loading = true;
		config.value.errors = [];

		const response = await appStore.register(data.value.name, data.value.email, data.value.password, data.value.confirmPassword);

		router.push({ name: 'home' });

	} catch (error) {
		if ( error.errors ) {
			config.value.errors = error.errors;
		}
	} finally {
		config.value.loading = false;
	}			
}

</script>

<template>
	<div class="bg-teal-400">
		<div class="custom-container h-full flex flex-col items-center justify-center gap-16">
			<HeadingSmall />
			<form class="card w-full lg:w-2/3 flex flex-col gap-10" @submit.prevent="handleRegister">
				<div class="flex flex-col gap-6">
					<TextInput 
						label="Full Name" 
						type="text" 
						id="name" 
						placeholder="Full Name"
						v-model="data.name"
						:errors="config.errors.name"
					/>
					<TextInput 
						label="Email" 
						type="email" 
						id="email" 
						placeholder="Email"
						v-model="data.email"
						:errors="config.errors.email"
					/>
					<TextInput 
						label="Password" 
						type="password" 
						id="password" 
						placeholder="Password"
						v-model="data.password"
						:errors="config.errors.password"
					/>
					<TextInput 
						label="Confirm Password" 
						type="password" 
						id="comfirm_pasword" 
						placeholder="Confirm Password"
						v-model="data.confirmPassword"
					/>
				</div>	
				<div class="w-full flex justify-center">
					<button type="submit" class="btn btn-primary w-48">
						<span v-if="!config.loading">Register</span>
						<span v-else class="animate-spin">X</span>
					</button>
				</div>
			</form>
			<div class="flex flex-col md:flex-row gap-5 md:gap-10 w-full justify-center items-center">
				<RouterLink :to="{ name: 'home' }" class="btn btn-tertiary w-48">Home</RouterLink>
				<RouterLink :to="{ name: 'login' }" class="btn btn-secondary w-48">Login</RouterLink>
			</div>
		</div>
	</div>
</template>
