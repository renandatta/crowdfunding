<table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 5rem;">No</th>
        <th>Nama</th>
        <th>Keterangan</th>
        <th class="text-right" style="width: 10rem;"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $key => $value)
        <tr>
            <td>@if($data instanceof \Illuminate\Pagination\LengthAwarePaginator ) {{ (($data->currentPage()-1)*10)+($key+1) }} @else {{ $key+1 }} @endif</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->description }}</td>
            <td class="text-center">
                <a href="{{ route('admin.payment_type.info', $value->id) }}"><i class="typcn typcn-edit" style="font-size: 12pt;"></i> Ubah</a>
                &nbsp; &nbsp;
                <a href="javascript:void(0)" onclick="deletePaymentType('{{ $value->id }}')"><i class="typcn typcn-trash" style="font-size: 12pt;"></i> Hapus</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@include('_tools.pagination', ['data' => $data, 'functionName' => 'searchPaymentType'])
