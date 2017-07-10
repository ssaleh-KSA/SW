-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 03, 2017 at 12:25 PM
-- Server version: 5.7.15-log
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saudi_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Com_ID` int(11) NOT NULL COMMENT 'comments ID',
  `Com_Comments` text NOT NULL COMMENT 'The Comments',
  `Com_Date` date NOT NULL COMMENT 'Date Of Comments',
  `Com_UserName` int(11) DEFAULT NULL COMMENT 'Written by And Linked with the Users table in a field User_ID',
  `Com_SectionName` int(11) NOT NULL COMMENT 'The section where the comment was written and 1 = History, 2 = Culture, 3 = Comunity, 4 = Tourism, 5 = Sport, 6 = Websites, 7 = SecurityAndDefense, 8 = Economy, 9 = Politics, 10 = News',
  `Art_ID` int(11) NOT NULL COMMENT 'There is an article ID',
  `Alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds a comment recorded in Alerts 1 means new, and after viewing the comment when the admin changes the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `community`
--

CREATE TABLE `community` (
  `Com_ID` int(11) NOT NULL COMMENT 'Community Article ID',
  `Com_Name` varchar(255) NOT NULL COMMENT 'Article Name',
  `Com_Image` varchar(255) NOT NULL COMMENT 'Article Image',
  `Com_Write` int(11) DEFAULT NULL COMMENT 'Written by And Linked with the Users table in a field User_ID',
  `Com_Date` date NOT NULL COMMENT 'Date Of Article Write',
  `Com_Time` time NOT NULL COMMENT 'Time Of Article Add Hour And Minutes And Seconds	',
  `Com_Details` text NOT NULL COMMENT 'Details Of Article',
  `Com_Parent` tinyint(4) NOT NULL COMMENT '1 = Saudi influencers, 2 = population, 3 = Education',
  `Com_Videos` varchar(255) NOT NULL COMMENT 'Videos For Article',
  `alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds an article that registers 1 in the alerts, means new, after viewing the admin article change the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `connect_us`
--

CREATE TABLE `connect_us` (
  `Con_ID` int(11) NOT NULL COMMENT 'Connect_Us Article ID',
  `Con_Name` varchar(255) NOT NULL COMMENT 'Name of the sending person',
  `Con_Email` varchar(255) NOT NULL COMMENT 'The Email For person who sent the message',
  `Con_Parent` int(11) NOT NULL COMMENT '1 = complaint, 2 = suggestion, 3 = note, 4 = request, 5 = other',
  `Con_Subject` text NOT NULL COMMENT 'Message Subject',
  `Con_Message` text NOT NULL COMMENT 'The Message',
  `Con_UserName` int(11) NOT NULL COMMENT 'User ID, if the person is registered on the site type the user ID, if not registered type 0',
  `Con_Date` date NOT NULL COMMENT 'Date Of Message Send',
  `Con_Answered` tinyint(4) NOT NULL COMMENT '0 = The message was not answered, 1 = The message was answered',
  `Alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds an article that registers 1 in the alerts, means new, after viewing the admin article change the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `culture`
--

CREATE TABLE `culture` (
  `Cul_ID` int(11) NOT NULL COMMENT 'Culture Article ID',
  `Cul_Name` varchar(255) NOT NULL COMMENT 'Article Name',
  `Cul_Image` varchar(255) NOT NULL COMMENT 'Article Image',
  `Cul_Write` int(11) NOT NULL COMMENT 'Written by And Linked with the Users table in a field User_ID',
  `Cul_Date` date NOT NULL COMMENT 'Date Of Article Write',
  `Cul_Time` time NOT NULL COMMENT 'Time Of Article Add Hour And Minutes And Seconds	',
  `Cul_Details` text NOT NULL COMMENT 'Details Of Article',
  `Cul_Parent` tinyint(4) NOT NULL COMMENT '1 = Theater and cinema, 2 = Music, 3 = Literature and Arts, 4 = Museums and festivals, 5 = media, 6 = the kitchen',
  `Cul_Videos` varchar(255) NOT NULL COMMENT 'Videos For Article',
  `Alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds an article that registers 1 in the alerts, means new, after viewing the admin article change the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `economy`
--

CREATE TABLE `economy` (
  `Eco_ID` int(11) NOT NULL COMMENT 'Economy Article ID',
  `Eco_Name` varchar(255) NOT NULL COMMENT 'Article Name',
  `Eco_Image` varchar(255) NOT NULL COMMENT 'Article Image',
  `Eco_Write` int(11) DEFAULT NULL COMMENT 'Written by And Linked with the Users table in a field User_ID',
  `Eco_Date` date NOT NULL COMMENT 'Date Of Article Write',
  `Eco_Time` time NOT NULL COMMENT 'Time Of Article Add Hour And Minutes And Seconds	',
  `Eco_Details` text NOT NULL COMMENT 'Details Of Article',
  `Eco_Parent` tinyint(4) NOT NULL COMMENT '1 = private companies, 2 = government companies',
  `Eco_Videos` varchar(255) NOT NULL COMMENT 'Videos For Article',
  `Alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds an article that registers 1 in the alerts, means new, after viewing the admin article change the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `His_ID` int(11) NOT NULL COMMENT 'History Article ID',
  `His_Name` varchar(255) NOT NULL COMMENT 'Article Name',
  `His_Image` varchar(255) NOT NULL COMMENT 'Article Image',
  `His_Write` int(11) NOT NULL COMMENT 'Written by And Linked with the Users table in a field User_ID',
  `His_Date` date NOT NULL COMMENT 'Date Of Article Write',
  `His_Time` time NOT NULL COMMENT 'Time Of Article Add Hour And Minutes And Seconds',
  `His_Details` text NOT NULL COMMENT 'Details Of Article',
  `His_Parent` tinyint(4) NOT NULL COMMENT '1 = Old History, 2 = New History',
  `His_Videos` varchar(255) NOT NULL COMMENT 'Videos For Article',
  `Alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds an article that registers 1 in the alerts, means new, after viewing the admin article change the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `News_ID` int(11) NOT NULL COMMENT 'news Article ID',
  `News_Name` varchar(255) NOT NULL COMMENT 'Article Name',
  `News_Image` varchar(255) NOT NULL COMMENT 'Article Image',
  `News_Write` int(11) DEFAULT NULL COMMENT 'Written by And Linked with the Users table in a field User_ID',
  `News_Date` date NOT NULL COMMENT 'Date Of Article Write',
  `News_Time` time NOT NULL COMMENT 'Time Of Article Add Hour And Minutes And Seconds	',
  `News_Details` text NOT NULL COMMENT 'Details Of Article',
  `News_Videos` varchar(255) NOT NULL COMMENT 'Viseos For Article',
  `Alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds an article that registers 1 in the alerts, means new, after viewing the admin article change the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `politics`
--

CREATE TABLE `politics` (
  `Pol_ID` int(11) NOT NULL COMMENT 'Politics Article ID',
  `Pol_Name` varchar(255) NOT NULL COMMENT 'Article Name',
  `Pol_Image` varchar(255) NOT NULL COMMENT 'Article Image',
  `Pol_Write` int(11) DEFAULT NULL COMMENT 'Written by And Linked with the Users table in a field User_ID',
  `Pol_Date` date NOT NULL COMMENT 'Date Of Article Write',
  `Pol_Time` time NOT NULL COMMENT 'Time Of Article Add Hour And Minutes And Seconds	',
  `Pol_Details` text NOT NULL COMMENT 'Details Of Article',
  `Pol_Videos` varchar(255) NOT NULL COMMENT 'Viseos For Article',
  `Alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds an article that registers 1 in the alerts, means new, after viewing the admin article change the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `security_and_defense`
--

CREATE TABLE `security_and_defense` (
  `SAD_ID` int(11) NOT NULL COMMENT 'History Article IDSecurityAndDefense',
  `SAD_Name` varchar(255) NOT NULL COMMENT 'Article Name',
  `SAD_Image` varchar(255) NOT NULL COMMENT 'Article Image',
  `SAD_Write` int(11) DEFAULT NULL COMMENT 'Written by And Linked with the Users table in a field User_ID',
  `SAD_Date` date NOT NULL COMMENT 'Date Of Article Write',
  `SAD_Time` time NOT NULL COMMENT 'Time Of Article Add Hour And Minutes And Seconds	',
  `SAD_Details` text NOT NULL COMMENT 'Details Of Article',
  `SAD_Parent` tinyint(4) NOT NULL COMMENT '1 = Ministry of Defense, 2 = Ministry of Interior, 3 = Ministry of National Guard',
  `SAD_Videos` varchar(255) NOT NULL COMMENT 'Videos For Article',
  `Alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds an article that registers 1 in the alerts, means new, after viewing the admin article change the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE `sport` (
  `Spo_ID` int(11) NOT NULL COMMENT 'Sport Article ID',
  `Spo_Name` varchar(255) NOT NULL COMMENT 'Article Name',
  `Spo_Image` varchar(255) NOT NULL COMMENT 'Article Image',
  `Spo_Write` int(11) DEFAULT NULL COMMENT 'Written by And Linked with the Users table in a field User_ID',
  `Spo_Date` date NOT NULL COMMENT 'Date Of Article Write',
  `Spo_Time` time NOT NULL COMMENT 'Time Of Article Add Hour And Minutes And Seconds	',
  `Spo_Details` text NOT NULL COMMENT 'Details Of Article',
  `Spo_Videos` varchar(255) NOT NULL COMMENT 'Viseos For Article',
  `Alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds an article that registers 1 in the alerts, means new, after viewing the admin article change the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tourism`
--

CREATE TABLE `tourism` (
  `Tou_ID` int(11) NOT NULL COMMENT 'Tourism Article ID',
  `Tou_Name` varchar(255) NOT NULL COMMENT 'Article Name',
  `Tou_Image` varchar(255) NOT NULL COMMENT 'Article Image',
  `Tou_Write` int(11) DEFAULT NULL COMMENT 'Written by And Linked with the Users table in a field User_ID',
  `Tou_Date` date NOT NULL COMMENT 'Date Of Article Write',
  `Tou_Time` time NOT NULL COMMENT 'Time Of Article Add Hour And Minutes And Seconds	',
  `Tou_Details` text NOT NULL COMMENT 'Details Of Article',
  `Tou_Videos` varchar(255) NOT NULL COMMENT 'Viseos For Article',
  `Alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds an article that registers 1 in the alerts, means new, after viewing the admin article change the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL COMMENT 'User ID',
  `User_Name` varchar(255) NOT NULL COMMENT 'User Name And It Is Unique',
  `User_Password` varchar(255) NOT NULL COMMENT 'User Password',
  `User_Email` varchar(255) NOT NULL COMMENT 'User Email',
  `User_FullName` varchar(255) NOT NULL COMMENT 'User Full Name',
  `User_Group` tinyint(4) NOT NULL COMMENT '1 = User, 2 = Author, 3 = Admin',
  `User_From` varchar(255) NOT NULL COMMENT 'The Country Of user',
  `User_Age` tinyint(4) NOT NULL COMMENT 'User Age',
  `User_Sex` tinyint(4) NOT NULL COMMENT '1 = male, 2 = female',
  `Reg_Date` date NOT NULL COMMENT 'Date Of Register',
  `User_Image` varchar(255) NOT NULL COMMENT 'User Image For Profile',
  `User_Following` varchar(255) NOT NULL COMMENT 'ID For users who following the user',
  `User_Followers` varchar(255) NOT NULL COMMENT 'ID For users who follows the user	',
  `Alerts` tinyint(4) NOT NULL COMMENT 'When a new user is registered, 1 is added to the alerts, meaning new, and after the new user admin is displayed, the value changes to 0 means age'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `User_Name`, `User_Password`, `User_Email`, `User_FullName`, `User_Group`, `User_From`, `User_Age`, `User_Sex`, `Reg_Date`, `User_Image`, `User_Following`, `User_Followers`, `Alerts`) VALUES
(24, 'omer', '6a2b3fa376eaaefa628ba0e36b601bb1adab5658', 's3leh.511@gmail.com', 'امل احمد خالد', 1, 'سعودي', 33, 2, '2017-06-10', '8017_norah.png', '0,22,23,', '0,22,', 0),
(27, 'saleh', '74be0fe9182962a9231fff70def7289bdd801135', 's3leh.511@gmail.com', 'صالح العتيبي', 3, 'سعودي', 23, 1, '2017-07-01', '34897_saleh.png', '0,', '0,', 0),
(28, 'gader', 'cf84f60660b6b34981d3829bb20cd02bfed2d8e2', 's3leh.511@gmail.com', 'لانا عبدااله الخالد', 1, 'سعودية', 23, 2, '2017-07-02', '1165_mona.jpg', '0,', '0,', 1);

-- --------------------------------------------------------

--
-- Table structure for table `websites`
--

CREATE TABLE `websites` (
  `Web_ID` int(11) NOT NULL COMMENT 'Websites Article ID',
  `Web_Name` varchar(255) NOT NULL COMMENT 'Article Name',
  `Web_Image` varchar(255) NOT NULL COMMENT 'Article Image',
  `Web_Write` int(11) DEFAULT NULL COMMENT 'Written by And Linked with the Users table in a field User_ID',
  `Web_Date` date NOT NULL COMMENT 'Date Of Article Write',
  `Web_Time` time NOT NULL COMMENT 'Time Of Article Add Hour And Minutes And Seconds	',
  `Web_Details` text NOT NULL COMMENT 'Details Of Article',
  `Web_Videos` varchar(255) NOT NULL COMMENT 'Viseos For Article',
  `Web_Link` varchar(255) NOT NULL COMMENT 'Link Of Websites Article',
  `Alerts` tinyint(4) NOT NULL COMMENT 'Anyone who adds an article that registers 1 in the alerts, means new, after viewing the admin article change the value to 0 means old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Com_ID`),
  ADD KEY `Com_UserName` (`Com_UserName`);

--
-- Indexes for table `community`
--
ALTER TABLE `community`
  ADD PRIMARY KEY (`Com_ID`),
  ADD KEY `Com_Write` (`Com_Write`);

--
-- Indexes for table `connect_us`
--
ALTER TABLE `connect_us`
  ADD PRIMARY KEY (`Con_ID`);

--
-- Indexes for table `culture`
--
ALTER TABLE `culture`
  ADD PRIMARY KEY (`Cul_ID`),
  ADD KEY `Cul_Write` (`Cul_Write`) USING BTREE;

--
-- Indexes for table `economy`
--
ALTER TABLE `economy`
  ADD PRIMARY KEY (`Eco_ID`),
  ADD KEY `Eco_Write` (`Eco_Write`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`His_ID`),
  ADD KEY `user_Write` (`His_Write`) USING BTREE;

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`News_ID`),
  ADD KEY `News_Write` (`News_Write`);

--
-- Indexes for table `politics`
--
ALTER TABLE `politics`
  ADD PRIMARY KEY (`Pol_ID`),
  ADD KEY `Pol_Write` (`Pol_Write`) USING BTREE;

--
-- Indexes for table `security_and_defense`
--
ALTER TABLE `security_and_defense`
  ADD PRIMARY KEY (`SAD_ID`),
  ADD KEY `SAD_Write` (`SAD_Write`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
  ADD PRIMARY KEY (`Spo_ID`),
  ADD KEY `Spo_Write` (`Spo_Write`);

--
-- Indexes for table `tourism`
--
ALTER TABLE `tourism`
  ADD PRIMARY KEY (`Tou_ID`),
  ADD KEY `Tou_Write` (`Tou_Write`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `User_Name` (`User_Name`);

--
-- Indexes for table `websites`
--
ALTER TABLE `websites`
  ADD PRIMARY KEY (`Web_ID`),
  ADD KEY `Web_Write` (`Web_Write`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Com_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'comments ID';
--
-- AUTO_INCREMENT for table `community`
--
ALTER TABLE `community`
  MODIFY `Com_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Community Article ID';
--
-- AUTO_INCREMENT for table `connect_us`
--
ALTER TABLE `connect_us`
  MODIFY `Con_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Connect_Us Article ID';
--
-- AUTO_INCREMENT for table `culture`
--
ALTER TABLE `culture`
  MODIFY `Cul_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Culture Article ID';
--
-- AUTO_INCREMENT for table `economy`
--
ALTER TABLE `economy`
  MODIFY `Eco_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Economy Article ID';
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `His_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'History Article ID';
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `News_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'news Article ID';
--
-- AUTO_INCREMENT for table `politics`
--
ALTER TABLE `politics`
  MODIFY `Pol_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Politics Article ID';
--
-- AUTO_INCREMENT for table `security_and_defense`
--
ALTER TABLE `security_and_defense`
  MODIFY `SAD_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'History Article IDSecurityAndDefense';
--
-- AUTO_INCREMENT for table `sport`
--
ALTER TABLE `sport`
  MODIFY `Spo_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Sport Article ID';
--
-- AUTO_INCREMENT for table `tourism`
--
ALTER TABLE `tourism`
  MODIFY `Tou_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tourism Article ID';
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID', AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `websites`
--
ALTER TABLE `websites`
  MODIFY `Web_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Websites Article ID';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Com_UserName` FOREIGN KEY (`Com_UserName`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `community`
--
ALTER TABLE `community`
  ADD CONSTRAINT `Com_Write` FOREIGN KEY (`Com_Write`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `culture`
--
ALTER TABLE `culture`
  ADD CONSTRAINT `Cul_Write` FOREIGN KEY (`Cul_Write`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `economy`
--
ALTER TABLE `economy`
  ADD CONSTRAINT `Eco_Write` FOREIGN KEY (`Eco_Write`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `user_Write` FOREIGN KEY (`His_Write`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `News_Write` FOREIGN KEY (`News_Write`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `politics`
--
ALTER TABLE `politics`
  ADD CONSTRAINT `Pol_Write` FOREIGN KEY (`Pol_Write`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `security_and_defense`
--
ALTER TABLE `security_and_defense`
  ADD CONSTRAINT `SAD_Write` FOREIGN KEY (`SAD_Write`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sport`
--
ALTER TABLE `sport`
  ADD CONSTRAINT `Spo_Write` FOREIGN KEY (`Spo_Write`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tourism`
--
ALTER TABLE `tourism`
  ADD CONSTRAINT `Tou_Write` FOREIGN KEY (`Tou_Write`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `websites`
--
ALTER TABLE `websites`
  ADD CONSTRAINT `Web_Write` FOREIGN KEY (`Web_Write`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
