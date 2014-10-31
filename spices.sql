DROP SCHEMA IF EXISTS spices CASCADE;
CREATE SCHEMA spices;

SET search_path = spices;

CREATE TABLE Spices(
  name varchar(50),
  descr text,
  price decimal(13,2),
  size varchar(10),
  id serial PRIMARY KEY,
  food varchar(255),
  catagory varchar(50));
  
CREATE TABLE Users(
  email varchar(50),
  name varchar(50),
  user_Id serial PRIMARY KEY);
  

  
