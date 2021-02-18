@php($title = 'User')

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
                <a href="javascript:void(0)" class="btn btn-light" onclick="toggleUserSearch()">Pencarian</a>
            </div>
            <div class="col-6 text-right">
                <a href="{{ route('admin.user.info', 'new') }}" class="btn btn-primary">Tambah Baru</a>
            </div>
        </div>
        <div class="card mt-3" id="cardUserSearch" style="display: none;">
            <div class="card-body">
                @php($prefix = 'formUserSearch')
                <form action="{{ route('admin.user.search') }}" method="post" id="{{ $prefix }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            @include('_tools.form', [
                                'prefix' => $prefix,
                                'type' => 'text',
                                'name' => 'name',
                                'caption' => 'Nama User',
                                'value' => old('name'),
                                'placeholder' => 'Cari ...',
                            ])
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="buttonUserSearch">Cari</button>
                </form>
            </div>
        </div>
        <div class="table-responsive mt-3" id="tableUser">
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let formUserSearch = $('#formUserSearch');
        function toggleUserSearch() {
            $('#cardUserSearch').slideToggle();
        }
        function searchUser(url = null) {
            url = url === null ? '{{ route('admin.user.search') }}' : url;
            let data = formUserSearch.serialize();
            let captionButton = '';
            let buttonSearch = $('#buttonUserSearch');
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
                    $('#tableUser').html(result);
                },
                error: function (xhr) {
                    $('#tableUser').html(xhr.responseText);
                },
                complete: function () {
                    buttonSearch.removeAttr('disabled');
                    buttonSearch.html(captionButton);
                }
            });
        }
        function deleteUser(id) {
            Swal.fire({
                title: 'Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.post('{{ url('admin/user/delete') }}/' + id, {_token: '{{ csrf_token() }}', _method: 'delete'}, function () {
                        searchUser();
                    });
                }
            });
        }
        formUserSearch.submit(function (e) {
            e.preventDefault();
            searchUser();
        });
        searchUser();
    </script>
@endpush
