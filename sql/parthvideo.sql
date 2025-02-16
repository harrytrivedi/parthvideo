-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 16, 2025 at 12:21 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: parthvideo
--

-- --------------------------------------------------------

--
-- Table structure for table bookings
--

CREATE TABLE bookings (
  bookingid INTEGER NOT NULL,
  eventid INTEGER NOT NULL,
  title varchar(255) NOT NULL,
  fullname varchar(255) NOT NULL,
  username varchar(100) NOT NULL,
  items text NOT NULL,
  status varchar(50) NOT NULL
) 

-- --------------------------------------------------------

--
-- Table structure for table devices
--

CREATE TABLE devices (
  deviceid INTEGER NOT NULL,
  devicename varchar(255) DEFAULT NULL,
  devicedesc text DEFAULT NULL,
  deviceimage text DEFAULT NULL,
  fullname varchar(255) DEFAULT NULL,
  userid INTEGER DEFAULT NULL
) 

--
-- Dumping data for table devices
--

INSERT INTO devices (deviceid, devicename, devicedesc, deviceimage, fullname, userid) VALUES
(0, 'happydfsdafds', ' dsbfuiyhdsf', 'carousel-4500761_1280.jpg', 'test', 3);

-- --------------------------------------------------------

--
-- Table structure for table events
--

CREATE TABLE events (
  eventid INTEGER NOT NULL,
  title varchar(255) NOT NULL,
  date date NOT NULL,
  venue varchar(255) NOT NULL,
  capacity INTEGER NOT NULL,
  eventimage varchar(255) DEFAULT NULL
) 

--
-- Dumping data for table events
--

INSERT INTO events (eventid, title, date, venue, capacity, eventimage) VALUES
(3, 'test2', '2025-02-19', 'test', 20, '../user/images/uploads/test.png'),
(4, 'test2', '2025-02-27', 'test', 203, '../user/images/uploads/Black White Minimalist Initials Monogram Jewelry Logo.png');

-- --------------------------------------------------------

--
-- Table structure for table team
--

CREATE TABLE team (
  id INTEGER NOT NULL,
  name varchar(255) NOT NULL,
  role varchar(255) NOT NULL,
  photo varchar(255) NOT NULL,
  description text NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) 

--
-- Dumping data for table team
--

INSERT INTO team (id, name, role, photo, description, created_at) VALUES
(1, 'Bhavesh Trivedi', 'Director', 'bhavesh_ceo.png', 'He is the King, Our BOSS Bhavesh Trivedi, Owner and Director of Parth Video.', '2025-02-11 00:18:13'),
(3, 'Harsh Trivedi', 'CEO, Co-Director', 'harsh.jpeg', 'He is our boss\'s man. He works really hard, he looks after all our technical stuff for Parth Video. Including This Website.', '2025-02-11 00:33:02');

-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE users (
  userid INTEGER NOT NULL,
  fullname varchar(255) NOT NULL,
  username varchar(100) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  avatar varchar(255) DEFAULT NULL,
  level INTEGER DEFAULT 0
) 

--
-- Dumping data for table users
--

INSERT INTO users (userid, fullname, username, email, password, avatar, level) VALUES
(3, 'test', 'test', 'test@test.com', '$2y$10$emGLoG9KmbCETYdlWBSTRe.VCC9/./VzJMglLBVSSdA3wQ5sjK0O6', 'carousel-4500761_1280.jpg', 0),
(4, 'Admin', 'admin', 'admin@parthvideo.com', '$2y$10$QQECdk78GymbSkQv4qiuYuW8sDLnQkHkER4MEN5jA.ltpsgcS7L0i', 'harsh.jpeg', 1),
(5, 'Harsh Bhaveshkumar Trivedi', 'Harsht1955', 'harsht1955@gmail.com', '$2y$10$MLb9uTtBTLhH..AQkNwrQucIjo0SnVCYF.UrvBkrah9wPUCW60Fce', 'IMG_0480.jpeg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table bookings
--
ALTER TABLE bookings
  ADD PRIMARY KEY (bookingid);

--
-- Indexes for table devices
--
ALTER TABLE devices
  ADD PRIMARY KEY (deviceid),
  ADD KEY userid (userid);

--
-- Indexes for table events
--
ALTER TABLE events
  ADD PRIMARY KEY (eventid);

--
-- Indexes for table team
--
ALTER TABLE team
  ADD PRIMARY KEY (id);

--
-- Indexes for table users
--
ALTER TABLE users
  ADD PRIMARY KEY (userid);

--
-- SERIAL for dumped tables
--

--
-- SERIAL for table bookings
--
ALTER TABLE bookings
  MODIFY bookingid INTEGER NOT NULL SERIAL;

--
-- SERIAL for table events
--
ALTER TABLE events
  MODIFY eventid INTEGER NOT NULL SERIAL, SERIAL=5;

--
-- SERIAL for table team
--
ALTER TABLE team
  MODIFY id INTEGER NOT NULL SERIAL, SERIAL=4;

--
-- SERIAL for table users
--
ALTER TABLE users
  MODIFY userid INTEGER NOT NULL SERIAL, SERIAL=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table devices
--
ALTER TABLE devices
  ADD CONSTRAINT devices_ibfk_1 FOREIGN KEY (userid) REFERENCES users (userid);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
