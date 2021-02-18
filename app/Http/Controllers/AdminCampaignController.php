<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignRequest;
use App\Repositories\CampaignRepository;
use App\Repositories\CampaignTypeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminCampaignController extends Controller
{
    private $breadcrumbs;
    private $campaignRepository;
    private $campaignTypeRepository;
    private $userRepository;

    public function __construct(CampaignRepository $campaignRepository, CampaignTypeRepository $campaignTypeRepository,
                                UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->campaignRepository = $campaignRepository;
        $this->campaignTypeRepository = $campaignTypeRepository;
        $this->userRepository = $userRepository;
        $this->breadcrumbs = [
            ['url' => 'admin.campaign', 'params' => null, 'caption' => 'Bantuan']
        ];
    }

    public function index()
    {
        Session::put('menu_active', 'admin.campaign');

        return view('admin.campaign.index')
            ->with('breadcrumbs', $this->breadcrumbs);
    }

    public function search(Request $request, $pagination = true)
    {
        $data = $this->campaignRepository->search([
            'id' => $request->input('id'),
            'name' => $request->input('name')
        ], $pagination);
        return $request->has('ajax') ? $data : view('admin.campaign._table', ['data' => $data])->render();
    }

    public function info($id)
    {
        if ($id == 'new') {
            array_push($this->breadcrumbs, ['url' => 'admin.campaign.info', 'params' => 'new', 'caption' => 'Tambah']);
            $campaign = [];
        } else {
            array_push($this->breadcrumbs, ['url' => 'admin.campaign.info', 'params' => 'new', 'caption' => 'Ubah']);
            $campaign = $this->campaignRepository->find($id);
        }
        $campaignTypes = $this->campaignTypeRepository->search(null, false);
        $users = $this->userRepository->search(['user_level' => 'user'], false);

        return view('admin.campaign.info')
            ->with('id', $id)
            ->with('breadcrumbs', $this->breadcrumbs)
            ->with('campaign', $campaign)
            ->with('campaignTypes', $campaignTypes)
            ->with('users', $users);
    }

    public function save(CampaignRequest $request, $id)
    {
        if ($id == 'new') {
            $this->campaignRepository->store($request);
        } else {
            $this->campaignRepository->update($request, $id);
        }

        return redirect()->route('admin.campaign')
            ->with('success', $id == 'new' ? 'Bantuan berhasil ditambahkan' : 'Bantuan berhasil diubah');
    }

    public function delete($id)
    {
        $this->campaignRepository->delete($id);
    }

    public function detail($id)
    {
        array_push($this->breadcrumbs, ['url' => 'admin.campaign.info', 'params' => $id, 'caption' => 'Detail']);
        $campaign = $this->campaignRepository->find($id);

        return view('admin.campaign.detail')
            ->with('id', $id)
            ->with('breadcrumbs', $this->breadcrumbs)
            ->with('campaign', $campaign);
    }
}
