@extends('layouts.main')

@section('title')
    {{ $campaignType->name }} -
@endsection

@section('content')
    <div class="campaigns">
        <section class="statics section">
            <h2 class="title">{{ $campaignType->name }}</h2>
            <div class="description"><p>{{ $campaignType->description }}</p></div>
        </section>
        <div class="container">
            <div class="campaign-content">
                <div class="row" id="listCampaign">
                    <div class="col-12" id="listCampaignLoading" style="display: none;">
                        <h1 class="text-center"><i class="fa fa-spinner fa-spin"></i></h1>
                    </div>
                </div>
            </div>
            <div class="latest-button"><a href="javascript:void(0)" onclick="getCampaign()" class="btn-primary">Load more</a></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentPage = 1;
        let listCampaign = $('#listCampaign');
        let listCampaignLoading = $('#listCampaignLoading');
        function getCampaign() {
            $.ajax({
                type: 'post',
                url: "{{ route('campaign.search') }}?page=" + currentPage,
                data: {
                    _token: '{{ csrf_token() }}',
                    type_id: '{{ $campaignType->id }}'
                },
                beforeSend: function () {
                    listCampaignLoading.show();
                },
                success: function (result) {
                    listCampaign.append(result);
                    currentPage++;
                    listCampaignLoading.hide();
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
        getCampaign();
    </script>
@endpush
