SET CHARSET UTF8;
DROP DATABASE IF EXISTS harmonie;
CREATE DATABASE harmonie DEFAULT CHARACTER SET utf8;

use harmonie;


DROP TABLE IF EXISTS users;
CREATE TABLE users(
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL,
  password VARCHAR(100) NOT NULL,
  role ENUM('member', 'admin') DEFAULT 'member',
  email VARCHAR(100),
  PRIMARY KEY(id)
);

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`) VALUES
(1,	'john',	'$2y$10$Tmw0idHeNT.DCboYxlATyOnB8q88AhNdyUf5N8oSzMOVgbQeFpOaC',	'member',	''),
(2,	'jan',	'$2y$10$Gu5pGJrnl4PQIlmXIyYDO.NRzzNay7VHXXKwYkNQQcCJI0A0Q.jG2',	'member',	''),
(3,	'dylan',	'$2y$10$Gu5pGJrnl4PQIlmXIyYDO.NRzzNay7VHXXKwYkNQQcCJI0A0Q.jG2',	'admin',	'dylan@gmail.com'),
(4,	'Sebastián Skočdopole',	'$2y$10$Gu5pGJrnl4PQIlmXIyYDO.NRzzNay7VHXXKwYkNQQcCJI0A0Q.jG2',	'member',	't.smidova@seznam.cz');



DROP TABLE IF EXISTS events;
CREATE TABLE events(
  id INT AUTO_INCREMENT,
  title VARCHAR(100) NOT NULL,
  subtitle VARCHAR(100),
  likes INT NOT NULL DEFAULT '0',
  link VARCHAR(100),
  facebook VARCHAR(100),
  datetime DATETIME NOT NULL,
  datetime_end DATETIME,
  type ENUM('rehearsal', 'concert', 'tour') DEFAULT 'rehearsal',
  location VARCHAR(100),
  info TEXT,
  PRIMARY KEY(id)
);

INSERT INTO `events` (`id`, `title`, `subtitle`, `likes`, `link`, `facebook`, `datetime`, `type`, `location`, `info`) VALUES
(1,	'Koncert v Německu',	'Koncert v Německém Bobingenu',	0,	'',	'',	'2022-08-13 20:00:00',	'concert',	NULL,	NULL),
(2,	'WASBE',	'Wasbe Conference Prague 2022',	0,	'@WASBE',	'https://fb.me/e/1HYJ3GEkO',	'2022-07-23 00:00:00',	NULL,	NULL,	NULL),
(3,	'Galakoncert',	'Tradiční výroční koncert',	0,	'@Šternberk',	NULL,	'2022-12-13 18:00:00',	NULL,	NULL,	NULL),
(4,	'Galakoncert',	'Tradiční výroční koncert',	0,	'@Šternberk',	NULL,	'2023-12-13 18:00:00',	NULL,	NULL,	NULL),
(5,	'Galakoncert',	'Tradiční výroční koncert',	0,	'@Šternberk',	NULL,	'2024-12-13 18:00:00',	NULL,	NULL,	NULL),
(6,	'Chrámový koncert',	NULL,	0,	'@Kostel Zvěstování Panny Marie',	NULL,	'2022-04-30 19:00:00',	NULL,	NULL,	NULL),
(7,	'Zkouška',	NULL,	0,	NULL,	NULL,	'2022-08-15 16:00:00',	'rehearsal',	'sál ZUŠ Šternberk',	NULL);