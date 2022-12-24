<?php

namespace App\Repositories;

use App\CampaignUpdate;

class CampaignUpdatesRepository {

    protected $campaignUpdate;

    public function __construct(CampaignUpdate $campaignUpdate)
    {
        $this->campaignUpdate = $campaignUpdate;
    }

    public function search($parameters = null, $paginate = true)
    {
        $data = $this->campaignUpdate->where('is_deleted', '=', 0);
        if ($parameters != null) {
            $data = (!empty($parameters['campaign_id']) && $parameters['campaign_id'] != '') ? $data->where('campaign_id', '=', $parameters['campaign_id']) : $data;
            $data = (!empty($parameters['title']) && $parameters['title'] != '') ? $data->where('title', 'like', '%' . $parameters['title'] . '%') : $data;
        }
        return $paginate == true ? $data->paginate(10) : $data->get();
    }

    public function find($id)
    {
        return $this->campaignUpdate->where('is_deleted', '=', 0)->where('id', '=', $id)->first();
    }

    public function store($request)
    {
        return $this->campaignUpdate->create($request->all());
    }

    public function update($request, $id)
    {
        $campaignUpdate = $this->campaignUpdate->find($id);
        $campaignUpdate->update($request->all());
        return $campaignUpdate;
    }

    public function delete($id)
    {
        $campaignUpdate = $this->campaignUpdate->find($id);
        $campaignUpdate->is_deleted = 1;
        $campaignUpdate->save();
    }

}
