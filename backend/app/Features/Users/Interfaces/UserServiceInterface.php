<?php

namespace App\Features\Users\Interfaces;

use App\Features\Users\DTO\UserCreateDTO;
use App\Features\Users\DTO\UserRoleDTO;
use App\Features\Users\DTO\UserUpdateDTO;
use App\Features\Users\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(UserCreateDTO $data, UserRoleDTO $role): User;
    public function update(UserUpdateDTO $data, User $user): User;
    public function getById(int $id): User;
    public function delete(User $user): User;
    public function toggleBlock(User $user): User;
    /**
     * @param User $user
     * @param UserRoleDTO[] $roles
     */
    public function syncRoles(User $user, array $roles = []): void;
    public function exportUsers(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
