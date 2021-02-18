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
                <a href="javascript:void(0)" class="btn btn-light" onclick="togglePaymentTypeSearch()">Pencarian</a>
            </div>
            <div class="col-6 text-right">
                <a href="{{ route('admin.payment_type.info', 'new') }}" class="btn btn-primary">Tambah Baru</a>
            </div>
        </div>
        <div class="card mt-3" id="cardPaymentTypeSearch" style="display: none;">
            <div class="card-body">
                @php($prefix = 'formPaymentTypeSearch')
                <form action="{{ route('admin.payment_type.search') }}" method="post" id="{{ $prefix }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            @include('_tools.form', [
                                'prefix' => $prefix,
                                'type' => 'text',
                                'name' => 'name',
                                'caption' => 'Nama Jenis Pembayaran',
                                'value' => old('name'),
                                'placeholder' => 'Cari ...',
                            ])
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="buttonPaymentTypeSearch">Cari</button>
                </form>
            </div>
        </div>
        <div class="table-responsive mt-3" id="tablePaymentType">
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let formPaymentTypeSearch = $('#formPaymentTypeSearch');
        function togglePaymentTypeSearch() {
            $('#cardPaymentTypeSearch').slideToggle();
        }
        function searchPaymentType(url = null) {
            url = url === null ? '{{ route('admin.payment_type.search') }}' : url;
            let data = formPaymentTypeSearch.serialize();
            let captionButton = '';
            let buttonSearch = $('#buttonPaymentTypeSearch');
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
                    $('#tablePaymentType').html(result);
                },
                error: function (xhr) {
                    $('#tablePaymentType').html(xhr.responseText);
                },
                complete: function () {
                    buttonSearch.removeAttr('disabled');
                    buttonSearch.html(captionButton);
                }
            });
        }
        function deletePaymentType(id) {
            Swal.fire({
                title: 'Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.post('{{ url('admin/payment_type/delete') }}/' + id, {_token: '{{ csrf_token() }}', _method: 'delete'}, function () {
                        searchPaymentType();
                    });
                }
            });
        }
        formPaymentTypeSearch.submit(function (e) {
            e.preventDefault();
            searchPaymentType();
        });
        searchPaymentType();
    </script>
@endpush
