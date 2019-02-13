CREATE DATABASE doingsdone
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_of_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email CHAR(128) NOT NULL UNIQUE,
  name CHAR(128) NOT NULL UNIQUE,
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
  date_of_completion TIMESTAMP NOT NULL,
  state TINYINT NOT NULL,
  title CHAR(128) NOT NULL,
  critical_time TIMESTAMP NOT NULL
);
