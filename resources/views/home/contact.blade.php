@extends('layouts.main')

@section('title')
    Hubungi Kami
@endsection

@section('classbody')
    contact-us
@endsection

@section('content')
    <main id="main" class="site-main">
        <div class="page-content contact-content padbot50">
            <section class="statics section">
                <h2 class="title">We are changing the way of making things possible.</h2>
                <div class="description"><p>Raise money for ​over 1.5 million charities with personal fundraisers, events, races and corporate philanthropy.</p></div>
            </section>
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 main-content">
                        <div class="contact-info">
                            <h3>Hubungi Kami</h3>
                            <div class="contact-desc">
                                <p>Lorem Ipsum is simply dummy text of the printing & typesetting industry. Lorem Ipsum has been scrambled it to make type specimen book.</p>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6 align-left">
                                    <button type="submit" value="Send Messager" class="btn-primary"><i class="fa fa-whatsapp" aria-hidden="true">&nbsp; Whatsapp</i></button>
                                </div>
                                <div class="col-md-6  align-right">
                                    <button type="submit" value="Send Messager" class="btn-primary"><i class="fa fa-envelope-o" aria-hidden="true">&nbsp; Email</i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')

@endpush
