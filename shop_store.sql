-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2021 at 01:39 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `categor`
--

CREATE TABLE `categor` (
  `ID` int(11) NOT NULL,
  `thename` varchar(255) NOT NULL,
  `deck` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT 0,
  `comment` int(11) NOT NULL DEFAULT 0,
  `ads` int(11) NOT NULL DEFAULT 0,
  `parent` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categor`
--

INSERT INTO `categor` (`ID`, `thename`, `deck`, `ordering`, `visible`, `comment`, `ads`, `parent`) VALUES
(1, 'IPHONE', 'this is parent category', 0, 0, 0, 0, 0),
(2, 'iphone 6', 'this is iphone before 2010', 1, 0, 1, 0, 1),
(3, 'labtop', 'this is section of laptop', 2, 1, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `com_data` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `mem_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`com_id`, `comment`, `status`, `com_data`, `item_id`, `mem_id`) VALUES
(1, 'can you send me some image of iphone', 1, '2020-10-03', 1, 1),
(2, 'can you send me more details', 1, '2020-10-03', 3, 1),
(3, 'plz!\r\nsend me in my email\r\nmahmoud@gmail.com', 1, '2020-10-03', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desk` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `country_made` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `approv` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ID`, `name`, `desk`, `price`, `add_date`, `country_made`, `status`, `cate_id`, `member_id`, `tag`, `approv`) VALUES
(1, 'iphone 6plus', 'this is phone from apple', 180, '2020-10-03', 'EGY', 2, 1, 1, 'iphone, games, apple', 1),
(2, 'PS4 sony', 'this is for PS4 Gaming and popular gaming', 300, '2020-10-03', 'USA', 3, 1, 1, 'online,games', 1),
(3, 'dell g5 ', 'this is the newest but this is very expensive', 500, '2020-10-03', 'jaban', 1, 3, 2, 'labtop,gaming', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Fullname` varchar(255) NOT NULL,
  `regstatus` int(11) NOT NULL DEFAULT 0,
  `history` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `groupID` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `pass`, `email`, `Fullname`, `regstatus`, `history`, `image`, `groupID`) VALUES
(1, 'mahmoud', '123', 'mahmoud@gmail.com', 'mahmoud khairy', 1, '2020-10-03', '', 1),
(2, 'hassan', '123', 'has@gmail.com', 'hassan ahmed', 1, '0000-00-00', '15871_82023737_179585280083881_2339355097131122688_o.jpg', 0),
(3, 'elzero', '123', 'elsham@gmail.com', 'elzero school', 1, '0000-00-00', '25190_105192304_257803415521227_7079920541731668317_n.jpg', 0),
(4, 'medhat', '123', 'med@gmail.com', 'medhat ail', 1, '2020-10-03', '9634_84400298_180123879968778_2240845400812552192_n.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categor`
--
ALTER TABLE `categor`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `thename` (`thename`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`),
  ADD UNIQUE KEY `comment` (`comment`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `mem_id` (`mem_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `items_ibfk_1` (`member_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categor`
--
ALTER TABLE `categor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`mem_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
