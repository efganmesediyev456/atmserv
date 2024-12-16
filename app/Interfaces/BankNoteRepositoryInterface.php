<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface BankNoteRepositoryInterface
{
    public function create(array $data);

    public function getAll():Collection;

    public function delete(int $id): bool;
}
