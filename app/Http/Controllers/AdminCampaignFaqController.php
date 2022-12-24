<?php

namespace App\Http\Controllers;

use App\Repositories\CampaignFaqRepository;
use App\Repositories\CampaignRepository;
use Illuminate\Http\Request;

class AdminCampaignFaqController extends Controller
{
    private $breadcrumbs;
    private $campaignFaqRepository;
    private $campaignRepository;

    public function __construct(CampaignFaqRepository $campaignFaqRepository, CampaignRepository $campaignRepository)
    {
        $this->middleware('auth');
        $this->campaignFaqRepository = $campaignFaqRepository;
        $this->campaignRepository = $campaignRepository;
        $this->breadcrumbs = [
            ['url' => 'admin.campaign', 'params' => null, 'caption' => 'Bantuan'],
        ];
    }

    public function info($campaignId, $id)
    {
        $campaign = $this->campaignRepository->find($campaignId);
        array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail', 'params' => $campaign->id, 'caption' => 'Faq']);
        if ($id == 'new') array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail.faq.info', 'params' => [$campaignId, 'new'], 'caption' => 'Tambah']);
        if ($id != 'new') array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail.faq.info', 'params' => [$campaignId, $id], 'caption' => 'Ubah']);

        $faq = $id == 'new' ? 'new' : $this->campaignFaqRepository->find($id);
        return view('admin.campaign.detail')
            ->with('breadcrumbs', $this->breadcrumbs)
            ->with('id', $id)
            ->with('tab', 'faq')
            ->with('campaign', $campaign)
            ->with('faq', $faq);
    }

    public function save(Request $request, $campaignId, $id)
    {
        if ($id == 'new') {
            $request->merge(['campaign_id' => $campaignId]);
            $this->campaignFaqRepository->store($request);
        } else {
            $this->campaignFaqRepository->update($request, $id);
        }

        return redirect()->route('admin.campaign.detail', $campaignId)
            ->with('success', $id == 'new' ? 'Faq Bantuan berhasil ditambahkan' : 'Faq Bantuan berhasil diubah');
    }

    public function delete($campaignId, $id)
    {
        $this->campaignFaqRepository->delete($id);
        return redirect()->route('admin.campaign.detail', $campaignId)
            ->with('success', 'Faq Bantuan berhasil dihapus');
    }
}
