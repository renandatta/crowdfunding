@php($title = $breadcrumbs[count($breadcrumbs)-1]['caption'] . ' Jenis Pembayaran')

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
        @php($prefix = 'formPaymentTypeInfo')
        <form action="{{ route('admin.payment_type.save', $id) }}" method="post" id="{{ $prefix }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h4># Informasi Jenis Pembayaran</h4>
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'text',
                        'name' => 'name',
                        'caption' => 'Nama Jenis Pembayaran',
                        'value' => $paymentType != [] ? $paymentType->name : old('name'),
                        'placeholder' => 'Nama',
                    ])
                    @include('_tools.form', [
                        'prefix' => $prefix,
                        'type' => 'textarea',
                        'name' => 'description',
                        'caption' => 'Keterangan',
                        'value' => $paymentType != [] ? $paymentType->description : old('description'),
                    ])
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="buttonSavePaymentTypeInfo">Simpan</button>
            <a href="{{ route('admin.payment_type') }}" class="btn btn-light">Batal & Kembali</a>
        </form>
    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
