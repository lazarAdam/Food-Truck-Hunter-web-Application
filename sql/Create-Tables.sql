DROP DATABASE FoodTruckHunter;

CREATE DATABASE FoodTruckHunter;

USE FoodTruckHunter;

CREATE TABLE ADMINS(
    adminid INT NOT NULL AUTO_INCREMENT,
    email CHAR(254) NOT NULL,
    password CHAR(64) NOT NULL,
    last_login_date timestamp default '0000-00-00 00:00:00',
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    PRIMARY KEY(adminid));

CREATE TABLE USERS(
    userid INT NOT NULL AUTO_INCREMENT,
    email CHAR(254) NOT NULL,
    password CHAR(64) NOT NULL,
    latitude DECIMAL(9, 6),
    longitude DECIMAL(9, 6),
    num_contributions INT,
    ranking CHAR(30),
    last_login_date DATETIME default '0000-00-00 00:00:00',
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    PRIMARY KEY(userid));

CREATE TABLE REVIEW(
    reviewid INT,
    usercomment TEXT,
    creation_date timestamp default now(),
    rating TINYINT UNSIGNED NOT NULL,
    CONSTRAINT CHK_rating CHECK(rating>=1 AND rating<=5),
    PRIMARY KEY(reviewid));

CREATE TABLE FOOD_TRUCK(
    foodtruckid INT NOT NULL AUTO_INCREMENT,
    FT_main_pic_path CHAR(255),
    name CHAR(30),
    description CHAR(200),
    latitude DECIMAL(9, 6),
    longitude DECIMAL(9, 6),
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    PRIMARY KEY(foodtruckid));

CREATE TABLE MENU(
    menuid INT,
    foodtruckid iNT,
    name CHAR(30),
    file_path CHAR(255),
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    FOREIGN KEY(foodtruckid) REFERENCES FOOD_TRUCK(foodtruckid),
    PRIMARY KEY(menuid));

CREATE TABLE FOOD_TRUCK_REVIEWS(
    foodtruckid INT,
    reviewid INT,
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    FOREIGN KEY(foodtruckid) REFERENCES FOOD_TRUCK(foodtruckid),
    FOREIGN KEY(reviewid) REFERENCES REVIEW(reviewid));

CREATE TABLE USER_REVIEWS(
    userid INT,
    foodtruckid INT,
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    FOREIGN KEY(userid) REFERENCES USERS(userid),
    FOREIGN KEY(foodtruckid) REFERENCES FOOD_TRUCK(foodtruckid));

CREATE TABLE VENDORS(
    vendorid INT NOT NULL AUTO_INCREMENT,
    email CHAR(254) NOT NULL,
    first_name CHAR(30) NOT NULL,
    last_name CHAR(30) NOT NULL,
    company_name CHAR(30) NOT NULL,
    password CHAR(64) NOT NULL,
    phone_number CHAR(12) NOT NULL,
    city CHAR(50) NOT NULL,
    state CHAR(30) NOT NULL,
    status CHAR(10) NOT NULL,
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    PRIMARY KEY(vendorid));

CREATE TABLE FOOD_TRUCK_OWNERS(
    vendorid INT,
    foodtruckid INT,
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    FOREIGN KEY(vendorid) REFERENCES VENDORS(vendorid),
    FOREIGN KEY(foodtruckid) REFERENCES FOOD_TRUCK(foodtruckid));

CREATE TABLE VENDOR_REQUEST(
    vendorid INT NOT NULL AUTO_INCREMENT,
    email CHAR(254) NOT NULL,
    first_name CHAR(30) NOT NULL,
    last_name CHAR(30) NOT NULL,
    company_name CHAR(30) NOT NULL,
    password CHAR(64) NOT NULL,
    phone_number CHAR(12) NOT NULL,
    city CHAR(50) NOT NULL,
    state CHAR(30) NOT NULL,
    status CHAR(10) NOT NULL,
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    PRIMARY KEY (vendorid));

CREATE TABLE FOOD_TYPE(
    foodtypeid INT,
    food_type_name CHAR(60),
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    PRIMARY KEY(foodtypeid));

CREATE TABLE TRUCK_FOOD_TYPE(
    foodtypeid INT,
    foodtruckid INT,
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    FOREIGN KEY(foodtypeid) REFERENCES FOOD_TYPE(foodtypeid),
    FOREIGN KEY(foodtruckid) REFERENCES FOOD_TRUCK(foodtruckid));

CREATE TABLE SPECIAL_FOOD_TYPE(
    foodtypeid INT,
    food_type_name CHAR(60),
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    PRIMARY KEY(foodtypeid));

CREATE TABLE TRUCK_SPECIAL_FOOD_TYPE(
    foodtypeid INT,
    foodtruckid INT,
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    FOREIGN KEY(foodtypeid) REFERENCES SPECIAL_FOOD_TYPE(foodtypeid),
    FOREIGN KEY(foodtruckid) REFERENCES FOOD_TRUCK(foodtruckid));

CREATE TABLE PICTURE(
    pictureid INT,
    file_path CHAR(255),
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    PRIMARY KEY(pictureid));

CREATE TABLE FOOD_TRUCK_PICTURES(
    foodtruckid INT,
    pictureid INT,
    creation_date timestamp default now(),
    last_update_date timestamp default now() on update now(),
    FOREIGN KEY(pictureid) REFERENCES PICTURE(pictureid),
    FOREIGN KEY(foodtruckid) REFERENCES FOOD_TRUCK(foodtruckid));


