@extends('layouts.default') {{-- 使用 Color Admin 模板的默认布局 --}}
@section('title', '词库登录')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        {{-- 登录部分 --}}
        <div id="login-section" class="card border-0 shadow-lg mb-4">
          <div class="card-header bg-primary text-white text-center fs-4 fw-bold">
            华樱外语词库登录
          </div>
          <div class="card-body text-center">
            <div class="mb-3">
              <label class="form-label fs-5 fw-semibold">登录码</label>
              <input type="text" id="login-code" class="form-control form-control-lg text-center" placeholder="请输入登录码">
            </div>
            <button id="btn-login" class="btn btn-warning w-100 fs-5">验证</button>
          </div>
        </div>

        {{-- 词库列表 --}}
        <div id="list-section" class="card border-0 shadow-lg" style="display:none;">
          <div class="card-header bg-success text-white text-center fs-4 fw-bold">
            词库列表
          </div>
          <div class="card-body">
            @foreach($list as $item)
              <a href="{{ url('/wy/vocab/list/'.$item->id) }}" class="btn btn-outline-primary w-100 mb-3 fs-5">
                {{ $item->lexiconname }}
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      const $login = $('#login-section');
      const $list = $('#list-section');

      if (sessionStorage.wy_lexicon_loginid) {
        $.post('{{ route("user.login.check") }}', { loginid: sessionStorage.wy_lexicon_loginid }, res => {
          if (res.ret === 'success' && res.logined > 0) {
            $login.hide(); $list.show();
          }
        });
      }

      $('#btn-login').on('click', function() {
        const pwd = $('#login-code').val();
        if (!pwd) return alert('请输入登录码');
        $.post('{{ route("wy.lexicon.login") }}', { pwd }, res => {
          if (res.ret === 'success') {
            sessionStorage.wy_lexicon_loginid = res.loginid;
            $login.hide(); $list.show();
          } else {
            alert('登录码错误！');
          }
        });
      });
    });
  </script>
@endpush
