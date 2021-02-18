@php($title = $breadcrumbs[count($breadcrumbs)-1]['caption'] . ' Jenis Bantuan')

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
        @php($prefix = 'formCampaignTypeInfo')
        <form action="{{ route('admin.campaign_type.save', $id) }}" method="post" id="{{ $prefix }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h4># Informasi Jenis Bantuan</h4>
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'text',
                        'name' => 'name',
                        'caption' => 'Nama Jenis Bantuan',
                        'value' => $campaignType != [] ? $campaignType->name : old('name'),
                        'placeholder' => 'Nama',
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'textarea',
                        'name' => 'description',
                        'caption' => 'Keterangan',
                        'value' => $campaignType != [] ? $campaignType->description : old('description'),
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'file',
                        'name' => 'icon',
                        'caption' => 'Gambar',
                        'class' => 'dropify',
                        'attributes' => ' data-height="400" data-default-file="' . $campaignType->icon . '" '
                    ])
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="buttonSaveCampaignTypeInfo">Simpan</button>
            <a href="{{ route('admin.campaign_type') }}" class="btn btn-light">Batal & Kembali</a>
        </form>
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
