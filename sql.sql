-- Создаем базу данных
CREATE DATABASE IF NOT EXISTS tasks_db CHARACTER SET utf8 COLLATE utf8_general_ci;

USE tasks_db;

-- Типы пользователей

CREATE TABLE IF NOT EXISTS user_type
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID Пользователя',
	type VARCHAR(60) NOT NULL COMMENT 'Тип пользователя',
	title VARCHAR(60) NOT NULL COMMENT 'Название для чтения',
	description TEXT NULL DEFAULT NULL COMMENT 'Описание',
	PRIMARY KEY (id), CONSTRAINT ukType UNIQUE KEY (type), CONSTRAINT ukTitle UNIQUE KEY (title)
)ENGINE = INNODB;

-- Заполняем первичные типы
INSERT INTO user_type(type,title) VALUES
	('admin','Administrator');

-- Пользователи

CREATE TABLE IF NOT EXISTS user
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID Пользователя',
	login VARCHAR(60) NOT NULL COMMENT 'Логин пользователя',
	pass CHAR(32) NOT NULL COMMENT 'Пароль',
	email VARCHAR(60) NULL COMMENT 'Email адрес',
	registered TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время регистрации',
	id_type INT(10) UNSIGNED NOT NULL COMMENT 'id типа пользователя, администратон он или модератор',
	PRIMARY KEY (id), CONSTRAINT ukLogin UNIQUE KEY (login),
    INDEX ixIdType(id_type),
    CONSTRAINT fkIdType FOREIGN KEY (id_type)
            REFERENCES user_type (id) 
)ENGINE = INNODB;

-- Заполняем первичных пользователей
INSERT INTO user(login,pass,id_type) VALUES
	("admin","202cb962ac59075b964b07152d234b70",1);


-- Задачи

CREATE TABLE IF NOT EXISTS tasks
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID задачи',
    name VARCHAR(60) NOT NULL COMMENT 'Имя пользователя',
    email VARCHAR(60) NOT NULL COMMENT 'Email адрес',
    task TEXT NOT NULL COMMENT 'Задача',
    `create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания',
    edit INT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 = не редактировано, 1 = редактировано',
    PRIMARY KEY (id)
)ENGINE = INNODB;