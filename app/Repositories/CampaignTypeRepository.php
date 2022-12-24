<?php

namespace App\Repositories;

use App\CampaignType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignTypeRepository {

    protected $campaignType;

    public function __construct(CampaignType $campaignType)
    {
        $this->campaignType = $campaignType;
    }

    public function search($parameters = null, $paginate = true)
    {
        $data = $this->campaignType->where('is_deleted', '=', 0);
        if ($parameters != null) {
            $data = (!empty($parameters['name']) && $parameters['name'] != '') ? $data->where('name', 'like', '%' . $parameters['name'] . '%') : $data;
        }
        return $paginate == true ? $data->paginate(10) : $data->get();
    }

    public function find($id)
    {
        return $this->campaignType->where('is_deleted', '=', 0)->where('id', '=', $id)->first();
    }

    public function store($request)
    {
        $campaignType = $this->campaignType->create($request->all());
        $this->uploadFile($request, $campaignType);
        return $campaignType;
    }

    public function update($request, $id)
    {
        $campaignType = $this->campaignType->find($id);
        $campaignType->update($request->all());
        $this->uploadFile($request, $campaignType);
        return $campaignType;
    }

    public function delete($id)
    {
        $campaignType = $this->campaignType->find($id);
        $campaignType->is_deleted = 1;
        $campaignType->save();
    }

    public function uploadFile($request, $campaignType)
    {
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = Str::random(6) . '.' . $request->file('icon')->extension();
            $path = Storage::putFileAs('icon', $file, $filename);
            $campaignType->icon = url('storage') . '/' . $path;
            $campaignType->save();
        }
    }

}
