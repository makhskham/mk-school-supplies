-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2025 at 06:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolstore_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(1, 'Notebooks', 'All kinds of notebooks for note-taking and journaling'),
(2, 'Pens', 'Ballpoint, gel, and fountain pens'),
(3, 'Backpacks', 'Carry your supplies with these backpacks'),
(4, 'Paper', 'Loose leaf paper, graph pads, and notepads'),
(5, 'Accessories', 'Tools like erasers, rulers, sharpeners, and more');

-- --------------------------------------------------------

--
-- Table structure for table `monitoring`
--

CREATE TABLE `monitoring` (
  `check_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `status` enum('online','offline') NOT NULL,
  `checked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` int(11) NOT NULL,
  `option_type` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL,
  `extra_cost` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `option_type`, `label`, `extra_cost`) VALUES
(1, 'color', 'Black', 0.00),
(2, 'color', 'White', 0.00),
(3, 'color', 'Red', 0.00),
(4, 'color', 'Blue', 0.00),
(5, 'color', 'Green', 0.00),
(6, 'color', 'Yellow', 0.00),
(7, 'color', 'Pink', 0.00),
(8, 'color', 'Purple', 0.00),
(9, 'color', 'Pastel', 0.00),
(10, 'color', 'Multicolor', 0.00),
(11, 'color', 'Neon', 0.00),
(12, 'ink_color', 'Black', 0.00),
(13, 'ink_color', 'Blue', 0.00),
(14, 'ink_color', 'Red', 0.00),
(15, 'brand', 'Casio', 0.00),
(16, 'brand', 'Texas Instruments', 0.00),
(17, 'brand', 'Crayola', 0.00),
(18, 'brand', 'Prismacolor', 0.00),
(19, 'brand', 'SanDisk 16GB', 0.00),
(20, 'brand', 'Kingston 16GB', 0.00),
(21, 'grid_size', '5mm', 0.00),
(22, 'grid_size', '10mm', 0.00),
(23, 'lead_size', '0.7mm', 0.00),
(24, 'lead_size', '0.5mm', 0.00),
(25, 'cover_type', 'Black Marble', 0.00),
(26, 'cover_type', 'Blue Marble', 0.00),
(27, 'finish', 'Glossy Black', 0.00),
(28, 'finish', 'Matte White', 0.00),
(29, 'pack_type', 'White (4-pack)', 0.00),
(30, 'pack_type', 'Pink (4-pack)', 0.00),
(31, 'style', 'Neon', 0.00),
(32, 'style', 'Pastel', 0.00),
(33, 'style', 'Enclosed', 0.00),
(34, 'style', 'Open', 0.00),
(35, 'type', 'Washable', 0.00),
(36, 'type', 'Permanent', 0.00),
(37, 'material', 'Transparent Plastic', 0.00),
(38, 'material', 'Colored Plastic', 0.00),
(39, 'cover_color', 'Blue', 0.00),
(40, 'cover_color', 'Purple', 0.00),
(41, 'cover_color', 'Red', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `status` enum('pending','paid','shipped','cancelled') NOT NULL DEFAULT 'pending',
  `total_amount` decimal(12,2) NOT NULL,
  `ordered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `customer_email`, `total`, `order_date`, `user_id`, `status`, `total_amount`, `ordered_at`) VALUES
(4, 'Makhsuma K', 'khamzal@abc.com', 58.49, '2025-07-27 20:57:59', 1, 'pending', 0.00, '2025-07-28 00:57:59'),
(5, 'khamzal', 'admin@schoolstore.com', 59.98, '2025-07-29 11:39:41', 1, 'pending', 0.00, '2025-07-29 15:39:41'),
(6, 'khamzal', 'khamzal@abc.ca', 1.50, '2025-07-29 11:56:25', 1, 'pending', 0.00, '2025-07-29 15:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `quantity`, `price`, `unit_price`) VALUES
(1, 4, 11, 1, 29.99, 0.00),
(2, 4, 12, 1, 4.50, 0.00),
(3, 4, 19, 2, 12.00, 0.00),
(4, 5, 11, 2, 29.99, 0.00),
(5, 6, 4, 1, 1.50, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(50) NOT NULL DEFAULT 'Accessories'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `price`, `stock`, `description`, `image_url`, `created_at`, `category`) VALUES
(1, 1, 'Spiral Notebook – 80 pages', 3.50, 100, 'Durable spiral-bound notebook with 80 sheets', 'images/spiral_notebook.jpg', '2025-07-27 23:44:49', 'Notebooks'),
(2, 1, 'Composition Book – 100 pages', 2.99, 150, 'Classic composition notebook in black marble cover', 'images/composition_book_100.jpg', '2025-07-27 23:44:49', 'Accessories'),
(3, 4, 'Graph Paper Pad', 4.00, 75, '8.5x11 inch graph pad with 50 sheets', 'images/graph_paper_pad.jpg', '2025-07-27 23:44:49', 'Paper'),
(4, 2, 'Ballpoint Pen', 1.50, 200, 'Smooth-writing ballpoint pen', 'images/ballpoint_pen_blue.jpg', '2025-07-27 23:44:49', 'Pens'),
(5, 2, 'Gel Pen', 2.00, 180, 'Gel pen with quick-dry ink', 'images/gel_pen_black.jpg', '2025-07-27 23:44:49', 'Pens'),
(6, 2, 'Mechanical Pencil', 2.50, 120, 'Mechanical pencil with ergonomic grip', 'images/mechanical_pencil.jpg', '2025-07-27 23:44:49', 'Pens'),
(7, 5, 'Highlighter Set', 5.00, 90, 'Highlighter set with multiple colors.', 'images/highlighter_set.jpg', '2025-07-27 23:44:49', 'Accessories'),
(8, 5, 'Colored Pencils – 12-Pack', 6.50, 80, 'Set of 12 vibrant colored pencils', 'images/colored_pencils_12.jpg', '2025-07-27 23:44:49', 'Pens'),
(9, 5, 'Marker Set – 8 Colors', 7.00, 85, 'Water-based marker set with 8 colors', 'images/marker_set_8.jpg', '2025-07-27 23:44:49', 'Accessories'),
(10, 5, 'Ruler – 30cm', 1.20, 200, 'Clear plastic 30cm ruler with cm/inch marks', 'images/ruler.jpg', '2025-07-27 23:44:49', 'Accessories'),
(11, 3, 'Backpack with Laptop Compartment', 29.99, 50, 'Durable backpack fits up to 15\" laptop', 'images/backpack_with_laptop_comp.jpg', '2025-07-27 23:44:49', 'Backpacks'),
(12, 5, 'Binder – 3-Ring', 4.50, 100, '3-ring binder with clear front pocket', 'images/binder_3_ring.jpg', '2025-07-27 23:44:49', 'Accessories'),
(13, 5, 'Subject Dividers – 5-Tab', 2.00, 120, 'Pack of 5 subject dividers with tabs', 'images/subject_dividers.jpg', '2025-07-27 23:44:49', 'Accessories'),
(14, 5, 'Sticky Notes – 3x3', 3.00, 150, 'Pack of 100 sticky notes, 3x3 inches', 'images/sticky_notes.jpg', '2025-07-27 23:44:49', 'Accessories'),
(15, 5, 'Eraser Pack', 1.00, 300, 'Pack of 2 soft erasers', 'images/eraser_pack.jpg', '2025-07-27 23:44:49', 'Accessories'),
(16, 5, 'Sharpener – Dual', 1.50, 250, 'Dual sharpener for pencils & colored pencils', 'images/sharpener.jpg', '2025-07-27 23:44:49', 'Pens'),
(17, 5, 'Pencil Case', 8.00, 70, 'Zippered pencil case with two compartments', 'images/pencil_case.jpg', '2025-07-27 23:44:49', 'Pens'),
(18, 5, 'Calculator – Scientific', 15.00, 40, 'Scientific calculator with 240 functions', 'images/scientific_calc.jpg', '2025-07-27 23:44:49', 'Accessories'),
(19, 5, 'Desk Organizer', 12.00, 60, 'Desktop organizer with compartments', 'images/desk_organizer.jpg', '2025-07-27 23:44:49', 'Accessories'),
(20, 5, 'USB Flash Drive – 16GB', 10.00, 90, '16GB USB 3.0 flash drive', 'images/usb_flash.jpg', '2025-07-27 23:44:49', 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE `product_options` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_options`
--

INSERT INTO `product_options` (`id`, `product_id`, `option_id`) VALUES
(1, 11, 1),
(2, 11, 2),
(3, 4, 4),
(4, 4, 1),
(5, 4, 3),
(6, 12, 9),
(7, 12, 4),
(8, 12, 1),
(9, 18, 15),
(10, 18, 16),
(11, 8, 17),
(12, 8, 18),
(13, 2, 25),
(14, 2, 26),
(15, 19, 27),
(16, 19, 28),
(17, 15, 29),
(18, 15, 30),
(19, 5, 1),
(20, 5, 4),
(21, 5, 3),
(22, 3, 21),
(23, 3, 22),
(24, 7, 31),
(25, 7, 32),
(26, 9, 35),
(27, 9, 36),
(28, 6, 23),
(29, 6, 24),
(30, 17, 1),
(31, 17, 4),
(32, 10, 37),
(33, 10, 38),
(34, 16, 33),
(35, 16, 34),
(36, 1, 39),
(37, 1, 40),
(38, 1, 41),
(39, 14, 10),
(40, 14, 7),
(41, 13, 2),
(42, 13, 10),
(43, 20, 19),
(44, 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text DEFAULT NULL,
  `asked_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `answered_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `comment` text DEFAULT NULL,
  `admin_response` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `comment`, `admin_response`, `created_at`, `updated_at`) VALUES
(2, 12, 4, 5, 'love this binder', NULL, '2025-07-28 20:18:48', '2025-07-28 20:19:02'),
(3, 4, 4, 3, 'could be better', NULL, '2025-07-28 20:21:15', '2025-07-28 20:21:15'),
(4, 11, 4, 5, 'compact and durable', 'Thank you for enjoying it!', '2025-07-29 11:19:52', '2025-07-29 12:19:05');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `theme_id` int(11) NOT NULL,
  `theme_name` varchar(50) NOT NULL,
  `css_file` varchar(255) NOT NULL,
  `active_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `role`, `is_active`, `status`, `created_at`) VALUES
(1, 'khamzal', 'admin@schoolstore.com', '$2y$12$fBsmVp8ay.G64qqzf76OhemPCsKXHMpZXBRBWmeJdaHizPLpZbYeq', 'admin', 1, 'active', '2025-07-28 00:51:17'),
(4, 'tony', 'tony@abc.ca', '$2y$10$pgAIoaD5i.MK2bDb0lv3meIb1BvDWfk9NdWeKtE.Mhp/fpZScUCjK', 'customer', 1, 'active', '2025-07-28 19:55:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `monitoring`
--
ALTER TABLE `monitoring`
  ADD PRIMARY KEY (`check_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `option_id` (`option_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`theme_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `monitoring`
--
ALTER TABLE `monitoring`
  MODIFY `check_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `theme_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON UPDATE CASCADE;

--
-- Constraints for table `product_options`
--
ALTER TABLE `product_options`
  ADD CONSTRAINT `product_options_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_options_ibfk_2` FOREIGN KEY (`option_id`) REFERENCES `options` (`option_id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
