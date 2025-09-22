<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <!-- Logo -->
        <router-link class="navbar-brand" to="/">Blogg</router-link>

        <!-- Toggle button (mobile) -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarsExample"
            aria-controls="navbarsExample"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div id="navbarsExample" class="collapse navbar-collapse">
            <!-- Left menu -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <router-link class="nav-link" to="/">最新文章</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/categories">地區分類</router-link>
                </li>
            </ul>

                    <!-- Search -->
                    <form class="d-flex ms-auto" @submit.prevent="onSearch">
                        <input
                            v-model="searchQuery"
                            class="form-control me-2"
                            type="search"
                            placeholder="Search users, articles, tags..."
                            aria-label="Search"
                        />
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>

                    <!-- Right menu -->
                    <ul class="navbar-nav ms-auto">
                    <template v-if="isLoggedIn">
                        <li class="nav-item">
                            <router-link class="nav-link btn" to="/articles/create">
                                <i class="bi bi-pencil-square"></i>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-bell-fill"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-envelope-fill"></i></a>
                        </li>

                        <!-- Avatar dropdown -->
                        <li class="nav-item dropdown">
                            <a
                                id="navbarAvatar"
                                class="nav-link dropdown-toggle d-flex align-items-center"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                                <img
                                :src="user.avatar"
                                alt="avatar"
                                class="rounded-circle"
                                style="width:32px; height:32px; object-fit:cover;"
                                />
                            </a>

                        <div
                            class="dropdown-menu dropdown-menu-end shadow"
                            aria-labelledby="navbarAvatar"
                            style="min-width: 220px;"
                        >
                            <!-- User info -->
                            <div class="px-3 py-2 text-center border-bottom">
                                <img
                                    :src="user.avatar"
                                    alt="avatar"
                                    class="rounded-circle mb-2"
                                    style="width:60px; height:60px; object-fit:cover;"
                                />
                                <div class="fw-bold">{{ user.name }}</div>
                                <small class="text-muted">{{ user.email }}</small>
                            </div>

                            <!-- Menu items -->
                            <router-link class="dropdown-item" :to="`/users/${user.slug}`">主頁</router-link>

                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item text-danger" @click="logout">登出</button>

                            <li class="nav-item d-flex align-items-center">
                            <button id="themeToggle" class="btn btn-link nav-link" @click="toggleTheme">
                                <i :class="themeIcon"></i>
                            </button>
                            </li>
                        </div>
                        </li>
                    </template>

                    <template v-else>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/login">登入</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/register">註冊</router-link>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

// 假資料，正式專案應該來自 Pinia / Vuex / API
const isLoggedIn = ref(true)
const user = ref({
  name: 'Demo User',
  email: 'demo@example.com',
  slug: 'demo-user',
  avatar: '/images/default-avatar.png',
})

const searchQuery = ref('')
const router = useRouter()

// 搜尋事件
const onSearch = () => {
    if (searchQuery.value.trim()) {
        router.push({ path: '/search', query: { q: searchQuery.value } })
    }
}

// 登出事件
const logout = () => {
    console.log('登出中...')
    // axios.post('/logout') => 然後清掉使用者狀態
    isLoggedIn.value = false
}

// 深色/淺色模式切換
const isDark = ref(false)
const themeIcon = computed(() => (isDark.value ? 'bi bi-sun-fill' : 'bi bi-moon-fill'))
const toggleTheme = () => {
    isDark.value = !isDark.value
    document.body.classList.toggle('dark-mode', isDark.value)
}
</script>
