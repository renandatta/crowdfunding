@extends('layouts.main')

@section('title')
    {{ $campaign->title }}
@endsection

@section('classbody')
    campaign-detail
@endsection

@section('content')
    <div class="page-title background-page" style="background: #00a6eb;">
        <div class="container">
            <h1>Pembayaran Donasi</h1>
            <div class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('/') }}">Home</a><span>/</span></li>
                    <li>Pembayaran Donasi</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="form-payment">
                @php($prefix = 'donateForm')
                <form action="{{ route('campaign.donation.save', $campaign->slug) }}" method="post" id="{{ $prefix }}" enctype="multipart/form-data" class="mb-5">
                    @csrf
                    <div id="itemform">
                        <div class="start-form">
                            <div class="reward-top">
                                @php($uniqueCode = mt_rand(111,999))
                                <h2 class="reward-title">Pembayaran Transaksi #{{ date('dmyH').$uniqueCode }}</h2>
                            </div>
                            <div class="field">
                                <label for="rewardtitle">Nama Campaign</label>
                                <h4>#BERIBERBAGI-{{ $campaign->title }}</h4>
                            </div>
                            <div class="field">
                                <label for="donate">Jumlah Donasi</label>
                                <input type="text" id="donate" class="autonumeric" required>
                            </div>
                            <div class="field">
                                <h4>Metode Pembayaran</h4>
                                <div class="payment">
                                    <ul>
                                        @foreach($paymentTypes as $type)
                                        <li>
                                            <input type="radio" id="paymentType{{ $type->id }}" class="payment-option" value="{{ $type->id }}" name="payment_type_id">
                                            <label for="paymentType{{ $type->id }}">{{ $type->name }}</label>
                                            <div class="payment-check"></div>
                                            <div class="payment-desc">
                                                <p>{{ $type->description }}</p>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="field">
                                <a href="#" class="add-item btn-primary" id="buttonCofirm" style="display: none;">Konfirmasi</a>
                                <div class="spopup-bg"></div>
                                <div class="item-popup start-popup">
                                    <div class="spopup-title">
                                        <h3>Konfirmasi</h3>
                                        <div class="spopup-close"><span class="ion-ios-close-empty"></span></div>
                                    </div>
                                    <div class="spopup-desc">Saya telah membaca dan memahami. Saya akan menyumbang sebesar:</div>
                                    <div class="spopup-content">

                                        <input type="hidden" name="unique_code" id="unique_code" value="{{ $uniqueCode }}">
                                        <input type="hidden" name="no_donate" id="no_donate" value="#{{ date('dmyH').$uniqueCode }}">
                                        <input type="hidden" name="donation" id="{{ $prefix }}donate" value="">
                                        <h4 class="nominal_donasi" id="textDonate">Rp. 0</h4>
                                        <div class="field field-checkbox">
                                            <input type="checkbox" name="agree" id="checkAgree" required>
                                            <label for="checkAgree"><span></span><strong>Ya, saya setuju</strong></label>
                                        </div>
                                        <button type="submit" class="btn-primary" id="buttonSave" disabled>Bayar Donasi</button>
                                        <a href="#" class="btn item-cancel">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#donate').change(function () {
            let donate = $('#donate').val();
            let unique = parseInt('{{ $uniqueCode }}');
            donate = parseInt(remove_commas(donate));
            donate = donate + unique;
            $('#{{ $prefix }}donate').val(donate);
            $('#textDonate').html('Rp. ' + add_commas(donate));
        });
        $('.payment-option, #donate').change(function () {
            let donate = $('#donate').val();
            if (donate !== '' && donate !== '0') {
                $('#buttonCofirm').show();
            } else {
                $('#buttonCofirm').hide();
            }
        });
        $('#checkAgree').change(function () {
            if ($('#checkAgree').is(":checked")) {
                $('#buttonSave').removeAttr('disabled');
            } else {
                $('#buttonSave').attr('disabled', 'disabled');
            }
        });
    </script>
@endpush
