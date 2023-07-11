SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Base de datos: `id20949959_bdshortaudi`

-- Estructura de tabla para la tabla `id20444493_audiencias00_`

CREATE TABLE `id20444493_audiencias00_` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `dia_de_audiencia` date NOT NULL,
  `hora_de_cita` time NOT NULL,
  `num_personas` int(11) NOT NULL,
  `procedencia` varchar(255) NOT NULL,
  `asunto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `id20444493_audiencias00_`

INSERT INTO `id20444493_audiencias00_` (`id`, `nombre`, `apellidos`, `dia_de_audiencia`, `hora_de_cita`, `num_personas`, `procedencia`, `asunto`) VALUES
(1, 'Juan', 'Pérez', '2023-05-01', '10:00:00', 2, 'Villahermosa', 'Entrega de informe'),
(2, 'María', 'González', '2023-05-02', '11:00:00', 3, 'Cárdenas', 'Seguridad en plantas potabilizadoras'),
(3, 'Pedro', 'López', '2023-05-03', '12:00:00', 1, 'Comalcalco', 'Entrega de equipos');

-- Índices para tablas volcadas

-- Indices de la tabla `id20444493_audiencias00_`
ALTER TABLE `id20444493_audiencias00_`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT de las tablas volcadas

-- AUTO_INCREMENT de la tabla `id20444493_audiencias00_`
ALTER TABLE `id20444493_audiencias00_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
