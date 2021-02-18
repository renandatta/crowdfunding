<?php

namespace App\Repositories;

use App\Donation;

class DonationRepository {

    protected $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    public function search($parameters = null, $paginate = true)
    {
        $data = $this->donation->where('donations.is_deleted', '=', 0)
            ->select('donations.*')
            ->join('campaigns', 'campaigns.id', '=', 'donations.campaign_id')
            ->join('users', 'users.id', '=', 'donations.user_id');
        if ($parameters != null) {
            $data = (!empty($parameters['user_name']) && $parameters['user_name'] != '') ? $data->where('users.name', 'like', '%' . $parameters['user_name'] . '%') : $data;
            $data = (!empty($parameters['campaign_title']) && $parameters['campaign_title'] != '') ? $data->where('campaigns.title', 'like', '%' . $parameters['campaign_title'] . '%') : $data;
            $data = (!empty($parameters['status']) && $parameters['status'] != '') ? $data->where('status', '=', $parameters['status']) : $data;
            $data = (!empty($parameters['donation_min']) && $parameters['donation_min'] != '') ? $data->where('donation', '>=', unformat_number($parameters['donation_min'])) : $data;
            $data = (!empty($parameters['donation_max']) && $parameters['donation_max'] != '') ? $data->where('donation', '<=', unformat_number($parameters['donation_max'])) : $data;
            $data = (!empty($parameters['date_start']) && $parameters['date_start'] != '') ? $data->where('donations.created_at', '>=', unformat_date($parameters['date_start'])) : $data;
            $data = (!empty($parameters['date_end']) && $parameters['date_end'] != '') ? $data->where('donations.created_at', '<=', unformat_date($parameters['date_end'])) : $data;
        }
        return $paginate == true ? $data->paginate(10) : $data->get();
    }

    public function find($id)
    {
        return $this->donation->where('is_deleted', '=', 0)->where('id', '=', $id)->first();
    }

    public function filterRequest($request)
    {
        if ($request->has('donation')) $request->merge(['donation' => unformat_number($request->input('donation'))]);

        return $request;
    }

    public function store($request)
    {
        $request = $this->filterRequest($request);
        return $this->donation->create($request->all());
    }

    public function update($request, $id)
    {
        $request = $this->filterRequest($request);
        $donation = $this->donation->find($id);
        $donation->update($request->all());
        return $donation;
    }

    public function delete($id)
    {
        $donation = $this->donation->find($id);
        $donation->is_deleted = 1;
        $donation->save();
    }

    public function verify($id)
    {
        $donation = $this->donation->find($id);
        $donation->status = 'diverifikasi';
        $donation->save();
    }

}
