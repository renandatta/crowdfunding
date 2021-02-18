<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentTypeRequest;
use App\Repositories\PaymentTypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminPaymentTypeController extends Controller
{
    private $breadcrumbs;
    private $paymentTypeRepository;

    public function __construct(PaymentTypeRepository $paymentTypeRepository)
    {
        $this->middleware('auth');
        $this->paymentTypeRepository = $paymentTypeRepository;
        $this->breadcrumbs = [
            ['url' => null, 'params' => null, 'caption' => 'Data Master'],
            ['url' => 'admin.payment_type', 'params' => null, 'caption' => 'Jenis Pembayaran']
        ];
    }

    public function index()
    {
        Session::put('menu_active', 'admin.payment_type');

        return view('admin.payment_type.index')
            ->with('breadcrumbs', $this->breadcrumbs);
    }

    public function search(Request $request, $pagination = true)
    {
        $data = $this->paymentTypeRepository->search([
            'id' => $request->input('id'),
            'name' => $request->input('name')
        ], $pagination);
        return $request->has('ajax') ? $data : view('admin.payment_type._table', ['data' => $data])->render();
    }

    public function info($id)
    {
        if ($id == 'new') {
            array_push($this->breadcrumbs, ['url' => 'admin.payment_type.info', 'params' => 'new', 'caption' => 'Tambah']);
            $paymentType = [];
        } else {
            array_push($this->breadcrumbs, ['url' => 'admin.payment_type.info', 'params' => 'new', 'caption' => 'Ubah']);
            $paymentType = $this->paymentTypeRepository->find($id);
        }

        return view('admin.payment_type.info')
            ->with('id', $id)
            ->with('breadcrumbs', $this->breadcrumbs)
            ->with('paymentType', $paymentType);
    }

    public function save(PaymentTypeRequest $request, $id)
    {
        if ($id == 'new') {
            $this->paymentTypeRepository->store($request);
        } else {
            $this->paymentTypeRepository->update($request, $id);
        }

        return redirect()->route('admin.payment_type')
            ->with('success', $id == 'new' ? 'Jenis Pembayaran berhasil ditambahkan' : 'Jenis Pembayaran berhasil diubah');
    }

    public function delete($id)
    {
        $this->paymentTypeRepository->delete($id);
    }
}
