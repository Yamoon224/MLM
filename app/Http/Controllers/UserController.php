<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct(private UserRepositoryInterface $repository) {}

    public function index()
    {
        return view('users.index', [
            'users' => $this->repository->paginate()
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->back();
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $this->repository->update($id, $request->validated());
        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->back();
    }
}