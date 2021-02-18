<?php

namespace App\Http\Controllers;

use App\Repositories\CampaignRepository;
use App\Repositories\CampaignDiscussionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCampaignDiscussionController extends Controller
{
    private $breadcrumbs;
    private $campaignDiscussionRepository;
    private $campaignRepository;

    public function __construct(CampaignDiscussionRepository $campaignDiscussionRepository, CampaignRepository $campaignRepository)
    {
        $this->middleware('auth');
        $this->campaignDiscussionRepository = $campaignDiscussionRepository;
        $this->campaignRepository = $campaignRepository;
        $this->breadcrumbs = [
            ['url' => 'admin.campaign', 'params' => null, 'caption' => 'Bantuan'],
        ];
    }

    public function info($campaignId, $id)
    {
        $campaign = $this->campaignRepository->find($campaignId);
        array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail', 'params' => $campaign->id, 'caption' => 'Discussion']);
        if ($id == 'new') array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail.discussion.info', 'params' => [$campaignId, 'new'], 'caption' => 'Tambah']);
        if ($id != 'new') array_push($this->breadcrumbs, ['url' => 'admin.campaign.detail.discussion.info', 'params' => [$campaignId, $id], 'caption' => 'Ubah']);

        $discussion = $id == 'new' ? 'new' : $this->campaignDiscussionRepository->find($id);
        return view('admin.campaign.detail')
            ->with('breadcrumbs', $this->breadcrumbs)
            ->with('id', $id)
            ->with('tab', 'discussion')
            ->with('campaign', $campaign)
            ->with('discussion', $discussion);
    }

    public function save(Request $request, $campaignId, $id)
    {
        if ($id == 'new') {
            $request->merge(['campaign_id' => $campaignId]);
            $request->merge(['user_id' => Auth::user()->id]);
            $this->campaignDiscussionRepository->store($request);
        } else {
            $this->campaignDiscussionRepository->update($request, $id);
        }

        return redirect()->route('admin.campaign.detail', $campaignId)
            ->with('success', $id == 'new' ? 'Discussion Bantuan berhasil ditambahkan' : 'Discussion Bantuan berhasil diubah');
    }

    public function delete($campaignId, $id)
    {
        $this->campaignDiscussionRepository->delete($id);
        return redirect()->route('admin.campaign.detail', $campaignId)
            ->with('success', 'Discussion Bantuan berhasil dihapus');
    }
}
