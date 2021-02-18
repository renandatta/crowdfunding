<?php

namespace App\Repositories;

use App\CampaignFaq;

class CampaignFaqRepository {

    protected $campaignFaq;

    public function __construct(CampaignFaq $campaignFaq)
    {
        $this->campaignFaq = $campaignFaq;
    }

    public function search($parameters = null, $paginate = true)
    {
        $data = $this->campaignFaq->where('is_deleted', '=', 0);
        if ($parameters != null) {
            $data = (!empty($parameters['campaign_id']) && $parameters['campaign_id'] != '') ? $data->where('campaign_id', '=', $parameters['campaign_id']) : $data;
        }
        return $paginate == true ? $data->paginate(10) : $data->get();
    }

    public function find($id)
    {
        return $this->campaignFaq->where('is_deleted', '=', 0)->where('id', '=', $id)->first();
    }

    public function store($request)
    {
        return $this->campaignFaq->create($request->all());
    }

    public function update($request, $id)
    {
        $campaignFaq = $this->campaignFaq->find($id);
        $campaignFaq->update($request->all());
        return $campaignFaq;
    }

    public function delete($id)
    {
        $campaignFaq = $this->campaignFaq->find($id);
        $campaignFaq->is_deleted = 1;
        $campaignFaq->save();
    }

}
