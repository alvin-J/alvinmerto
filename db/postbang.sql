-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2019 at 11:47 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `postbang`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `catid` varchar(250) NOT NULL,
  `catname` varchar(500) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`catid`, `catname`, `status`) VALUES
('39128h9t2', 'combo meal', 1),
('981h23921', 'beverages', 1),
('9sdjhf924h', 'burgers', 1);

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `cid` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `discountprice` varchar(500) NOT NULL,
  `discounttype` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`cid`, `status`, `discountprice`, `discounttype`) VALUES
('GO2018', 1, '10', 'percentage'),
('GO2018_1', 1, '150', 'real');

-- --------------------------------------------------------

--
-- Table structure for table `listofprods`
--

CREATE TABLE `listofprods` (
  `prod_id` int(11) NOT NULL,
  `prodname` varchar(500) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` varchar(500) NOT NULL,
  `category` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `pic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `listofprods`
--

INSERT INTO `listofprods` (`prod_id`, `prodname`, `qty`, `price`, `category`, `status`, `pic`) VALUES
(1, 'cheeseburger', 10, '89.29', '9sdjhf924h', 1, 'images/burger.jpg'),
(2, 'Hotdog', 15, '20.15', '9sdjhf924h', 1, 'images/hotdog.jpg'),
(3, 'fries', 29, '90.19', '9sdjhf924h', 1, 'images/fries.jpg'),
(4, 'coke', 29, '29.10', '981h23921', 1, 'images/Coke.png'),
(5, 'sprite', 16, '90.39', '981h23921', 1, 'images/sprite.jpg'),
(6, 'tea', 58, '34.45', '981h23921', 1, 'images/tea.jpg'),
(7, 'chicken combo meal', 290, '236.24', '39128h9t2', 1, 'images/chickencombo.jpg'),
(8, 'pork combo meal', 910, '69.39', '39128h9t2', 1, 'images/porkcombo.jpg'),
(9, 'fish combo meal', 90, '49.29', '39128h9t2', 1, 'images/fishcombo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `salesid` varchar(250) NOT NULL,
  `prodid` varchar(500) NOT NULL,
  `qty` int(11) NOT NULL,
  `rec_price` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `groupid` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`salesid`, `prodid`, `qty`, `rec_price`, `status`, `groupid`) VALUES
('21e3806c6f5', '3', 6, '90.19', 1, 'ef94151ce4d'),
('350e4e40b75', '5', 4, '90.39', 1, 'ef94151ce4d'),
('51b4e3330df', '8', 2, '69.39', 1, 'ef94151ce4d'),
('8b13dce6dca', '4', 3, '29.10', 1, '27d010db4d8'),
('e30ab7f5e5a', '7', 2, '236.24', 1, '27d010db4d8'),
('f63f6c6d75a', '3', 2, '90.19', 1, '27d010db4d8');

--
-- Triggers `sales`
--
DELIMITER $$
CREATE TRIGGER `after_sales_insert` AFTER INSERT ON `sales` FOR EACH ROW BEGIN
	IF (select count(*) from saleshead where grpid = new.groupid) = 0 THEN
	insert into saleshead (grpid,rectax,coupon,status,cust_id,salesdate) values (new.groupid,'null',0,1,0,0);
    END if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `saleshead`
--

CREATE TABLE `saleshead` (
  `shid` int(11) NOT NULL,
  `grpid` varchar(250) NOT NULL,
  `rectax` varchar(250) NOT NULL,
  `coupon` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `cust_id` varchar(250) NOT NULL,
  `salesdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saleshead`
--

INSERT INTO `saleshead` (`shid`, `grpid`, `rectax`, `coupon`, `status`, `cust_id`, `salesdate`) VALUES
(58, '27d010db4d8', '12', 'GO2018', 0, '::1', '2019-07-03'),
(59, 'ef94151ce4d', '12', 'GO2018_1', 0, '::1', '2019-07-03');

--
-- Triggers `saleshead`
--
DELIMITER $$
CREATE TRIGGER `log_saleshead_delete` AFTER DELETE ON `saleshead` FOR EACH ROW BEGIN 
	DELETE FROM SALES where groupid = OLD.grpid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `vat`
--

CREATE TABLE `vat` (
  `vid` int(11) NOT NULL,
  `v_value` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vat`
--

INSERT INTO `vat` (`vid`, `v_value`) VALUES
(1, '12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `listofprods`
--
ALTER TABLE `listofprods`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`salesid`);

--
-- Indexes for table `saleshead`
--
ALTER TABLE `saleshead`
  ADD PRIMARY KEY (`shid`);

--
-- Indexes for table `vat`
--
ALTER TABLE `vat`
  ADD PRIMARY KEY (`vid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `listofprods`
--
ALTER TABLE `listofprods`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `saleshead`
--
ALTER TABLE `saleshead`
  MODIFY `shid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `vat`
--
ALTER TABLE `vat`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
