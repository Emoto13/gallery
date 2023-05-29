SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `albums` (`id`, `name`, `description`, `created_at`, `user_id`) VALUES
(1, 'Test Album', 'This is a test album', '2020-07-21 20:31:34', 1),
(2, 'Second Test', 'This is another test album', '2020-07-21 20:32:39', 1);


CREATE TABLE `album_images` (
  `id` int(11) NOT NULL,
  `image_instance_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `album_images` (`id`, `image_instance_id`, `album_id`) VALUES
(1, 15, 1),
(2, 16, 1),
(3, 17, 1),
(4, 18, 2),
(5, 19, 2);


CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `path` varchar(2048) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `author_id` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `images` (`path`, `timestamp`, `id`, `author_id`, `description`, `address`) VALUES
('1225f06e-3999-4f5a-b83f-f78afae41257.jpg', '2023-04-14 11:59:26', 15, 1, 'Cute doggo', ''),
('29ec0317-5ea6-4c24-9a43-4d2b06f86c00.jpg', '2023-04-24 14:41:53', 16, 1, 'Morning cofee', ''),
('9f80a9fb-9985-4668-a362-d5529503fb4b.jpg', '2023-04-14 11:59:26', 17, 1, 'Lego', ''),
('9b643de1-2557-4113-a3b5-66166c739e18.jpg', '2012-04-22 03:07:31', 18, 1, 'Cosmos', ''),
('8db911c3-3efc-4afa-bf73-9abe69bdf214.jpg', '2023-04-22 09:32:43', 19, 1, 'Eggs', ''),
('7bc6980f-6454-472f-8ce3-648b0b4479af.jpeg', '2022-04-11 09:32:51', 20, 1, 'Bright idea', ''),
('6d0567e3-84bb-42ec-b08a-2760b3b25b90.jpg', '2022-04-07 09:33:11', 21, 1, 'Mountains', ''),
('1352b1a4-4ef6-44b2-bbda-4aa5d4d150d7.jpg', '2022-04-25 09:23:44', 22, 1, '', 'Outside during winter');


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `password` longtext NOT NULL,
  `date_registered` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `users` (`id`, `username`, `email`, `password`, `date_registered`) VALUES
(1, 'test_user', 'emilian.spassov@gmail.com', '$2y$10$iRUbwBh/Q.lpoh9k4uRmG.wiXDdyh3bg7WfNdfcZhhG0i.cZwrt.C', '2022-06-10');


ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);


ALTER TABLE `album_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`),
  ADD KEY `image_instance_id` (`image_instance_id`) USING BTREE;


ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imagePath` (`path`) USING HASH;


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING HASH,
  ADD UNIQUE KEY `email` (`email`) USING HASH;


ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `album_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);


ALTER TABLE `album_images`
  ADD CONSTRAINT `album_images_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `album_images_ibfk_2` FOREIGN KEY (`image_instance_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;