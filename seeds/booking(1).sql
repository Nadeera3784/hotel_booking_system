-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2019 at 03:55 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_advance_payment`
--

CREATE TABLE `app_advance_payment` (
  `month_num` int(11) NOT NULL,
  `month` varchar(255) NOT NULL,
  `deposit_percent` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_advance_payment`
--

INSERT INTO `app_advance_payment` (`month_num`, `month`, `deposit_percent`) VALUES
(1, 'January', '0.00'),
(2, 'February', '0.00'),
(3, 'March', '0.00'),
(4, 'April', '0.00'),
(5, 'May', '0.00'),
(6, 'June', '0.00'),
(7, 'July', '0.00'),
(8, 'August', '0.00'),
(9, 'September', '0.00'),
(10, 'October', '0.00'),
(11, 'November', '0.00'),
(12, 'December', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `app_bookings`
--

CREATE TABLE `app_bookings` (
  `booking_id` int(10) UNSIGNED NOT NULL,
  `booking_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_date` date NOT NULL DEFAULT '0000-00-00',
  `end_date` date NOT NULL DEFAULT '0000-00-00',
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `child_count` int(2) NOT NULL DEFAULT '0',
  `extra_guest_count` int(2) NOT NULL DEFAULT '0',
  `discount_coupon` varchar(50) DEFAULT NULL,
  `total_cost` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_type` varchar(255) NOT NULL,
  `payment_success` tinyint(1) NOT NULL DEFAULT '0',
  `payment_txnid` varchar(100) DEFAULT NULL,
  `paypal_email` varchar(500) DEFAULT NULL,
  `special_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `special_requests` text,
  `is_block` tinyint(4) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `block_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `app_capacity`
--

CREATE TABLE `app_capacity` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_capacity`
--

INSERT INTO `app_capacity` (`id`, `title`, `capacity`) VALUES
(1, 'Single', 2),
(2, 'Double', 3),
(3, 'Mega', 6);

-- --------------------------------------------------------

--
-- Table structure for table `app_clients`
--

CREATE TABLE `app_clients` (
  `client_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(64) DEFAULT NULL,
  `surname` varchar(64) DEFAULT NULL,
  `title` varchar(16) DEFAULT NULL,
  `street_addr` text,
  `city` varchar(64) DEFAULT NULL,
  `zip` varchar(64) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `additional_comments` text,
  `ip` varchar(32) DEFAULT NULL,
  `existing_client` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_clients`
--

INSERT INTO `app_clients` (`client_id`, `first_name`, `surname`, `title`, `street_addr`, `city`, `zip`, `country`, `phone`, `email`, `id_type`, `id_number`, `additional_comments`, `ip`, `existing_client`) VALUES
(3, 'jaiden', 'maccoy', 'Mr.', 'fgdfgfdgfdgfdg', 'colombo', '34343', 'sri lanka', '0754560024', 'kella650018@gmail.com', 'driver’s_license', '435345435', '', '175.157.41.251', 1),
(4, 'fsdf', 'dsf', 'Mr.', 'dfs', 'dsf', 'dsf', 'df', 'sdf', 'mnv@dfd.com', 'passport', '1242343', '', '112.135.40.56', 0),
(5, 'Nn', 'Nnn', 'Mr.', 'Jjj', 'Hhjb', 'Hhhb', 'Jjjj', 'Hhhh', 'nnnn@hhh.com', 'national_card', '222222222v', 'Nnnn', '43.250.241.135', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_configure`
--

CREATE TABLE `app_configure` (
  `conf_id` int(11) NOT NULL,
  `conf_key` varchar(100) NOT NULL,
  `conf_value` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='app hotel configurations';

--
-- Dumping data for table `app_configure`
--

INSERT INTO `app_configure` (`conf_id`, `conf_key`, `conf_value`) VALUES
(1, 'conf_hotel_name', 'beachhotel'),
(2, 'conf_hotel_streetaddr', '99 xxxxx Road'),
(3, 'conf_hotel_city', 'Your City'),
(4, 'conf_hotel_state', 'Your State'),
(5, 'conf_hotel_country', 'USA'),
(6, 'conf_hotel_zipcode', '11211'),
(7, 'conf_hotel_phone', '+187788889777'),
(8, 'conf_hotel_fax', '+18778888972'),
(9, 'conf_hotel_email', 'booking@lankan.link'),
(20, 'conf_tax_amount', '10'),
(21, 'conf_dateformat', 'mm/dd/yy'),
(22, 'conf_booking_exptime', '1000'),
(25, 'conf_enabled_deposit', '1'),
(26, 'conf_hotel_timezone', 'Asia/Calcutta'),
(27, 'conf_booking_turn_off', '0'),
(28, 'conf_min_night_booking', '1'),
(30, 'conf_notification_email', 'booking@lankan.link'),
(31, 'conf_price_with_tax', '0'),
(32, 'conf_maximum_global_years', '730'),
(33, 'conf_payment_currency', '0'),
(34, 'conf_invoice_currency', '0'),
(35, 'conf_currency_update_time', '1550930918');

-- --------------------------------------------------------

--
-- Table structure for table `app_currency`
--

CREATE TABLE `app_currency` (
  `id` int(11) NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `currency_symbl` varchar(10) NOT NULL,
  `exchange_rate` decimal(20,6) NOT NULL,
  `default_c` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_currency`
--

INSERT INTO `app_currency` (`id`, `currency_code`, `currency_symbl`, `exchange_rate`, `default_c`) VALUES
(1, 'USD', '$', '1.040000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_gallery`
--

CREATE TABLE `app_gallery` (
  `pic_id` int(11) NOT NULL,
  `roomtype_id` int(11) NOT NULL,
  `capacity_id` int(11) NOT NULL,
  `img_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_gallery`
--

INSERT INTO `app_gallery` (`pic_id`, `roomtype_id`, `capacity_id`, `img_path`) VALUES
(17, 1, 1, '1558190708_pigneto-luxury-rooms-affittacamere-di-lusso-a-roma1.jpg,1558190712_magicgridarticle03.jpg,1558190722_magicgridarticle01.jpg,1558190726_luxury-room-sofitel-the-palm-dubai-1200x675.jpg'),
(18, 2, 2, '1558190776_king-luxury-room.jpg,1558190781_indxcxcex.jpg,1558190786_index.jpg,1558190790_imddfdfages.jpg'),
(19, 2, 3, '1558190837_imddfdfages.jpg,1558190841_images.jpg,1558190845_imagdsdses.jpg,1558190850_imadfdfdfges.jpg,1558190854_blogimage02.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `app_groups`
--

CREATE TABLE `app_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_groups`
--

INSERT INTO `app_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `app_invoice`
--

CREATE TABLE `app_invoice` (
  `booking_id` int(10) NOT NULL,
  `client_name` varchar(500) NOT NULL,
  `client_email` varchar(500) NOT NULL,
  `invoice` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_invoice`
--

INSERT INTO `app_invoice` (`booking_id`, `client_name`, `client_email`, `invoice`) VALUES
(1562056002, 'jaiden maccoy', 'kella650018@gmail.com', '<hr class=\"light-grey-hr row mt-10 mb-15\">\n		<div class=\"label-chatrs mb-10\">\n			<div class=\"\">\n				<span class=\"clabels-text font-12 inline-block txt-dark capitalize-font pull-left\">\n					<span class=\"block font-15  mt-5\">Booking Number</span>\n				</span>\n				<div class=\"pull-right\"><button type=\"button\" id=\"showinfo\" class=\"btn btn-default\"><i class=\"icon-plus text-blue mr-10\"></i> 1562056002</button></div>\n				<div class=\"clearfix\"></div>\n			</div>\n		</div>\n		<div class=\"table-responsive\" id=\"invoice_ws\">\n		<table class=\"table table-bordered\">\n		      <tbody>	\n		        <tr class=\"txt-dark weight-500\">\n					<th>Check-In Date</th>\n					<th>Check-Out Date</th>\n					<th>Total Nights</th>\n					<th>Total Rooms</th>\n		        </tr>\n			   <tr>\n				  <td>07/02/2019</td>\n				  <td>07/17/2019</td>\n				  <td>15</td>\n				  <td>1</td>\n				</tr>\n				<tr class=\"txt-dark weight-500\">\n				   <th>Number of rooms</th>\n		           <th>Room type</th>\n		           <th>Max Occupancy</th>\n				   <th>Gross Total</th>\n				</tr><tr>\n									<td>1</td>\n									<td>Deluxe (Single)</td>\n									<td>2 Adult </td>\n										<td>$1,405.00</td>\n								    </tr><tr>\n							  <td></td>\n							  <td></td>\n							  <td>Sub Total</td>\n							  <td>$1,405.00</td>\n							  </tr><tr>\n								 <td></td>\n								 <td></td>\n		                         <td>Tax(10.00%)</td>\n		                         <td>(+) $140.50</td>\n							 </tr>\n							 <tr>\n							    <td></td>\n							    <td></td>\n							    <td>Grand Total</td>\n								<td class=\"text-primary\">$1,545.50</td>\n							 </tr></tbody></table></div>\n			<div class=\"label-chatrs\">\n			<div class=\"\">\n				<span class=\"clabels-text font-12 inline-block txt-dark capitalize-font pull-left\">\n					<span class=\"block font-15  mt-5\">Payment Option</span>\n				</span>\n				<div class=\"pull-right\"><span class=\"font-18\">offline</span></div>\n				<div class=\"clearfix\"></div>\n			</div>\n		    </div>\n            <hr class=\"light-grey-hr row mt-10 mb-15\">\n			<div class=\"label-chatrs\">\n			<div class=\"\">\n				<span class=\"clabels-text font-12 inline-block txt-dark capitalize-font pull-left\">\n					<span class=\"block font-15  mt-5\">Transaction ID</span>\n				</span>\n				<div class=\"pull-right\"><span class=\"font-18\">NA</span></div>\n				<div class=\"clearfix\"></div>\n			</div>\n			</div>'),
(1562302168, 'fsdf dsf', 'mnv@dfd.com', '<hr class=\"light-grey-hr row mt-10 mb-15\">\n		<div class=\"label-chatrs mb-10\">\n			<div class=\"\">\n				<span class=\"clabels-text font-12 inline-block txt-dark capitalize-font pull-left\">\n					<span class=\"block font-15  mt-5\">Booking Number</span>\n				</span>\n				<div class=\"pull-right\"><button type=\"button\" id=\"showinfo\" class=\"btn btn-default\"><i class=\"icon-plus text-blue mr-10\"></i> 1562302168</button></div>\n				<div class=\"clearfix\"></div>\n			</div>\n		</div>\n		<div class=\"table-responsive\" id=\"invoice_ws\">\n		<table class=\"table table-bordered\">\n		      <tbody>	\n		        <tr class=\"txt-dark weight-500\">\n					<th>Check-In Date</th>\n					<th>Check-Out Date</th>\n					<th>Total Nights</th>\n					<th>Total Rooms</th>\n		        </tr>\n			   <tr>\n				  <td>07/24/2019</td>\n				  <td>02/26/2020</td>\n				  <td>217</td>\n				  <td>1</td>\n				</tr>\n				<tr class=\"txt-dark weight-500\">\n				   <th>Number of rooms</th>\n		           <th>Room type</th>\n		           <th>Max Occupancy</th>\n				   <th>Gross Total</th>\n				</tr><tr>\n									<td>1</td>\n									<td>Standard (Double)</td>\n									<td>3 Adult </td>\n										<td>$382,552.00</td>\n								    </tr><tr>\n							  <td></td>\n							  <td></td>\n							  <td>Sub Total</td>\n							  <td>$382,552.00</td>\n							  </tr><tr>\n								 <td></td>\n								 <td></td>\n		                         <td>Tax(10.00%)</td>\n		                         <td>(+) $38,255.20</td>\n							 </tr>\n							 <tr>\n							    <td></td>\n							    <td></td>\n							    <td>Grand Total</td>\n								<td class=\"text-primary\">$420,807.20</td>\n							 </tr></tbody></table></div>\n			<div class=\"label-chatrs\">\n			<div class=\"\">\n				<span class=\"clabels-text font-12 inline-block txt-dark capitalize-font pull-left\">\n					<span class=\"block font-15  mt-5\">Payment Option</span>\n				</span>\n				<div class=\"pull-right\"><span class=\"font-18\">paypal</span></div>\n				<div class=\"clearfix\"></div>\n			</div>\n		    </div>\n            <hr class=\"light-grey-hr row mt-10 mb-15\">\n			<div class=\"label-chatrs\">\n			<div class=\"\">\n				<span class=\"clabels-text font-12 inline-block txt-dark capitalize-font pull-left\">\n					<span class=\"block font-15  mt-5\">Transaction ID</span>\n				</span>\n				<div class=\"pull-right\"><span class=\"font-18\">NA</span></div>\n				<div class=\"clearfix\"></div>\n			</div>\n			</div>'),
(1565960985, 'Nn Nnn', 'nnnn@hhh.com', '<hr class=\"light-grey-hr row mt-10 mb-15\">\n		<div class=\"label-chatrs mb-10\">\n			<div class=\"\">\n				<span class=\"clabels-text font-12 inline-block txt-dark capitalize-font pull-left\">\n					<span class=\"block font-15  mt-5\">Booking Number</span>\n				</span>\n				<div class=\"pull-right\"><button type=\"button\" id=\"showinfo\" class=\"btn btn-default\"><i class=\"icon-plus text-blue mr-10\"></i> 1565960985</button></div>\n				<div class=\"clearfix\"></div>\n			</div>\n		</div>\n		<div class=\"table-responsive\" id=\"invoice_ws\">\n		<table class=\"table table-bordered\">\n		      <tbody>	\n		        <tr class=\"txt-dark weight-500\">\n					<th>Check-In Date</th>\n					<th>Check-Out Date</th>\n					<th>Total Nights</th>\n					<th>Total Rooms</th>\n		        </tr>\n			   <tr>\n				  <td>08/16/2019</td>\n				  <td>08/17/2019</td>\n				  <td>1</td>\n				  <td>1</td>\n				</tr>\n				<tr class=\"txt-dark weight-500\">\n				   <th>Number of rooms</th>\n		           <th>Room type</th>\n		           <th>Max Occupancy</th>\n				   <th>Gross Total</th>\n				</tr><tr>\n									<td>1</td>\n									<td>Standard (Mega)</td>\n									<td>6 Adult </td>\n										<td>$25.00</td>\n								    </tr><tr>\n							  <td></td>\n							  <td></td>\n							  <td>Sub Total</td>\n							  <td>$25.00</td>\n							  </tr><tr>\n								 <td></td>\n								 <td></td>\n		                         <td>Tax(10.00%)</td>\n		                         <td>(+) $2.50</td>\n							 </tr>\n							 <tr>\n							    <td></td>\n							    <td></td>\n							    <td>Grand Total</td>\n								<td class=\"text-primary\">$27.50</td>\n							 </tr></tbody></table></div>\n			<div class=\"label-chatrs\">\n				<div class=\"\">\n					<span class=\"clabels-text font-12 inline-block txt-dark capitalize-font pull-left\">\n						<span class=\"block font-15  mt-5\">Additional requests</span>\n					</span>\n					<div class=\"pull-right\"><span class=\"font-18\">Nnnn</span></div>\n					<div class=\"clearfix\"></div>\n				</div>\n		    </div>\n			<div class=\"label-chatrs\">\n			<div class=\"\">\n				<span class=\"clabels-text font-12 inline-block txt-dark capitalize-font pull-left\">\n					<span class=\"block font-15  mt-5\">Payment Option</span>\n				</span>\n				<div class=\"pull-right\"><span class=\"font-18\">offline</span></div>\n				<div class=\"clearfix\"></div>\n			</div>\n		    </div>\n            <hr class=\"light-grey-hr row mt-10 mb-15\">\n			<div class=\"label-chatrs\">\n			<div class=\"\">\n				<span class=\"clabels-text font-12 inline-block txt-dark capitalize-font pull-left\">\n					<span class=\"block font-15  mt-5\">Transaction ID</span>\n				</span>\n				<div class=\"pull-right\"><span class=\"font-18\">NA</span></div>\n				<div class=\"clearfix\"></div>\n			</div>\n			</div>');

-- --------------------------------------------------------

--
-- Table structure for table `app_login_attempts`
--

CREATE TABLE `app_login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `app_logs`
--

CREATE TABLE `app_logs` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_logs`
--

INSERT INTO `app_logs` (`id`, `type`, `description`, `create_date`) VALUES
(1, 'success', 'price plan has been updated', '2019-04-27 07:28:06'),
(2, 'success', 'price plan has been updated', '2019-04-27 07:29:39');

-- --------------------------------------------------------

--
-- Table structure for table `app_payment_gateway`
--

CREATE TABLE `app_payment_gateway` (
  `id` int(11) NOT NULL,
  `gateway_name` varchar(255) NOT NULL,
  `gateway_code` varchar(50) NOT NULL,
  `account` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_payment_gateway`
--

INSERT INTO `app_payment_gateway` (`id`, `gateway_name`, `gateway_code`, `account`) VALUES
(1, 'PayPal', 'paypal', 'kella650018-facilitator@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `app_priceplan`
--

CREATE TABLE `app_priceplan` (
  `plan_id` int(10) NOT NULL,
  `roomtype_id` int(10) DEFAULT NULL,
  `capacity_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `sun` decimal(10,2) DEFAULT '0.00',
  `mon` decimal(10,2) DEFAULT '0.00',
  `tue` decimal(10,2) DEFAULT '0.00',
  `wed` decimal(10,2) DEFAULT '0.00',
  `thu` decimal(10,2) DEFAULT '0.00',
  `fri` decimal(10,2) DEFAULT '0.00',
  `sat` decimal(10,2) DEFAULT '0.00',
  `default_plan` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_priceplan`
--

INSERT INTO `app_priceplan` (`plan_id`, `roomtype_id`, `capacity_id`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_plan`) VALUES
(1, 1, 1, '0000-00-00', '0000-00-00', '20.00', '10.00', '10.00', '10.00', '10.00', '10.00', '15.00', 1),
(2, 2, 1, '0000-00-00', '0000-00-00', '10.00', '10.00', '10.00', '10.00', '20.00', '23.00', '26.00', 1),
(3, 1, 2, '0000-00-00', '0000-00-00', '10.00', '10.00', '10.00', '10.00', '13.00', '15.00', '25.00', 1),
(4, 2, 2, '0000-00-00', '0000-00-00', '12.00', '12.00', '12.00', '12.00', '18.00', '20.00', '26.00', 1),
(5, 1, 3, '0000-00-00', '0000-00-00', '10.00', '10.00', '10.00', '10.00', '13.00', '15.00', '32.00', 1),
(6, 2, 3, '0000-00-00', '0000-00-00', '15.00', '15.00', '15.00', '15.00', '15.00', '25.00', '35.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_reservation`
--

CREATE TABLE `app_reservation` (
  `id` int(11) NOT NULL,
  `bookings_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `app_room`
--

CREATE TABLE `app_room` (
  `room_ID` int(10) NOT NULL,
  `roomtype_id` int(10) DEFAULT NULL,
  `room_no` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `capacity_id` int(10) DEFAULT NULL,
  `no_of_child` int(11) NOT NULL DEFAULT '0',
  `extra_bed` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_room`
--

INSERT INTO `app_room` (`room_ID`, `roomtype_id`, `room_no`, `capacity_id`, `no_of_child`, `extra_bed`) VALUES
(2, 2, '2', 2, 0, 0),
(3, 2, '3', 2, 0, 0),
(4, 2, '4', 2, 0, 0),
(14, 2, '14', 3, 0, 0),
(15, 2, '15', 3, 0, 0),
(16, 2, '16', 3, 0, 0),
(23, 1, '23', 1, 0, 0),
(24, 1, '24', 1, 0, 0),
(25, 1, '25', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `app_roomtype`
--

CREATE TABLE `app_roomtype` (
  `roomtype_ID` int(10) NOT NULL,
  `type_name` varchar(500) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_roomtype`
--

INSERT INTO `app_roomtype` (`roomtype_ID`, `type_name`, `description`) VALUES
(1, 'Deluxe', 'Only 300 m from the Vatican City, Deluxe Rooms is a 3-minute walk from Ottaviano Metro Station. It offers air-conditioned rooms with free WiFi and a flat-screen TV, and self-catering units with a kitchen or kitchenette.'),
(2, 'Standard', 'Overlooking the street, this air-conditioned room features a flat-screen TV and a small fridge. Its private bathroom is complete with a hairdryer. Wi-Fi is free\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `app_special_offer`
--

CREATE TABLE `app_special_offer` (
  `id` int(11) NOT NULL,
  `offer_title` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `room_type` varchar(255) CHARACTER SET latin1 NOT NULL,
  `price_deduc` decimal(10,2) NOT NULL,
  `min_stay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_special_offer`
--

INSERT INTO `app_special_offer` (`id`, `offer_title`, `start_date`, `end_date`, `room_type`, `price_deduc`, `min_stay`) VALUES
(1, 'seasonalFest', '2019-06-15', '2019-06-18', '1', '8.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1573906385, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(2, '::1', 'johndoe@gmail.com', '$2y$08$ywNSTk9KlxGy4WZ5OyC3Z.wnHFLHAoBiGo2z3voJTgpSteBJ4Qpcy', NULL, 'johndoe@gmail.com', NULL, NULL, NULL, NULL, 1555328053, 1566711956, 1, 'john', 'doe', 'creative desing.inc', '0450948509');

-- --------------------------------------------------------

--
-- Table structure for table `app_users_groups`
--

CREATE TABLE `app_users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_users_groups`
--

INSERT INTO `app_users_groups` (`id`, `user_id`, `group_id`) VALUES
(3, 1, 1),
(4, 2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_advance_payment`
--
ALTER TABLE `app_advance_payment`
  ADD PRIMARY KEY (`month_num`);

--
-- Indexes for table `app_bookings`
--
ALTER TABLE `app_bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `start_date` (`start_date`),
  ADD KEY `end_date` (`end_date`),
  ADD KEY `booking_time` (`discount_coupon`);

--
-- Indexes for table `app_capacity`
--
ALTER TABLE `app_capacity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_clients`
--
ALTER TABLE `app_clients`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `app_configure`
--
ALTER TABLE `app_configure`
  ADD PRIMARY KEY (`conf_id`);

--
-- Indexes for table `app_currency`
--
ALTER TABLE `app_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_gallery`
--
ALTER TABLE `app_gallery`
  ADD PRIMARY KEY (`pic_id`);

--
-- Indexes for table `app_groups`
--
ALTER TABLE `app_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_invoice`
--
ALTER TABLE `app_invoice`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `app_login_attempts`
--
ALTER TABLE `app_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_logs`
--
ALTER TABLE `app_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_payment_gateway`
--
ALTER TABLE `app_payment_gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_priceplan`
--
ALTER TABLE `app_priceplan`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `priceplan` (`roomtype_id`,`capacity_id`,`start_date`,`end_date`);

--
-- Indexes for table `app_reservation`
--
ALTER TABLE `app_reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_room`
--
ALTER TABLE `app_room`
  ADD PRIMARY KEY (`room_ID`),
  ADD KEY `roomtype_id` (`roomtype_id`);

--
-- Indexes for table `app_roomtype`
--
ALTER TABLE `app_roomtype`
  ADD PRIMARY KEY (`roomtype_ID`);

--
-- Indexes for table `app_special_offer`
--
ALTER TABLE `app_special_offer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_users_groups`
--
ALTER TABLE `app_users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_advance_payment`
--
ALTER TABLE `app_advance_payment`
  MODIFY `month_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `app_capacity`
--
ALTER TABLE `app_capacity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `app_clients`
--
ALTER TABLE `app_clients`
  MODIFY `client_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `app_configure`
--
ALTER TABLE `app_configure`
  MODIFY `conf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `app_currency`
--
ALTER TABLE `app_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `app_gallery`
--
ALTER TABLE `app_gallery`
  MODIFY `pic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `app_groups`
--
ALTER TABLE `app_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `app_login_attempts`
--
ALTER TABLE `app_login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_logs`
--
ALTER TABLE `app_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `app_payment_gateway`
--
ALTER TABLE `app_payment_gateway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `app_priceplan`
--
ALTER TABLE `app_priceplan`
  MODIFY `plan_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `app_reservation`
--
ALTER TABLE `app_reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_room`
--
ALTER TABLE `app_room`
  MODIFY `room_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `app_roomtype`
--
ALTER TABLE `app_roomtype`
  MODIFY `roomtype_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `app_special_offer`
--
ALTER TABLE `app_special_offer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `app_users_groups`
--
ALTER TABLE `app_users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_users_groups`
--
ALTER TABLE `app_users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `app_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
