@extends('layouts.main')

@section('title')
    Login -
@endsection

@section('content')
    <div class="page-title background-page" style="background: #fe6666;">
        <div class="container">
            <h1>Login</h1>
            <div class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('/') }}">Home</a><span>/</span></li>
                    <li>Login</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="margin-bottom: 100px;">
        <div class="main-content">
            <div class="form-login">
                <h2>Login sesuai akun anda</h2>
                @include('_tools.alert')
                @php($prefix = 'loginForm')
                <form action="{{ route('login.process') }}" method="post" id="{{ $prefix }}" class="clearfix mt-2">
                    @csrf
                    <div class="field">
                        <input type="email" name="email" placeholder="E-mail Address" />
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" />
                    </div>
                    <div class="inline clearfix">
                        <button type="submit" class="btn-primary">Login</button>
                        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
