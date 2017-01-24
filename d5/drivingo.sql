-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 24, 2017 at 08:08 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drivingo`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_act`
--

CREATE TABLE `email_act` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `key` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_act`
--

INSERT INTO `email_act` (`id`, `email`, `type`, `key`) VALUES
(20, 'sa4420@gmail.com', 'user', 'a8e864d04c95572d1aece099af852d0a'),
(26, 'sarangkartikey50@gmail.com', 'd_school', 'b9228e0962a78b84f3d5d92f4faa000b'),
(27, 'sweetanirudhgupta@gmail.com', 'd_school', '788d986905533aba051261497ecffcbb'),
(28, 'panakajmeena@gmail.com', 'd_school', '3c7781a36bcd6cf08c11a970fbe0e2a6'),
(29, 'manojitpaul@gmail.com', 'd_school', '9f53d83ec0691550f7d2507d57f4f5a2'),
(30, 'kkpp@gmail.com', 'd_school', 'cedebb6e872f539bef8c3f919874e9d7'),
(31, 'kkpp@gmail.com', 'd_school', '9461cce28ebe3e76fb4b931c35a169b0'),
(32, 'saurabh@gmail.com', 'd_school', 'cfcd208495d565ef66e7dff9f98764da');

-- --------------------------------------------------------

--
-- Table structure for table `fb_schools`
--

CREATE TABLE `fb_schools` (
  `id` int(11) NOT NULL,
  `fbId` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `school_name` varchar(500) NOT NULL,
  `about` varchar(500) NOT NULL,
  `address` varchar(500) NOT NULL,
  `about_owner` varchar(500) NOT NULL,
  `services` varchar(200) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `authorized` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fb_schools`
--

INSERT INTO `fb_schools` (`id`, `fbId`, `name`, `email`, `gender`, `image`, `phone`, `school_name`, `about`, `address`, `about_owner`, `services`, `lat`, `lng`, `authorized`) VALUES
(5, '1203816219712229', 'Sarfraz Ahmad', 'sa4420@gmail.com', 'male', 'https://graph.facebook.com/1203816219712229/picture?width=300', '43', 'sdfg', 'sdfg', 'gtb nagar, new delhi', '', 'SUVS/TRAINING/LICENSE', 28.697838, 77.206947, 2),
(6, '1251165524961462', 'Sarang Kartikey', 'sarangkartikey50@gmail.com', 'male', 'https://graph.facebook.com/1251165524961462/picture?width=300', 'dsga', 'asdg', 'asgd', 'narela, delhi', '', 'SUVS/TRUCKS/TRAINING/LICENSE/STUNT', 28.853960, 77.091782, 2);

-- --------------------------------------------------------

--
-- Table structure for table `fb_users`
--

CREATE TABLE `fb_users` (
  `id` int(11) NOT NULL,
  `fbId` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fb_users`
--

INSERT INTO `fb_users` (`id`, `fbId`, `name`, `email`, `gender`, `image`, `phone`) VALUES
(7, '1251165524961462', 'Sarang Kartikey', 'sarangkartikey50@gmail.com', 'male', 'https://graph.facebook.com/1251165524961462/picture?width=300', '8962636894'),
(8, '1203816219712229', 'Sarfraz Ahmad', 'sa4420@gmail.com', 'male', 'https://graph.facebook.com/1203816219712229/picture?width=300', '4325443562');

-- --------------------------------------------------------

--
-- Table structure for table `g_schools`
--

CREATE TABLE `g_schools` (
  `id` int(11) NOT NULL,
  `oauth_provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `school_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `about_owner` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `services` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `authorized` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `g_schools`
--

INSERT INTO `g_schools` (`id`, `oauth_provider`, `oauth_uid`, `first_name`, `last_name`, `email`, `gender`, `locale`, `picture`, `link`, `created`, `modified`, `phone`, `school_name`, `about`, `address`, `about_owner`, `services`, `lat`, `lng`, `authorized`) VALUES
(7, 'google', '108403709690928436359', 'Sarang', 'Kartikey', 'sarangkartikey50@gmail.com', '', 'en', 'https://lh3.googleusercontent.com/-WKLeZcKOpvg/AAAAAAAAAAI/AAAAAAAAGao/5r95ot8xa7o/photo.jpg', '', '2017-01-24 19:55:24', '2017-01-24 19:55:24', '6565', 'jjjjjjj', 'jjjjjjjj', 'new delhi', '', 'CARS/TRAINING/LICENSE', 28.613939, 77.209023, 2);

-- --------------------------------------------------------

--
-- Table structure for table `g_users`
--

CREATE TABLE `g_users` (
  `id` int(11) NOT NULL,
  `oauth_provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `g_users`
--

INSERT INTO `g_users` (`id`, `oauth_provider`, `oauth_uid`, `first_name`, `last_name`, `email`, `gender`, `locale`, `picture`, `link`, `created`, `modified`, `phone`) VALUES
(1, 'google', '108403709690928436359', 'Sarang', 'Kartikey', 'sarangkartikey50@gmail.com', '', 'en', 'https://lh3.googleusercontent.com/-WKLeZcKOpvg/AAAAAAAAAAI/AAAAAAAAGao/5r95ot8xa7o/photo.jpg', '', '2017-01-23 19:37:36', '2017-01-23 20:41:52', '7011267805'),
(2, 'google', '104992405407602986625', 'learn', 'drive', 'learn2drive02@gmail.com', '', 'en', 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', '', '2017-01-23 20:35:40', '2017-01-23 20:35:40', '34565'),
(3, 'google', '107893797756590287435', 'sarang', 'kartikey', '141100009@nitdelhi.ac.in', '', 'en', 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', '', '2017-01-23 20:41:24', '2017-01-23 20:41:24', '');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `detail_one` text NOT NULL,
  `detail_two` text NOT NULL,
  `detail_three` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `school_id`, `package_name`, `price`, `detail_one`, `detail_two`, `detail_three`) VALUES
(12, 25, 'Bikes', 3000, '1', '2', '3'),
(13, 25, 'suv', 2000, '1', '2', '3'),
(14, 25, 'truck', 990000, '1', '2', '4');

-- --------------------------------------------------------

--
-- Table structure for table `profile_school`
--

CREATE TABLE `profile_school` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile_school`
--

INSERT INTO `profile_school` (`id`, `school_id`, `about`) VALUES
(1, 23, 'hello world.'),
(2, 25, 'sdgs');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `owners_name` varchar(100) NOT NULL,
  `schools_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `about` varchar(1000) NOT NULL,
  `address` varchar(100) NOT NULL,
  `services` varchar(100) NOT NULL,
  `authorized` int(11) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `owners_name`, `schools_name`, `email`, `phone`, `pass`, `about`, `address`, `services`, `authorized`, `lat`, `lng`) VALUES
(2, 'Sarfraz Ahmad', 'Star Motor Driving School', 'sarfraznitd@gmail.com', '9990099080', '1', '1', '1590, Arya Samaj Road, Sitaram Bazar, New Delhi, Delhi 110006', 'CARS', 1, 28.645792, 77.228790),
(1, 'sarang kartikey', 'Jai Janta Motor Driving Training School', 'sarangkartikey50@gmail.com', '8962636894', '1', 'hello world', 'F-6, Pal Market Main Road, Mandawali, New Delhi, Delhi 110092', 'CARS/SUV/BIKES', 2, 28.635307, 77.224960),
(3, 'Ramandeep Bawa', 'New Seven Star Motor Driving College', 'rsbawa@gmail.com', '897966979', '1', 'yo!', '3842, Gali No: 23, Arya Samaj Rd, Ragher Pura, Karol Bagh, New Delhi, Delhi 1100', 'BIKES', 1, 28.651310, 77.187248),
(21, 'Anirudh Gupta', 'Gupta Driving school', 'sweetanirudhgupta@gmail.com', '904278888', '1', 'Best driving school in the world.', 'agra, uttarpradesh, india', 'CARS/SUVS', 2, 27.176670, 78.008072),
(22, 'Pankaj Meena', 'Anuja driving school', 'panakajmeena@gmail.com', '904278888', '1', 'best driving school in the world.', 'GTB nagar, new delhi, india', 'CARS/BIKES', 2, 28.709339, 77.201546),
(23, 'Manojit Paul', 'Powl''s driving school', 'manojitpaul@gmail.com', '897868987', '1', 'Khoob bhalo acho driving school.', 'green park, new delhi, india', 'CARS/SUVS/LICENSE/STUNT', 2, 28.558449, 77.202934),
(25, 'Kapil kumar dabhai', 'VR DABHAI DRIVING SCHOOL', 'kkpp@gmail.com', '797989', '1', 'ho ho ho!', 'kundli, sonipat, haryana', 'SUVS/TRAINING', 2, 28.868671, 77.116875),
(26, 'saurabh', 'oopadai driving school', 'saurabh@gmail.com', '8989898989', '1', 'how you doin?', 'narela, delhi', 'SUVS/TRAINING', 2, 28.853960, 77.091782);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `authorized` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `pass`, `sex`, `authorized`) VALUES
(11, 'k', 'k', 'sa4420@gmail.com', 'j', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_act`
--
ALTER TABLE `email_act`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fb_schools`
--
ALTER TABLE `fb_schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fb_users`
--
ALTER TABLE `fb_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `g_schools`
--
ALTER TABLE `g_schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `g_users`
--
ALTER TABLE `g_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_school`
--
ALTER TABLE `profile_school`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_act`
--
ALTER TABLE `email_act`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `fb_schools`
--
ALTER TABLE `fb_schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `fb_users`
--
ALTER TABLE `fb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `g_schools`
--
ALTER TABLE `g_schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `g_users`
--
ALTER TABLE `g_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `profile_school`
--
ALTER TABLE `profile_school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
