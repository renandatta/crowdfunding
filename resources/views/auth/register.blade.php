@extends('layouts.main')

@section('title')
    Login -
@endsection

@section('content')
    <div class="page-title background-page" style="background: #fe6666">
        <div class="container">
            <h1>Daftar</h1>
            <div class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('/') }}">Home</a><span>/</span></li>
                    <li>Daftar</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="margin-bottom: 100px;">
        <div class="main-content">
            <div class="form-login">
                <h2>Daftar gratis</h2>
                @include('_tools.alert')
                @php($prefix = 'registerForm')
                <form action="{{ route('register.process') }}" method="post" id="{{ $prefix }}" class="clearfix">
                    @csrf
                    <div class="field">
                        <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" />
                    </div>
                    <div class="field">
                        <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" />
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" />
                    </div>
                    <div class="field">
                        <input type="password" name="password_confirmation" placeholder="Ulangi Password" />
                    </div>
                    <div class="inline clearfix">
                        <button type="submit" class="btn-primary">Daftar</button>
                        <p>Sudah punya akun ? <a href="{{ route('login') }}">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
