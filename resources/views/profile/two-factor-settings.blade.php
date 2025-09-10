@extends('layouts.app')

@section('content')
<!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
<div class="container">
    <h3>雙因子驗證設定</h3>

    @if (session('status') == 'two-factor-authentication-enabled')
        <div class="alert alert-success">
            已啟用雙因子驗證，請使用 Google Authenticator 掃描 QR Code。
        </div>
    @endif

    @if (!auth()->user()->two_factor_secret)
        <form method="POST" action="{{ route('two-factor.enable') }}">
            @csrf
            <button class="btn btn-success">啟用雙因子驗證</button>
        </form>
    @else
        <div class="mb-3">
            <h5>掃描 QR Code</h5>
            <p>請使用 Google Authenticator 或 Authy 掃描：</p>
            {!! auth()->user()->twoFactorQrCodeSvg() !!}
        </div>

        <div class="mb-3">
            <h5>恢復代碼</h5>
            <ul>
                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                    <li>{{ $code }}</li>
                @endforeach
            </ul>
        </div>

        <form method="POST" action="{{ route('two-factor.disable') }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">停用雙因子驗證</button>
        </form>
    @endif
</div>
@endsection
