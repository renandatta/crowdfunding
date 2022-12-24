@extends('layouts.main')

@section('title')
    Profil
@endsection

@section('classbody')
    contact-us
@endsection

@section('content')
    <div class="page-title background-page" style="background: #fe6666;">
        <div class="container">
            <h1>Profile</h1>
            <div class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('/') }}">Home</a><span>/</span></li>
                    <li>Profil</li>
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
                    @php($user = Auth::user())
                    <div class="account-content profile mb-5">
                        <h3 class="account-title">Profil</h3>
                        <div class="account-main">
                            <div class="author clearfix">
                                <a class="author-avatar" href="#"><img src="{{ $user->image }}" alt=""></a>
                                <div class="author-content">
                                    <div class="author-title"><h3><a>{{ $user->name }}</a></h3></div>
                                    <div class="author-info">
                                        <p><a href="#">{{ $user->email }}</a></p>
                                        <p>Bergabung Sejak {{ fulldate($user->created_at) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-box">
                                <h3>Data Diri</h3>
                                <ul>
                                    <li>
                                        <strong>No.Telp:</strong>
                                        <div class="profile-text"><p>{{ $user->phone }}</p></div>
                                    </li>
                                    <li>
                                        <strong>Kota Domisili:</strong>
                                        <div class="profile-text"><p>{{ $user->city }}</p></div>
                                    </li>
                                    <li>
                                        <strong>Alamat Lengkap:</strong>
                                        <div class="profile-text"><p>{{ $user->address }}</p></div>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Ubah Profil</a>
                            <a href="{{ route('profile.edit_password') }}" class="btn btn-primary">Ubah Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
