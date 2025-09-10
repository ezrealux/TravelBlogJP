@extends('layouts.app')

@section('content')
<div class="container">
    <h1>編輯個人資料</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-4" id="ProfileEditForm"> 
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">使用者名稱</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">自訂網址 Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $user->slug) }}" required>
            <small class="text-muted">將用於網址，例如：/users/{{ old('slug', $user->slug) }}</small>
        </div>

        <div class="mb-3">
            <label for="bio" class="form-label">自我介紹</label>
            <textarea class="form-control" id="bio" name="bio" rows="4">
                {{ old('bio', $user->bio) }}
            </textarea>
        </div>

        {{-- 共用圖片裁切元件 --}}
        <x-image-cropper 
            name="avatar" 
            label="頭像"
            aspect="1"
            :preview="$user->avatar ?? 'storage/avatars/default-avatar.png'"
        />

        <button type="submit" class="btn btn-primary">更新資料</button>
    </form>

    <hr class="my-4">

    {{-- 2FA 功能 --}}
    <h3>雙因子驗證 (2FA)</h3>
    @if (auth()->user()->two_factor_secret)
        <form method="POST" action="{{ route('two-factor.disable') }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">停用雙因子驗證</button>
        </form>

        <div class="mt-3">
            <h6>恢復代碼 (請妥善保存)</h6>
            <ul>
                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                    <li>{{ $code }}</li>
                @endforeach
            </ul>
        </div>
    @else
        <form method="POST" action="{{ route('two-factor.enable') }}">
            @csrf
            <button type="submit" class="btn btn-success" disabled>啟用雙因子驗證</button>
        </form>
    @endif
</div>

@push('ckeditor')
<script>
    ClassicEditor
        .create(document.querySelector('#bio'))
        .catch(error => console.error(error));
</script>
@endpush
@endsection