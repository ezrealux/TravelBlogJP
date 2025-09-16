<template>
    <button @click="toggleTheme">切换主题</button>
</template>

<script>
import Navbar from './components/Navbar.vue';

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            user: {
                name: 'John Doe',
                avatar: 'path/to/avatar.png',
                email: 'john@example.com',
            },
        };
    },
    methods: {
        toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        },
    },
};
</script>

<style scoped>
/* Global styles for App.vue */
</style>