<?php

declare(strict_types=1);

namespace App\Models;

class AuditLog extends BaseModel
{
    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO audit_logs (user_id, entity_type, entity_id, action, before_json, after_json, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            $data['user_id'],
            $data['entity_type'],
            $data['entity_id'],
            $data['action'],
            $data['before_json'],
            $data['after_json'],
        ]);
    }
}
