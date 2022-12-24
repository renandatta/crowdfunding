@php($title = $breadcrumbs[count($breadcrumbs)-1]['caption'] . ' User')

@extends('layouts.admin')

@section('title')
    {{ $title }} -
@endsection

@section('content')
    <div class="az-content-header d-block d-md-flex">
        <div>
            <h2 class="az-content-title mg-b-5 mg-b-lg-8">{{ $title }}</h2>
            <div class="az-content-breadcrumb">
                @foreach ($breadcrumbs as $breadcrumb)
                    <span><a href="{{ $breadcrumb['url'] != null ? route($breadcrumb['url'], $breadcrumb['params']) : 'javascript:void(0)' }}">{{ $breadcrumb['caption'] }}</a></span>
                @endforeach
            </div>
        </div>
    </div>
    <div class="az-content-body border-top pt-3">
        @php($prefix = 'formUserInfo')
        <form action="{{ route('admin.user.save', $id) }}" method="post" id="{{ $prefix }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h4># Informasi User</h4>
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'text',
                        'name' => 'name',
                        'caption' => 'Nama User',
                        'value' => $user != [] ? $user->name : old('name'),
                        'placeholder' => 'Nama',
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'email',
                        'name' => 'email',
                        'caption' => 'Email',
                        'value' => $user != [] ? $user->email : old('email'),
                        'placeholder' => 'Email',
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'password',
                        'name' => 'password',
                        'caption' => $id == 'new' ? 'Password' : 'Password (Kosongi apabila tidak diubah)',
                        'placeholder' => 'Password',
                        'attributes' => $id == 'new' ? 'required' : '',
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'options' => $userLevels,
                        'optionKey' => 'name',
                        'optionValue' => 'name',
                        'type' => 'select',
                        'name' => 'user_level',
                        'caption' => 'User Level',
                        'class' => 'select2',
                        'value' => $user != [] ? $user->user_level : old('user_level'),
                    ])
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="buttonSaveUserInfo">Simpan</button>
            <a href="{{ route('admin.user') }}" class="btn btn-light">Batal & Kembali</a>
        </form>
    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
