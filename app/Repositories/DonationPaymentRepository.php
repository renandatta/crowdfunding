<?php

namespace App\Repositories;

use App\DonationPayment;

class DonationPaymentRepository {

    protected $donationPayment;

    public function __construct(DonationPayment $donationPayment)
    {
        $this->donationPayment = $donationPayment;
    }

    public function search($parameters = null, $paginate = true)
    {
        $data = $this->donationPayment->where('is_deleted', '=', 0);
        if ($parameters != null) {
            $data = (!empty($parameters['donation_id']) && $parameters['donation_id'] != '') ? $data->where('donation_id', '=', $parameters['donation_id']) : $data;
            $data = (!empty($parameters['payment_type_id']) && $parameters['payment_type_id'] != '') ? $data->where('payment_type_id', '=', $parameters['payment_type_id']) : $data;
            $data = (!empty($parameters['unique_code']) && $parameters['unique_code'] != '') ? $data->where('unique_code', '=', $parameters['unique_code']) : $data;
            $data = (!empty($parameters['total_min']) && $parameters['total_min'] != '') ? $data->where('total', '>=', $parameters['total_min']) : $data;
            $data = (!empty($parameters['total_max']) && $parameters['total_max'] != '') ? $data->where('total', '<=', $parameters['total_max']) : $data;
        }
        return $paginate == true ? $data->paginate(10) : $data->get();
    }

    public function find($id)
    {
        return $this->donationPayment->where('is_deleted', '=', 0)->where('id', '=', $id)->first();
    }

    public function filterRequest($request)
    {
        if ($request->has('donationPayment')) $request->merge(['donationPayment' => unformat_number($request->input('donationPayment'))]);
        return $request;
    }

    public function store($request)
    {
        $request = $this->filterRequest($request);
        return $this->donationPayment->create($request->all());
    }

    public function update($request, $id)
    {
        $request = $this->filterRequest($request);
        $donationPayment = $this->donationPayment->find($id);
        $donationPayment->update($request->all());
        return $donationPayment;
    }

    public function delete($id)
    {
        $donationPayment = $this->donationPayment->find($id);
        $donationPayment->is_deleted = 1;
        $donationPayment->save();
    }

}
