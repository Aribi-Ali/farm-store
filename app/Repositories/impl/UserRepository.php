<?php

namespace App\Repositories\impl;

use App\Models\User;
use App\Providers\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
  protected $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function all()
  {
    return $this->user->all();
  }

  public function find($id)
  {
    return $this->user->find($id);
  }

  public function create(array $data)
  {
    return $this->user->create($data);
  }

  public function update($id, array $data)
  {
    $record = $this->find($id);
    $record->update($data);
    return $record;
  }

  public function delete($id)
  {
    return $this->user->destroy($id);
  }
}
