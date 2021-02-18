<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignTypeRequest;
use App\Repositories\CampaignTypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminCampaignTypeController extends Controller
{
    private $breadcrumbs;
    private $campaignTypeRepository;

    public function __construct(CampaignTypeRepository $campaignTypeRepository)
    {
        $this->middleware('auth');
        $this->campaignTypeRepository = $campaignTypeRepository;
        $this->breadcrumbs = [
            ['url' => null, 'params' => null, 'caption' => 'Data Master'],
            ['url' => 'admin.campaign_type', 'params' => null, 'caption' => 'Jenis Bantuan']
        ];
    }

    public function index()
    {
        Session::put('menu_active', 'admin.campaign_type');

        return view('admin.campaign_type.index')
            ->with('breadcrumbs', $this->breadcrumbs);
    }

    public function search(Request $request, $pagination = true)
    {
        $data = $this->campaignTypeRepository->search([
            'id' => $request->input('id'),
            'name' => $request->input('name')
        ], $pagination);
        return $request->has('ajax') ? $data : view('admin.campaign_type._table', ['data' => $data])->render();
    }

    public function info($id)
    {
        if ($id == 'new') {
            array_push($this->breadcrumbs, ['url' => 'admin.campaign_type.info', 'params' => 'new', 'caption' => 'Tambah']);
            $campaignType = [];
        } else {
            array_push($this->breadcrumbs, ['url' => 'admin.campaign_type.info', 'params' => 'new', 'caption' => 'Ubah']);
            $campaignType = $this->campaignTypeRepository->find($id);
        }

        return view('admin.campaign_type.info')
            ->with('id', $id)
            ->with('breadcrumbs', $this->breadcrumbs)
            ->with('campaignType', $campaignType);
    }

    public function save(CampaignTypeRequest $request, $id)
    {
        if ($id == 'new') {
            $this->campaignTypeRepository->store($request);
        } else {
            $this->campaignTypeRepository->update($request, $id);
        }

        return redirect()->route('admin.campaign_type')
            ->with('success', $id == 'new' ? 'Jenis Bantuan berhasil ditambahkan' : 'Jenis Bantuan berhasil diubah');
    }

    public function delete($id)
    {
        $this->campaignTypeRepository->delete($id);
    }
}
