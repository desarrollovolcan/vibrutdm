INSERT INTO users (name, email, password_hash, role, is_active, created_at)
VALUES ('Administrador', 'admin@example.com', '$2y$12$Za/T8cJM9BKKhEDGq5DI5e7nOb1HwNC6XPJkl2tRG/Yko2IZMwVqm', 'ADMIN', 1, NOW());

INSERT INTO tournaments (name, venue, date_start, status, created_at)
VALUES ('Open Tenis de Mesa', 'Centro Deportivo', CURDATE(), 'borrador', NOW());

INSERT INTO categories (tournament_id, name, group_size, qualify_per_group, best_of_sets, points_per_set, bracket_size, tiebreak_criteria, created_at)
VALUES (1, 'Senior Masculino', 3, 2, 5, 11, 8, 'matches_won,sets_ratio,points_ratio,head_to_head', NOW());

INSERT INTO associations (name, created_at)
VALUES ('Club Centro', NOW()), ('Club Norte', NOW());

INSERT INTO players (name, association_id, ranking_seed, created_at)
VALUES
('Juan Pérez', 1, 1, NOW()),
('Luis Gómez', 1, 2, NOW()),
('Carlos Díaz', 2, 3, NOW()),
('Pedro Ruiz', 2, 4, NOW());

INSERT INTO registrations (category_id, player_id, ranking_seed)
VALUES (1, 1, 1), (1, 2, 2), (1, 3, 3), (1, 4, 4);
