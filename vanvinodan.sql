-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2017 at 12:02 PM
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
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `Category_Id` smallint(11) NOT NULL,
  `Category_Name` varchar(200) NOT NULL COMMENT 'English Category Name'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`Category_Id`, `Category_Name`) VALUES
(6, 'Roof Design'),
(7, 'Dining Area'),
(8, 'Jungle Safari');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_image_upload`
--

CREATE TABLE `tbl_image_upload` (
  `Image_Id` int(11) NOT NULL,
  `Image_Path` varchar(200) NOT NULL,
  `MainImage` tinyint(2) NOT NULL,
  `Category_Id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_image_upload`
--

INSERT INTO `tbl_image_upload` (`Image_Id`, `Image_Path`, `MainImage`, `Category_Id`) VALUES
(19, '15063392000.jpg', 1, 6),
(20, '15063392011.jpg', 0, 6),
(23, '15063492470.jpg', 0, 7),
(24, '15063492530.jpg', 0, 8),
(25, '15063493020.jpg', 1, 7),
(26, '15063498000.jpg', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_latest_news`
--

CREATE TABLE `tbl_latest_news` (
  `Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `News_Title` text NOT NULL,
  `News_Image` varchar(100) NOT NULL,
  `Description` mediumtext NOT NULL,
  `Status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_latest_news`
--

INSERT INTO `tbl_latest_news` (`Id`, `Date`, `News_Title`, `News_Image`, `Description`, `Status`) VALUES
(1, '2017-09-23', 'Jungle Safari will start from the next month.', '1506144822.jpg', 'dsa fasdf asdf asdf adsf asfas df', 1),
(2, '2017-09-23', 'Jungle Safari will start from the next month.', '1506144854.jpg', 'sdfasd fas dfasd fasdf asdf asdf asdf asdf asdfa sdfasd fasd fasdf', 1),
(3, '2017-09-23', 'Jungle Safari will start from the next month.', '1506144876.jpg', 'fd sd gfsdg sdf gsdf gsdfg sdfg sdg sdfgsd fsdf gsfd gfsd gsdfg sdfg sdgsfdg sfdg sdgs dffg.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_offers`
--

CREATE TABLE `tbl_offers` (
  `Offer_Id` int(11) NOT NULL,
  `Offer_Name` varchar(100) NOT NULL,
  `Published_Date` date NOT NULL,
  `Expired_Date` date NOT NULL,
  `Offer_Image` varchar(75) NOT NULL,
  `Status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_offers`
--

INSERT INTO `tbl_offers` (`Offer_Id`, `Offer_Name`, `Published_Date`, `Expired_Date`, `Offer_Image`, `Status`) VALUES
(1, 'Winter Bonanza', '2017-09-23', '2017-09-24', '1506139210.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_gateway_detail`
--

CREATE TABLE `tbl_payment_gateway_detail` (
  `Payment_Gateway_Id` tinyint(4) NOT NULL,
  `Company_Name` varchar(100) NOT NULL,
  `Merchant_Key` varchar(20) NOT NULL,
  `Salt_Key` varchar(20) NOT NULL,
  `Status` tinyint(4) NOT NULL COMMENT '1 for Activated'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payment_gateway_detail`
--

INSERT INTO `tbl_payment_gateway_detail` (`Payment_Gateway_Id`, `Company_Name`, `Merchant_Key`, `Salt_Key`, `Status`) VALUES
(1, 'Suncros Online', 'rhchpcYE', 'Zu6mupmKDd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `Reservation_Id` int(11) NOT NULL,
  `Reservation_Ref_No` varchar(75) NOT NULL,
  `Check_In_Date` date NOT NULL,
  `Check_Out_Date` date NOT NULL,
  `Arrival_Time` time NOT NULL,
  `Client_Name` varchar(75) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(75) NOT NULL,
  `ID_Proof_Image` varchar(75) NOT NULL,
  `Total_Rooms_Amt` float NOT NULL,
  `Total_Guests_Amt` float NOT NULL,
  `Subtotal_Amt` float NOT NULL,
  `SGST_Amt` float NOT NULL,
  `CGST_Amt` float NOT NULL,
  `Grand_Total_Amt` float NOT NULL,
  `Reservation_Status` tinyint(4) NOT NULL COMMENT '1 confirmed, 2 arrived, 3 checked-out, 4 cancelled, 5 pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`Reservation_Id`, `Reservation_Ref_No`, `Check_In_Date`, `Check_Out_Date`, `Arrival_Time`, `Client_Name`, `Email`, `Phone`, `ID_Proof_Image`, `Total_Rooms_Amt`, `Total_Guests_Amt`, `Subtotal_Amt`, `SGST_Amt`, `CGST_Amt`, `Grand_Total_Amt`, `Reservation_Status`) VALUES
(1, 'REF1505568460', '2017-09-22', '2017-09-23', '12:00:00', 'sudhir', 'sudhir5106@gmail.com', '9826396462', '1505568459.jpg', 1, 0, 1, 0.09, 0.09, 1.18, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reserved_rooms`
--

CREATE TABLE `tbl_reserved_rooms` (
  `RB_Id` int(11) NOT NULL,
  `Reservation_Id` int(11) NOT NULL,
  `Room_Id` tinyint(4) NOT NULL,
  `Check_In_Date` date NOT NULL,
  `Check_Out_Date` date NOT NULL,
  `Adult` tinyint(4) NOT NULL,
  `Children` tinyint(4) NOT NULL,
  `Total_Extra_Guests` tinyint(4) NOT NULL,
  `Base_Fare` float NOT NULL,
  `Extra_Guest_Amt` float NOT NULL,
  `Reservation_Status` tinyint(4) NOT NULL COMMENT '1 confirmed, 2 arrived, 3 checked-out, 4 cancelled, 5 pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_reserved_rooms`
--

INSERT INTO `tbl_reserved_rooms` (`RB_Id`, `Reservation_Id`, `Room_Id`, `Check_In_Date`, `Check_Out_Date`, `Adult`, `Children`, `Total_Extra_Guests`, `Base_Fare`, `Extra_Guest_Amt`, `Reservation_Status`) VALUES
(1, 1, 1, '2017-09-22', '2017-09-23', 1, 0, 0, 0.5, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rooms_category`
--

CREATE TABLE `tbl_rooms_category` (
  `R_Category_Id` tinyint(4) NOT NULL,
  `R_Category_Name` varchar(75) NOT NULL,
  `R_Capacity` tinyint(4) NOT NULL,
  `Base_Fare` float NOT NULL,
  `Extra_Guest_Fare` float NOT NULL,
  `Room_Info` text NOT NULL,
  `Amenities` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_rooms_category`
--

INSERT INTO `tbl_rooms_category` (`R_Category_Id`, `R_Category_Name`, `R_Capacity`, `Base_Fare`, `Extra_Guest_Fare`, `Room_Info`, `Amenities`) VALUES
(1, 'Deluxe', 2, 0.5, 1000, 'These Cottage Rooms Epitomize The Mark Of Grandeur . Every Cottage Is Encircled By A Private Patch Of Garden With Umbrella Shade Generating A Cozy Nook. The Cottage Encompasses An Exclusive Royal Bed, Accommodating 2 Adult Persons. Amidst The Stretch Of Timeless Idleness The Guests Can Experience The Visual Pleasure Of Viewing And Dynamic Sea-Waves Breaking Upon The Golden Sea-Beach, Through The Huge Fenesta Window . The Cottages Are Adorned With Sophisticated Furniture, Picturesque Wall-Papers, And Traditional Art Frames. A Concoction Of Tradition And Modernity --- Providing The Opportunity Of Living In A Luxurious Style.', 'LCD TV | H/C Water Supply | Tea/Coffee Maker | Wifi | Electronic Safe | EPABX | Toiletries | Mini Refrigerator | Packaged Drinking Water | English Newspaper | Digital Locker | Patio |'),
(2, 'Super Deluxe', 4, 4000, 1500, 'These Cottage Rooms Epitomize The Mark Of Grandeur . Every Cottage Is Encircled By A Private Patch Of Garden With Umbrella Shade Generating A Cozy Nook. The Cottage Encompasses An Exclusive Royal Bed, Accommodating 2 Adult Persons. Amidst The Stretch Of Timeless Idleness The Guests Can Experience The Visual Pleasure Of Viewing And Dynamic Sea-Waves Breaking Upon The Golden Sea-Beach, Through The Huge Fenesta Window . The Cottages Are Adorned With Sophisticated Furniture, Picturesque Wall-Papers, And Traditional Art Frames. A Concoction Of Tradition And Modernity --- Providing The Opportunity Of Living In A Luxurious Style.', 'LCD TV | H/C Water Supply | Tea/Coffee Maker | Wifi | Electronic Safe | EPABX | Toiletries | Mini Refrigerator | Packaged Drinking Water | English Newspaper | Digital Locker | Patio'),
(4, 'Tent', 6, 5000, 2000, 'Most Of These Rooms Are In The 2nd , 3rd And 4th Floor Of The Hotel Building. These Rooms Encapsulate 2 Royal Beds Marked By Their Exclusivity. The Exclusivity Can Not Be Enunciated. It Can Only Be Perceived When You Stretch Yourselves Upon Them And Experience An Ineffable Pleasure. The Beds Are Capacious Enough To Accommodate 4 Adults . Through The Crystal Clear Fenesta Windows , Marked By Their Optimum Transparency, The Guests Can Enjoy The Panoramic View Of The Sea Extending Up To The Horizon. The Room Is Adorned By Classical Furniture , Artistic Frames And Exquisite Wall-Papers All Of Which Reflect The Glow Of Aristocratic Sophistication.', 'LCD TV | H/C Water Supply | Tea/Coffee Maker | Wireless Broadband Internet Access | Electronic Safe | EPABX | Toiletries | Mini Refrigerator | Packaged Drinking Water | English Newspaper | Digital Locker');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rooms_gallery`
--

CREATE TABLE `tbl_rooms_gallery` (
  `Gallery_Id` int(11) NOT NULL,
  `Image_Path` varchar(200) NOT NULL,
  `MainImage` tinyint(4) NOT NULL,
  `R_Category_Id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_rooms_gallery`
--

INSERT INTO `tbl_rooms_gallery` (`Gallery_Id`, `Image_Path`, `MainImage`, `R_Category_Id`) VALUES
(5, '15071308920.jpg', 1, 1),
(7, '15071308922.jpg', 0, 1);

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE `tbl_transactions` (
  `Transaction_Id` int(11) NOT NULL,
  `Transaction_Date` datetime NOT NULL,
  `Transaction_No` varchar(100) NOT NULL,
  `Reservation_Id` int(11) NOT NULL,
  `Paid_Amt` float NOT NULL,
  `Payment_Mode` varchar(20) NOT NULL,
  `Pay_Status` varchar(20) NOT NULL,
  `Payment_Id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transactions`
--

INSERT INTO `tbl_transactions` (`Transaction_Id`, `Transaction_Date`, `Transaction_No`, `Reservation_Id`, `Paid_Amt`, `Payment_Mode`, `Pay_Status`, `Payment_Id`) VALUES
(1, '2017-09-16 19:04:21', 'MQ==', 1, 1.18, 'DC', 'success', '163407227');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video_gallery`
--

CREATE TABLE `tbl_video_gallery` (
  `Video_Id` smallint(11) NOT NULL,
  `Video_Caption` varchar(200) NOT NULL COMMENT 'English Caption Name',
  `Video_Link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin_login`
--
ALTER TABLE `tbl_admin_login`
  ADD PRIMARY KEY (`Login_Id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`Category_Id`);

--
-- Indexes for table `tbl_image_upload`
--
ALTER TABLE `tbl_image_upload`
  ADD PRIMARY KEY (`Image_Id`),
  ADD KEY `Category_Id` (`Category_Id`);

--
-- Indexes for table `tbl_latest_news`
--
ALTER TABLE `tbl_latest_news`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_offers`
--
ALTER TABLE `tbl_offers`
  ADD PRIMARY KEY (`Offer_Id`);

--
-- Indexes for table `tbl_payment_gateway_detail`
--
ALTER TABLE `tbl_payment_gateway_detail`
  ADD PRIMARY KEY (`Payment_Gateway_Id`);

--
-- Indexes for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD PRIMARY KEY (`Reservation_Id`);

--
-- Indexes for table `tbl_reserved_rooms`
--
ALTER TABLE `tbl_reserved_rooms`
  ADD PRIMARY KEY (`RB_Id`),
  ADD KEY `Reservation_Id` (`Reservation_Id`),
  ADD KEY `Room_Id` (`Room_Id`);

--
-- Indexes for table `tbl_rooms_category`
--
ALTER TABLE `tbl_rooms_category`
  ADD PRIMARY KEY (`R_Category_Id`);

--
-- Indexes for table `tbl_rooms_gallery`
--
ALTER TABLE `tbl_rooms_gallery`
  ADD PRIMARY KEY (`Gallery_Id`),
  ADD KEY `R_Category_Id` (`R_Category_Id`);

--
-- Indexes for table `tbl_room_master`
--
ALTER TABLE `tbl_room_master`
  ADD PRIMARY KEY (`Room_Id`),
  ADD KEY `R_Category_Id` (`R_Category_Id`);

--
-- Indexes for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD PRIMARY KEY (`Transaction_Id`);

--
-- Indexes for table `tbl_video_gallery`
--
ALTER TABLE `tbl_video_gallery`
  ADD PRIMARY KEY (`Video_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `Category_Id` smallint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_image_upload`
--
ALTER TABLE `tbl_image_upload`
  MODIFY `Image_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `tbl_latest_news`
--
ALTER TABLE `tbl_latest_news`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_offers`
--
ALTER TABLE `tbl_offers`
  MODIFY `Offer_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_payment_gateway_detail`
--
ALTER TABLE `tbl_payment_gateway_detail`
  MODIFY `Payment_Gateway_Id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `Reservation_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tbl_reserved_rooms`
--
ALTER TABLE `tbl_reserved_rooms`
  MODIFY `RB_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `tbl_rooms_category`
--
ALTER TABLE `tbl_rooms_category`
  MODIFY `R_Category_Id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_rooms_gallery`
--
ALTER TABLE `tbl_rooms_gallery`
  MODIFY `Gallery_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_room_master`
--
ALTER TABLE `tbl_room_master`
  MODIFY `Room_Id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  MODIFY `Transaction_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `tbl_video_gallery`
--
ALTER TABLE `tbl_video_gallery`
  MODIFY `Video_Id` smallint(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_image_upload`
--
ALTER TABLE `tbl_image_upload`
  ADD CONSTRAINT `image_uplaod_fg_1` FOREIGN KEY (`Category_Id`) REFERENCES `tbl_category` (`Category_Id`);

--
-- Constraints for table `tbl_reserved_rooms`
--
ALTER TABLE `tbl_reserved_rooms`
  ADD CONSTRAINT `tbl_reserved_rooms_ibfk_1` FOREIGN KEY (`Reservation_Id`) REFERENCES `tbl_reservation` (`Reservation_Id`),
  ADD CONSTRAINT `tbl_reserved_rooms_ibfk_2` FOREIGN KEY (`Room_Id`) REFERENCES `tbl_room_master` (`Room_Id`);

--
-- Constraints for table `tbl_rooms_gallery`
--
ALTER TABLE `tbl_rooms_gallery`
  ADD CONSTRAINT `tbl_rooms_gallery_ibfk_1` FOREIGN KEY (`R_Category_Id`) REFERENCES `tbl_rooms_category` (`R_Category_Id`);

--
-- Constraints for table `tbl_room_master`
--
ALTER TABLE `tbl_room_master`
  ADD CONSTRAINT `tbl_room_master_ibfk_1` FOREIGN KEY (`R_Category_Id`) REFERENCES `tbl_rooms_category` (`R_Category_Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
