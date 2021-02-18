@php($title = $breadcrumbs[count($breadcrumbs)-1]['caption'] . ' Bantuan')

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
        @php($prefix = 'formCampaignInfo')
        <form action="{{ route('admin.campaign.save', $id) }}" method="post" id="{{ $prefix }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h4># Informasi Bantuan</h4>
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'text',
                        'name' => 'title',
                        'caption' => 'Judul',
                        'value' => $campaign != [] ? $campaign->title : old('title'),
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'textarea',
                        'name' => 'description',
                        'caption' => 'Keterangan',
                        'value' => $campaign != [] ? $campaign->description : old('description'),
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'text',
                        'name' => 'province',
                        'caption' => 'Provinsi',
                        'value' => $campaign != [] ? $campaign->province : old('province'),
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'text',
                        'name' => 'district',
                        'caption' => 'Kabupaten / Kota',
                        'value' => $campaign != [] ? $campaign->district : old('district'),
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'text',
                        'name' => 'sub_district',
                        'caption' => 'Kecamatan',
                        'value' => $campaign != [] ? $campaign->sub_district : old('sub_district'),
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'text',
                        'name' => 'village',
                        'caption' => 'Desa',
                        'value' => $campaign != [] ? $campaign->village : old('village'),
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'textarea',
                        'name' => 'address',
                        'caption' => 'Alamat',
                        'value' => $campaign != [] ? $campaign->address : old('address'),
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'text',
                        'name' => 'target_fund',
                        'caption' => 'Target Dana',
                        'value' => $campaign != [] ? $campaign->target_fund : old('target_fund'),
                        'class' => 'autonumeric'
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'text',
                        'name' => 'deadline',
                        'caption' => 'Batas Waktu',
                        'value' => $campaign != [] ? format_date($campaign->deadline) : old('deadline'),
                        'class' => 'datepicker'
                    ])
                </div>
                <div class="col-md-6">
                    <h4># Informasi Tambahan</h4>
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'select',
                        'name' => 'campaign_type_id',
                        'caption' => 'Kategori',
                        'value' => $campaign != [] ? $campaign->campaign_type_id : old('campaign_type_id'),
                        'class' => 'select2',
                        'options' => $campaignTypes,
                        'optionKey' => 'id',
                        'optionValue' => 'name'
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'select',
                        'name' => 'user_id',
                        'caption' => 'User',
                        'value' => $campaign != [] ? $campaign->user_id : old('user_id'),
                        'class' => 'select2',
                        'options' => $users,
                        'optionKey' => 'id',
                        'optionValue' => 'name'
                    ])
                    <h4># Poster Bantuan</h4>
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'file',
                        'name' => 'featured_image',
                        'caption' => 'Gambar',
                        'value' => $campaign != [] ? $campaign->featured_image : old('featured_image'),
                        'class' => 'dropify',
                        'attributes' => ' data-height="400" data-default-file="' . ($campaign->featured_image ?? '') . '" '
                    ])
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="buttonSaveCampaignInfo">Simpan</button>
            <a href="{{ route('admin.campaign') }}" class="btn btn-light">Batal & Kembali</a>
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
