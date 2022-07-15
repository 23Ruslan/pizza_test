CREATE TABLE pizzaType (
  type_id INT PRIMARY KEY AUTO_INCREMENT, 
  name VARCHAR(20),
  price INT,
  recipe VARCHAR(80)
);
CREATE TABLE pizzaSize (
  size_id INT PRIMARY KEY AUTO_INCREMENT, 
  size INT,
  price INT
);
CREATE TABLE pizzaSauce (
  sauce_id INT PRIMARY KEY AUTO_INCREMENT, 
  name VARCHAR(20),
  price INT,
  recipe VARCHAR(80)
);

INSERT pizzaType 
VALUES 
  (1, 'Pepperoni', 1, Null), 
  (2, 'Country', 2, Null), 
  (3, 'Hawaiian', 3, Null), 
  (4, 'Mushroom', 4, Null);

INSERT pizzaSize 
VALUES 
  (1, 21, 1), 
  (2, 26, 2), 
  (3, 31, 3), 
  (4, 45, 4);

INSERT pizzaSauce 
VALUES 
  (1, 'cheesy', 1, Null), 
  (2, 'sweet_and_sour', 2, Null), 
  (3, 'garlic', 3, Null), 
  (4, 'barbecue', 4, Null);