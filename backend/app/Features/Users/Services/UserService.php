<?php

namespace App\Features\Users\Services;

use App\Features\Authentication\Services\AuthCache;
use App\Features\Users\DTO\UserCreateDTO;
use App\Features\Users\DTO\UserRoleDTO;
use App\Features\Users\DTO\UserUpdateDTO;
use App\Features\Users\Exports\UserExport;
use App\Features\Users\Interfaces\UserRepositoryInterface;
use App\Features\Users\Interfaces\UserServiceInterface;
use App\Features\Users\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserService implements UserServiceInterface
{

	public function __construct(private UserRepositoryInterface $userRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->userRepository->paginate($total);
	}

	public function getById(Int $id): User
	{
		return $this->userRepository->getById($id);
	}

	public function getByEmail(String $email): User
	{
		return $this->userRepository->getByColumnOrFail('email', $email);
	}

	public function getByPhone(String $phone): User
	{
		return $this->userRepository->getByColumnOrFail('phone', $phone);
	}

	public function create(UserCreateDTO $data, UserRoleDTO $role): User
	{
		$user = DB::transaction(function () use ($data, $role) {
			$user = $this->userRepository->create($data->toArray());
			$this->syncRoles($user, [$role]);
			return $user;
		});
		return $user;
	}

	public function update(UserUpdateDTO $data, User $user): User
	{
		DB::transaction(function () use ($data, $user) {
			// $this->userService->syncRoles($updated_user, [UserRoleDTO::fromRequest($request)]);
			$user = $this->userRepository->update($user, $data->toArray());
			return $user;
		});
		return $user;
	}

	public function toggleBlock(User $user): User
	{
		$user = $this->userRepository->update($user, ['is_blocked' => !$user->is_blocked]);
		return $user;
	}

	/**
	 * @param User $user
	 * @param UserRoleDTO[] $roles
	 */
	public function syncRoles(User $user, array $roles = []): void
	{
		$roleNames = array_map(
			static fn(UserRoleDTO $dto) => $dto->role,
			$roles
		);
		$user->syncRoles($roleNames);
		AuthCache::forget($user->id);
		app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
	}

	public function delete(User $user): User
	{
		$user = DB::transaction(function () use ($user) {
			return $this->userRepository->delete($user);
			// $this->userService->syncRoles($user, []);
		});
		return $user;
	}

	public function exportUsers(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new UserExport($this->userRepository->query()), 'users.xlsx');
	}
}
