CREATE DATABASE doingsdone
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_of_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email CHAR(128) NOT NULL,
  name CHAR(128) NOT NULL,
  password CHAR(128) NOT NULL
);

CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  title CHAR(128) NOT NULL
);

CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  project_id INT,
  date_of_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  date_of_completion TIMESTAMP,
  state TINYINT NOT NULL,
  title CHAR(128) NOT NULL,
  file CHAR(128),
  critical_time TIMESTAMP
);

CREATE UNIQUE INDEX email ON users(email);

CREATE INDEX user_id ON projects(user_id);

CREATE INDEX user_id ON tasks(user_id);
