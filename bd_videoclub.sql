-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2021 a las 11:56:47
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_videoclub`
--
CREATE DATABASE IF NOT EXISTS `bd_videoclub` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_videoclub`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `tipoGenero` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`tipoGenero`) VALUES
('Acción'),
('Animación'),
('Aventuras'),
('Ciencia Ficción'),
('Comedia'),
('Dramática'),
('Guerra/Bélica'),
('Musical'),
('Romántica'),
('Terror'),
('Thriller/Suspense'),
('Western/Oeste');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `nom_pelicula` varchar(60) NOT NULL,
  `nom_original` varchar(60) NOT NULL,
  `genero_principal` varchar(30) NOT NULL,
  `genero_secundario` varchar(30) DEFAULT NULL,
  `imagen` varchar(100) NOT NULL,
  `sinopsis` varchar(1500) NOT NULL,
  `anio` int(4) NOT NULL,
  `pais` varchar(30) NOT NULL,
  `soporte` varchar(15) NOT NULL,
  `cantidad_disponible` int(4) NOT NULL,
  `id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`nom_pelicula`, `nom_original`, `genero_principal`, `genero_secundario`, `imagen`, `sinopsis`, `anio`, `pais`, `soporte`, `cantidad_disponible`, `id`) VALUES
('Mortal Kombat', 'Mortal Kombat (2021)', 'Aventuras', 'Ciencia Ficción', 'assets\\images\\films\\mortal_kombat.png', 'En \"Mortal Kombat\", Cole Young, un luchador de MMA acostumbrado a recibir palizas a cambio de plata, no sabe lo que heredó, ni por qué el emperador Shang Tsung del Mundo Exterior mandó a Sub-Zero, su mejor guerrero, un criomante de otro mundo, a cazarlo. Cole teme por la seguridad de su familia, y sale en busca de Sonya Blade por indicación de Jax, un comandante de las Fuerzas Especiales que tiene la misma marca rara de nacimiento que Cole, con forma de dragón. Cole llega pronto al templo de Lord Raiden, un Dios Antiguo protector de la Tierra que ofrece refugio a quienes portan la marca. Allí, Cole entrena con los guerreros expertos Liu Kang, Kung Lao y Kano, el mercenario rebelde, y se prepara para unirse a los mayores campeones de la Tierra en el combate contra los enemigos del Mundo Exterior en una arriesgada batalla por el universo. Pero ¿sentirá la presión suficiente para desbloquear a tiempo su arcana (el inmenso poder que proviene de su alma) no solo para salvar a su familia, sino también para vencer al Mundo Exterior para siempre?\r\n', 2021, 'Estados Unidos', 'Fisico', 20, 1),
('Test', 'OriginalTest', 'Aventuras', 'Ciencia Ficción', 'ImagenTest', 'La sinopsis de esta pelicula es un test', 2020, 'Españita', 'Video', 45, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `nombre_pelicula` varchar(60) NOT NULL,
  `cliente` varchar(40) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `precio` float NOT NULL,
  `devuelto` set('Si','No') NOT NULL,
  `id_prestamo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nom_usuario` varchar(40) NOT NULL,
  `email` varchar(2500) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `password` varchar(60) NOT NULL,
  `tipo_usuario` varchar(20) NOT NULL,
  `id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nom_usuario`, `email`, `estado`, `password`, `tipo_usuario`, `id`) VALUES
('Akiuro', 'adrianmendozasantano@gmail.com', 1, '$2y$10$.40gkP6z2076iucrPYnwJueVZnpkVoKzuSaL0L8l6jne5h7j2uTEy', 'administrador', 34),
('Paco', 'Fiestas@gmail.com', 1, '$2y$10$rnTZiA3.H7Wkcb5UqdZIdeUMRQxhmqtM8awTiXLzT4owwkHaVEXui', 'normal', 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `nombre_pelicula` varchar(60) NOT NULL,
  `cliente` varchar(40) NOT NULL,
  `fecha_venta` date NOT NULL,
  `limite_fecha_devolucion` date NOT NULL,
  `precio` float NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`tipoGenero`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_pelicula` (`nom_pelicula`),
  ADD UNIQUE KEY `nom_original` (`nom_original`),
  ADD KEY `genero_principal` (`genero_principal`),
  ADD KEY `genero_secundario` (`genero_secundario`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id_prestamo`),
  ADD KEY `nombre_pelicula` (`nombre_pelicula`),
  ADD KEY `cliente` (`cliente`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`,`nom_usuario`),
  ADD KEY `nom_usuario` (`nom_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD KEY `nombre_pelicula` (`nombre_pelicula`),
  ADD KEY `cliente` (`cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD CONSTRAINT `peliculas_ibfk_1` FOREIGN KEY (`genero_principal`) REFERENCES `generos` (`tipoGenero`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peliculas_ibfk_2` FOREIGN KEY (`genero_secundario`) REFERENCES `generos` (`tipoGenero`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`nombre_pelicula`) REFERENCES `peliculas` (`nom_pelicula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`cliente`) REFERENCES `usuarios` (`nom_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`nombre_pelicula`) REFERENCES `peliculas` (`nom_pelicula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`cliente`) REFERENCES `usuarios` (`nom_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
