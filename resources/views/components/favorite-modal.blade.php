<!-- resources/views/components/favorite-modal.blade.php -->
<!-- The whole future lies in uncertainty: live immediately. - Seneca -->

<!--給整個modal賦予獨特id favoriteModal-[文章id]-->
@php $modalId = 'favoriteModal-'.$article->id; @endphp

<button class="btn btn-outline-primary"
        data-bs-toggle="modal"
        data-bs-target="#{{ $modalId }}"
        data-article-id="{{ $article->id }}">
    <i class="bi bi-heart"></i> 收藏
</button>

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true" data-article-id="{{ $article->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">收藏到清單</h5>
      </div>
      <div class="modal-body">
        <form id="favorite-form">
          @foreach(auth()->user()->favoriteLists as $list)
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="lists[]"
                value="{{ $list->id }}" id="list{{ $list->id }}"
                {{ $article->favoriteLists->contains($list->id) ? 'checked' : '' }}>
              <label class="form-check-label" for="list{{ $list->id }}">
                {{ $list->name }}
              </label>
            </div>
          @endforeach
        </form>
        <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#newListModal">➕ 新增清單</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="newListModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="new-list-form" class="modal-content">
      <div class="modal-header"><h5>新增清單</h5></div>
      <div class="modal-body">
        <input type="text" name="name" class="form-control" placeholder="清單名稱" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">建立</button>
      </div>
    </form>
  </div>
</div>

<script>
document.querySelectorAll('[id^="favoriteModal-"]').forEach(modalEl => {
    const modal = modalEl;
    let articleId = modal.dataset.articleId;

    // Modal 開啟時
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        articleId = button.getAttribute('data-article-id');
    });

    modal.addEventListener('hide.bs.modal', function () {
        if (!articleId) return;

        const form = modal.querySelector('form');
        const data = new FormData(form);

        fetch(`/favoriteLists/${articleId}/sync`, {
            method: "POST",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: data
        });
    });
});

// 新增清單
document.getElementById('new-list-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const data = new FormData(this);

    fetch("{{ route('favoriteLists.store') }}", {
        method: "POST",
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: data
    })
    .then(r => r.json())
    .then(list => {
        bootstrap.Modal.getInstance(document.getElementById('newListModal')).hide();
        alert(`成功建立清單：${list.name}`);
    })
    .catch(err => alert("建立失敗"));
});
</script>
