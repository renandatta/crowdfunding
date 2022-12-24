<?php

namespace App\Http\Controllers;

use App\Repositories\CampaignUpdatesRepository;
use App\Repositories\CampaignRepository;
use Illuminate\Http\Request;

class AdminCampaignUpdateController extends Controller
{
    private $breadcrumbs;
    private $campaignUpdateRepository;
    private $campaignRepository;

    public function __construct(CampaignUpdatesRepository $campaignUpdateRepository, CampaignRepository $campaignRepository)
    {
        $this->middleware('auth');
        $this->campaignUpdateRepository = $campaignUpdateRepository;
        $this->campaignRepository = $campaignRepository;
        $this->breadcrumbs = [
            ['url' => 'admin.campaign', 'params' => null, 'caption' => 'Bantuan'],
        ];
    }

    public function info($campaignId, $id)
    {
        $campaign = $this->campaignRepository->find($campaignId);
        array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail', 'params' => $campaign->id, 'caption' => 'Update']);
        if ($id == 'new') array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail.update.info', 'params' => [$campaignId, 'new'], 'caption' => 'Tambah']);
        if ($id != 'new') array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail.update.info', 'params' => [$campaignId, $id], 'caption' => 'Ubah']);

        $update = $id == 'new' ? 'new' : $this->campaignUpdateRepository->find($id);
        return view('admin.campaign.detail')
            ->with('breadcrumbs', $this->breadcrumbs)
            ->with('id', $id)
            ->with('tab', 'update')
            ->with('campaign', $campaign)
            ->with('update', $update);
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
            $this->campaignUpdateRepository->store($request);
        } else {
            $this->campaignUpdateRepository->update($request, $id);
        }

        return redirect()->route('admin.campaign.detail', $campaignId)
            ->with('success', $id == 'new' ? 'Update Bantuan berhasil ditambahkan' : 'Update Bantuan berhasil diubah');
    }

    public function delete($campaignId, $id)
    {
        $this->campaignUpdateRepository->delete($id);
        return redirect()->route('admin.campaign.detail', $campaignId)
            ->with('success', 'Update Bantuan berhasil dihapus');
    }
}
