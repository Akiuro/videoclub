-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-05-2021 a las 11:12:51
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
  `precio` float NOT NULL,
  `id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`nom_pelicula`, `nom_original`, `genero_principal`, `genero_secundario`, `imagen`, `sinopsis`, `anio`, `pais`, `soporte`, `cantidad_disponible`, `precio`, `id`) VALUES
('Mulán (2020)', 'Hua Mulan', 'Acción', 'Aventuras', 'assets/images/films/mulan.jpg', 'Ante la amenaza de la invasión de los hunos, el emperador chino recluta a un varón de cada familia para luchar en el ejército. Fa Mulán (Liu Yifei) decide disfrazarse de hombre para proteger a su padre, un héroe de guerra con una cojera permanente. Mulán deberá proteger su verdadera identidad y evitar que la descubran, pero su secreto acabará por salir a la luz.\n\n', 2020, 'Estados Unidos', 'Digital', 30, 19.95, 10),
('La vida es bella', 'La vita è bella', 'Dramática', 'Dramática', 'assets/images/films/lavidaesbella.jpg', 'En 1939, a punto de estallar la Segunda Guerra Mundial (1939-1945), el extravagante Guido llega a Arezzo, en la Toscana, con la intención de abrir una librería. Allí conoce a la encantadora Dora y, a pesar de que es la prometida del fascista Rodolfo, se casa con ella y tiene un hijo. Al estallar la guerra, los tres son internados en un campo de exterminio, donde Guido hará lo imposible para hacer creer a su hijo que la terrible situación que están padeciendo es tan sólo un juego.', 1997, 'Italia', 'Físico', 20, 9.95, 11),
('Los Increíbles 2', 'Incredibles 2', 'Animación', 'Acción', 'assets/images/films/increibles2.jpg', 'Helen es reclutada para ayudar a que la acción vuelva a la vida de los Súper, mientras Bob se enfrenta a la rutina de su vida diaria \"normal\" en el hogar. En casa debe lidiar con un bebé que está a punto de descubrir sus superpoderes. Mientras tanto un nuevo villano trama un plan brillante y peligroso que lleva a pique toda la estabilidad conseguida y que solo Los Increíbles podrán afrontar juntos.', 2018, 'Estados Unidos', 'Fisico', 30, 14.95, 12),
('A todo gas', 'The Fast and the Furious', 'Acción', 'Aventuras', 'assets/images/films/fastandfurious.jpg', 'Una misteriosa banda de delincuentes se dedica a robar camiones en marcha desde vehículos deportivos. La policía decide infiltrar un hombre en el mundo de las carreras ilegales para descubrir posibles sospechosos. El joven y apuesto Brian entra en el mundo del tunning donde conoce a Dominic, rey indiscutible de este mundo y sospechoso número uno, pero todo se complicará cuando se enamore de su hermana.', 2001, 'Estados Unidos', 'Fisico', 30, 4.95, 13),
('Mamma Mia!', 'Mamma Mia!', 'Comedia', 'Musical', 'assets/images/films/mammamia.jpg', 'Donna, una madre independiente y soltera, dueña de un pequeño hotel en una idílica isla griega, está a punto de dejar que se marche Sophie, la hija a la que ha criado sola. Donna ha invitado a sus dos mejores amigas a la boda de su hija, Rosie, una mujer práctica y lógica, y Tanya, rica y multidivorciada. Las dos son ex miembros de su antigua banda, Donna and the Dynamos. Por su parte, Sophie también ha hecho tres invitaciones muy especiales.\n\nDecidida a encontrar un padre para que la lleve al altar, invita a tres hombres que visitaron la paradisíaca isla hace 20 años. Durante las siguientes caóticas y mágicas 24 horas, florecerán nuevos amores y se reavivarán viejos romances en una isla llena de posibilidades.', 2008, 'Reino Unido', 'Digital', 30, 4.95, 14),
('Pokemon: Diancie y la crisálida de la destrucción', 'Pokemon The Movie XY Hakai No Mayu to Diancie', 'Animación', 'Aventuras', 'assets/images/films/pkmndiance.jpg', 'En el subterráneo Dominio Diamante, donde muchos Carbink viven, el Pokémon singular Diancie es quien está al mando. El Diamante Corazón, que sostiene el reino, está empezando a desmoronarse, y Diancie no es todavía lo suficientemente fuerte para crear uno nuevo. Mientras busca la ayuda del Pokémon legendario Xerneas, Diancie se encuentra con un grupo de ladrones que quieren hacerse con su poder para crear diamantes y que despiertan al Pokémon legendario Yveltal, que dormía en su crisálida. ¿Podrán Ash y sus amigos ayudar a Diancie a descubrir su verdadero poder, detener la furia de Yveltal y salvar el Dominio Diamante?', 2014, 'Japón', 'Fisico', 30, 14.95, 15),
('Avatar', 'Avatar', 'Ciencia Ficción', 'Aventuras', 'assets/images/films/avatar.jpg', 'Jake Sully es un ex-marine confinado en una silla de ruedas que, a pesar de su cuerpo tullido, todavía es un guerrero de corazón. Jake ha sido reclutado para viajar a Pandora, donde las corporaciones están extrayendo un mineral extraño que es la clave para resolver los problemas de la crisis energética de la Tierra. Al ser tóxica la atmósfera de Pandora, ellos han creado el programa Avatar, en el cual los humanos ¿conductores¿ tienen sus conciencias unidas a un avatar, un cuerpo biológico controlado de forma remota que puede sobrevivir en el aire letal. Estos cuerpos están creados genéticamente de ADN humano, mezclado con ADN de los nativos de Pandora¿ los Na\'vi. Ya en su forma avatar, Jake puede caminar otra vez. Ha recibido la misión de infiltrarse entre los Na\'vi, los cuales se han convertido en el mayor obstáculo para la extracción del mineral. Pero una bella Na\'vi, Naytiri, salva la vida de Jake, y todo cambia. Jake es admitido en su clan y aprende a ser uno de ellos, lo cual le hace someterse a muchas pruebas y aventuras. Según la relación de Jake con su profesora Neytiry se va intensificando, él aprende a respetar la vida de los Na\'vi y decide encontrar su lugar entre ellos. Pronto se enfrentará a la mayor de las pruebas cuando tenga que dirigir una batalla épica que decidirá nada menos que el destino de su nuevo mundo.', 2009, 'Estados Unidos', 'Físico', 30, 4.95, 16),
('Mortal Kombat', 'Mortal Kombat', 'Ciencia Ficción', 'Acción', 'assets/images/films/mortal_kombat.png', 'trhrtyhnyt4ij6tyuj', 2020, 'Estados Unidos', 'Digital', 30, 14.95, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `nombre_pelicula` varchar(60) NOT NULL,
  `cliente` varchar(40) NOT NULL,
  `tipo` set('compra','alquiler','','') NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `precio` float NOT NULL,
  `devuelto` set('Si','No') NOT NULL,
  `id_prestamo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`nombre_pelicula`, `cliente`, `tipo`, `fecha_inicio`, `fecha_fin`, `precio`, `devuelto`, `id_prestamo`) VALUES
('La vida es bella', 'Akiuro', 'compra', '2021-05-24', '2021-05-31', 14.95, 'Si', 1),
('A todo gas', 'Isabel', 'alquiler', '2021-05-24', '2021-05-31', 14.95, 'No', 2),
('Pokemon: Diancie y la crisálida de la destrucción', 'Akiuro', 'alquiler', '2021-05-24', '2021-05-31', 14.95, 'No', 3);

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
  `cartera` float NOT NULL,
  `id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nom_usuario`, `email`, `estado`, `password`, `tipo_usuario`, `cartera`, `id`) VALUES
('Akiuro', 'adrianmendozasantano@gmail.com', 1, '$2y$10$.40gkP6z2076iucrPYnwJueVZnpkVoKzuSaL0L8l6jne5h7j2uTEy', 'administrador', 0, 34),
('Paco', 'Fiestas@gmail.com', 1, '$2y$10$rnTZiA3.H7Wkcb5UqdZIdeUMRQxhmqtM8awTiXLzT4owwkHaVEXui', 'normal', 0, 35),
('Isabel', 'sabudoo@gmail.com', 1, '$2y$10$TEMUOVNSaAyFh1b3bRwvIeNhl6kVR08lMHN3BGjTEiB5DcuYM10.K', 'normal', 0, 36),
('test', 'test@gmail.com', 1, '$2y$10$RkXw/uchtuqRCJnO87zDFu2f5RAHMU1yfx0cYT/hxK52Md3/kkIqq', 'normal', 14.95, 38);

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
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
