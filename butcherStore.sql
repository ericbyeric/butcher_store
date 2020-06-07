DROP DATABASE IF EXISTS butcherStore;
CREATE DATABASE butcherStore;
USE butcherStore;

CREATE TABLE USERS (
	userId INT NOT NULL AUTO_INCREMENT,
	userName VARCHAR(254) NOT NULL,
	userEmail VARCHAR(254) NOT NULL,
	userPassword VARCHAR(254) NOT NULL,
	userAddress VARCHAR(254) NOT NULL,
	userMobile VARCHAR(254) NOT NULL,
	PRIMARY KEY (userId)
);

CREATE TABLE ADMINISTRATORS (
	adminId INTEGER AUTO_INCREMENT,
	adminName VARCHAR(254) NOT NULL,
	adminEmail VARCHAR(254) NOT NULL,
	adminPassword VARCHAR(254) NOT NULL,
	PRIMARY KEY (adminId)
);

CREATE TABLE MANAGES (
	adminId INTEGER AUTO_INCREMENT,
	userId INT NOT NULL,
	PRIMARY KEY (adminId, userId),
	FOREIGN KEY (userId) REFERENCES USERS (userId),
	FOREIGN KEY (adminId) REFERENCES ADMINISTRATORS (adminId)
);


CREATE TABLE ORIGIN(
	country VARCHAR(254) NOT NULL,
	growingEnv VARCHAR(254) NOT NULL,
	feed VARCHAR(254) NOT NULL,
	PRIMARY KEY (country)
);

CREATE TABLE PRODUCTS(
	productId VARCHAR(254) NOT NULL,
	productName VARCHAR(254) NOT NULL,
	productEachWeight FLOAT (10,2),
	country VARCHAR(254) NOT NULL,
	picture VARCHAR(254) NOT NULL,
	stock INTEGER NOT NULL,
	PRIMARY KEY (productID),
	FOREIGN KEY (country) REFERENCES ORIGIN (country)
);

CREATE TABLE REVIEWS_FOR (
	userId INT NOT NULL,
	productId VARCHAR(254) NOT NULL,
	content VARCHAR(254) NOT NULL,
	rating INTEGER NOT NULL,
	PRIMARY KEY (userId, productId),
	FOREIGN KEY (userId) REFERENCES USERS (userId),
	FOREIGN KEY (productId) REFERENCES PRODUCTS (productId)
);


CREATE TABLE ORDERS (	
	orderId INT NOT NULL AUTO_INCREMENT,
	orderType VARCHAR(254) NOT NULL,
	orderDate VARCHAR(254) NOT NULL,
	productId VARCHAR(254) NOT NULL,
	productQuant INT NOT NULL,
	userId INT NOT NULL,
	PRIMARY KEY(orderId),
	FOREIGN KEY(userId) REFERENCES USERS(userId),
	FOREIGN KEY(productId) REFERENCES PRODUCTS (productId) ON DELETE CASCADE
);

CREATE TABLE SHIPMENT(
	orderId INTEGER NOT NULL,
	shipId INTEGER NOT NULL AUTO_INCREMENT,
	shipDate VARCHAR(254) NOT NULL,
	shipCost FLOAT(10,2) NOT NULL,
	PRIMARY KEY(shipId, orderId),
	FOREIGN KEY(orderId) REFERENCES ORDERS(orderId) ON DELETE CASCADE
);

CREATE TABLE VIEWS(
	userId INT NOT NULL,
	shipId INTEGER NOT NULL,
	PRIMARY KEY(userId, shipId),
	FOREIGN KEY (userId) REFERENCES USERS (userId),
	FOREIGN KEY (shipId) REFERENCES SHIPMENT(shipId)
);

CREATE TABLE INCLUDES(
	orderId INTEGER NOT NULL AUTO_INCREMENT,
	productId VARCHAR(254) NOT NULL,
	PRIMARY KEY (orderId, productId),
	FOREIGN KEY (orderId) REFERENCES ORDERS (orderId),
	FOREIGN KEY (productId) REFERENCES PRODUCTS(productId)
);

CREATE TABLE SHOPPING_CART(
	cartId INTEGER NOT NULL AUTO_INCREMENT,
	userId INT NOT NULL,
	pQuantity INTEGER NOT NULL,
	PRIMARY KEY(cartID,userId),
	FOREIGN KEY(userId) REFERENCES USERS(userId) ON DELETE CASCADE
);

CREATE TABLE ADDS_TO (
	userId INT NOT NULL,
	cartId INTEGER NOT NULL,
	PRIMARY KEY(userId, cartId),
	FOREIGN KEY (userId) REFERENCES USERS (userId),
	FOREIGN KEY (cartId) REFERENCES SHOPPING_CART(cartId)
);

CREATE TABLE REQUEST_FOR (
	cartId INTEGER NOT NULL AUTO_INCREMENT,
	productId VARCHAR(254) NOT NULL,
	PRIMARY KEY (cartId, productId),
	FOREIGN KEY (cartId) REFERENCES SHOPPING_CART(cartId) ON DELETE CASCADE,
	FOREIGN KEY (productId) REFERENCES PRODUCTS (productId)
);


CREATE TABLE IS_FROM (
	productId VARCHAR(254) NOT NULL,
	country VARCHAR(254) NOT NULL,
	PRIMARY KEY(productId, country),
	FOREIGN KEY (productId) REFERENCES PRODUCTS (productId),
	FOREIGN KEY (country) REFERENCES ORIGIN (country)
);


CREATE TABLE TYPE(
	productId VARCHAR(254) NOT NULL,
	type VARCHAR(50) NOT NULL,
	cut VARCHAR(254) NOT NULL,
	aging VARCHAR(50) NOT NULL,
	price FLOAT(10,2),
	grade VARCHAR(254) NOT NULL,
	PRIMARY KEY (productId, type, cut, aging),
	FOREIGN KEY (productId) REFERENCES PRODUCTS(productId)
);

INSERT INTO ORIGIN VALUES('United States', 'cattle', 'grain');
INSERT INTO ORIGIN VALUES('Australia', 'grazed', 'grass');
INSERT INTO ORIGIN VALUES('South Korea', 'cattle', 'forage');
INSERT INTO ORIGIN VALUES('Germany', 'cattle', 'grain');
INSERT INTO ORIGIN VALUES('Chile', 'grazed', 'grass');
INSERT INTO ORIGIN VALUES('Spain', 'cattle', 'acorn');
INSERT INTO ORIGIN VALUES('New Zealand', 'grazed', 'grass');
INSERT INTO ORIGIN VALUES('Ireland', 'grazed', 'grass');

INSERT INTO PRODUCTS VALUES('b1', 'Beef Fillet', 0.50, 'United States' , 'Bfillet.jpg', 250);
INSERT INTO PRODUCTS VALUES('b2', 'Beef Brisket', 1.00, 'United States', 'Bbrisket.jpg', 150);
INSERT INTO PRODUCTS VALUES('b3', 'Beef Skirt', 0.75, 'Australia', 'Bskirt.jpg', 300);
INSERT INTO PRODUCTS VALUES('b4', 'Beef Flank', 0.75, 'South Korea', 'Bflank.jpg', 200);
INSERT INTO PRODUCTS VALUES('b5', 'Beef Sirloin', 0.50, 'South Korea', 'Bsirloin.jpg', 500);
INSERT INTO PRODUCTS VALUES('b6', 'Beef Short Ribs', 0.75, 'Australia' , 'Bshortribs.jpg', 125);
INSERT INTO PRODUCTS VALUES('b7', 'Beef Flat Iron', 0.60, 'United States', 'Bflatiron.jpg', 180);
INSERT INTO PRODUCTS VALUES('b8', 'Beef striploin', 0.55, 'Australia', 'Bstriploin.jpg', 105);
INSERT INTO PRODUCTS VALUES('b9', 'Beef Tenderloin', 0.45, 'Australia', 'Btenderloin.jpg', 350);
INSERT INTO PRODUCTS VALUES('b10', 'Beef Roast', 1.00, 'South Korea', 'Broast.jpg', 115);
INSERT INTO PRODUCTS VALUES('p1', 'Pork Belly', 0.85, 'Germany', 'Pbelly.jpg', 500);
INSERT INTO PRODUCTS VALUES('p2', 'Pork Tenderloin', 0.50, 'Chile', 'Ptenderloin.jpg', 100);
INSERT INTO PRODUCTS VALUES('p3', 'Pork Ribs', 0.50, 'Spain', 'Pribs.jpg', 50);
INSERT INTO PRODUCTS VALUES('p4', 'Pork Rack', 1.00, 'South Korea', 'Prack.jpg', 75);
INSERT INTO PRODUCTS VALUES('p5', 'Pork Tomahawk', 0.85, 'Germany', 'Ptomahawk.jpg', 420);
INSERT INTO PRODUCTS VALUES('p6', 'Pork Chops', 0.95, 'Chile', 'Pchops.jpg', 160);
INSERT INTO PRODUCTS VALUES('p7', 'Pork Loin', 0.70, 'Spain', 'Ploin.jpg', 100);
INSERT INTO PRODUCTS VALUES('p8', 'Pork Porchetta', 0.70, 'Germany', 'Pporchetta.jpg', 110);
INSERT INTO PRODUCTS VALUES('p9', 'Pork Ham', 1.00, 'South Korea', 'Pham.jpg', 75);
INSERT INTO PRODUCTS VALUES('p10', 'Pork Butt', 0.85, 'Germany', 'Pass.jpg', 220);
INSERT INTO PRODUCTS VALUES('l1', 'Lamb Shank', 0.45, 'New Zealand', 'Lshank.jpg', 225);
INSERT INTO PRODUCTS VALUES('l2', 'Lamb Rack', 0.80, 'New Zealand', 'Lrack.jpg', 175);
INSERT INTO PRODUCTS VALUES('l3', 'Lamb Leg', 0.50, 'Ireland', 'Lleg.jpg', 125);
INSERT INTO PRODUCTS VALUES('l4', 'Lamb Shoulder', 1.00, 'Australia', 'Lshoulder.jpg', 250);
INSERT INTO PRODUCTS VALUES('l5', 'Lamb Saddle', 0.50, 'Ireland', 'Lsaddle.jpg', 550);
INSERT INTO PRODUCTS VALUES('l6', 'Lamb Loin Chops', 0.45, 'Ireland', 'Lloinchops.jpg', 225);
INSERT INTO PRODUCTS VALUES('l7', 'Veal Chops', 0.60, 'New Zealand', 'LVchops.jpg', 105);
INSERT INTO PRODUCTS VALUES('l8', 'Lamb Fillet', 0.50, 'Ireland', 'Lfillet.jpg', 95);
INSERT INTO PRODUCTS VALUES('l9', 'Lamb Breast', 0.30, 'Australia', 'Lbreast.jpg', 90);
INSERT INTO PRODUCTS VALUES('l10', 'Lamb TBone', 0.80, 'Ireland', 'Ltbone.jpg', 130);

INSERT INTO TYPE VALUES('b1', 'beef', 'fillet', 'none', 15.75, 'Prime');
INSERT INTO TYPE VALUES('b2', 'beef', 'brisket', 'dry', 35.00, 'Choice');
INSERT INTO TYPE VALUES('b3', 'beef', 'skirt', 'dry', 25.50, 'Choice');
INSERT INTO TYPE VALUES('b4', 'beef', 'flank', 'wet', 23.75, 'Prime');
INSERT INTO TYPE VALUES('b5', 'beef', 'sirloin', 'none', 12.75, 'Select');
INSERT INTO TYPE VALUES('b6', 'beef', 'shortribs', 'none', 10.25, 'Select');
INSERT INTO TYPE VALUES('b7', 'beef', 'flatiron', 'wet', 20.00, 'Choice');
INSERT INTO TYPE VALUES('b8', 'beef', 'striploin', 'wet', 21.50, 'Choice');
INSERT INTO TYPE VALUES('b9', 'beef', 'tenderloin', 'dry', 25.75, 'Select');
INSERT INTO TYPE VALUES('b10', 'beef', 'roast', 'none', 32.75, 'Prime');
INSERT INTO TYPE VALUES('p1', 'pork', 'belly', 'wet', 35.75, '1');
INSERT INTO TYPE VALUES('p2', 'pork', 'tenderloin', 'wet', 20.95, '3');
INSERT INTO TYPE VALUES('p3', 'pork', 'ribs', 'dry', 40.00, '2');
INSERT INTO TYPE VALUES('p4', 'pork', 'rack', 'dry', 99.95, '1');
INSERT INTO TYPE VALUES('p5', 'pork', 'tomahawk', 'dry', 27.50, '3');
INSERT INTO TYPE VALUES('p6', 'pork', 'chops', 'dry', 45.75, '1');
INSERT INTO TYPE VALUES('p7', 'pork', 'loin', 'wet', 10.95, '3');
INSERT INTO TYPE VALUES('p8', 'pork', 'porchetta', 'wet', 40.00, '2');
INSERT INTO TYPE VALUES('p9', 'pork', 'ham', 'dry', 99.90, '1');
INSERT INTO TYPE VALUES('p10', 'pork', 'butt', 'wet', 17.50, '3');
INSERT INTO TYPE VALUES('l1', 'lamb', 'shank', 'dry', 25.95, 'Prime');
INSERT INTO TYPE VALUES('l2', 'lamb', 'rack', 'wet', 59.75, 'Choice');
INSERT INTO TYPE VALUES('l3', 'lamb', 'leg', 'none', 29.75, 'Select');
INSERT INTO TYPE VALUES('l4', 'lamb', 'shoulder', 'wet', 37.75, 'Prime');
INSERT INTO TYPE VALUES('l5', 'lamb', 'saddle', 'dry', 40.75, 'Prime');
INSERT INTO TYPE VALUES('l6', 'lamb', 'loinchops', 'dry', 75.95, 'Prime');
INSERT INTO TYPE VALUES('l7', 'lamb', 'vealchops', 'none', 49.75, 'Choice');
INSERT INTO TYPE VALUES('l8', 'lamb', 'fillet', 'wet', 21.75, 'Select');
INSERT INTO TYPE VALUES('l9', 'lamb', 'breast', 'wet', 27.75, 'Prime');
INSERT INTO TYPE VALUES('l10', 'lamb', 'tbone', 'dry', 50.75, 'Prime');

INSERT INTO IS_FROM VALUES('b1', 'United States');
INSERT INTO IS_FROM VALUES('b2', 'United States');
INSERT INTO IS_FROM VALUES('b3', 'Australia');
INSERT INTO IS_FROM VALUES('b4', 'South Korea');
INSERT INTO IS_FROM VALUES('b5', 'South Korea');
INSERT INTO IS_FROM VALUES('b6', 'Australia');
INSERT INTO IS_FROM VALUES('b7', 'United States');
INSERT INTO IS_FROM VALUES('b8', 'Australia');
INSERT INTO IS_FROM VALUES('b9', 'Australia');
INSERT INTO IS_FROM VALUES('b10', 'South Korea');
INSERT INTO IS_FROM VALUES('p1', 'Germany');
INSERT INTO IS_FROM VALUES('p2', 'Chile');
INSERT INTO IS_FROM VALUES('p3', 'Spain');
INSERT INTO IS_FROM VALUES('p4', 'South Korea');
INSERT INTO IS_FROM VALUES('p5', 'Germany');
INSERT INTO IS_FROM VALUES('p6', 'Chile');
INSERT INTO IS_FROM VALUES('p7', 'Spain');
INSERT INTO IS_FROM VALUES('p8', 'Germany');
INSERT INTO IS_FROM VALUES('p9', 'South Korea');
INSERT INTO IS_FROM VALUES('p10', 'Germany');
INSERT INTO IS_FROM VALUES('l1', 'New Zealand');
INSERT INTO IS_FROM VALUES('l2', 'New Zealand');
INSERT INTO IS_FROM VALUES('l3', 'Ireland');
INSERT INTO IS_FROM VALUES('l4', 'Australia');
INSERT INTO IS_FROM VALUES('l5', 'Ireland');
INSERT INTO IS_FROM VALUES('l6', 'Ireland');
INSERT INTO IS_FROM VALUES('l7', 'New Zealand');
INSERT INTO IS_FROM VALUES('l8', 'Ireland');
INSERT INTO IS_FROM VALUES('l9', 'Australia');
INSERT INTO IS_FROM VALUES('l10', 'Ireland');
