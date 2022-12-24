<table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 3rem;">No</th>
        <th style="width: 4rem;"></th>
        <th>Nama User</th>
        <th>Judul</th>
        <th class="text-center">Batas Waktu</th>
        <th class="text-right">Target Dana</th>
        <th class="text-right" style="width: 15rem;"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $key => $value)
        <tr>
            <td>@if($data instanceof \Illuminate\Pagination\LengthAwarePaginator ) {{ (($data->currentPage()-1)*10)+($key+1) }} @else {{ $key+1 }} @endif</td>
            <td class="p-0 text-center" style="vertical-align: middle;">
                <img src="{{ $value->featured_image  }}" alt="" class="img-fluid" style="height: 40px;">
            </td>
            <td>{{ $value->user->name }}</td>
            <td>{{ $value->title }}</td>
            <td class="text-center text-nowrap">{{ format_date($value->deadline) }}</td>
            <td class="text-right">{{ 'Rp.'.format_number($value->target_fund) }}</td>
            <td class="text-center">
                <a href="{{ route('admin.campaign.detail', $value->id) }}"><i class="typcn typcn-arrow-right" style="font-size: 12pt;"></i> Detail</a>
                &nbsp; &nbsp;
                <a href="{{ route('admin.campaign.info', $value->id) }}"><i class="typcn typcn-edit" style="font-size: 12pt;"></i> Ubah</a>
                &nbsp; &nbsp;
                <a href="javascript:void(0)" onclick="deleteCampaign('{{ $value->id }}')"><i class="typcn typcn-trash" style="font-size: 12pt;"></i> Hapus</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@include('_tools.pagination', ['data' => $data, 'functionName' => 'searchCampaign'])
