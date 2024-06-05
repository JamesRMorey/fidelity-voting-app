<script setup>
import { ref } from 'vue'
import Container from '@/components/layout/Container.vue'
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
	email: '',
	password: '',
});

const handleLogin = async () => {
	try {
		config.value.loading = true;
		config.value.errors = [];
		await appStore.login(data.value.email, data.value.password);

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
	<div class="h-screen min-w-screen bg-teal-400">
		<div class="custom-container h-full flex flex-col items-center justify-center gap-16">
			<HeadingSmall />
			<form class="card w-full lg:w-2/3 flex flex-col gap-10" @submit.prevent="handleLogin">
				<div class="flex flex-col gap-6">
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
				</div>	
				<div class="w-full flex justify-center">
					<button type="submit" class="btn btn-primary w-48">
						<span v-if="!config.loading">Login</span>
						<span v-else class="animate-spin">X</span>
					</button>
				</div>
			</form>
			<div class="flex flex-col md:flex-row gap-5 md:gap-10 w-full justify-center items-center">
				<RouterLink :to="{ name: 'home' }" class="btn btn-tertiary w-4/5 md:w-48">Home</RouterLink>
				<RouterLink :to="{ name: 'register' }" class="btn btn-secondary w-4/5 md:w-48">Register</RouterLink>
			</div>
		</div>
	</div>
</template>
