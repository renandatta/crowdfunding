<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserRepository {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function search($parameters = null, $paginate = true)
    {
        $data = $this->user->where('is_deleted', '=', 0);
        if ($parameters != null) {
            $data = (!empty($parameters['id']) && $parameters['id'] != '') ? $data->where('id', '=', $parameters['id']) : $data;
            $data = (!empty($parameters['name']) && $parameters['name'] != '') ? $data->where('name', 'like', '%' . $parameters['name'] . '%') : $data;
            $data = (!empty($parameters['email']) && $parameters['email'] != '') ? $data->where('email', 'like', '%' . $parameters['email'] . '%') : $data;
        }
        return $paginate == true ? $data->paginate(10) : $data->get();
    }

    public function find($id)
    {
        return $this->user->where('is_deleted', '=', 0)->where('id', '=', $id)->first();
    }

    public function store($request)
    {
        $request->merge(['password' => Hash::make($request->input('password'))]);
        return $this->user->create($request->all());
    }

    public function update($request, $id)
    {
        $newPassword = $request->input('password') != '' ? Hash::make($request->input('password')) : null;
        $user = $this->user->find($id);
        $user->update($request->except('password'));
        if ($newPassword != null) {
            $user->password = $newPassword;
            $user->save();
        }
        $this->uploadFile($request, $user);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        $user->is_deleted = 1;
        $user->save();
    }

    public function uploadFile($request, $user)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::random(6) . '.' . $request->file('image')->extension();
            $path = Storage::putFileAs('user', $file, $filename);
            $user->image = url('storage') . '/' . $path;
            $user->save();
        }
    }

}
