CREATE DATABASE IF NOT EXISTS Evoting;

USE Evoting;

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users(
  user_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT ,
  fname VARCHAR (100) NOT NULL ,
  lname VARCHAR (100) NOT NULL ,
  username VARCHAR (100) NOT NULL,
  email VARCHAR (100) NOT NULL UNIQUE,
  phone VARCHAR (20) NOT NULL,
  password VARCHAR (100) NOT NULL,
  gender VARCHAR (10) NOT NULL,
  date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  status BOOLEAN DEFAULT 0,
  picture_name VARCHAR (100)
);

DROP TABLE IF EXISTS election;
CREATE TABLE IF NOT EXISTS election(
  election_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT ,
  election_name VARCHAR (200) NOT NULL ,
  election_start_date DATE NOT NULL ,
  election_end_date DATE NOT NULL,
  election_time_from TIME NOT NULL,
  election_time_to TIME NOT NULL,
  election_pin VARCHAR (20) NOT NULL ,
  date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  user_id INT UNSIGNED ,
  privacy INT UNSIGNED NOT NULL ,
  result_display VARCHAR (20) NOT NULL DEFAULT "after",
  result_mail_sent BOOLEAN NOT NULL DEFAULT FALSE ,
  CONSTRAINT fk_election_user_id FOREIGN KEY (user_id) REFERENCES users(user_id)
);

DROP TABLE IF EXISTS joined;
CREATE TABLE IF NOT EXISTS joined(
  joined_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNSIGNED ,
  election_id INT UNSIGNED ,
  has_voted BOOLEAN DEFAULT 0,
  joined_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_joined_user_id FOREIGN KEY (user_id) REFERENCES users(user_id),
  CONSTRAINT fk_joined_election_id FOREIGN KEY (election_id) REFERENCES election(election_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS posts;
CREATE TABLE IF NOT EXISTS posts(
  post_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  post_key VARCHAR (100) NOT NULL ,
  post VARCHAR (100) NOT NULL,
  election_id INT UNSIGNED ,
  CONSTRAINT fk_posts_election_id FOREIGN KEY (election_id) REFERENCES election(election_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS contestants;
CREATE TABLE IF NOT EXISTS contestants(
  contestant_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  picture_name VARCHAR (100),
  nickname VARCHAR (100),
  number_of_votes INT DEFAULT 0,
  citation_name VARCHAR(100),
  post_id INT UNSIGNED ,
  election_id INT UNSIGNED ,
  user_id INT UNSIGNED ,
  CONSTRAINT fk_contestants_election_id FOREIGN KEY (election_id) REFERENCES election(election_id)ON DELETE CASCADE  ,
  CONSTRAINT fk_contestants_post_id FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE ,
  CONSTRAINT fk_contestants_user_id FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS manifesto;
CREATE TABLE IF NOT EXISTS manifesto(
  manifesto_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT ,
  manifesto VARCHAR (200),
  contestant_id INT UNSIGNED ,
  constraint fk_manifesto_contestant_id FOREIGN KEY (contestant_id) REFERENCES contestants(contestant_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS request;
CREATE TABLE IF NOT EXISTS request(
  request_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNSIGNED ,
  election_id INT UNSIGNED ,
  request_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_request_election_id FOREIGN KEY (election_id) REFERENCES election(election_id) ON DELETE CASCADE ,
  CONSTRAINT fk_request_user_id FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS invites;
CREATE TABLE IF NOT EXISTS invites(
  invite_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNSIGNED ,
  election_id INT UNSIGNED ,
  invite_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_invites_election_id FOREIGN KEY (election_id) REFERENCES election(election_id) ON DELETE CASCADE ,
  CONSTRAINT fk_invites_user_id FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS news;
CREATE TABLE IF NOT EXISTS news(
  news_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  news TEXT,
  election_id INT UNSIGNED ,
  date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  CONSTRAINT fk_news_election_id FOREIGN KEY (election_id) REFERENCES election(election_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS comments;
CREATE TABLE IF NOT EXISTS comments(
  comments_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  comments TEXT,
  news_id INT UNSIGNED,	
  joined_id INT UNSIGNED ,
  election_id INT UNSIGNED ,
  CONSTRAINT fk_comments_election_id FOREIGN KEY (election_id) REFERENCES election(election_id),
  CONSTRAINT fk_comments_joined_id FOREIGN KEY (joined_id) REFERENCES joined(joined_id), 
  CONSTRAINT fk_comments_news_id FOREIGN KEY (news_id) REFERENCES news(news_id)
);

DROP TABLE IF EXISTS ignored;
CREATE TABLE IF NOT EXISTS ignored (
  ignored_id INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  email VARCHAR(100) NOT NULL ,
  election_id INT UNSIGNED NOT NULL ,
  ignored_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (ignored_id) ,
  CONSTRAINT fk_ignored_election_id FOREIGN KEY (election_id) REFERENCES election(election_id) ON DELETE CASCADE
);