USE FoodTruckHunter;

/* admin@a.com with password a */
INSERT INTO ADMINS (email, password)
VALUES ('admin@a.com', '0cc175b9c0f1b6a831c399e269772661');
/* user@a.com with password a */
INSERT INTO USERS (email, password, latitude, longitude, num_contributions, ranking, last_login_date)
VALUES ('user@a.com', '0cc175b9c0f1b6a831c399e269772661', NULL, NULL, NULL, NULL, NULL);
/* vendor@b.com with password a */
INSERT INTO VENDORS (email, password, first_name, last_name, company_name, phone_number, city, state, status)
VALUES ('vendor@a.com', '0cc175b9c0f1b6a831c399e269772661', 'Harry', 'Potter', 'Harry''s Goods', '555-555-5555', 'Minneapolis', 'MN', 'approved');

INSERT INTO FOOD_TRUCK (name, description, latitude, longitude, FT_main_pic_path)
VALUES ('Harry''s Drinks', 'Harry Potter''s Butter Beers', '44.98', '-93.27', NULL);
INSERT INTO FOOD_TRUCK (name, description, latitude, longitude, FT_main_pic_path)
VALUES ('Ron''s Nuggets', 'Best chicken nuggets in the world', '44.955', '-93.086', NULL);
INSERT INTO FOOD_TRUCK (name, description, latitude, longitude, FT_main_pic_path)
VALUES ('Larry''s Aligators', 'Aligators on a stick', '45.013214', '-93.169952', NULL);


INSERT INTO VENDOR_REQUEST (email, password, first_name, last_name, company_name, phone_number, city, state, status)
VALUES ('vendor@a.com', '0cc175b9c0f1b6a831c399e269772661', 'Harry', 'Potter', 'Harry\'s Goods', '555-555-5555', 'Minneapolis', 'MN', 'pending');

INSERT INTO VENDOR_REQUEST (email, password, first_name, last_name, company_name, phone_number, city, state, status)
VALUES ('vendor@a.com', '0cc175b9c0f1b6a831c399e269772661', 'Harry', 'Potter', 'Harry\'s Goods', '555-555-5555', 'Minneapolis', 'MN', 'pending');
INSERT INTO VENDOR_REQUEST (email, password, first_name, last_name, company_name, phone_number, city, state, status)
VALUES ('vendor@a.com', '0cc175b9c0f1b6a831c399e269772661', 'Harry', 'Potter', 'Harry\'s Goods', '555-555-5555', 'Minneapolis', 'MN', 'pending');
