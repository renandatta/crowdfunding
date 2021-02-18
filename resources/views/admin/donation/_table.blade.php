<table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 3rem;">No</th>
        <th>Nama Bantuan</th>
        <th>Nama User</th>
        <th>Tanggal</th>
        <th class="text-right">Donasi</th>
        <th class="text-right text-nowrap">Kode Unik</th>
        <th class="text-right">Total</th>
        <th>Status</th>
        <th class="text-right" style="width: 7rem;"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $key => $value)
        <tr>
            <td>@if($data instanceof \Illuminate\Pagination\LengthAwarePaginator ) {{ (($data->currentPage()-1)*10)+($key+1) }} @else {{ $key+1 }} @endif</td>
            <td>{{ $value->campaign->title }}</td>
            <td>{{ $value->user->name }}</td>
            <td class="text-nowrap">{{ format_date($value->created_at) }}</td>
            <td class="text-right">{{ format_number($value->donation) }}</td>
            <td class="text-right">{{ format_number($value->donationPayment->unique_code) }}</td>
            <td class="text-right">{{ format_number($value->donationPayment->total) }}</td>
            <td id="status{{ $value->id }}">{{ $value->status }}</td>
            <td class="text-center" id="action{{ $value->id }}">
                @if($value->status == 'pending')
                    <a href="javascript:void(0)" onclick="verifyDonation('{{ $value->id }}')"><i class="la la-check" style="font-size: 12pt;"></i> Verifikasi</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@include('_tools.pagination', ['data' => $data, 'functionName' => 'searchDonation'])
