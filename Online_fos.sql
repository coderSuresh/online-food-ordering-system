-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 18, 2023 at 01:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Online_fos`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`) VALUES
(1, 'paras', 'parash420', 'b49aabd1514284a48f7277ed25b61cb0');

-- --------------------------------------------------------

--
-- Table structure for table `aos`
--

CREATE TABLE `aos` (
  `aos_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aos`
--

INSERT INTO `aos` (`aos_id`, `order_id`, `status`) VALUES
(43, 51, 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `customer_id`, `food_id`, `quantity`) VALUES
(132, 40, 24, 4),
(134, 40, 22, 1),
(136, 40, 23, 1),
(138, 40, 20, 4),
(147, 41, 24, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `cat_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `image`, `cat_name`) VALUES
(114, 'momo.jpg', 'Momo'),
(115, '1674974608momo.jpg', 'Burgers'),
(116, '1674974554momo.jpg', 'Coffee');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(10) NOT NULL,
  `names` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `provider` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `active` int(1) NOT NULL,
  `otp` varchar(11) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `names`, `username`, `email`, `password`, `provider`, `date`, `status`, `active`, `otp`, `image`, `count`) VALUES
(10, 'milan', 'milan45', 'milan45@gmail.com', '6a2801261a59fb0f75ca9c2e3560fbe3', '', '0000-00-00 00:00:00', 'not verified', 0, '0', '', 0),
(34, 'parash bhandari', 'parash', 'parashbhandari85@gmail.com', '4297f44b13955235245b2497399d7a93', '', '0000-00-00 00:00:00', 'not verified', 0, '0', '', 0),
(37, 'dklfj', 'skjfl', 'jfls@dkfj.adsfj', '4297f44b13955235245b2497399d7a93', '', '0000-00-00 00:00:00', 'not verified', 0, '0', '', 0),
(38, 'Rame', 'rame', 'rame@chor.ho', '78dacb5f238ca3ac3694f7c2114fa69c', '', '0000-00-00 00:00:00', 'not verified', 1, '0', '', 0),
(40, 'Ashish Acharya', 'ashish', 'acashish458@gmail.com', '332b3091416bc4687821c4653f1c6eb1', '', '0000-00-00 00:00:00', 'verified', 0, '978534', '', 0),
(41, 'suresh dahal', NULL, 'dahal4524@gmail.com', NULL, 'google.com', '2023-02-09 18:07:21', 'verified', 1, NULL, 'https://lh3.googleusercontent.com/a/AEdFTp4eqmbn7hywqFqlAJna9S49fO4veKZ_FUz8jQPR=s96-c', 0),
(42, 'suresh dahal', 'suresh', 'sd807141@gmail.com', '3e6a0966890c85a8ca932302ad6a2405', 'email', '2023-02-18 15:34:54', 'not verified', 1, '370724', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `f_id` int(11) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `cost` int(11) NOT NULL,
  `cooking_time` int(11) DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `veg` int(1) NOT NULL,
  `product_id` varchar(30) NOT NULL,
  `short_desc` varchar(50) NOT NULL,
  `ingredients` varchar(255) NOT NULL,
  `disabled` int(11) NOT NULL,
  `special` int(11) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`f_id`, `img`, `name`, `price`, `cost`, `cooking_time`, `description`, `veg`, `product_id`, `short_desc`, `ingredients`, `disabled`, `special`, `category`) VALUES
(19, '1675007250momo.jpg', 'Cheese Burger', 180, 150, 20, 'very delicious cheesy burger', 0, 'bg1', '', '', 1, 0, 114),
(20, 'momo.jpg', 'Chicken Burger', 200, 160, 20, 'This is very delicious chicken burger made from fresh chicken', 0, 'bg2', '', '', 0, 0, 114),
(22, '1675058201momo.jpg', 'Buff Burger', 150, 100, 20, 'this is another description', 0, 'bg2', 'This is not delicious burger sjdkfjl jaldjl', 'these are not the list of ingredients                            ', 0, 1, 115),
(23, '1675063660momo.jpg', 'Espresso', 150, 100, 20, 'Espresso is a kind of coffee with very bad taste. made by using 1kg decayed coffee', 0, 'cf1', 'Espresso is a kind of coffee with very bad taste.', 'coffee\r\nwater\r\ncoffee again\r\nlittle sugar\r\ncoffee again                            ', 0, 0, 116),
(24, '1675066279momo.jpg', 'testnnmn', 400, 200, 10, 'jsdklfjsdalkfjdsafsa\r\ndsfklasdjflksadjflkdsjf\r\nsdfdaskjfsdlkf', 0, 'sdf', 'ajsdlkfjdkfjslkdjfskljflksjdlkfj', 'test\r\ntest1\r\ntest2                                                                                        ', 0, 0, 114),
(25, '1675066384momo.jpg', 'testjs', 200, 100, 10, 'dfghkl', 0, 'skjdfl', 'sdlfkjslkdfjsdkjfdlkjflskdjfldsjflksjdlfjsldkf', 'h\r\nh\r\nh\r\n', 1, 0, 114),
(26, '1675073155momo.jpg', 'Cappuccino', 200, 100, 12, 'ashdfsjdfhkajdshfksdhfsdfsadfasdfsd', 0, 'sdjfl', 'dfkdsjflsadjflsdflasdjfklasjksjdfff ffffffffffffff', 'coffee\r\nwater\r\ncoffee again\r\nlittle sugar\r\ncoffee again                                                                                                                                            ', 0, 1, 116),
(27, '1675144473momo.jpg', 'test food', 455, 200, 15, 'ksjdlfkjds\r\nfsdfsdf\r\ndsfsdjfdslfs dkjfkdsjfkdsjfldskjf kldsjflsdfjsdlkfjsldsd', 0, 'fsd54', 'this is very short description', 'ek\r\nzero\r\ndui\r\ntin\r\nchar\r\npanch\r\nxa\r\nsat\r\naath                                                                                                                ', 0, 1, 114);

-- --------------------------------------------------------

--
-- Table structure for table `kos`
--

CREATE TABLE `kos` (
  `kos_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kos`
--

INSERT INTO `kos` (`kos_id`, `order_id`, `status`) VALUES
(2, 51, 'rejected');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `total_price` int(10) NOT NULL,
  `note` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `c_id`, `qty`, `f_id`, `total_price`, `note`, `date`) VALUES
(51, 41, 2, 26, 452, 'No note', '2023-02-18 17:57:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_contact_details`
--

CREATE TABLE `order_contact_details` (
  `o_c_id` int(11) NOT NULL,
  `o_id` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `c_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_contact_details`
--

INSERT INTO `order_contact_details` (`o_c_id`, `o_id`, `address`, `phone`, `c_name`) VALUES
(45, 51, 'Mangsebung, Ilam', '9845241253', 'Suresh Dahal');

-- --------------------------------------------------------

--
-- Table structure for table `reject_reason`
--

CREATE TABLE `reject_reason` (
  `o_r_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rejected_by` varchar(10) NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reject_reason`
--

INSERT INTO `reject_reason` (`o_r_id`, `order_id`, `rejected_by`, `reason`) VALUES
(1, 51, 'kitchen', 'Your order has been rejected for testing purpose');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aos`
--
ALTER TABLE `aos`
  ADD PRIMARY KEY (`aos_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `cat_id` (`category`);

--
-- Indexes for table `kos`
--
ALTER TABLE `kos`
  ADD PRIMARY KEY (`kos_id`),
  ADD KEY `order_id_k` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_id` (`c_id`),
  ADD KEY `f_id` (`f_id`);

--
-- Indexes for table `order_contact_details`
--
ALTER TABLE `order_contact_details`
  ADD PRIMARY KEY (`o_c_id`),
  ADD KEY `o_id` (`o_id`);

--
-- Indexes for table `reject_reason`
--
ALTER TABLE `reject_reason`
  ADD PRIMARY KEY (`o_r_id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `aos`
--
ALTER TABLE `aos`
  MODIFY `aos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `kos`
--
ALTER TABLE `kos`
  MODIFY `kos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `order_contact_details`
--
ALTER TABLE `order_contact_details`
  MODIFY `o_c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `reject_reason`
--
ALTER TABLE `reject_reason`
  MODIFY `o_r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aos`
--
ALTER TABLE `aos`
  ADD CONSTRAINT `order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `food_id` FOREIGN KEY (`food_id`) REFERENCES `food` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `cat_id` FOREIGN KEY (`category`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kos`
--
ALTER TABLE `kos`
  ADD CONSTRAINT `order_id_k` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `c_id` FOREIGN KEY (`c_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `f_id` FOREIGN KEY (`f_id`) REFERENCES `food` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_contact_details`
--
ALTER TABLE `order_contact_details`
  ADD CONSTRAINT `o_id` FOREIGN KEY (`o_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reject_reason`
--
ALTER TABLE `reject_reason`
  ADD CONSTRAINT `reject_reason_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
