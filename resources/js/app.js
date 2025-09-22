import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'

// 匯入頁面
import HomePage from './pages/HomePage.vue'
import LoginPage from './pages/auth/LoginPage.vue'
import RegisterPage from './pages/auth/RegisterPage.vue'

// 定義 router
const routes = [
    { path: '/', component: HomePage },
    { path: '/login', component: LoginPage },
    { path: '/register', component: RegisterPage },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

// 掛載 Vue
createApp(App).use(router).mount('#app')