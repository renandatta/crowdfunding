@php($title = $breadcrumbs[count($breadcrumbs)-1]['caption'] . ' Bantuan')
@php($tab = $tab ?? 'detail')
@php($id = $id ?? null)
@php($detail = $detail ?? null)
@php($faq = $faq ?? null)
@php($update = $update ?? null)
@php($discussion = $discussion ?? null)

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
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('admin.campaign') }}" class="btn btn-light float-right">Kembali</a>
                <h4># Informasi Bantuan</h4>
                <table class="table table-borderless">
                    <tbody>
                    <tr><td class="p-1">Judul</td><td class="p-1 text-right">:</td><td class="p-1"><b>{{ $campaign->title }}</b></td></tr>
                    <tr><td class="p-1">Deskripsi</td><td class="p-1 text-right">:</td><td class="p-1"><b>{!! $campaign->fullAddress() !!}</b></td></tr>
                    <tr><td class="p-1">Kategori</td><td class="p-1 text-right">:</td><td class="p-1"><b>{{ $campaign->campaignType->name }}</b></td></tr>
                    <tr><td class="p-1">Pengusul</td><td class="p-1 text-right">:</td><td class="p-1"><b>{{ $campaign->user->name }}</b></td></tr>
                    <tr><td class="p-1">Kategori</td><td class="p-1 text-right">:</td><td class="p-1"><b>{{ $campaign->campaignType->name }}</b></td></tr>
                    <tr><td class="p-1">Target Dana</td><td class="p-1 text-right">:</td><td class="p-1"><b>Rp. {{ format_number($campaign->target_fund) }}</b></td></tr>
                    <tr><td class="p-1">Batas Waktu</td><td class="p-1 text-right">:</td><td class="p-1"><b>{{ format_date($campaign->deadline) }}</b></td></tr>
                    </tbody>
                </table>

                <div class="card bd-0">
                    <div class="card-header bg-gray-400 bd-b-0-f pd-b-0">
                        <nav class="nav nav-tabs">
                            <a class="nav-link {{ $tab == 'detail' ? 'active' : '' }}" data-toggle="tab" href="#detail">Detail Bantuan</a>
                            <a class="nav-link {{ $tab == 'faq' ? 'active' : '' }}" data-toggle="tab" href="#faq">Faq</a>
                            <a class="nav-link {{ $tab == 'update' ? 'active' : '' }}" data-toggle="tab" href="#update">Berita Terbaru</a>
                            <a class="nav-link {{ $tab == 'discussion' ? 'active' : '' }}" data-toggle="tab" href="#discussion">Diskusi</a>
                        </nav>
                    </div>
                    <div class="card-body bd bd-t-0 tab-content">
                        <div id="detail" class="tab-pane {{ $tab == 'detail' ? 'active show' : '' }}">
                            @if($detail == null)
                            <h4># Detail Bantuan</h4>
                            <table class="table table-borderless table-hover">
                                <tbody>
                                @foreach($campaign->campaignDetails as $detail)
                                    <tr>
                                        <td class="p-1">
                                            <div class="text-right">
                                                <a href="{{ route('admin.campaign.detail.info', [$campaign->id, $detail->id]) }}"><i class="typcn typcn-edit" style="font-size: 12pt;"></i> Ubah</a>
                                                &nbsp; &nbsp;
                                                <a href="{{ route('admin.campaign.detail.delete', [$campaign->id, $detail->id]) }}"><i class="typcn typcn-trash" style="font-size: 12pt;"></i> Hapus</a>
                                            </div>
                                            @if($detail->type == 'image')
                                                <img src="{{ $detail->content }}" alt="" class="img-fluid">
                                            @else
                                                {!! $detail->content !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="p-1">
                                        <a href="{{ route('admin.campaign.detail.info', [$campaign->id, 'new']) }}" class="btn btn-block btn-primary">Tambahkan</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            @else
                                @php($prefix = 'formCampaignDetailInfo')
                                <form action="{{ route('admin.campaign.detail.save', [$campaign->id, $id]) }}" method="post" id="{{ $prefix }}" enctype="multipart/form-data">
                                    @csrf
                                    <h4># {{ $id == 'new' ? 'Tambah' : 'Ubah' }} Detail Bantuan</h4>
                                    @if($id == 'new')
                                        @include('_tools.form', [
                                            'prefix' => $prefix,
                                            'type' => 'select',
                                            'name' => 'type',
                                            'caption' => 'Jenis Konten',
                                            'class' => 'select2',
                                            'options' => [['id' => 'image'], ['id' => 'text']],
                                            'optionKey' => 'id',
                                            'optionValue' => 'id'
                                        ])
                                        @include('_tools.form', [
                                            'prefix' => $prefix,
                                            'type' => 'file',
                                            'name' => 'content_image',
                                            'caption' => 'Konten',
                                            'class' => 'dropify',
                                            'attributes' => ' data-height="400"'
                                        ])
                                        @include('_tools.form', [
                                            'prefix' => $prefix,
                                            'type' => 'textarea',
                                            'name' => 'content_text',
                                            'caption' => 'Konten',
                                            'rowSize' => 20,
                                            'class' => 'summernote'
                                        ])
                                    @else
                                        @if($detail->type == 'image')
                                            @include('_tools.form', [
                                                'prefix' => $prefix,
                                                'type' => 'file',
                                                'name' => 'content',
                                                'caption' => 'Konten',
                                                'class' => 'dropify',
                                                'attributes' => ' data-height="400" data-default-file="' . $detail->content . '" '
                                            ])
                                        @else
                                            @include('_tools.form', [
                                                'prefix' => $prefix,
                                                'type' => 'textarea',
                                                'name' => 'content',
                                                'caption' => 'Konten',
                                                'rowSize' => 20,
                                                'value' => $detail != [] ? $detail->content : old('content'),
                                                'class' => 'summernote'
                                            ])
                                        @endif
                                    @endif
                                    <button type="submit" class="btn btn-primary" id="buttonSaveCampaignDetailInfo">Simpan</button>
                                    <a href="{{ route('admin.campaign.detail', $campaign->id) }}" class="btn btn-light">Batal & Kembali</a>
                                </form>
                            @endif
                        </div>
                        <div id="faq" class="tab-pane {{ $tab == 'faq' ? 'active show' : '' }}">
                            @if($faq == null)
                                <div id="accordion" class="accordion" role="tablist" aria-multiselectable="true">
                                    @foreach($campaign->campaignFaqs as $faq)
                                    <div class="card">
                                        <div class="card-header" role="tab" id="heading{{ $faq->id }}">
                                            <a data-toggle="collapse" href="#collapse{{ $faq->id }}" aria-expanded="true" aria-controls="collapse{{ $faq->id }}">
                                                {{ $faq->question }}
                                            </a>
                                        </div>

                                        <div id="collapse{{ $faq->id }}" data-parent="#accordion" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="card-body" style="padding: 20px;background-color: #fff;">
                                                <div class="text-right">
                                                    <a href="{{ route('admin.campaign.detail.faq.info', [$campaign->id, $faq->id]) }}"><i class="typcn typcn-edit" style="font-size: 12pt;"></i> Ubah</a>
                                                    &nbsp; &nbsp;
                                                    <a href="{{ route('admin.campaign.detail.faq.delete', [$campaign->id, $faq->id]) }}"><i class="typcn typcn-trash" style="font-size: 12pt;"></i> Hapus</a>
                                                </div>
                                                {!! $faq->answer !!}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <a href="{{ route('admin.campaign.detail.faq.info', [$campaign->id, 'new']) }}" class="btn btn-block btn-primary">Tambahkan</a>
                            @else
                                @php($prefix = 'formCampaignFaqInfo')
                                <form action="{{ route('admin.campaign.detail.faq.save', [$campaign->id, $id]) }}" method="post" id="{{ $prefix }}" enctype="multipart/form-data">
                                    @csrf
                                    <h4># {{ $id == 'new' ? 'Tambah' : 'Ubah' }} Faq</h4>
                                    @include('_tools.form', [
                                        'prefix' => $prefix,
                                        'type' => 'text',
                                        'name' => 'question',
                                        'caption' => 'Pertanyaan',
                                        'value' => $faq != 'new' ? $faq->question : old('question'),
                                    ])
                                    @include('_tools.form', [
                                        'prefix' => $prefix,
                                        'type' => 'textarea',
                                        'name' => 'answer',
                                        'caption' => 'Jawaban',
                                        'value' => $faq != 'new' ? $faq->answer : old('answer'),
                                        'class' => 'summernote'
                                    ])
                                    <button type="submit" class="btn btn-primary" id="buttonSaveCampaignFaqInfo">Simpan</button>
                                    <a href="{{ route('admin.campaign.detail', $campaign->id) }}" class="btn btn-light">Batal & Kembali</a>
                                </form>
                            @endif
                        </div>
                        <div id="update" class="tab-pane {{ $tab == 'update' ? 'active show' : '' }}">
                            @if($update == null)
                                <h4># Update Berita</h4>
                                <table class="table table-borderless table-hover">
                                    <tbody>
                                    @foreach($campaign->campaignUpdates as $update)
                                        <tr>
                                            <td class="p-1">
                                                <div class="text-right">
                                                    <a href="{{ route('admin.campaign.detail.update.info', [$campaign->id, $update->id]) }}"><i class="typcn typcn-edit" style="font-size: 12pt;"></i> Ubah</a>
                                                    &nbsp; &nbsp;
                                                    <a href="{{ route('admin.campaign.detail.update.delete', [$campaign->id, $update->id]) }}"><i class="typcn typcn-trash" style="font-size: 12pt;"></i> Hapus</a>
                                                </div>
                                                <h4>{{ $update->title }}</h4>
                                                <p><i>{{ format_date($update->created_at) }}</i></p>
                                                {!! $update->content !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="p-1">
                                            <a href="{{ route('admin.campaign.detail.update.info', [$campaign->id, 'new']) }}" class="btn btn-block btn-primary">Tambahkan</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            @else
                                @php($prefix = 'formCampaignUpdateInfo')
                                <form action="{{ route('admin.campaign.detail.update.save', [$campaign->id, $id]) }}" method="post" id="{{ $prefix }}" enctype="multipart/form-data">
                                    @csrf
                                    <h4># {{ $id == 'new' ? 'Tambah' : 'Ubah' }} Faq</h4>
                                    @include('_tools.form', [
                                        'prefix' => $prefix,
                                        'type' => 'text',
                                        'name' => 'title',
                                        'caption' => 'Judul',
                                        'value' => $update != 'new' ? $update->title : old('title'),
                                    ])
                                    @include('_tools.form', [
                                        'prefix' => $prefix,
                                        'type' => 'textarea',
                                        'name' => 'content',
                                        'caption' => 'Isi Berita',
                                        'value' => $update != 'new' ? $update->content : old('content'),
                                        'class' => 'summernote'
                                    ])
                                    <button type="submit" class="btn btn-primary" id="buttonSaveCampaignUpdateInfo">Simpan</button>
                                    <a href="{{ route('admin.campaign.detail', $campaign->id) }}" class="btn btn-light">Batal & Kembali</a>
                                </form>
                            @endif
                        </div>
                        <div id="discussion" class="tab-pane {{ $tab == 'discussion' ? 'active show' : '' }}">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    @foreach ($campaign->campaignDiscussions as $discussion)
                                    <tr>
                                        <td>{{ $discussion->user->name }}</td>
                                        <td>{{ $discussion->content }}</td>
                                        <td style="width: 100px;">
                                            <a href="{{ route('admin.campaign.detail.discussion.delete', [$campaign->id, $discussion->id]) }}"><i class="typcn typcn-trash" style="font-size: 12pt;"></i> Hapus</a>
                                        </td>
                                    </tr>
                                    @foreach($discussion->replies as $reply)
                                        <tr>
                                            <td class="border-0"></td>
                                            <td>
                                                {{ $reply->user->name }} <br>
                                                {{ $reply->content }}
                                            </td>
                                            <td style="width: 100px;">
                                                <a href="{{ route('admin.campaign.detail.discussion.delete', [$campaign->id, $reply->id]) }}"><i class="typcn typcn-trash" style="font-size: 12pt;"></i> Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <form action="{{ route('admin.campaign.detail.discussion.save', [$campaign->id, 'new']) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $discussion->id }}">
                                        <tr>
                                            <td class="text-right border-0"></td>
                                            <td class="p-0">
                                                <textarea name="content" id="content" rows="2" class="form-control" placeholder="Balasan"></textarea>
                                            </td>
                                            <td class="p-0">
                                                <button class="btn btn-primary btn-block" type="submit">Simpan</button>
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('assets/lib/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('assets/lib/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/lib/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $('.dropify').dropify();
        $('.summernote').summernote({
            height: 400
        });
        @if($detail != null)
            $('#formCampaignDetailInfotype').change(function () {
                let id = $(this).find('option:selected').val();
                if(id === 'image') {
                    $('#formCampaignDetailInfocontent_imageFormGroup').show();
                    $('#formCampaignDetailInfocontent_textFormGroup').hide();
                } else {
                    $('#formCampaignDetailInfocontent_imageFormGroup').hide();
                    $('#formCampaignDetailInfocontent_textFormGroup').show();
                }
            });
            $('#formCampaignDetailInfotype').trigger('change');
        @endif
    </script>
@endpush
