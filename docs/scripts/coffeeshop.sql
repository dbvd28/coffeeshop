CREATE SCHEMA `coffeeshop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `usuario` (
    `usercod` bigint(10) NOT NULL AUTO_INCREMENT,
    `useremail` varchar(80) DEFAULT NULL,
    `username` varchar(80) DEFAULT NULL,
    `userpswd` varchar(128) DEFAULT NULL,
    `userfching` datetime DEFAULT NULL,
    `userpswdest` char(3) DEFAULT NULL,
    `userpswdexp` datetime DEFAULT NULL,
    `userest` char(3) DEFAULT NULL,
    `useractcod` varchar(128) DEFAULT NULL,
    `userpswdchg` varchar(128) DEFAULT NULL,
    `usertipo` char(3) DEFAULT NULL COMMENT 'Tipo de Usuario, Normal, Consultor o Cliente',
    PRIMARY KEY (`usercod`),
    UNIQUE KEY `useremail_UNIQUE` (`useremail`),
    KEY `usertipo` (
        `usertipo`,
        `useremail`,
        `usercod`,
        `userest`
    )
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;

CREATE TABLE `roles` (
    `rolescod` varchar(128) NOT NULL,
    `rolesdsc` varchar(45) DEFAULT NULL,
    `rolesest` char(3) DEFAULT NULL,
    PRIMARY KEY (`rolescod`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `roles_usuarios` (
    `usercod` bigint(10) NOT NULL,
    `rolescod` varchar(128) NOT NULL,
    `roleuserest` char(3) DEFAULT NULL,
    `roleuserfch` datetime DEFAULT NULL,
    `roleuserexp` datetime DEFAULT NULL,
    PRIMARY KEY (`usercod`, `rolescod`),
    KEY `rol_usuario_key_idx` (`rolescod`),
    CONSTRAINT `rol_usuario_key` FOREIGN KEY (`rolescod`) REFERENCES `roles` (`rolescod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `usuario_rol_key` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `funciones` (
    `fncod` varchar(255) NOT NULL,
    `fndsc` varchar(255) DEFAULT NULL,
    `fnest` char(3) DEFAULT NULL,
    `fntyp` char(3) DEFAULT NULL,
    PRIMARY KEY (`fncod`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `funciones_roles` (
    `rolescod` varchar(128) NOT NULL,
    `fncod` varchar(255) NOT NULL,
    `fnrolest` char(3) DEFAULT NULL,
    `fnexp` datetime DEFAULT NULL,
    PRIMARY KEY (`rolescod`, `fncod`),
    KEY `rol_funcion_key_idx` (`fncod`),
    CONSTRAINT `funcion_rol_key` FOREIGN KEY (`rolescod`) REFERENCES `roles` (`rolescod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `rol_funcion_key` FOREIGN KEY (`fncod`) REFERENCES `funciones` (`fncod`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `bitacora` (
    `bitacoracod` int(11) NOT NULL AUTO_INCREMENT,
    `bitacorafch` datetime DEFAULT NULL,
    `bitprograma` varchar(255) DEFAULT NULL,
    `bitdescripcion` varchar(255) DEFAULT NULL,
    `bitobservacion` mediumtext,
    `bitTipo` char(3) DEFAULT NULL,
    `bitusuario` bigint(18) DEFAULT NULL,
    PRIMARY KEY (`bitacoracod`)
) ENGINE = InnoDB AUTO_INCREMENT = 10 DEFAULT CHARSET = utf8;

CREATE TABLE `proveedores` (
    `proveedorId` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100) NOT NULL,
    `contacto` VARCHAR(100),
    `telefono` VARCHAR(20),
    `email` VARCHAR(100),
    `direccion` TEXT,
    PRIMARY KEY (`proveedorId`)
) ENGINE = InnoDB AUTO_INCREMENT = 10 DEFAULT CHARSET = utf8;

CREATE TABLE `categorias` (
    `categoriaId` INT NOT NULL AUTO_INCREMENt,
    `nombre` VARCHAR(50) NOT NULL,
    `descripcion` TEXT,
    PRIMARY KEY (`categoriaId`)
) ENGINE = InnoDB AUTO_INCREMENT = 10 DEFAULT CHARSET = utf8;

CREATE TABLE `productos` (
    `productId` bigint(18) NOT NULL AUTO_INCREMENT,
    `productName` varchar(255) NOT NULL,
    `productDescription` text NOT NULL,
    `productPrice` decimal(10, 2) NOT NULL,
    `productImgUrl` varchar(255) NOT NULL,
    `productStock` int(11) NOT NULL DEFAULT 0,
    `productStatus` char(3) NOT NULL,
    `proveedorId` int,
    `categoriaId` int,
    PRIMARY KEY (`productId`),
    CONSTRAINT `productos_prvd_key` FOREIGN KEY (`proveedorId`) REFERENCES `proveedores` (`proveedorId`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `productos_categ_key` FOREIGN KEY (`categoriaId`) REFERENCES `categorias` (`categoriaId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4;

CREATE TABLE `pedidos` (
    `pedidoId` INT AUTO_INCREMENT NOT NULL,
    `usercod` BIgINT(10) NOT NULL,
    `fchpedido` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `estado` ENUM('PEND', 'PAG', 'ENV', 'CAN') NOT NULL DEFAULT 'PEND',
    `total` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (`pedidoId`),
    CONSTRAINT `pedidos_usr_key` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4;

CREATE TABLE `detalle_pedidos` (
    `detalleId` INT AUTO_INCREMENT NOT NULL,
    `pedidoId` INT NOT NULL,
    `productoId` BIGINT(18) NOT NULL,
    `cantidad` INT NOT NULL,
    `precio_unitario` DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (`detalleId`),
    CONSTRAINT `detalle_producto_key` FOREIGN KEY (`productoId`) REFERENCES `productos` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `detalle_pedido_key` FOREIGN KEY (`pedidoId`) REFERENCES `pedidos` (`pedidoId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4;

CREATE TABLE `carretilla` (
    `usercod` BIGINT(10) NOT NULL,
    `productId` bigint(18) NOT NULL,
    `crrctd` INT(5) NOT NULL,
    `crrprc` DECIMAL(12, 2) NOT NULL,
    `crrfching` DATETIME NOT NULL,
    PRIMARY KEY (`usercod`, `productId`),
    INDEX `productId_idx` (`productId` ASC),
    CONSTRAINT `carretilla_user_key` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `carretilla_prd_key` FOREIGN KEY (`productId`) REFERENCES `productos` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `carretillaanon` (
    `anoncod` varchar(128) NOT NULL,
    `productId` bigint(18) NOT NULL,
    `crrctd` int(5) NOT NULL,
    `crrprc` decimal(12, 2) NOT NULL,
    `crrfching` datetime NOT NULL,
    PRIMARY KEY (`anoncod`, `productId`),
    KEY `productId_idx` (`productId`),
    CONSTRAINT `carretillaanon_prd_key` FOREIGN KEY (`productId`) REFERENCES `productos` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
/*Inserts*/
INSERT INTO `roles`(`rolescod`,`rolesdsc`,`rolesest`) VALUES('Admin','Administradores','ACT');
INSERT INTO `roles`(`rolescod`,`rolesdsc`,`rolesest`) VALUES('Client','Cliente','ACT');
    INSERT INTO `funciones`(`fncod`,`fndsc`,`fnest`,`fntyp`) VALUES('Controllers\\Administrator\\Orders','Controllers\\Administrator\\Orders','ACT','CTR');
    INSERT INTO `funciones`(`fncod`,`fndsc`,`fnest`,`fntyp`) VALUES('Controllers\\Administrator\\Order','Controllers\\Administrator\\Order','ACT','CTR');
INSERT INTO `funciones`(`fncod`,`fndsc`,`fnest`,`fntyp`) VALUES('Controllers\\Administrator\\Order','Controllers\\Administrator\\Order\\update','ACT','CTR');
INSERT INTO `funciones_roles`(`rolescod`,`fncod`,`fnrolest`,`fnexp`) VALUES('Admin','Controllers\\Administrator\\Order','ACT','2025-08-09 00:00:00');
INSERT INTO `funciones_roles`(`rolescod`,`fncod`,`fnrolest`,`fnexp`) VALUES('Admin','Controllers\\Administrator\\Orders','ACT','2025-08-09 00:00:00');
INSERT INTO `funciones_roles`(`rolescod`,`fncod`,`fnrolest`,`fnexp`) VALUES('Admin','Controllers\\Administrator\\Order\\update','ACT','2025-08-09 00:00:00');
INSERT INTO `funciones_roles`(`rolescod`,`fncod`,`fnrolest`,`fnexp`) VALUES('Admin','Menu_Administrator_Orders','ACT','2025-08-09 00:00:00');

/*Trigger de la tabla usuario para que cada usuario que se ingrese agarre el rol de cliente*/
CREATE TRIGGER client_role
AFTER INSERT ON usuario
FOR EACH ROW
BEGIN
DECLARE clientrole varchar(128);
Select rolescod into clientrole FROM roles where rolescod='Client' LIMIT 1;
INSERT INTO roles_usuarios(usercod,rolescod,roleuserest,roleuserfch,roleuserexp) VALUES ( NEW.usercod,clientrole,'ACT',NOW(), DATE_ADD(NOW(), INTERVAL 10 YEAR));
END