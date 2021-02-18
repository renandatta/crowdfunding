<?php

namespace App\Http\Controllers;

use App\Repositories\DonationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminDonationController extends Controller
{
    private $breadcrumbs;
    private $donationRepository;

    public function __construct(DonationRepository $donationRepository)
    {
        $this->middleware('auth');
        $this->donationRepository = $donationRepository;
        $this->breadcrumbs = [
            ['url' => null, 'params' => null, 'caption' => 'Data Master'],
            ['url' => 'admin.donation', 'params' => null, 'caption' => 'Jenis Pembayaran']
        ];
    }

    public function index()
    {
        Session::put('menu_active', 'admin.donation');

        return view('admin.donation.index')
            ->with('breadcrumbs', $this->breadcrumbs);
    }

    public function search(Request $request, $pagination = true)
    {
        $data = $this->donationRepository->search([
            'user_name' => $request->input('user_name'),
            'campaign_title' => $request->input('campaign_title'),
            'date_start' => $request->input('date_start'),
            'date_end' => $request->input('date_end'),
        ], $pagination);
        return $request->has('ajax') ? $data : view('admin.donation._table', ['data' => $data])->render();
    }

    public function verify($id)
    {
        $this->donationRepository->verify($id);
    }
}
