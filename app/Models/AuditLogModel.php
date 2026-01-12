<?php

namespace App\Models;

class AuditLogModel extends Model
{
    public function create(array $data): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO audit_logs (user_id, entity_type, entity_id, before_json, after_json)
             VALUES (:user_id, :entity_type, :entity_id, :before_json, :after_json)'
        );
        $stmt->execute($data);
    }
}
