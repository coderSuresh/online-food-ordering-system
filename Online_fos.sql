-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 21, 2023 at 12:19 PM
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
  `status` varchar(15) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aos`
--

INSERT INTO `aos` (`aos_id`, `order_id`, `status`, `date`) VALUES
(125, 135, 'delivered', '2023-02-23 20:52:14'),
(126, 136, 'delivered', '2023-02-23 20:57:41'),
(127, 137, 'rejected', '2023-02-23 21:25:07'),
(128, 138, 'delivered', '2023-02-23 21:25:43'),
(129, 139, 'delivered', '2023-02-23 21:26:33'),
(130, 140, 'delivered', '2023-02-26 14:06:21'),
(132, 142, 'rejected', '2023-02-26 15:32:48'),
(133, 143, 'delivered', '2023-02-26 15:32:48'),
(134, 144, 'delivered', '2023-02-26 16:15:49'),
(135, 145, 'rejected', '2023-03-05 10:46:37'),
(137, 147, 'prepared', '2023-03-09 17:23:39'),
(138, 148, 'prepared', '2023-03-09 17:23:39'),
(139, 149, 'delivered', '2023-03-09 21:56:15'),
(141, 151, 'delivered', '2023-03-17 11:33:15'),
(146, 156, 'prepared', '2023-03-17 14:58:10'),
(147, 157, 'prepared', '2023-03-17 14:58:10'),
(148, 158, 'prepared', '2023-03-17 14:58:10'),
(149, 159, 'pending', '2023-03-17 20:56:41'),
(150, 160, 'pending', '2023-03-17 20:56:41'),
(151, 161, 'pending', '2023-03-17 20:56:41'),
(152, 162, 'accepted', '2023-03-19 13:43:30'),
(153, 163, 'accepted', '2023-03-19 13:43:30'),
(154, 164, 'accepted', '2023-03-19 13:43:30'),
(155, 165, 'accepted', '2023-03-19 13:43:30'),
(156, 166, 'pending', '2023-03-19 17:30:05'),
(157, 167, 'pending', '2023-03-19 17:30:05');

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
(170, 45, 39, 1),
(171, 45, 40, 1),
(172, 45, 44, 1),
(173, 46, 31, 2),
(174, 46, 39, 1),
(175, 46, 40, 1),
(183, 46, 44, 1),
(198, 41, 44, 4),
(199, 42, 40, 1);

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
(115, 'burger.jpg', 'Burger'),
(120, 'pizza.jpg', 'Pizza');

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
  `provider` varchar(50) DEFAULT NULL,
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
(10, 'milan', 'milan45', 'milan45@gmail.com', '6a2801261a59fb0f75ca9c2e3560fbe3', '', '0000-00-00 00:00:00', 'not verified', 1, '225001', '', 0),
(34, 'parash bhandari', 'parash', 'parashbhandari85@gmail.com', '4297f44b13955235245b2497399d7a93', '', '0000-00-00 00:00:00', 'not verified', 1, '225001', '', 0),
(37, 'dklfj', 'skjfl', 'jfls@dkfj.adsfj', '4297f44b13955235245b2497399d7a93', '', '0000-00-00 00:00:00', 'not verified', 0, '225001', '', 0),
(38, 'Rame', 'rame', 'rame@chor.ho', '78dacb5f238ca3ac3694f7c2114fa69c', '', '0000-00-00 00:00:00', 'not verified', 0, '225001', '', 0),
(40, 'Ashish Acharya', 'ashish', 'acashish458@gmail.com', '332b3091416bc4687821c4653f1c6eb1', '', '0000-00-00 00:00:00', 'verified', 1, '225001', '', 0),
(41, 'suresh dahal', 'suresh', 'dahal4524@gmail.com', '3e6a0966890c85a8ca932302ad6a2405', 'google.com', '2023-02-09 18:07:21', 'verified', 1, '0', 'https://lh3.googleusercontent.com/a/AEdFTp4eqmbn7hywqFqlAJna9S49fO4veKZ_FUz8jQPR=s96-c', 0),
(42, 'suresh dahal', 'suresh', 'sd807141@gmail.com', '3e6a0966890c85a8ca932302ad6a2405', 'email', '2023-02-18 15:34:54', 'verified', 1, '0', NULL, 0),
(43, 'Suresh Dahal', NULL, 'itsureshdahal@gmail.com', NULL, 'google.com', '2023-02-19 13:45:31', 'verified', 1, '225001', 'https://lh3.googleusercontent.com/a/AEdFTp4RIDKQ7PaRgFvQR1ah3Hmu_4PgcJ6c3FSHBBZA=s96-c', 0),
(44, 'suresh dahal', 'sureshdahal', 'carepc49@gmail.com', '332b3091416bc4687821c4653f1c6eb1', 'email', '2023-02-26 14:27:07', 'verified', 1, '225001', NULL, 0),
(45, 'Bibek Mahat', 'mahat', 'mahat6981@gmail.com', 'de58bc546778fe4bae8ede6a094bca0c', 'email', '2023-03-12 15:32:24', 'verified', 1, '225001', NULL, 0),
(46, 'Parash', 'Hero01', 'shaktishiv209@gmail.com', '33ec856129f7ec4de61221a67917d334', 'email', '2023-03-14 18:51:53', 'verified', 1, '225001', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `department` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `department`) VALUES
(1, 'kitchen'),
(2, 'delivery');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `department` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `name`, `department`, `email`, `username`, `password`, `image`, `active`) VALUES
(1, 'Ashika Dulal', 1, 'dulalashika@protonmail.com', 'chef_ashika', '3495a890e500304ce83fc28b928c5269', '/uploads/employees/ashika.jpg', 1),
(2, 'Suresh Dahal', 2, 'dahalsuresh@gmail.com', 'suresh', '3495a890e500304ce83fc28b928c5269', '/uploads/employees/suresh.jpg', 0),
(3, 'Adip Sharma', 2, 'adip@gmail.com', 'adip', '332b3091416bc4687821c4653f1c6eb1', '../../../uploads/employees/momo.jpg', 1),
(5, 'sjflka f', 2, 'sdfjl@jsdlf.sdf', 'sdlfjsd', '5abb790b7f72e0dc9297698ebebe8336', '1679198895logo.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `f_id` int(11) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `cooking_time` int(11) DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `veg` int(1) NOT NULL,
  `product_id` varchar(30) NOT NULL,
  `short_desc` varchar(50) NOT NULL,
  `ingredients` varchar(500) NOT NULL,
  `disabled` int(11) NOT NULL,
  `special` int(11) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`f_id`, `img`, `name`, `price`, `cooking_time`, `description`, `veg`, `product_id`, `short_desc`, `ingredients`, `disabled`, `special`, `category`) VALUES
(31, 'veg c momo.jpg', 'Veg C Momo', 150, 20, 'C momo or Si Momo is regular momo dipped in a hot and spicy sauce. C momo is good for people willing to try hot chili pepper. Special type of vegetable sauce with lot of hot chili peppers is prepared. When momo and soup are cooked well, both are put together in a bowl and served hot.', 1, 'vcm', 'Try this spicy veg c momo from RestroHub', 'Tomatoes\r\nSesame seed (teel)\r\nBell Pepper\r\nGreen Chilies\r\nGarlic \r\nCoriander\r\nFlour\r\nVegetables\r\nSalt                                                                                    ', 0, 1, 114),
(32, 'buff burger.jpg', 'Buff Burger', 160, 20, 'This juicy buff burger is made with a perfectly cooked patty that\'s loaded with flavor. Topped with melted cheese, fresh lettuce, and other classic burger toppings, this sandwich is sure to satisfy your cravings for something hearty and delicious.', 0, 'bb', 'Juicy buff patty with melted cheese', 'buff patty\r\ncheese\r\nlettuce\r\ntomato\r\nonion\r\npickles\r\nbun                            ', 0, 0, 115),
(33, 'burger.jpg', 'Veg Burger', 140, 20, 'If you\'re looking for a meatless option, this veggie burger is the perfect choice. Made with a flavorful and hearty patty made from vegetables, grains, and other plant-based ingredients, this sandwich is both healthy and delicious. Topped with fresh veggies and your choice of sauce, it\'s the perfect choice for vegetarians and meat-eaters alike.', 1, 'vb', 'Delicious meatless option with veggies', 'veggie patty \r\nlettuce\r\ntomato\r\nonion\r\npickles\r\nbun', 0, 0, 115),
(34, 'chicken burger.jpg', 'Chicken Burger', 160, 20, ' Crispy and flavorful, this chicken burger is sure to satisfy your cravings for something savory and delicious. Made with a crispy chicken patty, fresh lettuce, and other classic burger toppings, this sandwich is perfect for lunch or dinner', 0, 'cb', 'Crispy chicken with fresh lettuce', 'chicken patty\r\nlettuce\r\ntomato\r\nonion\r\npickles\r\nbun', 0, 0, 115),
(35, 'veg momo.jpg', 'Veg Momo', 100, 20, 'These healthy and delicious steamed dumplings are made with a flavorful vegetable filling. The tender, doughy exterior is the perfect complement to the savory and spicy filling, making these dumplings a popular snack in many Asian countries.', 1, 'vm', 'Healthy steamed dumplings with veggies', 'flour and water\r\nveggies (such as cabbage, carrots, and onions)\r\nspices (such as ginger, garlic, and cumin).', 0, 0, 114),
(36, 'veg fried momo.jpg', 'Veg Fried Momo', 120, 25, 'For those who love crispy, fried food, these veggie dumplings are the perfect choice. The savory and spicy filling is encased in a crispy, golden-brown exterior that\'s sure to satisfy your cravings for something crunchy and delicious.', 1, 'vfm', 'Crispy, fried veggie dumplings', 'flour and water\r\nveggies (such as cabbage, carrots, and onions)\r\nspices (such as ginger, garlic, and cumin).', 0, 0, 114),
(37, 'momo.jpg', 'Buff Momo', 110, 20, 'Made with a savory buff filling and a tender, doughy exterior, these steamed buff dumplings are a popular snack in many Asian countries. The rich and flavorful buff filling is the perfect complement to the soft and chewy dough, making these dumplings a delicious and satisfying snack.', 0, 'bm', 'Savory buff filling in a soft shell.', 'flour and water\r\nBuff keema\r\nveggies (such as cabbage, carrots, and onions)\r\nspices (such as ginger, garlic, and cumin).                ', 0, 0, 114),
(38, 'buff c momo.jpg', 'Buff C Momo', 160, 25, 'For a rich and creamy twist on classic buff dumplings, try these buff and cheese dumplings. The cheesy filling adds a luxurious and creamy flavor to the already savory buff filling, making these dumplings a popular choice for those who love the taste of cheese.', 0, 'bcm', 'Rich buff and cheese filling.', 'flour and water\r\nBuff keema\r\nveggies (such as cabbage, carrots, and onions)\r\nspices (such as ginger, garlic, and cumin).                                                                                         ', 0, 0, 114),
(39, 'buff fried momo.jpg', 'Buff Fried Momo', 140, 25, 'These deep-fried buff dumplings are the perfect choice for those who love crispy, fried food. The savory and spicy buff filling is encased in a crispy, golden-brown exterior, making these dumplings a delicious and satisfying snack.', 0, 'bfm', 'Deep-fried buff dumplings', 'flour and water\r\nBuff keema\r\nveggies (such as cabbage, carrots, and onions)', 0, 1, 114),
(40, 'crunchy chicken burger.jpg', 'Crunchy Chicken Burger', 180, 25, 'Sink your teeth into our delicious crunchy fried chicken burger! Made with a crispy fried chicken patty that\'s made from juicy chicken breast coated in a flavorful blend of flour, eggs, bread crumbs, and spices. Served on a soft bun and topped with fresh lettuce, juicy tomato slices, crunchy onion, and tangy pickles, this burger is a feast for your taste buds. Perfect for a quick lunch or dinner, our crunchy fried chicken burger is sure to satisfy your cravings!', 0, 'ccb', 'Crispy fried chicken on a bun.', 'fried chicken patty (made with chicken breast, flour, eggs, bread crumbs, and spices)\r\nlettuce\r\ntomato\r\nonion\r\npickles\r\nbun', 0, 1, 115),
(41, 'Margherita.jpg', 'Margherita Pizza', 340, 20, ' A classic Italian pizza with tangy tomato sauce, melty slices of creamy mozzarella cheese, and fragrant basil leaves.', 1, 'mp', 'Classic pizza with tomato, mozzarella, and basil', 'tomato sauce\r\nmozzarella cheese\r\nbasil leaves                            ', 0, 0, 120),
(42, 'pepperoni.jpg', 'Pepperoni Pizza', 350, 25, 'A pizza topped with tangy tomato sauce, melty mozzarella cheese, and slices of spicy pepperoni sausage.', 0, 'pp', 'Pizza with tomato, mozzarella, and pepperoni.', 'tomato sauce \r\nmozzarella cheese \r\npepperoni sausage                                             ', 0, 0, 120),
(43, 'Hawaiian pizza.jpg', 'Hawaiian Pizza', 400, 20, 'A pizza with sweet pineapple, savory ham, and melty mozzarella cheese, all topped with tangy tomato sauce.', 0, 'hp', 'Pizza with ham, pineapple, and mozzarella.', 'tomato sauce\r\nmozzarella cheese\r\nham\r\npineapple                            ', 0, 0, 120),
(44, 'Meat lovers pizza.jpg', 'Meat Lovers Pizza', 400, 25, 'A pizza piled high with tangy tomato sauce, melty mozzarella cheese, and a variety of savory meats including pepperoni, Italian sausage, bacon, and ham.', 0, 'mlp', 'Pizza loaded with meat and cheese.', 'tomato sauce\r\nmozzarella cheese\r\npepperoni sausage\r\nItalian sausage\r\nbacon\r\nham                                                                                                                ', 0, 1, 120),
(48, '1677410877pepperoni.jpg', 'Cheese Burger', 150, 10, 'ajsdf ljalsdkfj las f', 1, 'bf123', 'asljf asdjfl asjfl asjlkj', 'sadfads\r\nfsadf\r\nsad\r\nf\r\nsadf\r\nsadf                            ', 0, 0, 115);

-- --------------------------------------------------------

--
-- Table structure for table `kos`
--

CREATE TABLE `kos` (
  `kos_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(15) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kos`
--

INSERT INTO `kos` (`kos_id`, `order_id`, `status`, `date`) VALUES
(58, 151, 'pending', '2023-03-17 11:33:41'),
(63, 156, 'pending', '2023-03-17 18:00:23'),
(64, 157, 'pending', '2023-03-17 18:00:23'),
(65, 158, 'pending', '2023-03-17 18:00:23'),
(66, 156, 'pending', '2023-03-17 18:09:59'),
(67, 157, 'pending', '2023-03-17 18:09:59'),
(68, 158, 'pending', '2023-03-17 18:09:59'),
(69, 164, 'pending', '2023-03-19 13:45:22'),
(70, 163, 'pending', '2023-03-19 13:45:22'),
(71, 162, 'pending', '2023-03-19 13:45:22'),
(72, 165, 'pending', '2023-03-19 13:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `nl_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`nl_id`, `c_id`, `email`, `date`) VALUES
(1, 41, 'dahal4524@gmail.com', '2023-03-20 12:01:59'),
(2, 42, 'sd807141@gmail.com', '2023-03-20 13:24:36');

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
(135, 41, 1, 42, 396, 'No note', '2023-02-23 20:52:14'),
(136, 41, 2, 43, 904, 'No note', '2023-02-23 20:57:41'),
(137, 41, 2, 39, 316, 'No note', '2023-02-23 21:25:07'),
(138, 41, 2, 39, 316, 'No note', '2023-02-23 21:25:43'),
(139, 41, 2, 39, 316, 'No note', '2023-02-23 21:26:33'),
(140, 41, 2, 40, 407, 'No note', '2023-02-26 14:06:21'),
(141, 41, 2, 44, 904, 'No note', '2023-02-26 15:32:48'),
(142, 41, 1, 39, 158, 'No note', '2023-02-26 15:32:48'),
(143, 41, 1, 40, 203, 'No note', '2023-02-26 15:32:48'),
(144, 41, 1, 39, 158, 'jdlksjflaj', '2023-02-26 16:15:49'),
(145, 41, 1, 31, 170, 'chado chayo lastai vok lagyo ', '2023-03-05 10:46:37'),
(147, 41, 1, 37, 124, 'No note', '2023-03-09 17:23:39'),
(148, 41, 1, 39, 158, 'No note', '2023-03-09 17:23:39'),
(149, 44, 1, 40, 203, 'No note', '2023-03-09 21:56:15'),
(151, 41, 2, 39, 316, 'No note', '2023-03-17 11:33:15'),
(156, 44, 1, 44, 452, 'No note', '2023-03-17 14:58:10'),
(157, 44, 1, 37, 124, 'No note', '2023-03-17 14:58:10'),
(158, 44, 1, 36, 136, 'No note', '2023-03-17 14:58:10'),
(159, 44, 1, 31, 170, 'No note', '2023-03-17 20:56:41'),
(160, 44, 1, 39, 158, 'No note', '2023-03-17 20:56:41'),
(161, 44, 1, 40, 203, 'No note', '2023-03-17 20:56:41'),
(162, 41, 1, 40, 203, 'No note', '2023-03-19 13:43:30'),
(163, 41, 1, 39, 158, 'No note', '2023-03-19 13:43:30'),
(164, 41, 1, 31, 170, 'No note', '2023-03-19 13:43:30'),
(165, 41, 1, 44, 452, 'No note', '2023-03-19 13:43:30'),
(166, 41, 1, 43, 452, 'No note', '2023-03-19 17:30:05'),
(167, 41, 1, 40, 203, 'No note', '2023-03-19 17:30:05');

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
(129, 135, 'sfjlk asjdflk sj flkas jdflak', '9800000000', 'dfkal dsjfalk jfksl j'),
(130, 136, 'sajdflk asj lfkas', '9800000000', 'asdhf jashd fkj'),
(131, 137, 'chardobato, banepa', '9800000000', 'Suresh Dahal'),
(132, 138, 'lkjsdlfk jaslkjdsl', '9800000000', 'sdkfjl asj'),
(133, 139, 'ksdjf lkajlfk', '9800000000', 'Suresh Dahal'),
(134, 140, 'sjkfjsljfal jlj', '9800000000', 'sdkf jal'),
(135, 141, 'chardobato banepa', '9845215362', 'suresh dahal'),
(136, 142, 'chardobato banepa', '9845215362', 'suresh dahal'),
(137, 143, 'chardobato banepa', '9845215362', 'suresh dahal'),
(138, 144, 'aldfjaksjdflk akjsdflajl ', '9800000000', 'Suresh Dahal'),
(139, 145, 'lokanthali', '9803637795', 'Shuvam Sharma'),
(141, 147, 'khai kata ho kata', '9814524752', 'Suresh Dahal'),
(142, 148, 'khai kata ho kata', '9814524752', 'Suresh Dahal'),
(143, 149, 'Khamba Gaadeko Thau Maa ', '9845725142', 'Khai ko ho'),
(145, 151, 'djf lasjdkf jadslfj ', '9800000000', 'Suresh'),
(150, 156, 'suresh ko ghar', '9800000000', 'Suresh Dahal'),
(151, 157, 'suresh ko ghar', '9800000000', 'Suresh Dahal'),
(152, 158, 'suresh ko ghar', '9800000000', 'Suresh Dahal'),
(153, 159, 'djsflksdj flksjd lfj', '9800000000', 'jkhk jhkj'),
(154, 160, 'djsflksdj flksjd lfj', '9800000000', 'jkhk jhkj'),
(155, 161, 'djsflksdj flksjd lfj', '9800000000', 'jkhk jhkj'),
(156, 162, 'xwxwsx', '023233333', 'sxswxsw'),
(157, 163, 'xwxwsx', '023233333', 'sxswxsw'),
(158, 164, 'xwxwsx', '023233333', 'sxswxsw'),
(159, 165, 'xwxwsx', '023233333', 'sxswxsw'),
(160, 166, 'sjdkf jsakldfj sa', '9800000000', 'safd fjlksa j'),
(161, 167, 'sjdkf jsakldfj sa', '9800000000', 'safd fjlksa j');

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
(18, 137, 'kitchen', 'just for testing purpose'),
(19, 142, 'kitchen', 'item not available'),
(20, 145, 'admin', 'this order was placed for fun'),
(21, 145, 'kitchen', 'Hya, tiktok herira bela kasle momo banune. Reject gardinxu');

-- --------------------------------------------------------

--
-- Table structure for table `to_be_delivered`
--

CREATE TABLE `to_be_delivered` (
  `tbd_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `department` (`department`);

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
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`nl_id`),
  ADD KEY `cus_id` (`c_id`);

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
-- Indexes for table `to_be_delivered`
--
ALTER TABLE `to_be_delivered`
  ADD PRIMARY KEY (`tbd_id`),
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
  MODIFY `aos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `kos`
--
ALTER TABLE `kos`
  MODIFY `kos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `nl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `order_contact_details`
--
ALTER TABLE `order_contact_details`
  MODIFY `o_c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `reject_reason`
--
ALTER TABLE `reject_reason`
  MODIFY `o_r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `to_be_delivered`
--
ALTER TABLE `to_be_delivered`
  MODIFY `tbd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`department`) REFERENCES `department` (`dept_id`);

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
-- Constraints for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD CONSTRAINT `cus_id` FOREIGN KEY (`c_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Constraints for table `to_be_delivered`
--
ALTER TABLE `to_be_delivered`
  ADD CONSTRAINT `to_be_delivered_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
