<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');

    function updateIcon(theme) {
        if (theme === 'dark') {
            icon.className = "bi bi-sun-fill"; // 深色模式 → 顯示亮太陽
        } else {
            icon.className = "bi bi-moon-fill"; // 淺色模式 → 顯示月亮
        }
    }

    function setTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('theme', theme);
        updateIcon(theme);
    }

    // 初始化
    let currentTheme = document.documentElement.getAttribute('data-bs-theme');
    updateIcon(currentTheme);

    // 切換
    toggleBtn.addEventListener('click', function() {
        let newTheme = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
        setTheme(newTheme);
    });
});
</script>
