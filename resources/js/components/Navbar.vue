<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('articles.index') }}">Blogg</a>
            <!--
            data-bs-toggle="collapse"           這是個「可收合」的按鈕。
            data-bs-target="#navbarsExample"	  點下去之後讓 id=navbarsExample 的物件展開/收合
            aria-controls="navbarsExample"      可存取性設定，指出控制的區塊 ID。
            aria-expanded="false"               表示目前狀態為「未展開」。
            aria-label="Toggle navigation"      給螢幕閱讀器用的描述文字。
            <span class="navbar-toggler-icon">	三條橫線的漢堡圖示。
            -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample" aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navbarsExample" class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('articles.index') }}">最新文章</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">地區分類</a></li>
                </ul>

                <ul>
                    <form class="d-flex ms-auto" action="{{ route('search.index') }}" method="GET">
                    <input
                        class="form-control me-2"
                        type="search"
                        name="query"
                        placeholder="Search users, articles, tags..."
                        value="{{ request('query') }}"
                        aria-label="Search"
                    >
                    <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <div v-if="user">
                        <li class="nav-item">
                            <a class="nav-link btn" href="{{ route('articles.create') }}">
                            <i class="bi bi-pencil-square"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href=""><i class="bi bi-bell-fill"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href=""><i class="bi bi-envelope-fill"></i></a>
                        </li>

                        <!--asset(...): Laravel 的 helper，會把路徑補上網站的 base URL，例如：
                            asset('images/default-avatar.png') -> https://yourdomain.com/images/default-avatar.png-->
                        <li class="nav-item dropdown ">
                        <!--dropdown: bootstrap觸發下拉功能-->
                            <!-- 頭像按鈕 -->
                            <a id="navbarAvatar"
                                class="nav-link dropdown-toggle d-flex align-items-center"
                                href="#" role="button"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset(Auth::user()->avatar ?? 'storage/avatars/default-avatar.png') }}"
                                    alt="avatar"
                                    class="rounded-circle"
                                    style="width:32px; height:32px; object-fit:cover;">
                            </a>
                            <!--aria-haspopup="true"	表示是個「彈出式選單」螢幕閱讀器會告知使用者(小箭頭)
                                aria-expanded="false" 目前是閉合狀態-->

                            <!--dropdown-menu-lg-start -->
                            <div class="dropdown-menu dropdown-menu-end shadow" 
                                aria-labelledby="navbarAvatar"
                                style="min-width: 220px;">

                                <! User info -->
                                <div class="px-3 py-2 text-center border-bottom">
                                    <img :src="user.avatar_url"
                                        alt="avatar"
                                        class="rounded-circle mb-2"
                                        style="width:60px; height:60px; object-fit:cover;">
                                    <div class="fw-bold">{{ user.name }}</div>
                                    <small class="text-muted">{{ user.email }}</small>
                                </div>

                                <! 功能選單 -->
                                <a class="dropdown-item" href="{{ routes.userProfile }}">主頁</a>

                                <div class="dropdown-divider"></div>
                                <button type="submit" class="dropdown-item text-danger" @click="logout">登出</button>

                                <li class="nav-item d-flex align-items-center">
                                <button id="themeToggle" class="btn btn-link nav-link">
                                    <!-- 預設 icon (淺色模式：月亮、深色模式：太陽) -->
                                    <i id="themeIcon" class="bi"></i>
                                </button>
                                </li>
                            </div>
                        </li>
                    </div>
                    <div v-else>
                        <li class="nav-item"><a class="nav-link" href="{{ routes.login }}">登入</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ routes.register }}">註冊</a></li>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
            required: false,
            default: () => null
        }
        user: Object,
        routes: Object,
        csrf: String
    },
    data() {
        return {
        searchQuery: '',
        };
    },
    methods: {
        // 处理主题切换的事件
        toggleTheme() {
        this.$emit('theme-toggle');
        },
    },
};
</script>

<style scoped>
/* Navbar 相关的样式 */
</style>