DROP DATABASE IF EXISTS  eVoting;
CREATE DATABASE IF NOT EXISTS eVoting;

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users(
  user_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT ,
  fname VARCHAR (100) NOT NULL ,
  lname VARCHAR (100) NOT NULL ,
  username VARCHAR (100) NOT NULL,
  email VARCHAR (100) NOT NULL UNIQUE ,
  phone VARCHAR (20) NOT NULL,
  password VARCHAR (100) NOT NULL,
  date_created TIMESTAMP NOT NULL ,
  status BOOLEAN DEFAULT 0
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
  date_created TIMESTAMP NOT NULL,
  user_id INT UNSIGNED ,
  CONSTRAINT fk_election_election_id FOREIGN KEY (user_id) REFERENCES users(user_id)
);

DROP TABLE IF EXISTS joined;
CREATE TABLE IF NOT EXISTS joined(
  joined_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNSIGNED ,
  election_id INT UNSIGNED ,
  CONSTRAINT fk_joined_user_id FOREIGN KEY (user_id) REFERENCES users(user_id),
  CONSTRAINT fk_joined_election_id FOREIGN KEY (election_id) REFERENCES election(election_id)

);


DROP TABLE IF EXISTS posts;
CREATE TABLE IF NOT EXISTS posts(
  post_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  post_key VARCHAR (100) NOT NULL ,
  post VARCHAR (100) NOT NULL,
  election_id INT UNSIGNED ,
  CONSTRAINT fk_posts_election_id FOREIGN KEY (election_id) REFERENCES election(election_id)
);

DROP TABLE IF EXISTS contestants;
CREATE TABLE IF NOT EXISTS contestants(
  contestant_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  picture_name VARCHAR (50),
  nickname VARCHAR (100),
  number_of_votes INT DEFAULT 0,
  post_id INT UNSIGNED ,
  election_id INT UNSIGNED ,
  user_id INT UNSIGNED ,
  CONSTRAINT fk_contestants_election_id FOREIGN KEY (election_id) REFERENCES election(election_id),
  CONSTRAINT fk_contestants_post_id FOREIGN KEY (post_id) REFERENCES posts(post_id),
  CONSTRAINT fk_contestants_user_id FOREIGN KEY (user_id) REFERENCES users(user_id)
);

DROP TABLE IF EXISTS manifesto;
CREATE TABLE IF NOT EXISTS manifesto(
  manifesto_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT ,
  manifesto VARCHAR (200),
  contestant_id INT UNSIGNED ,
  constraint fk_manifesto_contestant_id FOREIGN KEY (contestant_id) REFERENCES contestants(contestant_id)
);

DROP TABLE IF EXISTS request;
CREATE TABLE IF NOT EXISTS request(
  request_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNSIGNED ,
  election_id INT UNSIGNED ,
  CONSTRAINT fk_request_election_id FOREIGN KEY (election_id) REFERENCES election(election_id),
  CONSTRAINT fk_request_user_id FOREIGN KEY (user_id) REFERENCES users(user_id)
);

DROP TABLE IF EXISTS news;
CREATE TABLE IF NOT EXISTS news(
  news_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  news TEXT,	
  election_id INT UNSIGNED ,
  CONSTRAINT fk_news_election_id FOREIGN KEY (election_id) REFERENCES election(election_id)
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


