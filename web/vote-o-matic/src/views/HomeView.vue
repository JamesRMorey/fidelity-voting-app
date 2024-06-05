<script setup>
import Container from '@/components/layout/Container.vue'
import HeadingLarge from '@/components/layout/headings/HeadingLarge.vue'
import { useAppStore } from '@/stores/app-store'
import { storeToRefs } from 'pinia'
import LogoutButton from '@/components/buttons/LogoutButton.vue'

const appStore = useAppStore();

const { user } = storeToRefs(appStore);
console.log(user.value);
</script>

<template>
	<div class="h-screen min-w-screen bg-teal-400">
		<div class="custom-container h-full flex flex-col items-center justify-center">
			<div v-if="user" class="w-full relative">
				<div class="absolute bottom-10 right-0">
					<LogoutButton />
				</div>
			</div>
			<div class="mb-32 relative">
				<HeadingLarge />
			</div>
			<div class="flex gap-10">
				<RouterLink v-if="!user" :to="{ name: 'login' }" class="btn btn-primary w-48">Login</RouterLink>
				<RouterLink v-if="!user" :to="{ name: 'register' }" class="btn btn-secondary w-48">Register</RouterLink>
				<RouterLink v-else :to="{ name: 'login' }" class="btn btn-primary w-48">Vote</RouterLink>
			</div>
		</div>
	</div>
</template>
