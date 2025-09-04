<div class="modal fade" id="favoritesModal" tabindex="-1">
    {{-- Do your work, then step back. --}}
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <h5>收藏到清單</h5>
            
            <form wire:submit.prevent="createCollection" class="mb-3">
                <div class="input-group">
                    <input type="text" wire:model="newCollectionName" class="form-control" placeholder="新增清單名稱">
                    <button class="btn btn-primary">新增</button>
                </div>
            </form>

            <div class="list-group">
                @foreach($collections as $col)
                    <label class="list-group-item">
                        <input type="checkbox" wire:model="selected" value="{{ $col->id }}"
                               wire:change="toggleCollection({{ $col->id }})">
                        {{ $col->name }}
                    </label>
                @endforeach
            </div>

            <div class="mt-3 text-end">
                <button class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>
