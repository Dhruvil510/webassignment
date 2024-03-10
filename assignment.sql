-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2024 at 11:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_data`
--

CREATE TABLE `cart_data` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantities` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_data`
--

INSERT INTO `cart_data` (`id`, `product_id`, `quantities`, `user_id`) VALUES
(2, 3, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `comment_data`
--

CREATE TABLE `comment_data` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `ratings` int(10) NOT NULL,
  `product_images` varchar(191) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment_data`
--

INSERT INTO `comment_data` (`id`, `product_id`, `user_id`, `ratings`, `product_images`, `text`) VALUES
(4, 1, 1, 4, 'https://www.ebay.ca/itm/373767262386', 'Best brand for suit');

-- --------------------------------------------------------

--
-- Table structure for table `order_data`
--

CREATE TABLE `order_data` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `quantities` int(10) NOT NULL,
  `totalAmount` int(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_data`
--

INSERT INTO `order_data` (`id`, `product_id`, `user_id`, `quantities`, `totalAmount`) VALUES
(2, 2, 2, 6, 80);

-- --------------------------------------------------------

--
-- Table structure for table `product_data`
--

CREATE TABLE `product_data` (
  `id` int(10) NOT NULL,
  `product_description` varchar(191) NOT NULL,
  `product_image` varchar(191) NOT NULL,
  `product_pricing` int(10) NOT NULL,
  `product_shippingCost` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_data`
--

INSERT INTO `product_data` (`id`, `product_description`, `product_image`, `product_pricing`, `product_shippingCost`) VALUES
(1, 'Red suit', 'https://www.ebay.ca/itm/373767262386', 100, 15),
(3, 'New Launched suit', 'https://unsplash.com/photos/man-in-black-suit-jacket-and-black-sunglasses-Uw3OfKz2J-0', 120, 9);

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int(10) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `username` varchar(191) NOT NULL,
  `purchaseHistory` varchar(191) NOT NULL,
  `shippingAddress` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `email`, `password`, `username`, `purchaseHistory`, `shippingAddress`) VALUES
(1, 'dhruvilpatel@gmail.com', 'das456', 'dhruvilpatel', 'Yes', 'Timberlane Kitchener, Ontario'),
(3, 'kevin@gmail.com', 'kevin789', 'kevin', 'Yes', 'Lester, oshwa, Ontario');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_data`
--
ALTER TABLE `cart_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment_data`
--
ALTER TABLE `comment_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_data`
--
ALTER TABLE `order_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_data`
--
ALTER TABLE `product_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_data`
--
ALTER TABLE `cart_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comment_data`
--
ALTER TABLE `comment_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_data`
--
ALTER TABLE `order_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_data`
--
ALTER TABLE `product_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
