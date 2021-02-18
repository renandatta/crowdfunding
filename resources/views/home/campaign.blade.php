@extends('layouts.main')

@section('title')
    Data Bantuan -
@endsection

@section('content')
    <div class="campaigns">
        <section class="statics section">
            @if($search != null)
                <h2 class="title mt-0">Hasil Pencarian Dari "{{ $search }}"</h2>
                <br>
            @else
            <h2 class="title">We are changing the way of making things possible.</h2>
            <div class="description"><p>Raise money for ​over 1.5 million charities with personal fundraisers, events, races and corporate philanthropy.</p></div>
            @endif
        </section>
        <div class="container">
            <div class="campaign-content">
                <div class="row" id="listCampaign">
                    <div class="col-12" id="listCampaignLoading" style="display: none;">
                        <h1 class="text-center"><i class="fa fa-spinner fa-spin"></i></h1>
                    </div>
                </div>
            </div>
            <div class="latest-button"><a href="javascript:void(0)" onclick="getCampaign()" id="buttonLoadMore" class="btn-primary">Load more</a></div>
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
                    @if($search != null)
                    title: '{{ $search }}'
                    @endif
                },
                beforeSend: function () {
                    listCampaignLoading.show();
                },
                success: function (result) {
                    if (result === '') {
                        $('#buttonLoadMore').hide();
                    }
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
