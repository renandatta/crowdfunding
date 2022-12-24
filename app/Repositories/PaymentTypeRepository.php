<?php

namespace App\Repositories;

use App\PaymentType;

class PaymentTypeRepository {

    protected $paymentType;

    public function __construct(PaymentType $paymentType)
    {
        $this->paymentType = $paymentType;
    }

    public function search($parameters = null, $paginate = true)
    {
        $data = $this->paymentType->where('is_deleted', '=', 0);
        if ($parameters != null) {
            $data = (!empty($parameters['name']) && $parameters['name'] != '') ? $data->where('name', 'like', '%' . $parameters['name'] . '%') : $data;
        }
        return $paginate == true ? $data->paginate(10) : $data->get();
    }

    public function find($id)
    {
        return $this->paymentType->where('is_deleted', '=', 0)->where('id', '=', $id)->first();
    }

    public function store($request)
    {
        return $this->paymentType->create($request->all());
    }

    public function update($request, $id)
    {
        $paymentType = $this->paymentType->find($id);
        $paymentType->update($request->all());
        return $paymentType;
    }

    public function delete($id)
    {
        $paymentType = $this->paymentType->find($id);
        $paymentType->is_deleted = 1;
        $paymentType->save();
    }

}
