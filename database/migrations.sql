CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('ADMIN','OPERADOR','LECTURA') NOT NULL DEFAULT 'LECTURA',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tournaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    venue VARCHAR(120) NOT NULL,
    date_start DATE NOT NULL,
    status ENUM('borrador','en_curso','finalizado') NOT NULL DEFAULT 'borrador',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tournament_id INT NOT NULL,
    name VARCHAR(120) NOT NULL,
    group_size INT NOT NULL DEFAULT 3,
    qualify_per_group INT NOT NULL DEFAULT 2,
    best_of_sets INT NOT NULL DEFAULT 5,
    points_per_set INT NOT NULL DEFAULT 11,
    bracket_size INT NOT NULL DEFAULT 8,
    tiebreak_criteria VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_categories_tournament FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE associations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    association_id INT NULL,
    ranking_seed INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_players_association FOREIGN KEY (association_id) REFERENCES associations(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE registrations (
    category_id INT NOT NULL,
    player_id INT NOT NULL,
    ranking_seed INT NULL,
    PRIMARY KEY (category_id, player_id),
    CONSTRAINT fk_registrations_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    CONSTRAINT fk_registrations_player FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    number INT NOT NULL,
    CONSTRAINT fk_groups_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE group_players (
    group_id INT NOT NULL,
    player_id INT NOT NULL,
    position INT NOT NULL,
    PRIMARY KEY (group_id, player_id),
    CONSTRAINT fk_group_players_group FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    CONSTRAINT fk_group_players_player FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE brackets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    size INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_brackets_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE bracket_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bracket_id INT NOT NULL,
    slot_number INT NOT NULL,
    player_id INT NULL,
    source_type VARCHAR(40) NOT NULL,
    source_group_id INT NULL,
    source_rank INT NULL,
    CONSTRAINT fk_bracket_slots_bracket FOREIGN KEY (bracket_id) REFERENCES brackets(id) ON DELETE CASCADE,
    CONSTRAINT fk_bracket_slots_player FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phase ENUM('groups','bracket') NOT NULL,
    category_id INT NOT NULL,
    group_id INT NULL,
    bracket_id INT NULL,
    round_number INT NULL,
    match_number INT NULL,
    player_a_id INT NULL,
    player_b_id INT NULL,
    status VARCHAR(40) NOT NULL DEFAULT 'scheduled',
    winner_id INT NULL,
    best_of_sets INT NOT NULL DEFAULT 5,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_matches_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    CONSTRAINT fk_matches_group FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    CONSTRAINT fk_matches_bracket FOREIGN KEY (bracket_id) REFERENCES brackets(id) ON DELETE CASCADE,
    CONSTRAINT fk_matches_player_a FOREIGN KEY (player_a_id) REFERENCES players(id) ON DELETE SET NULL,
    CONSTRAINT fk_matches_player_b FOREIGN KEY (player_b_id) REFERENCES players(id) ON DELETE SET NULL,
    CONSTRAINT fk_matches_winner FOREIGN KEY (winner_id) REFERENCES players(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE match_sets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT NOT NULL,
    set_number INT NOT NULL,
    points_a INT NOT NULL,
    points_b INT NOT NULL,
    CONSTRAINT fk_match_sets_match FOREIGN KEY (match_id) REFERENCES matches(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE group_standings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    player_id INT NOT NULL,
    matches_played INT NOT NULL DEFAULT 0,
    matches_won INT NOT NULL DEFAULT 0,
    matches_lost INT NOT NULL DEFAULT 0,
    sets_won INT NOT NULL DEFAULT 0,
    sets_lost INT NOT NULL DEFAULT 0,
    points_for INT NOT NULL DEFAULT 0,
    points_against INT NOT NULL DEFAULT 0,
    rank_pos INT NOT NULL DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_group_standings_group FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    CONSTRAINT fk_group_standings_player FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    entity_type VARCHAR(60) NOT NULL,
    entity_id INT NOT NULL,
    action VARCHAR(60) NOT NULL,
    before_json JSON NULL,
    after_json JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_audit_logs_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
