@extends('layouts.main')

@section('title')
    Profil
@endsection

@section('content')
    <div class="page-title background-page" style="background: #fe6666;">
        <div class="container">
            <h1>Profile</h1>
            <div class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('/') }}">Home</a><span>/</span></li>
                    <li><a href="{{ route('profile') }}">Profil</a></li>
                    <li>Ubah Password</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="account-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('profile._sidebar', ['menu_active' => 'profile'])
                </div>
                <div class="col-lg-9">
                    <div class="account-content profile">
                        <h3 class="account-title">Ubah Password</h3>
                        <div class="account-main">
                            @php($user = Auth::user())
                            @php($prefix = 'profileForm')
                            <form action="{{ route('profile.save_password') }}" method="post" id="{{ $prefix }}" enctype="multipart/form-data" class="mb-5">
                                @csrf

                                @include('_tools.form', [
                                    'prefix' => $prefix,
                                    'type' => 'password',
                                    'name' => 'password',
                                    'caption' => 'Password',

                                ])
                                @include('_tools.form', [
                                    'prefix' => $prefix,
                                    'type' => 'password',
                                    'name' => 'password_confirmation',
                                    'caption' => 'Ulangi Password',
                                ])

                                <button type="submit" class="btn btn-primary">Ubah Password</button>
                                <a href="{{ route('profile') }}" class="btn btn-light ml-2">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
