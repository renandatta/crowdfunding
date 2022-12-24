<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Repositories\CampaignDetailRepository;
use App\Repositories\CampaignRepository;
use Illuminate\Http\Request;

class AdminCampaignDetailController extends Controller
{
    private $breadcrumbs;
    private $campaignDetailRepository;
    private $campaignRepository;

    public function __construct(CampaignDetailRepository $campaignDetailRepository, CampaignRepository $campaignRepository)
    {
        $this->middleware('auth');
        $this->campaignDetailRepository = $campaignDetailRepository;
        $this->campaignRepository = $campaignRepository;
        $this->breadcrumbs = [
            ['url' => 'admin.campaign', 'params' => null, 'caption' => 'Bantuan'],
        ];
    }

    public function info($campaignId, $id)
    {
        $campaign = $this->campaignRepository->find($campaignId);
        array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail', 'params' => $campaign->id, 'caption' => 'Detail']);
        if ($id == 'new') array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail.info', 'params' => [$campaignId, 'new'], 'caption' => 'Tambah']);
        if ($id != 'new') array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail.info', 'params' => [$campaignId, $id], 'caption' => 'Ubah']);

        $detail = $id == 'new' ? 'new' : $this->campaignDetailRepository->find($id);
        return view('admin.campaign.detail')
            ->with('breadcrumbs', $this->breadcrumbs)
            ->with('id', $id)
            ->with('tab', 'detail')
            ->with('campaign', $campaign)
            ->with('detail', $detail);
    }

    public function save(Request $request, $campaignId, $id)
    {
        if ($id == 'new') {
            $request->merge(['campaign_id' => $campaignId]);
            if ($request->input('type') == 'image') {
                $request->merge(['content' => $request->input('content_image')]);
            } else {
                $request->merge(['content' => $request->input('content_text')]);
            }
            $this->campaignDetailRepository->store($request);
        } else {
            $this->campaignDetailRepository->update($request, $id);
        }

        return redirect()->route('admin.campaign.detail', $campaignId)
            ->with('success', $id == 'new' ? 'Detail Bantuan berhasil ditambahkan' : 'Detail Bantuan berhasil diubah');
    }

    public function delete($campaignId, $id)
    {
        $this->campaignDetailRepository->delete($id);
        return redirect()->route('admin.campaign.detail', $campaignId)
            ->with('success', 'Detail Bantuan berhasil dihapus');
    }
}
