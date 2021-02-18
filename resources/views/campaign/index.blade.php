@extends('layouts.main')

@section('title')
    {{ $campaign->title }}
@endsection

@section('classbody')
    campaign-detail
@endsection

@section('content')
    <div class="campaign-content padtop50">
        <div class="container">
            <div class="campaign">
                <div class="campaign-item clearfix">
                    <div class="campaign-image">
                        <img src="{{ $campaign->featured_image }}" alt="">
                    </div>
                    <div class="campaign-box">
                        <a href="{{ route('campaign.category', $campaign->campaignType->slug) }}" class="category">{{ $campaign->campaignType->name }}</a>
                        <h3>#Crowdfunding - {{ $campaign->title }}</h3>
                        <div class="campaign-description"><p>{!! $campaign->description !!}</p></div>
                        <div class="campaign-author clearfix">
                            <div class="author-profile">
                                <a class="author-icon" href="#"><img src="{{ $campaign->user->image }}" alt=""></a>
                                by <a class="author-name" href="#">{{ $campaign->user->name }}</a>
                            </div>
                            <div class="author-address"><span class="ion-location"></span>{{ $campaign->district . ', ' . $campaign->province }}</div>
                        </div>
                        <div class="process">
                            <div class="raised"><span style="width: {{ $campaign->percentageDonation() }}%"></span></div>
                            <div class="process-info">
                                <div class="process-funded"><span>Rp. {{ format_number($campaign->target_fund) }}</span>Target Bantuan</div>
                                <div class="process-pledged"><span>{{ format_number($campaign->donations->sum('donation')) }}</span>Bantuan</div>
                                <div class="process-time"><span>{{ format_number($campaign->donations->count('donation')) }}</span>Donatur</div>
                                <div class="process-time"><span>{{ format_number(dateDifference(date('Y-m-d'), $campaign->deadline)) }}</span>Hari lagi</div>
                            </div>
                        </div>
                        <div class="button">
                            <a href="{{ route('campaign.donate', $campaign->slug) }}" class="btn-primary">Beri Donasi</a>
                        </div>
{{--                        <div class="share">--}}
{{--                            <p>Share this project</p>--}}
{{--                            <ul>--}}
{{--                                <li class="share-facebook"><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>--}}
{{--                                <li class="share-twitter"><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>--}}
{{--                                <li class="share-google-plus"><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>--}}
{{--                                <li class="share-linkedin"><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>--}}
{{--                                <li class="share-code"><a href="#"><i class="fa fa-code" aria-hidden="true"></i></a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="campaign-history">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="campaign-tabs">
                        @php($tab = $tab ?? 'campaign')
                        <ul class="tabs-controls">
                            <li class=" {{ $tab == 'campaign' ? 'active' : '' }}" data-tab="campaign"><a href="#">Detail Cerita Bantuan</a></li>
                            <li class=" {{ $tab == 'backer' ? 'active' : '' }}" data-tab="backer"><a href="#">List Donatur</a></li>
                            <li class=" {{ $tab == 'faq' ? 'active' : '' }}" data-tab="faq"><a href="#">FAQ</a></li>
                            <li class=" {{ $tab == 'updates' ? 'active' : '' }}" data-tab="updates"><a href="#">Berita Terbaru</a></li>
                            <li class=" {{ $tab == 'comment' ? 'active' : '' }}" data-tab="comment"><a href="#">Ruang Diskusi</a></li>
                        </ul>
                        <div class="campaign-content">
                            <div id="campaign" class="tabs {{ $tab == 'campaign' ? 'active' : '' }}">
                                @foreach($campaign->campaignDetails as $detail)
                                    @if($detail->type == 'image')
                                        <img src="{{ $detail->content }}" alt="" class="img-fluid">
                                    @else
                                        {!! $detail->content !!}
                                    @endif
                                @endforeach
                            </div>
                            <div id="backer" class="tabs {{ $tab == 'backer' ? 'active' : '' }}">
                                <table>
                                    <tr>
                                        <th>Name</th>
                                        <th>Donate Amount</th>
                                        <th>Date</th>
                                    </tr>
                                    @foreach($campaign->donations as $donation)
                                    <tr>
                                        <td>{{ $donation->user->name }}</td>
                                        <td>Rp. {{ format_number($donation->donation) }}</td>
                                        <td>{{ fulldate($donation->created_at, " ", true) }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div id="faq" class="tabs {{ $tab == 'faq' ? 'active' : '' }}">
                                <h2>Frequently Asked Questions</h2>
                                @if(count($campaign->campaignFaqs) == 0)
                                <p>Looks like there aren't any frequently asked questions yet. Ask the project creator directly.</p>
                                @endif

                                <ul class="list-faq">
                                    @foreach($campaign->campaignFaqs as $faq)
                                    <li>
                                        <span class="ion-plus"></span><a href="#">{{ $faq->question }}</a>
                                        <div class="faq-desc">
                                            {!! $faq->answer !!}
                                        </div>
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                            <div id="updates" class="tabs {{ $tab == 'updates' ? 'active' : '' }}">
                                <ul>
                                    @foreach($campaign->campaignUpdates as $update)
                                    <li>
                                        <p class="date">{{ format_date($update->created_at) }}</p>
                                        <h3>{{ $update->title }}</h3>
                                        <div class="desc"><p>{!! $update->content !!}</p></div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div id="comment" class="tabs  {{ $tab == 'comment' ? 'active' : '' }} comment-area">
                                <h3 class="comments-title">{{ count($campaign->campaignDiscussions) }} Comment</h3>
                                <ol class="comments-list">
                                    @foreach($campaign->campaignDiscussions as $discussion)
                                    <li class="comment clearfix">
                                        <div class="comment-body">
                                            <div class="comment-avatar"><img src="{{ $discussion->user->image }}" alt="" style="width: 80px;"></div>
                                            <div class="comment-info">
                                                <header class="comment-meta"></header>
                                                <cite class="comment-author">{{ $discussion->user->name }}</cite>
                                                <div class="comment-inline">
                                                    <span class="comment-date">{{ $discussion->created_at->diffForHumans() }}</span>
                                                    @if(Auth::check())
                                                        @if(in_array(Auth::user()->id, $listDonationUserId))
                                                            <a href="javascript:void(0)" onclick="replyFrom({{ $discussion }})" class="comment-reply">Reply</a>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="comment-content"><p>{{ $discussion->content }}</p></div>
                                            </div>
                                        </div>
                                    </li>
                                        @foreach($discussion->replies as $reply)
                                            <li class="comment clearfix" style="border-left: 5px solid #eaeaea;margin-left: 100px;margin-top: 20px;">
                                                <div class="comment-body">
                                                    <div class="comment-info ml-2">
                                                        <header class="comment-meta"></header>
                                                        <cite class="comment-author">{{ $reply->user->name }}</cite>
                                                        <div class="comment-inline">
                                                            <span class="comment-date">{{ $reply->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <div class="comment-content"><p>{{ $reply->content }}</p></div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ol>
                                @if(Auth::check())
                                    @if(in_array(Auth::user()->id, $listDonationUserId))
                                    <div id="respond" class="comment-respond">
                                        <h3 id="reply-title" class="comment-reply-title">Tinggalkan Pesan?</h3>
                                        <form action="{{ route('campaign.discussion.save', $campaign->slug) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="parent_id" id="parent_id" value="">
                                            <h6 class="mb-2" id="replyFrom" style="display: none;">Balasan dari : </h6>
                                            <div class="field-textarea">
                                                <textarea rows="8" placeholder="Komentar" name="content"></textarea>
                                            </div>
                                            <button type="submit" class="btn-primary">Kirim Komentar</button>
                                        </form>
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function replyFrom(data) {
            $('#parent_id').val(data.id);
            $('#replyFrom').show();
            $('#replyFrom').html('Balasan dari : ' + data.content);
        }
    </script>
@endpush
