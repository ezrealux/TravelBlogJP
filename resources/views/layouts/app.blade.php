<!doctype html>
<html lang="zh-Hant">
    <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Blog') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    @stack('styles')
    <script>
      // 從localStorage讀取theme('dark'/'light') 並設定到html底下
      document.addEventListener('DOMContentLoaded', function() {
          const root = document.documentElement;

          // 初始化：從 localStorage 或系統偏好讀取
          let theme = localStorage.getItem('theme')
              || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
          root.setAttribute('data-bs-theme', theme);

          const toggleBtn = document.getElementById('themeToggle');
          const icon = document.getElementById('themeIcon');

          function updateIcon(theme) {
              if (theme === 'dark') {
                  icon.className = "bi bi-sun-fill"; // 深色模式 → 顯示太陽
              } else {
                  icon.className = "bi bi-moon-fill"; // 淺色模式 → 顯示月亮
              }
          }

          function setTheme(newTheme) {
              root.setAttribute('data-bs-theme', newTheme);
              localStorage.setItem('theme', newTheme);
              updateIcon(newTheme);
          }

          // 初始化 icon
          updateIcon(theme);

          // 點擊切換
          if (toggleBtn) {
              toggleBtn.addEventListener('click', function() {
                  let currentTheme = root.getAttribute('data-bs-theme');
                  let newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                  setTheme(newTheme);
              });
          }
      });
    </script>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
  </head>

  <body>
    <div id="app">
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
              <form class="d-flex ms-auto" action="{{ route('articles.bySearch') }}" method="GET">
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
              @auth
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
                    {{-- 頭像按鈕 --}}
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

                  {{-- Dropdown Menu --}}
                  <!--dropdown-menu-lg-start -->
                  <div class="dropdown-menu dropdown-menu-end shadow" 
                      aria-labelledby="navbarAvatar"
                      style="min-width: 220px;">

                      {{-- 使用者資訊 --}}
                      <div class="px-3 py-2 text-center border-bottom">
                          <img src="{{ asset(Auth::user()->avatar ?? 'storage/app/public/avatars/default-avatar.png') }}"
                              alt="avatar"
                              class="rounded-circle mb-2"
                              style="width:60px; height:60px; object-fit:cover;">
                          <div class="fw-bold">{{ Auth::user()->name }}</div>
                          <small class="text-muted">{{ Auth::user()->email }}</small>
                      </div>

                      {{-- 功能選單 --}}
                      <a class="dropdown-item" href="{{ route('users.show', Auth::user()->slug) }}">主頁</a>

                      <div class="dropdown-divider"></div>
                      <form action="{{ route('logout') }}" method="POST">
                          @csrf
                          <button type="submit" class="dropdown-item text-danger">登出</button>
                      </form>

                      <li class="nav-item d-flex align-items-center">
                        <button id="themeToggle" class="btn btn-link nav-link">
                          {{-- 預設 icon (淺色模式：月亮、深色模式：太陽) --}}
                          <i id="themeIcon" class="bi"></i>
                        </button>
                      </li>
                  </div>
                </li>
              @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登入</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">註冊</a></li>
              @endauth
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <!-- navbar-expand-lg：視窗 >= large(lg):,navbar會展開；視窗 < lg: 折疊成漢堡選單 -->

    <main class="container">
      @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    @stack('scripts')
    @stack('ckeditor')
  </body>
</html>