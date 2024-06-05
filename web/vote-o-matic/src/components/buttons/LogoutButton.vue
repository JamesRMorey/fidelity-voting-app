<script setup>
import { ref } from 'vue'
import { useAppStore } from '@/stores/app-store'

const appStore = useAppStore();

const config = ref({
    loading: false,
});

const logout = async () => {
    try {
        config.value.loading = true;
        await appStore.logout();
    } catch (error) {
        console.log(error);
    } finally {
        config.value.loading = false;
    }
}

</script>

<template>
    <button @click="logout" class="btn btn-secondary w-48">
        <span v-if="config.loading" class="animate-spin">X</span>
        <span v-else>Logout</span>
    </button>
</template>