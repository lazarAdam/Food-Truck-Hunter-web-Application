/*
Fill TRUCK_FOOD_TYPE w/ values
Korean
Japanese
Chinese
Mexican
Indian
Asian
Western
Fill TRUCK_SPECIAL_FOOD_TYPE with values
Vegan
Vegetarian
Keto
Dairy-free
Nut-free
Paleo

*/
insert into SPECIAL_FOOD_TYPE(foodtypeid,food_type_name)
values (1,'Vegetarian');


insert into SPECIAL_FOOD_TYPE(foodtypeid,food_type_name)
values (2,'Vegan');

insert into SPECIAL_FOOD_TYPE(foodtypeid,food_type_name)
values (3,'Paleo');

insert into SPECIAL_FOOD_TYPE(foodtypeid,food_type_name)
values (4,'Keto');

insert into SPECIAL_FOOD_TYPE(foodtypeid,food_type_name)
values (5,'Dairy-free');

insert into SPECIAL_FOOD_TYPE(foodtypeid,food_type_name)
values (6,'Nut-Free');

/*Making food trucks*/
/* vendor@b.com with password a */
INSERT INTO FOOD_TRUCK (name, description, latitude, longitude, FT_main_pic_path)
VALUES ('The Moral Omnivore', 'Solving the dilemma with organic and sustainable eats, this earnest truck''s gourmet goodies include curried mushroom fries, beet sliders, and fried tomato BLTs.', '44.980', '-93.255', NULL);
INSERT INTO FOOD_TRUCK (name, description, latitude, longitude, FT_main_pic_path)
VALUES ('Samurai Teppanyaki', 'This samurai pops up all over the Twin Cities to dish out fresh and hot Japanese cuisine.', '44.883', '-93.324', NULL);
INSERT INTO FOOD_TRUCK (name, description, latitude, longitude, FT_main_pic_path)
VALUES ('The Wandering Mug', 'This full-service traveling coffee shop offers Peace coffee, Tea Source tea, espresso, hot chocolate, and craft sodas. And don''t worry, it''s open bright and early.', '44.978000', '-93.272000', NULL);


/*
Fill TRUCK_FOOD_TYPE w/ values
Korean
Japanese
Chinese
Mexican
Indian
Asian
Western
Fill TRUCK_SPECIAL_FOOD_TYPE with values
Vegan
Vegetarian
Keto
Dairy-free
Nut-free
Paleo

*/


/*For Intermediate table*/
/*Samurai Teppanyaki id = 5 food truck has vegan and vegatarian options -- so fill in relation in intermediate table*/
insert into FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE(foodtypeid,foodtruckid)
values (1,5);

insert into FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE(foodtypeid,foodtruckid)
values (2,5);

/*Moral Omnivore id=4, has vegan, vegetarian, paleo, and keto options*/
insert into FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE(foodtypeid,foodtruckid)
values (1,4);

insert into FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE(foodtypeid,foodtruckid)
values (2,4);

insert into FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE(foodtypeid,foodtruckid)
values (3,4);

insert into FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE(foodtypeid,foodtruckid)
values (4,4);

/*Wandering mug id = 6 has a vegan option*/
insert into FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE(foodtypeid,foodtruckid)
values (2,6);


USE FoodTruckHunter;

INSERT INTO FOOD_TRUCK (foodtruckid,name, description, latitude, longitude, FT_main_pic_path)
VALUES (1,'Harry''s Drinks', 'Harry Potter''s Butter Beers', '44.98', '-93.27', NULL);
INSERT INTO FOOD_TRUCK (foodtruckid,name, description, latitude, longitude, FT_main_pic_path)
VALUES (2,'Ron''s Nuggets', 'Best chicken nuggets in the world', '44.955', '-93.086', NULL);
INSERT INTO FOOD_TRUCK (foodtruckid,name, description, latitude, longitude, FT_main_pic_path)
VALUES (3,'Larry''s Aligators', 'Aligators on a stick', '45.013214', '-93.169952', NULL);

/*Harry's drinks id=1 has diary free(5) and nut-free(6) options*/
insert into FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE(foodtypeid,foodtruckid)
values (5,1);
insert into FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE(foodtypeid,foodtruckid)
values (6,1);

/*Ron's nuggets id=2 has dairy-free id=5 options*/
insert into FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE(foodtypeid,foodtruckid)
values (5,2);
/*Larrys Aligators id=3, has dairy-free options id=5*/
insert into FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE(foodtypeid,foodtruckid)
values (5,3);




