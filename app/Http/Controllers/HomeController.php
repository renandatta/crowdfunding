<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Repositories\CampaignDiscussionRepository;
use App\Repositories\CampaignRepository;
use App\Repositories\CampaignTypeRepository;
use App\Repositories\DonationPaymentRepository;
use App\Repositories\DonationRepository;
use App\Repositories\PaymentTypeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $campaignRepository;
    private $campaignTypeRepository;
    private $userRepository;
    private $donationRepository;
    private $donationPaymentRepository;
    private $paymentTypeRepository;
    private $campaignDiscussionRepository;

    public function __construct(CampaignRepository $campaignRepository, CampaignTypeRepository $campaignTypeRepository,
                                UserRepository $userRepository, DonationRepository $donationRepository,
                                DonationPaymentRepository $donationPaymentRepository, PaymentTypeRepository $paymentTypeRepository,
                                CampaignDiscussionRepository $campaignDiscussionRepository)
    {
        $this->campaignRepository = $campaignRepository;
        $this->campaignTypeRepository = $campaignTypeRepository;
        $this->userRepository = $userRepository;
        $this->donationRepository = $donationRepository;
        $this->donationPaymentRepository = $donationPaymentRepository;
        $this->paymentTypeRepository = $paymentTypeRepository;
        $this->campaignDiscussionRepository = $campaignDiscussionRepository;
    }

    public function index()
    {
        $populars = $this->campaignRepository->popularCampaign();
        $featured = $this->campaignRepository->featuredCampaign();
        $campaignTypes = $this->campaignTypeRepository->search(null, false);
        return view('home.index', compact('populars', 'featured', 'campaignTypes'));
    }

    public function campaign(Request $request)
    {
        return view('home.campaign')
            ->with('search', $request->get('search'));
    }

    public function category($slug)
    {
        $campaignType = $this->campaignTypeRepository->search(['slug' => $slug], false);
        if (count($campaignType) > 0) {
            $campaignType = $campaignType[0];

            return view('home.campaign_type', compact('campaignType'));
        }
        return response(null, 404);
    }

    public function campaign_detail($slug, $tab = null)
    {
        if ($tab == 'faq') {
            if (!Auth::check()) {
                return redirect()->route('login');
            }
        }
        $campaign = $this->campaignRepository->search(['slug' => $slug], false);
        if (count($campaign) > 0) {
            $campaign = $campaign[0];
            $listDonationUserId = [];
            foreach ($campaign->donations as $key => $value) {
                array_push($listDonationUserId, $value->user_id);
            }

            return view('campaign.index', compact('campaign', 'tab', 'listDonationUserId'));
        }
        return response(null, 404);
    }

    public function campaign_search(Request $request)
    {
        $page = $request->has('page') ? $request->get('page') : 1;
        $type = $request->has('type_id') ? $request->input('type_id') : null;
        $title = $request->has('title') ? $request->input('title') : null;
        $campaigns = $this->campaignRepository->loadCampaign($page, $type, $title);
        return view('campaign._item_campaign', compact('campaigns'))->render();
    }

    public function search(Request $request)
    {
        if ($request->has('_token')) {
            return redirect()->route('campaign.search', 'search=' . $request->get('search'));
        }
    }

    public function about()
    {
        return view('home.about');
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function faq()
    {
        return view('home.faq');
    }

    public function profile()
    {
        return view('profile.index');
    }

    public function profile_edit()
    {
        return view('profile.edit');
    }

    public function profile_save(Request $request)
    {
        $this->userRepository->update($request, Auth::user()->id);

        return redirect()->route('profile')
            ->with('success', 'Profil User berhasil diubah');
    }

    public function profile_edit_password()
    {
        return view('profile.edit_password');
    }

    public function profile_save_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:4|max:255|confirmed'
        ]);

        $userRequest = new Request();
        $userRequest->merge(['password' => $request->input('password')]);

        $this->userRepository->update($userRequest, Auth::user()->id);

        return redirect()->route('profile')
            ->with('success', 'Password User berhasil diubah');
    }

    public function donation_history()
    {
        return view('profile.donation');
    }

    public function discussion_history()
    {
        return view('profile.discussion');
    }

    public function campaign_donate($slug)
    {
        $campaign = $this->campaignRepository->search(['slug' => $slug], false);
        if (count($campaign) > 0) {
            $campaign = $campaign[0];
            $paymentTypes = $this->paymentTypeRepository->search(null, false);
            return view('campaign.donate', compact('campaign', 'paymentTypes'));
        }
        return response(null, 404);
    }

    public function campaign_donation_save(Request $request, $slug)
    {
        $campaign = $this->campaignRepository->search(['slug' => $slug], false);
        if (count($campaign) > 0) {
            $campaign = $campaign[0];

            $request->merge(['user_id' => Auth::user()->id]);
            $request->merge(['campaign_id' => $campaign->id]);
            $request->merge(['status' => 'pending']);
            $request->merge(['total' => $request->input('donation')]);
            $donation = intval(unformat_number($request->input('donation')));
            $unique = intval($request->input('unique_code'));
            $donation = $donation - $unique;
            $request->merge(['donation' => $donation]);

            $donation = $this->donationRepository->store($request);
            $request->merge(['donation_id' => $donation->id]);
            $this->donationPaymentRepository->store($request);

            return redirect()->route('donation_history');
        }
        return response(null, 404);
    }

    public function campaign_discussion_save(Request $request, $slug)
    {
        $campaign = $this->campaignRepository->search(['slug' => $slug], false);
        if (count($campaign) > 0) {
            $campaign = $campaign[0];
            $request->merge(['user_id' => Auth::user()->id]);
            $request->merge(['campaign_id' => $campaign->id]);
            $this->campaignDiscussionRepository->store($request);

            return redirect()->route('campaign.detail', $campaign->slug)
                ->with('success', 'Komentar berhasil disimpan');
        }
        return response(null, 404);
    }
}
