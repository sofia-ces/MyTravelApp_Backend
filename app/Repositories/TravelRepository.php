<?php 
namespace App\Repositories;

use App\Models\Travel;

class TravelRepository
{
    public function getAll()
    {
        return Travel::all();
    }

    public function findById($id)
    {
        return Travel::findOrFail($id);
    }

    public function create(array $data)
    {
        return Travel::create($data);
    }

    public function update($id, array $data)
    {
        $travel = $this->findById($id);
        $travel->update($data);

        return $travel;
    }

    public function delete($id)
    {
        $travel = $this->findById($id);
        return $travel->delete();
    }
}
?>