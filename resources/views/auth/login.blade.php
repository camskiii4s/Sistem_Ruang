@extends('layouts.app')

@section('title', 'PT Angkasa Pura Indonesia')

@section('content')
<section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

          <div class="login-brand">
    <img src="{{ asset('storage/images/injourney1.png') }}" 
         alt="Logo" 
         width="120" 
         class="mb-3 d-block mx-auto">
    Sistem Peminjaman Ruangan Rapat
</div>

 <div class="text-center mb-4">
    <div class="subtitle">Gedung Administrasi PT Angkasa Pura Indonesia</div>
    <div class="subtitle">Bandar Udara Sultan Syarif Kasim II Pekanbaru</div>
</div>


          <div class="card card-primary">
            <div class="card-header"><h4>{{ __('Login') }}</h4></div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                  <label for="username">Username</label>
                  <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="control-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    {{ __('Login') }}
                  </button>
                </div>
                @if (Route::has('register'))
    <div class="text-center">
        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm mt-2">
            {{ __('Belum punya akun? Daftar di sini') }}
        </a>
    </div>
@endif

              </form>

            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
@endsection
