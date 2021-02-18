<?php

namespace App\Repositories;

use App\CampaignDetail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignDetailRepository {

    protected $campaignDetail;

    public function __construct(CampaignDetail $campaignDetail)
    {
        $this->campaignDetail = $campaignDetail;
    }

    public function search($parameters = null, $paginate = true)
    {
        $data = $this->campaignDetail->where('is_deleted', '=', 0);
        if ($parameters != null) {
            $data = (!empty($parameters['no']) && $parameters['no'] != '') ? $data->where('no', '=', $parameters['no']) : $data;
            $data = (!empty($parameters['type']) && $parameters['type'] != '') ? $data->where('type', '=', $parameters['type']) : $data;
            $data = (!empty($parameters['campaign_id']) && $parameters['campaign_id'] != '') ? $data->where('campaign_id', '=', $parameters['campaign_id']) : $data;
        }
        return $paginate == true ? $data->paginate(10) : $data->get();
    }

    public function find($id)
    {
        return $this->campaignDetail->where('is_deleted', '=', 0)->where('id', '=', $id)->first();
    }

    public function store($request)
    {
        $campaignDetail = $this->campaignDetail->create($request->all());
        $this->uploadFile($request, $campaignDetail);
        return $campaign;
    }

    public function update($request, $id)
    {
        $campaignDetail = $this->campaignDetail->find($id);
        $campaignDetail->update($request->all());
        $this->uploadFile($request, $campaignDetail);
        return $campaignDetail;
    }

    public function delete($id)
    {
        $campaignDetail = $this->campaignDetail->find($id);
        $campaignDetail->is_deleted = 1;
        $campaignDetail->save();
    }

    public function uploadFile($request, $campaignDetail)
    {
        if ($request->hasFile('content')) {
            $file = $request->file('content');
            $filename = Str::random(6) . '.' . $request->file('content')->extension();
            $path = Storage::putFileAs('content', $file, $filename);
            $campaignDetail->content = url('storage') . '/' . $path;
            $campaignDetail->save();
        }
    }

}
