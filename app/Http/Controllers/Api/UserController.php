<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function __construct(private UserRepositoryInterface $repository) {}

    public function index()
    {
        return UserResource::collection(
            $this->repository->paginate()
        );
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->repository->create($request->validated());
        return new UserResource($user);
    }

    public function show($id)
    {
        return new UserResource(
            $this->repository->find($id)
        );
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->repository->update($id, $request->validated());
        return new UserResource($user);
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return response()->noContent();
    }
}