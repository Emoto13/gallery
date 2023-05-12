SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_gallery`
--

-- --------------------------------------------------------

--
-- Структура на таблица `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Схема на данните от таблица `albums`
--

INSERT INTO `albums` (`id`, `name`, `description`, `createdAt`, `userId`) VALUES
(1, 'Test Album', 'This is a test album', '2020-07-21 20:31:34', 1),
(2, 'Second Test', 'This is another test album', '2020-07-21 20:32:39', 1);

-- --------------------------------------------------------

--
-- Структура на таблица `album_images`
--

CREATE TABLE `album_images` (
  `id` int(11) NOT NULL,
  `image_instance_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Схема на данните от таблица `album_images`
--

INSERT INTO `album_images` (`id`, `image_instance_id`, `album_id`) VALUES
(1, 15, 1),
(2, 16, 1),
(3, 17, 1),
(4, 18, 2),
(5, 19, 2);

-- --------------------------------------------------------

--
-- Структура на таблица `images`
--
CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `path` varchar(2048) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `author_id` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Схема на данните от таблица `images`
--

INSERT INTO `images` (`path`, `timestamp`, `id`, `author_id`, `description`, `address`) VALUES
('Chrysanthemum_5f174d9829225.jpg', '2023-04-14 11:59:26', 15, 1, 'Chrysanthemum', ''),
('Hydrangeas_5f174da2e5207.jpg', '2023-04-24 14:41:53', 16, 1, 'Hydrangeas', ''),
('Desert_5f174dc478022.jpg', '2023-04-14 11:59:26', 17, 1, 'Desert', ''),
('Penguins_5f174dcd791c4.jpg', '2012-04-22 03:07:31', 18, 1, 'Penguins', ''),
('Koala_5f174dd61ec81.jpg', '2023-04-22 09:32:43', 19, 1, 'Koala', ''),
('Lighthouse_5f174ddfea854.jpg', '2022-04-11 09:32:51', 20, 1, 'Lighthouse', ''),
('Tulips_5f174de637144.jpg', '2022-04-07 09:33:11', 21, 1, 'Tulips', ''),
('IMG_20120725_112345_5f1de393785da.jpg', '2022-04-25 09:23:44', 22, 1, '', 'Jardin du Luxembourg, Place Edmond Rostand, 75006 Paris, France');

-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `password` longtext NOT NULL,
  `date_registered` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `date_registered`) VALUES
(1, 'test_user', 'emilian.spassov@gmail.com', '$2y$10$iRUbwBh/Q.lpoh9k4uRmG.wiXDdyh3bg7WfNdfcZhhG0i.cZwrt.C', '2022-06-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `album_images`
--
ALTER TABLE `album_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`),
  ADD KEY `image_instance_id` (`image_instance_id`) USING BTREE;

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imagePath` (`path`) USING HASH;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING HASH,
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `album_images`
--
ALTER TABLE `album_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Ограничения за таблица `album_images`
--
ALTER TABLE `album_images`
  ADD CONSTRAINT `album_images_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `album_images_ibfk_2` FOREIGN KEY (`image_instance_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
