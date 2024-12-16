<?php

namespace App\Repositories;

use App\Interfaces\BankNoteRepositoryInterface;
use App\Models\BankNote;
use Illuminate\Database\Eloquent\Collection;

class BankNoteRepository implements BankNoteRepositoryInterface
{

    public function getAll():Collection{
        return BankNote::get();
    }
    public function create(array $data)
    {
        $bankNote = BankNote::where('price', $data['price'])->first();

        if ($bankNote) {
            $bankNote->count += $data['count'];
            $bankNote->save();
            return $bankNote;
        } else {
            return BankNote::create($data);
        }
    }

    public  function delete(int $id):bool{
        $banknote = BankNote::find($id);
        if (!$banknote) {
            return false;
        }
        return $banknote->delete();
    }
}
