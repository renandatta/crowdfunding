<?php

namespace App\Repositories;

use App\CampaignDiscussion;

class CampaignDiscussionRepository {

    protected $campaignDiscussion;

    public function __construct(CampaignDiscussion $campaignDiscussion)
    {
        $this->campaignDiscussion = $campaignDiscussion;
    }

    public function search($parameters = null, $paginate = true)
    {
        $data = $this->campaignDiscussion->where('is_deleted', '=', 0);
        if ($parameters != null) {
            $data = (!empty($parameters['user_id']) && $parameters['user_id'] != '') ? $data->where('user_id', '=', $parameters['user_id']) : $data;
            $data = (!empty($parameters['parent_id']) && $parameters['parent_id'] != '') ? $data->where('parent_id', '=', $parameters['parent_id']) : $data;
            $data = (!empty($parameters['campaign_id']) && $parameters['campaign_id'] != '') ? $data->where('campaign_id', '=', $parameters['campaign_id']) : $data;
        }
        return $paginate == true ? $data->paginate(10) : $data->get();
    }

    public function find($id)
    {
        return $this->campaignDiscussion->where('is_deleted', '=', 0)->where('id', '=', $id)->first();
    }

    public function store($request)
    {
        return $this->campaignDiscussion->create($request->all());
    }

    public function update($request, $id)
    {
        $campaignDiscussion = $this->campaignDiscussion->find($id);
        $campaignDiscussion->update($request->all());
        return $campaignDiscussion;
    }

    public function delete($id)
    {
        $campaignDiscussion = $this->campaignDiscussion->find($id);
        $campaignDiscussion->is_deleted = 1;
        $campaignDiscussion->save();
    }

}
