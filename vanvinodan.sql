-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2017 at 06:17 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vanvinodan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_login`
--

CREATE TABLE `tbl_admin_login` (
  `Login_Id` tinyint(4) NOT NULL,
  `Login_Name` varchar(30) NOT NULL,
  `Login_Password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin_login`
--

INSERT INTO `tbl_admin_login` (`Login_Id`, `Login_Name`, `Login_Password`) VALUES
(1, 'admin', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `Reservation_Id` int(11) NOT NULL,
  `Room_Id` tinyint(4) NOT NULL,
  `Check_In_Date` date NOT NULL,
  `Check_Out_Date` date NOT NULL,
  `Arrival_Time` time NOT NULL,
  `Rooms_Occupied` tinyint(4) NOT NULL,
  `Total_Nights` int(11) NOT NULL,
  `Client_Name` varchar(75) NOT NULL,
  `Adult` tinyint(4) NOT NULL,
  `Children` tinyint(4) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(75) NOT NULL,
  `ID_Proof_Image` varchar(75) NOT NULL,
  `Base_Fare` float NOT NULL,
  `Aircondition_Fare` float NOT NULL,
  `Extra_Bed_Fare` float NOT NULL,
  `Subtotal_Amt` float NOT NULL,
  `SGST_Amt` float NOT NULL,
  `CGST_Amt` float NOT NULL,
  `Grand_Total_Amt` float NOT NULL,
  `Reservation_Status` tinyint(4) NOT NULL COMMENT '1 confirmed, 2 arrived, 3 checked-out, 4 cancelled'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`Reservation_Id`, `Room_Id`, `Check_In_Date`, `Check_Out_Date`, `Arrival_Time`, `Rooms_Occupied`, `Total_Nights`, `Client_Name`, `Adult`, `Children`, `Email`, `Phone`, `ID_Proof_Image`, `Base_Fare`, `Aircondition_Fare`, `Extra_Bed_Fare`, `Subtotal_Amt`, `SGST_Amt`, `CGST_Amt`, `Grand_Total_Amt`, `Reservation_Status`) VALUES
(1, 1, '2017-08-29', '2017-08-31', '12:00:00', 1, 1, 'sudhir', 2, 0, 'sudhir5106@gmail.com', '9826396462', '123456789.jpg', 3000, 0, 0, 3000, 270, 270, 3540, 1),
(2, 2, '2017-08-29', '2017-08-30', '12:00:00', 1, 1, 'Rejith', 2, 0, 'rejith@gmail.com', '9826233257', '321654987.jpg', 3000, 500, 0, 3500, 315, 315, 4130, 1),
(3, 6, '2017-08-29', '2017-08-30', '12:00:00', 1, 1, 'Rakesh', 2, 2, 'rakesh@gmail.com', '9826233253', '321654977.jpg', 4000, 0, 0, 4000, 360, 360, 4720, 1),
(4, 7, '2017-08-28', '2017-08-29', '12:00:00', 1, 1, 'Khalid', 2, 2, 'khalid@gmail.com', '9826233253', '321654977.jpg', 4000, 0, 0, 4000, 360, 360, 4720, 1),
(5, 3, '2017-08-29', '2017-08-30', '12:00:00', 1, 1, 'ss', 2, 0, 'ss@gmail.com', '9826233257', '321654987.jpg', 3000, 500, 0, 3500, 315, 315, 4130, 1),
(6, 4, '2017-08-29', '2017-08-30', '12:00:00', 1, 1, 'rr', 2, 0, 'rr@gmail.com', '9826233257', '321654987.jpg', 3000, 500, 0, 3500, 315, 315, 4130, 1),
(7, 5, '2017-09-03', '2017-09-05', '12:00:00', 1, 1, 'kk', 2, 0, 'kk@gmail.com', '9826233257', '321654987.jpg', 3000, 500, 0, 3500, 315, 315, 4130, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rooms_category`
--

CREATE TABLE `tbl_rooms_category` (
  `R_Category_Id` tinyint(4) NOT NULL,
  `R_Category_Name` varchar(75) NOT NULL,
  `R_Capacity` tinyint(4) NOT NULL,
  `Base_Fare` float NOT NULL,
  `Aircondition_Fare` float NOT NULL,
  `Extra_Bed_Fare` float NOT NULL,
  `Room_Info` text NOT NULL,
  `Amenities` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_rooms_category`
--

INSERT INTO `tbl_rooms_category` (`R_Category_Id`, `R_Category_Name`, `R_Capacity`, `Base_Fare`, `Aircondition_Fare`, `Extra_Bed_Fare`, `Room_Info`, `Amenities`) VALUES
(1, 'Deluxe', 2, 3000, 500, 1000, 'These Cottage Rooms Epitomize The Mark Of Grandeur . Every Cottage Is Encircled By A Private Patch Of Garden With Umbrella Shade Generating A Cozy Nook. The Cottage Encompasses An Exclusive Royal Bed, Accommodating 2 Adult Persons. Amidst The Stretch Of Timeless Idleness The Guests Can Experience The Visual Pleasure Of Viewing And Dynamic Sea-Waves Breaking Upon The Golden Sea-Beach, Through The Huge Fenesta Window . The Cottages Are Adorned With Sophisticated Furniture, Picturesque Wall-Papers, And Traditional Art Frames. A Concoction Of Tradition And Modernity --- Providing The Opportunity Of Living In A Luxurious Style.', 'LCD TV | H/C Water Supply | Tea/Coffee Maker | Wifi | Electronic Safe | EPABX | Toiletries | Mini Refrigerator | Packaged Drinking Water | English Newspaper | Digital Locker | Patio |'),
(2, 'Super Deluxe', 4, 4000, 500, 1000, 'These Cottage Rooms Epitomize The Mark Of Grandeur . Every Cottage Is Encircled By A Private Patch Of Garden With Umbrella Shade Generating A Cozy Nook. The Cottage Encompasses An Exclusive Royal Bed, Accommodating 2 Adult Persons. Amidst The Stretch Of Timeless Idleness The Guests Can Experience The Visual Pleasure Of Viewing And Dynamic Sea-Waves Breaking Upon The Golden Sea-Beach, Through The Huge Fenesta Window . The Cottages Are Adorned With Sophisticated Furniture, Picturesque Wall-Papers, And Traditional Art Frames. A Concoction Of Tradition And Modernity --- Providing The Opportunity Of Living In A Luxurious Style.', 'LCD TV | H/C Water Supply | Tea/Coffee Maker | Wifi | Electronic Safe | EPABX | Toiletries | Mini Refrigerator | Packaged Drinking Water | English Newspaper | Digital Locker | Patio'),
(4, 'Tent', 6, 5000, 500, 1000, 'Most Of These Rooms Are In The 2nd , 3rd And 4th Floor Of The Hotel Building. These Rooms Encapsulate 2 Royal Beds Marked By Their Exclusivity. The Exclusivity Can Not Be Enunciated. It Can Only Be Perceived When You Stretch Yourselves Upon Them And Experience An Ineffable Pleasure. The Beds Are Capacious Enough To Accommodate 4 Adults . Through The Crystal Clear Fenesta Windows , Marked By Their Optimum Transparency, The Guests Can Enjoy The Panoramic View Of The Sea Extending Up To The Horizon. The Room Is Adorned By Classical Furniture , Artistic Frames And Exquisite Wall-Papers All Of Which Reflect The Glow Of Aristocratic Sophistication.', 'LCD TV | H/C Water Supply | Tea/Coffee Maker | Wireless Broadband Internet Access | Electronic Safe | EPABX | Toiletries | Mini Refrigerator | Packaged Drinking Water | English Newspaper | Digital Locker');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_master`
--

CREATE TABLE `tbl_room_master` (
  `Room_Id` tinyint(4) NOT NULL,
  `Room_Name` varchar(75) NOT NULL,
  `R_Category_Id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_room_master`
--

INSERT INTO `tbl_room_master` (`Room_Id`, `Room_Name`, `R_Category_Id`) VALUES
(1, 'Room 101', 1),
(2, 'Room 102', 1),
(3, 'Room 103', 1),
(4, 'Room 104', 1),
(5, 'Room 105', 1),
(6, 'Room 201', 2),
(7, 'Room 202', 2),
(8, 'Room 203', 2),
(9, 'Room 204', 2),
(10, 'Room 205', 2),
(11, 'Room 301', 4),
(12, 'Room 302', 4),
(13, 'Room 303', 4),
(14, 'Room 304', 4),
(15, 'Room 305', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin_login`
--
ALTER TABLE `tbl_admin_login`
  ADD PRIMARY KEY (`Login_Id`);

--
-- Indexes for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD PRIMARY KEY (`Reservation_Id`);

--
-- Indexes for table `tbl_rooms_category`
--
ALTER TABLE `tbl_rooms_category`
  ADD PRIMARY KEY (`R_Category_Id`);

--
-- Indexes for table `tbl_room_master`
--
ALTER TABLE `tbl_room_master`
  ADD PRIMARY KEY (`Room_Id`),
  ADD KEY `R_Category_Id` (`R_Category_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `Reservation_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_rooms_category`
--
ALTER TABLE `tbl_rooms_category`
  MODIFY `R_Category_Id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_room_master`
--
ALTER TABLE `tbl_room_master`
  MODIFY `Room_Id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_room_master`
--
ALTER TABLE `tbl_room_master`
  ADD CONSTRAINT `tbl_room_master_ibfk_1` FOREIGN KEY (`R_Category_Id`) REFERENCES `tbl_rooms_category` (`R_Category_Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
