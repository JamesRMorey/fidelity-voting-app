import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import Api from '@/services/api'


export const useAppStore = defineStore('app', () => {
	const user = ref(null);

	const api = new Api();

	const login = (email, password) => {
		return new Promise(async (resolve, reject) => {
			await api.login(email, password)
				.then((response) => {
					user.value = response;
					resolve(response);
				})
				.catch((error) => {
					reject(error);
				})
		});
	}

	const register = (name, email, password, confirmPassword) => {
		return new Promise(async (resolve, reject) => {
			await api.register(name, email, password, confirmPassword)
				.then((response) => {
					user.value = response;
					resolve(response);
				})
				.catch((error) => {
					reject(error);
				})
		});
	}

	const logout = () => {
		return new Promise(async (resolve, reject) => {
			await api.logout()
				.then(() => {
					user.value = null;
					resolve();
				})
				.catch((error) => {
					reject(error);
				})
		});
	}


	return {
		user,
		login,
		register,
		logout
	}

}, { persist: true });
