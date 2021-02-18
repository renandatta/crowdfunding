@foreach($campaigns as $campaign)
<div class="col-lg-4 col-sm-6 col-6">
    <div class="campaign-item">
        <a class="overlay" href="{{ route('campaign.detail', $campaign->slug) }}">
            <img src="{{ $campaign->featured_image }}" alt="">
            <span class="ion-ios-search-strong"></span>
        </a>
        <div class="campaign-box">
            <a href="#" class="category">{{ $campaign->campaignType->name }}</a>
            <h3><a href="{{ route('campaign.detail', $campaign->slug) }}">{{ $campaign->title }}</a></h3>
            <div class="campaign-description">{{ $campaign->description }}</div>
            <div class="campaign-author">
                <a class="author-icon" href="#"><img src="{{ $campaign->user->image }}" alt=""></a>
                by <a class="author-name" href="#">{{ $campaign->user->name }}</a>
            </div>
            <div class="process">
                <div class="raised"><span></span></div>
                <div class="process-info">
                    <div class="process-pledged"><span>Rp. {{ format_number($campaign->target_fund) }}</span></div>
                    <div class="process-funded"><span>{{ $campaign->percentageDonation() }}%</span>terkumpul</div>
                    <div class="process-time"><span>{{ format_number(dateDifference(date('Y-m-d'), $campaign->deadline)) }}</span>hari lagi</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
