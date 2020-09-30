-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2018 at 06:43 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wdv341`
--

-- --------------------------------------------------------

--
-- Table structure for table `wdv341_event`
--

-- CREATE TABLE `wdv341_event` (
--  `event_id` int(11) NOT NULL,
--  `event_name` varchar(200) NOT NULL,
--  `event_description` varchar(300) NOT NULL,
--  `event_presenter` varchar(200) NOT NULL,
--  `event_date` date NOT NULL,
--  `event_time` time NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wdv341_event`
--

INSERT INTO `wdv341_events` (`event_id`, `event_name`, `event_description`, `event_presenter`, `event_date`, `event_time`) VALUES
(4, 'WDV341 Intro PHP', 'Learning how to use and work with PHP', 'Jeff Gullion', '2018-10-25', '00:00:00'),
(5, 'WDV321 Advanced Javascript', 'Discusses JQuery and other Javascript applications.', 'Jasmine Francois', '2019-01-20', '00:00:00'),
(6, 'WDV321 Advanced Javascript', 'Discusses JQuery and other Javascript applications.', 'Ikea Javas', '2018-09-20', '00:00:00'),
(7, 'WDV321 Advanced Javascript', 'Discusses JQuery and other Javascript applications.', 'Chuck Partners', '2018-09-20', '00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wdv341_event`
--
ALTER TABLE `wdv341_events`
  ADD PRIMARY KEY (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wdv341_event`
--
ALTER TABLE `wdv341_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
