<div wire:ignore.self class="modal fade" id="favoritesModal" tabindex="-1" aria-labelledby="favoritesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <h5 class="modal-title" id="favoritesModalLabel">收藏到清單</h5>

            <!-- 建立清單 -->
            <form wire:submit.prevent="createFavoriteList" class="mb-3">
                <div class="input-group">
                    <input type="text" wire:model="newListName" class="form-control" placeholder="新增清單名稱">
                    <button class="btn btn-primary">新增</button>
                </div>
            </form>

            <!-- 清單勾選 -->
            <div class="list-group">
                @foreach($favoriteLists as $col)
                    <label class="list-group-item">
                        <input type="checkbox"
                               value="{{ $col['id'] }}"
                               wire:click="toggleFavoriteList({{ $col['id'] }})"
                               @checked(in_array($col['id'], $selected))>
                        {{ $col['name'] }}
                    </label>
                @endforeach
            </div>

            <!-- 關閉按鈕 -->
            <div class="mt-3 text-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>
