<?php

namespace App\Models;

class AssociationModel extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM associations ORDER BY name')->fetchAll();
    }
}
