-- init_db.sql
-- Run in phpMyAdmin or mysql: CREATE DATABASE mi_sitio CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- Then import or run the following in that DB.

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  content TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create a default admin (username: admin, password: admin123) - change immediately
INSERT INTO users (username,password,role) VALUES ('admin', '$2y$10$K7x1H6gGdfQhFzQYy2ZqKuG2m0fkdwz8a7yqz1QX3aQdGkz9n6V8e', 'admin');
-- The password hash above is for 'admin123' using password_hash default algo. Change it after first login.
