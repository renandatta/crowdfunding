<?php

namespace App\Repositories;

use App\Campaign;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignRepository {

    protected $campaign;

    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function loadCampaign($page, $type, $title)
    {
        $data = $this->campaign->where('is_deleted', '=', 0)
            ->orderBy('id', 'desc')
            ->skip(($page - 1) * 10)
            ->limit(12);
        if ($type != null) $data = $data->where('campaign_type_id', '=', $type);
        if ($title != null) $data = $data->where(function ($q) use ($title){
            $q->where('title', 'like', '%' . $title . '%');
        });
        return $data->get();
    }

    public function search($parameters = null, $paginate = true)
    {
        $data = $this->campaign->where('is_deleted', '=', 0);
        if ($parameters != null) {
            $data = (!empty($parameters['slug']) && $parameters['slug'] != '') ? $data->where('slug', '=', $parameters['slug']) : $data;
            $data = (!empty($parameters['title']) && $parameters['title'] != '') ? $data->where('title', 'like', '%' . $parameters['title'] . '%') : $data;
            $data = (!empty($parameters['description']) && $parameters['description'] != '') ? $data->where('description', 'like', '%' . $parameters['description'] . '%') : $data;
            $data = (!empty($parameters['province']) && $parameters['province'] != '') ? $data->where('province', '=', $parameters['province']) : $data;
            $data = (!empty($parameters['district']) && $parameters['district'] != '') ? $data->where('district', '=', $parameters['district']) : $data;
            $data = (!empty($parameters['sub_district']) && $parameters['sub_district'] != '') ? $data->where('sub_district', '=', $parameters['sub_district']) : $data;
            $data = (!empty($parameters['village']) && $parameters['village'] != '') ? $data->where('village', '=', $parameters['village']) : $data;
            $data = (!empty($parameters['status']) && $parameters['status'] != '') ? $data->where('status', '=', $parameters['status']) : $data;
            $data = (!empty($parameters['campaign_type_id']) && $parameters['campaign_type_id'] != '') ? $data->where('campaign_type_id', '=', $parameters['campaign_type_id']) : $data;
            $data = (!empty($parameters['user_id']) && $parameters['user_id'] != '') ? $data->where('user_id', '=', $parameters['user_id']) : $data;
            $data = (!empty($parameters['target_fund_min']) && $parameters['target_fund_min'] != '') ? $data->where('target_fund', '>=', $parameters['target_fund_min']) : $data;
            $data = (!empty($parameters['target_fund_max']) && $parameters['target_fund_max'] != '') ? $data->where('target_fund', '<=', $parameters['target_fund_max']) : $data;
        }
        return $paginate == true ? $data->paginate(10) : $data->get();
    }

    public function find($id)
    {
        return $this->campaign->where('is_deleted', '=', 0)->where('id', '=', $id)->first();
    }

    public function filterRequest($request)
    {
        if ($request->has('target_fund')) $request->merge(['target_fund' => unformat_number($request->input('target_fund'))]);
        if ($request->has('deadline')) $request->merge(['deadline' => unformat_date($request->input('deadline'))]);
        return $request;
    }

    public function store($request)
    {
        $request = $this->filterRequest($request);
        $campaign = $this->campaign->create($request->all());
        $this->uploadFile($request, $campaign);
        return $campaign;
    }

    public function update($request, $id)
    {
        $request = $this->filterRequest($request);
        $campaign = $this->campaign->find($id);
        $campaign->update($request->all());
        $this->uploadFile($request, $campaign);
        return $campaign;
    }

    public function delete($id)
    {
        $campaign = $this->campaign->find($id);
        $campaign->is_deleted = 1;
        $campaign->save();
    }

    public function popularCampaign()
    {
        return $this->campaign->where('is_deleted', '=', 0)->limit(10)->get();
    }

    public function featuredCampaign()
    {
        return $this->campaign->where('is_deleted', '=', 0)->limit(3)->get();
    }

    public function uploadFile($request, $campaign)
    {
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = Str::random(6) . '.' . $request->file('featured_image')->extension();
            $path = Storage::putFileAs('featured_image', $file, $filename);
            $campaign->featured_image = url('storage') . '/' . $path;
            $campaign->save();
        }
    }

}
