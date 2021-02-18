<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminUserController extends Controller
{
    private $breadcrumbs;
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->breadcrumbs = [
            ['url' => null, 'params' => null, 'caption' => 'Data Master'],
            ['url' => 'admin.user', 'params' => null, 'caption' => 'User']
        ];
    }

    public function index()
    {
        Session::put('menu_active', 'admin.user');

        return view('admin.user.index')
            ->with('breadcrumbs', $this->breadcrumbs);
    }

    public function search(Request $request, $pagination = true)
    {
        $data = $this->userRepository->search([
            'id' => $request->input('id'),
            'email' => $request->input('email'),
            'name' => $request->input('name')
        ], $pagination);
        return $request->has('ajax') ? $data : view('admin.user._table', ['data' => $data])->render();
    }

    public function info($id)
    {
        if ($id == 'new') {
            array_push($this->breadcrumbs, ['url' => 'admin.user.info', 'params' => 'new', 'caption' => 'Tambah']);
            $user = [];
        } else {
            array_push($this->breadcrumbs, ['url' => 'admin.user.info', 'params' => 'new', 'caption' => 'Ubah']);
            $user = $this->userRepository->find($id);
        }
        $userLevels = [['name' => 'Superadmin'], ['name' => 'User']];

        return view('admin.user.info')
            ->with('id', $id)
            ->with('breadcrumbs', $this->breadcrumbs)
            ->with('user', $user)
            ->with('userLevels', $userLevels);
    }

    public function save(UserRequest $request, $id)
    {
        if ($id == 'new') {
            $this->userRepository->store($request);
        } else {
            $this->userRepository->update($request, $id);
        }

        return redirect()->route('admin.user')
            ->with('success', $id == 'new' ? 'User berhasil ditambahkan' : 'User berhasil diubah');
    }

    public function delete($id)
    {
        $this->userRepository->delete($id);
    }
}
