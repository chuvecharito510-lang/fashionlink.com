USE fashionlink_db;
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE reservations;
TRUNCATE TABLE products;
SET FOREIGN_KEY_CHECKS = 1;

-- Camisas
insert into products (name, description, price, category, image_url, stock)
values ('Camisa Rosa corta', 'Camisa rosa para hombre', 30, 'Camisas', 'imagesz/camisas/camisas1.jpg', 1),
       ('Camisa Rosa a rayas', 'Camisa rosa a rayas para hombre', 25, 'Camisas', 'imagesz/camisas/camisas2.jpg', 1),
       ('Camisa Rosa Larga', 'Camisa rosa larga para hombre', 35, 'Camisas', 'imagesz/camisas/camisas3.jpg', 1),
       ('Camisa Azul corta', 'Camisa azul para hombre', 30, 'Camisas', 'imagesz/camisas/camisas4.jpg', 1);

-- Pantalones
insert into products (name, description, price, category, image_url, stock)
values ('Short Gris', 'Short gris para hombre', 20, 'Pantalones', 'imagesz/pants/pants1.jpg', 1),
       ('Buzo a Rayas', 'Buzo a rayas para mujer', 40, 'Pantalones', 'imagesz/pants/pants2.jpg', 1),
       ('Jean Negro', 'Jean negro para hombre', 50, 'Pantalones', 'imagesz/pants/pants3.jpg', 1),
       ('Jean Mostaza', 'Jean Mostaza para hombre', 45, 'Pantalones', 'imagesz/pants/pants4.jpg', 1),
       ('Jeans Cowgirls', 'Jeans cowsgirls para mujeres', 60, 'Pantalones', 'imagesz/pants/pants5.jpg', 1),
       ('Jean Azul 1', 'Jean Azul para mujer', 80, 'Pantalones', 'imagesz/pants/pants6.jpg', 1),
       ('Jeans Azul y Negro', 'Jeans Azul y Negro para mujeres', 65, 'Pantalones', 'imagesz/pants/pants7.jpg', 1),
       ('Jean Celeste 1', 'Jean celeste para mujer', 60, 'Pantalones', 'imagesz/pants/pants8.jpg', 1),
       ('Jean Plomo', 'Jean plomo para mujer', 85, 'Pantalones', 'imagesz/pants/pants9.jpg', 1),
       ('Jean Celeste 2', 'Jean celeste para mujer', 60, 'Pantalones', 'imagesz/pants/pants10.jpg', 1),
       ('Jean Azul 2', 'Jean Azul para mujer', 80, 'Pantalones', 'imagesz/pants/pants11.jpg', 1);

-- Poleras
insert into products (name, description, price, category, image_url, stock)
values ('Polera Verde', 'Polera verde para mujer', 20, 'Poleras', 'imagesz/poleras/poleras1.jpg', 1),
       ('Polera Infantil', 'Polera infantil roja con diseño de dinosaurio', 40, 'Poleras', 'imagesz/poleras/poleras2.jpg', 1),
       ('Remera Roja', 'Remera de un solo hombro roja', 50, 'Poleras', 'imagesz/poleras/poleras3.jpg', 1),
       ('Polera Negra', 'Polera negra para hombre', 45, 'Poleras', 'imagesz/poleras/poleras4.jpg', 1),
       ('Polera Naranja', 'Polera naranja para hombre', 60, 'Poleras', 'imagesz/poleras/poleras5.jpg', 1),
       ('Polera Roja', 'Polera roja para hombre', 80, 'Poleras', 'imagesz/poleras/poleras6.jpg', 1),
       ('Polera con cuello', 'Polera rosa con cuello para niño', 65, 'Poleras', 'imagesz/poleras/poleras7.jpg', 1);

-- Ropa Interior
insert into products (name, description, price, category, image_url, stock)
values ('Boxers y Calcetines Variados 1', 'Packs de boxers y calcetines variados para niños', 10, 'Ropa Interior', 'imagesz/interior/interior1.jpg', 1),
       ('Brasieres 1', 'Pack de brasiers variados para mujer', 25, 'Ropa Interior', 'imagesz/interior/interior2.jpg', 1),
       ('Calzones 1', 'Pack de calzones variados para mujer', 20, 'Ropa Interior', 'imagesz/interior/interior3.jpg', 1),
       ('Boxers Surtidos', 'Pack de boxers surtidos para niños', 30, 'Ropa Interior', 'imagesz/interior/interior4.jpg', 1),
       ('Boxer Verde UOMO', 'Boxer verde para hombre', 15, 'Ropa Interior', 'imagesz/interior/interior5.jpg', 1),
       ('Boxer y Calcetines Variados 2', 'Pack de boxers y calcetines variados para niños', 10, 'Ropa Interior', 'imagesz/interior/interior6.jpg', 1),
       ('Ropa Interior Femenina 1', 'Pack de ropa interior femenina variada', 35, 'Ropa Interior', 'imagesz/interior/interior7.jpg', 1),
       ('Ropa Interior Femenina 2', 'Pack de ropa interior femenina variada', 40, 'Ropa Interior', 'imagesz/interior/interior8.jpg', 1),
       ('Calzones 2', 'Pack de calzones variados para mujer', 20, 'Ropa Interior', 'imagesz/interior/interior9.jpg', 1),
       ('Boxers y Calcetines Variados 3', 'Pack de boxers y calcetines variados para niños', 10, 'Ropa Interior', 'imagesz/interior/interior10.jpg', 1),
       ('Boxer Azul UOMO', 'Boxer azul para hombre', 15, 'Ropa Interior', 'imagesz/interior/interior11.jpg', 1),
       ('Brasieres 2', 'Pack de brasiers variados para mujer', 25, 'Ropa Interior', 'imagesz/interior/interior12.jpg', 1);

-- Ropa de Invierno
insert into products (name, description, price, category, image_url, stock)
values ('Sueter Plomo', 'Sueter plomo para hombre', 60, 'Ropa de Invierno', 'imagesz/invierno/invierno1.jpg', 1),
       ('Sueter Beige', 'Sueter beige para hombre', 70, 'Ropa de Invierno', 'imagesz/invierno/invierno2.jpg', 1),
       ('Sueter DC Salmón', 'Sueter DC color salmón para hombre', 80, 'Ropa de Invierno', 'imagesz/invierno/invierno3.jpg', 1),
       ('Chamarra Azul Oscuro', 'Chamarra azul oscuro para hombre', 90, 'Ropa de Invierno', 'imagesz/invierno/invierno4.jpg', 1),
       ('Sueter Gris', 'Sueter gris para mujer', 60, 'Ropa de Invierno', 'imagesz/invierno/invierno5.jpg', 1);

-- Otros
insert into products (name, description, price, category, image_url, stock)
values ('Faja Negra', 'Faja negra para mujer', 25, 'Otros', 'imagesz/otros/otros1.jpg', 1),
       ('Faja Beige', 'Faja beige para mujer', 30, 'Otros', 'imagesz/otros/otros2.jpg', 1),
       ('Sombrero Café', 'Sombrero café para hombre', 20, 'Otros', 'imagesz/otros/otros3.jpg', 1),
       ('Carteras para Hombre', 'Carteras para hombre de varios colores', 35, 'Otros', 'imagesz/otros/otros4.jpg', 1),
       ('Set deportivo 1', 'Set deportivo para mujer', 50, 'Otros', 'imagesz/otros/otros5.jpg', 1),
       ('Set deportivo 2', 'Set deportivo para mujer', 55, 'Otros', 'imagesz/otros/otros6.jpg', 1),
       ('Gorra Negra', 'Gorra negra para hombre', 15, 'Otros', 'imagesz/otros/otros7.jpg', 1);