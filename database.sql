SET search_path = "folder_path";
DROP SCHEMA IF EXISTS project CASCADE;
CREATE SCHEMA project;

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
  

  
