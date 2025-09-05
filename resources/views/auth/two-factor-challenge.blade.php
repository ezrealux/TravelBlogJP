@extends('layouts.app')

@section('content')
<div class="container">
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
    <h3>雙因子驗證</h3>
    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <div class="mb-3">
            <label>驗證碼 (Authenticator App)</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>或使用恢復代碼</label>
            <input type="text" name="recovery_code" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">確認</button>
    </form>
</div>
@endsection
