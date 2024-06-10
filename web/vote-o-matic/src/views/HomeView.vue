<script setup>
import HeadingLarge from '@/components/layout/headings/HeadingLarge.vue'
import { useAppStore } from '@/stores/app-store'
import { storeToRefs } from 'pinia'
import LogoutButton from '@/components/buttons/LogoutButton.vue'

const appStore = useAppStore();

const { user } = storeToRefs(appStore);

</script>

<template>
	<div class="bg-teal-400">
		<div class="custom-container h-full flex flex-col items-center justify-center">
			<div v-if="user" class="w-full relative">
				<div class="absolute bottom-10 right-0">
					<LogoutButton />
				</div>
			</div>
			<div class=" mb-10 lg:mb-32 relative">
				<HeadingLarge />
			</div>
			<div class="flex flex-col md:flex-row max-sm:mt-6 gap-5 md:gap-10">
				<RouterLink v-if="!user" :to="{ name: 'login' }" class="btn btn-primary w-48">Login</RouterLink>
				<RouterLink v-if="!user" :to="{ name: 'register' }" class="btn btn-secondary w-48">Register</RouterLink>
				<RouterLink v-else :to="{ name: 'vote' }" class="btn btn-primary w-48">Vote</RouterLink>
			</div>
		</div>
	</div>
</template>
