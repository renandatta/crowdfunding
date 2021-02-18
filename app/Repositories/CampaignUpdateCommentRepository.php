<?php

namespace App\Repositories;

use App\CampaignUpdateComment;

class CampaignUpdateCommentRepository {

    protected $campaignUpdateComment;

    public function __construct(CampaignUpdateComment $campaignUpdateComment)
    {
        $this->campaignUpdateComment = $campaignUpdateComment;
    }

    public function search($parameters = null, $paginate = true)
    {
        $data = $this->campaignUpdateComment->where('is_deleted', '=', 0);
        if ($parameters != null) {
            $data = (!empty($parameters['campaign_update_id']) && $parameters['campaign_update_id'] != '') ? $data->where('campaign_update_id', '=', $parameters['campaign_update_id']) : $data;
            $data = (!empty($parameters['parent_id']) && $parameters['parent_id'] != '') ? $data->where('parent_id', '=', $parameters['parent_id']) : $data;
            $data = (!empty($parameters['user_id']) && $parameters['user_id'] != '') ? $data->where('user_id', '=', $parameters['user_id']) : $data;
        }
        return $paginate == true ? $data->paginate(10) : $data->get();
    }

    public function find($id)
    {
        return $this->campaignUpdateComment->where('is_deleted', '=', 0)->where('id', '=', $id)->first();
    }

    public function store($request)
    {
        return $this->campaignUpdateComment->create($request->all());
    }

    public function update($request, $id)
    {
        $campaignUpdateComment = $this->campaignUpdateComment->find($id);
        $campaignUpdateComment->update($request->all());
        return $campaignUpdateComment;
    }

    public function delete($id)
    {
        $campaignUpdateComment = $this->campaignUpdateComment->find($id);
        $campaignUpdateComment->is_deleted = 1;
        $campaignUpdateComment->save();
    }

}
