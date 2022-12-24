@php($title = 'Jenis Pembayaran')

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
    <div class="az-content-body border-top">
        <div class="row mt-3">
            <div class="col-6">
                <a href="javascript:void(0)" class="btn btn-light" onclick="toggleDonationSearch()">Pencarian</a>
            </div>
            <div class="col-6 text-right">

            </div>
        </div>
        <div class="card mt-3" id="cardDonationSearch" style="display: none;">
            <div class="card-body">
                @php($prefix = 'formDonationSearch')
                <form action="{{ route('admin.donation.search') }}" method="post" id="{{ $prefix }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            @include('_tools.form', [
                                'prefix' => $prefix,
                                'type' => 'text',
                                'name' => 'user_name',
                                'caption' => 'Nama User',
                                'value' => old('name'),
                                'placeholder' => 'Cari ...',
                            ])
                            @include('_tools.form', [
                                'prefix' => $prefix,
                                'type' => 'text',
                                'name' => 'campaign_title',
                                'caption' => 'Nama Bantuan',
                                'value' => old('name'),
                                'placeholder' => 'Cari ...',
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('_tools.form', [
                                'prefix' => $prefix,
                                'type' => 'text',
                                'name' => 'date_start',
                                'caption' => 'Tanggal Mulai',
                                'value' => old('date_start'),
                                'class' => 'datepicker'
                            ])
                            @include('_tools.form', [
                                'prefix' => $prefix,
                                'type' => 'text',
                                'name' => 'date_end',
                                'caption' => 'Tanggal Akhir',
                                'value' => old('date_end'),
                                'class' => 'datepicker'
                            ])
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="buttonDonationSearch">Cari</button>
                </form>
            </div>
        </div>
        <div class="table-responsive mt-3" id="tableDonation">
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let formDonationSearch = $('#formDonationSearch');
        function toggleDonationSearch() {
            $('#cardDonationSearch').slideToggle();
        }
        function searchDonation(url = null) {
            url = url === null ? '{{ route('admin.donation.search') }}' : url;
            let data = formDonationSearch.serialize();
            let captionButton = '';
            let buttonSearch = $('#buttonDonationSearch');
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                beforeSend: function () {
                    captionButton = buttonSearch.html();
                    buttonSearch.html('<i>Loading ...</i>');
                    buttonSearch.attr('disabled', 'disabled');
                },
                success: function (result) {
                    $('#tableDonation').html(result);
                },
                error: function (xhr) {
                    $('#tableDonation').html(xhr.responseText);
                },
                complete: function () {
                    buttonSearch.removeAttr('disabled');
                    buttonSearch.html(captionButton);
                }
            });
        }
        formDonationSearch.submit(function (e) {
            e.preventDefault();
            searchDonation();
        });
        function verifyDonation(id) {
            $.get("{{ url('admin/donation') }}/" + id + '/verify', function () {
                $('#status' + id).html('diverifikasi');
                $('#action' + id).html('');
            });
        }
        searchDonation();
    </script>
@endpush
