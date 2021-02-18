@extends('layouts.main')

@section('title')
    Profil
@endsection

@section('classbody')
    contact-us
@endsection

@section('content')
    <div class="page-title background-page" style="background: #fe6666;">
        <div class="container">
            <h1>Profile</h1>
            <div class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('/') }}">Home</a><span>/</span></li>
                    <li>Riwayat Donasi</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="account-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('profile._sidebar', ['menu_active' => 'donation'])
                </div>
                <div class="col-lg-9">
                    <div class="account-content payments account-table mb-5">
                        <h3 class="account-title">Riwayat Donasi</h3>
                        <div class="account-main">
                            <table>
                                <thead>
                                <tr>
                                    <th>Nama Bantuan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-right">Nominal Donasi</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($user = Auth::user())
                                @foreach($user->userDonations as $donation)
                                <tr>
                                    <td>{{ $donation->campaign->title }}</td>
                                    <td>{{ fulldate($donation->created_at) }}</td>
                                    <td>{{ $donation->status }}</td>
                                    <td class="text-right">{{ format_number($donation->donation) }}</td>
                                    <td><a href="{{ route('campaign.detail', $donation->campaign->slug) }}">View</a></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
