CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tournaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    location VARCHAR(150) DEFAULT NULL,
    start_date DATE DEFAULT NULL,
    end_date DATE DEFAULT NULL,
    status VARCHAR(20) DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tournament_id INT NOT NULL,
    name VARCHAR(120) NOT NULL,
    players_per_group INT NOT NULL,
    qualify_per_group INT NOT NULL,
    best_of_sets INT NOT NULL,
    bracket_size INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id)
);

CREATE TABLE associations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL
);

CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(120) NOT NULL,
    last_name VARCHAR(120) NOT NULL,
    association_id INT DEFAULT NULL,
    ranking_points INT DEFAULT 0,
    FOREIGN KEY (association_id) REFERENCES associations(id)
);

CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    player_id INT NOT NULL,
    ranking_seed INT DEFAULT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (player_id) REFERENCES players(id)
);

CREATE TABLE groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    group_number INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE group_players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    player_id INT NOT NULL,
    position INT NOT NULL,
    UNIQUE KEY group_player_unique (group_id, player_id),
    FOREIGN KEY (group_id) REFERENCES groups(id),
    FOREIGN KEY (player_id) REFERENCES players(id)
);

CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT DEFAULT NULL,
    phase ENUM('group', 'bracket') NOT NULL,
    group_id INT DEFAULT NULL,
    bracket_id INT DEFAULT NULL,
    round_number INT DEFAULT NULL,
    match_index INT DEFAULT NULL,
    player_a_id INT DEFAULT NULL,
    player_b_id INT DEFAULT NULL,
    best_of_sets INT NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    winner_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE match_sets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT NOT NULL,
    set_number INT NOT NULL,
    points_a INT NOT NULL,
    points_b INT NOT NULL,
    UNIQUE KEY match_set_unique (match_id, set_number),
    FOREIGN KEY (match_id) REFERENCES matches(id)
);

CREATE TABLE group_standings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    player_id INT NOT NULL,
    matches_won INT NOT NULL,
    matches_lost INT NOT NULL,
    sets_won INT NOT NULL,
    sets_lost INT NOT NULL,
    points_for INT NOT NULL,
    points_against INT NOT NULL,
    rank_pos INT NOT NULL,
    UNIQUE KEY group_player_unique (group_id, player_id),
    FOREIGN KEY (group_id) REFERENCES groups(id),
    FOREIGN KEY (player_id) REFERENCES players(id)
);

CREATE TABLE brackets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    size INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE bracket_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bracket_id INT NOT NULL,
    slot_no INT NOT NULL,
    seed INT NOT NULL,
    player_id INT DEFAULT NULL,
    FOREIGN KEY (bracket_id) REFERENCES brackets(id),
    FOREIGN KEY (player_id) REFERENCES players(id)
);

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    entity_type VARCHAR(50) NOT NULL,
    entity_id INT NOT NULL,
    before_json JSON NOT NULL,
    after_json JSON NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
