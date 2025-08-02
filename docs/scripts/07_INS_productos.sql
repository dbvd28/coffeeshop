INSERT INTO `categorias` ( `nombre`, `descripcion`) VALUES
( 'Ligero', 'Un tostado ligero del cafe'),
( 'Medio', 'Un tostado medio del cafe'),
( 'Fuerte', 'Un tostado fuerte del cafe'),
( 'Extra Fuerte', 'Un tostado extra fuerte del cafe');
INSERT INTO `proveedores` ( `nombre`, `contacto`, `telefono`, `email`, `direccion`) VALUES
('Espresso Americano', 'Luis Perez', '99556633', 'luisespresso@gmail.com', 'Blvd. Morazan, Tegucigalpa'),
('Cafe Oro', 'Juan Diaz', '88556622', 'Juanitooro@gmail.com', 'Blvd Suyapa, Tegucigalpa'),
('Cafe Maya', 'Marleny Avila', '33669988', 'Mmaya@gmail.com', 'Blv Juan Pablo, Tegugicalpa');

INSERT INTO `productos` ( `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStock`, `productStatus`, `proveedorId`, `categoriaId`) VALUES
('Cafe Espresso Americano ligero', 'Cafe en grano con un tueste ligero ', 200.00, 'public/imgs/hero/es_ligero.jpeg', 34, 'ACT', 10, 10),
('Cafe Maya fuerte', 'Cafe en grano con un tueste fuerte ', 100.00, 'public/imgs/hero/ma_medio.webp', 44, 'ACT', 11, 12),
('Cafe Oro medio', 'Cafe en grano con un tueste lmedio', 25.00, 'public/imgs/hero/oro_medio.jpeg', 36, 'ACT', 11, 11),
('Cafe Danli', 'Cafe hecho en las montañas de danli', 52.53, 'public/imgs/hero/cafe_danli.jpg', 27, 'ACT', 12, 12),
('Cafe Norteño', 'Cafe hecho con grano puro importado de colombia', 62.25, 'public/imgs/hero/cafe_norteno.webp', 30, 'ACT', 10, 13);
