import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '@/views/auth/LoginView.vue'
import RegisterView from '@/views/auth/RegisterView.vue'
import VoteView from '@/views/VoteView.vue'
import { useAppStore } from '@/stores/app-store'

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'home',
			component: HomeView
		},
		{
			path: '/login',
			name: 'login',
			component: LoginView,
			meta: { guest: true }
		},
		{
			path: '/register',
			name: 'register',
			component: RegisterView,
			meta: { guest: true }
		},
		{
			path: '/vote/',
			name: 'vote',
			component: VoteView,
			meta: { auth: true }
		},
	]
})

router.beforeEach(async (to) => {    

    if ( !to.meta ) return;

    const appStore = useAppStore();
    await appStore.getUser()
        .then(() => {})
        .catch(() => {})

    if( to.meta.auth && !appStore.user ) return { name: 'login' };
    if ( to.meta.guest && appStore.user ) return { name: 'home' }
})

export default router
