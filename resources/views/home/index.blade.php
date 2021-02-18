@extends('layouts.main')

@section('content')
    <div class="staff-picks">
        <div class="container">
            <div class="border-title">
                <h2 class="title left-title">Crowdfunding</h2>
                <div class="description left-description">Janganlah menahan kebaikan dari pada orang-orang yang berhak menerimanya, padahal engkau mampu melakukannya.</div>
            </div>
            <div class="staff-picks-content">
                <div class="staff-picks-slider slider-controls-top owl-carousel">
                    @foreach ($populars as $popular)
                    <div class="staff-picks-item clearfix">
                        <a class="staff-picks-image" href="{{ route('campaign.detail', $popular->slug) }}"><img src="{{ asset($popular->featured_image) }}" alt=""></a>
                        <div class="staff-picks-item-content staff-picks-box">
                            <a href="{{ route('campaign.category', $popular->campaignType->slug) }}" class="category">{{ $popular->campaignType->name }}</a>
                            <h3><a href="{{ route('campaign.detail', $popular->slug) }}">#Crowdfunding - {{ $popular->title }}</a></h3>
                            <div class="staff-picks-description">{{ $popular->description }}</div>
                            <div class="staff-picks-author">
                                <div class="author-profile">
                                    <a class="author-avatar" href="#"><img src="{{ $popular->user->image }}" alt=""></a>
                                    by <a class="author-name" href="#">{{ $popular->user->name }}</a>
                                </div>
                                <div class="author-address"><span class="ion-location"></span>{{ $popular->district . ', ' . $popular->province }}</div>
                            </div>
                            <div class="process">
                                <div class="raised"><span style="width: {{ $popular->percentageDonation() }}%"></span></div>
                                <div class="process-info">
                                    <div class="process-pledged"><span>Rp. {{ format_number($popular->target_fund) }}</span>Bantuan Dibutuhkan</div>
                                    <div class="process-funded"><span>{{ $popular->percentageDonation() }}%</span>Terkumpul</div>
                                    <div class="process-time"><span>{{ $popular->donations->count('donation') }}</span>Donatur</div>
                                    <div class="process-time"><span>{{ format_number(dateDifference(date('Y-m-d'), $popular->deadline)) }}</span>Hari lagi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="popular campaign">
        <div class="container">
            <h2 class="title">Bantuan Pilihan</h2>
            <div class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore.</div>
            <div class="campaign-content">
                <div class="row">
                    @foreach($featured as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="campaign-item">
                            <a class="overlay" href="{{ route('campaign.detail', $item->slug) }}">
                                <img src="{{ $item->featured_image }}" alt="">
                                <span class="ion-ios-search-strong"></span>
                            </a>
                            <div class="campaign-box">
                                <a href="{{ route('campaign.category', $item->campaignType->slug) }}" class="category">{{ $item->campaignType->name }}</a>
                                <h3><a href="{{ route('campaign.detail', $item->slug) }}">#Crowdfunding - {{ $item->title }}</a></h3>
                                <div class="campaign-description">{{ $item->description }}</div>
                                <div class="campaign-author">
                                    <a class="author-icon" href="#"><img src="{{ $item->user->image }}" alt=""></a>
                                    by <a class="author-name" href="#">{{ $item->user->name }}</a>
                                </div>
                                <div class="process">
                                    <div class="raised"><span style="width: {{ $item->percentageDonation() }}%;"></span></div>
                                    <div class="process-info">
{{--                                        <div class="process-pledged"><span>Rp. {{ format_number($item->target_fund) }}</span>Bantuan dibutuhkan</div>--}}
                                        <div class="process-funded"><span>{{ $item->percentageDonation() }}%</span>Dibantu</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="latest-button"><a href="{{ route('campaign') }}" class="btn-primary">Lihat Semua Campaign</a></div>
        </div>
    </div>
    <div class="explore">
        <div class="container">
            <h2 class="title">Kategori Bantuan</h2>
            <div class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore.</div>
            <div class="explore-content">
                <div class="row">
                    @foreach($campaignTypes as $campaignType)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="explore-item">
                            <a class="explore-overlay" href="{{ route('campaign.category', $campaignType->slug) }}">
                                <img src="{{ $campaignType->icon }}" alt="">
                                <span>{{ $campaignType->name }}</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
