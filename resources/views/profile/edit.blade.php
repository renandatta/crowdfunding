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
                    <li><a href="{{ route('profile') }}">Profil</a><span>/</span></li>
                    <li>Ubah Profil</li>
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
                        <h3 class="account-title">Ubah Profil</h3>
                        <div class="account-main">
                            @php($user = Auth::user())
                            @php($prefix = 'profileForm')
                            <form action="{{ route('profile.save') }}" method="post" id="{{ $prefix }}" enctype="multipart/form-data" class="mb-5">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4">
                                        @include('_tools.form', [
                                            'prefix' => $prefix,
                                            'type' => 'file',
                                            'name' => 'image',
                                            'caption' => 'Foto',
                                            'class' => 'dropify',
                                            'attributes' => ' data-height="200" data-default-file="' . $user->image . '" '
                                        ])
                                    </div>
                                </div>
                                @include('_tools.form', [
                                    'prefix' => $prefix,
                                    'type' => 'text',
                                    'name' => 'name',
                                    'caption' => 'Nama Lengkap',
                                    'value' => $user->name,
                                ])
                                @include('_tools.form', [
                                    'prefix' => $prefix,
                                    'type' => 'email',
                                    'name' => 'email',
                                    'caption' => 'Email',
                                    'value' => $user->email,
                                ])
                                @include('_tools.form', [
                                    'prefix' => $prefix,
                                    'type' => 'text',
                                    'name' => 'phone',
                                    'caption' => 'No.Telp',
                                    'value' => $user->phone,
                                ])
                                @include('_tools.form', [
                                    'prefix' => $prefix,
                                    'type' => 'text',
                                    'name' => 'city',
                                    'caption' => 'Kota',
                                    'value' => $user->city,
                                ])
                                @include('_tools.form', [
                                    'prefix' => $prefix,
                                    'type' => 'text',
                                    'name' => 'address',
                                    'caption' => 'Alamat',
                                    'value' => $user->address,
                                ])

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('profile') }}" class="btn btn-light ml-2">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('assets/lib/dropify/css/dropify.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('assets/lib/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('.dropify').dropify();

    </script>
@endpush
