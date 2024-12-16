<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface TransactionInterface
{
    public function getAll():Collection;

    public function delete(int $id): bool;

}
