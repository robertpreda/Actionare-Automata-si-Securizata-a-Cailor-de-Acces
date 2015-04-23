-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 22, 2015 at 07:45 AM
-- Server version: 5.5.41
-- PHP Version: 5.4.36-0+deb7u3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `poarta`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE IF NOT EXISTS `Admin` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `User` varchar(20) NOT NULL,
  `Parola` varchar(50) NOT NULL,
  `Tip` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`ID`, `User`, `Parola`, `Tip`) VALUES
(1, 'admin', 'admin1234', 1),
(2, 'portar', 'portar1234', 2),
(5, 'root', 'root1234', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pontaje`
--

CREATE TABLE IF NOT EXISTS `pontaje` (
  `Numar` int(10) NOT NULL AUTO_INCREMENT,
  `ID` int(10) NOT NULL,
  `Data` date NOT NULL,
  `Ora` time NOT NULL,
  `Actiune` varchar(20) NOT NULL,
  `sters` varchar(10) NOT NULL,
  PRIMARY KEY (`Numar`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=426 ;

--
-- Dumping data for table `pontaje`
--

INSERT INTO `pontaje` (`Numar`, `ID`, `Data`, `Ora`, `Actiune`, `sters`) VALUES
(418, 1, '2015-04-20', '12:09:45', 'Deschidere', 'da'),
(419, 23, '2015-04-20', '12:10:22', 'Inchidere', 'da'),
(420, 33, '2015-04-20', '12:18:11', 'Automat', 'da'),
(421, 32, '2015-04-21', '10:34:51', 'Deschidere', 'da'),
(422, 32, '2015-04-21', '10:36:10', 'Deschidere', 'da'),
(423, 32, '2015-04-21', '10:36:44', 'Deschidere', 'da'),
(424, 32, '2015-04-21', '10:36:53', 'Inchidere', 'da'),
(425, 32, '2015-04-21', '10:37:01', 'Automat', 'da');

-- --------------------------------------------------------

--
-- Table structure for table `random`
--

CREATE TABLE IF NOT EXISTS `random` (
  `rand` int(11) NOT NULL,
  `rand2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `random`
--

INSERT INTO `random` (`rand`, `rand2`) VALUES
(263, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Nume` varchar(20) NOT NULL,
  `Prenume` varchar(20) NOT NULL,
  `Adresa` text NOT NULL,
  `Parola_1` varchar(50) NOT NULL,
  `Parola_2` varchar(50) NOT NULL,
  `Parola_3` varchar(50) NOT NULL,
  `timpi` text NOT NULL,
  `Observatii` text NOT NULL,
  `Sters` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Nume`, `Prenume`, `Adresa`, `Parola_1`, `Parola_2`, `Parola_3`, `timpi`, `Observatii`, `Sters`) VALUES
(1, 'root', '', '', '', '', '', '', '', 'da'),
(2, 'admin', '', '', '', '', '', '', '', 'da'),
(3, 'portar', '', '', '', '', '', '', '', 'da'),
(4, 'Popescu', 'Ion', 'Calea Traian nr 2', 'oz70Xhqpd5jx1RIuhB', '9mICaxJs', 'admin1234', '22;117.8;202.4;113;892.6;104.2;166.2;108.2;379.8;117.6;238.8;115.4;763.6;118.6;211.8;113.2;311.6;104.8;203;111.2;399.4;117.8;', '', 'da'),
(5, 'Ionescu', 'Gheorghe', 'Calea Traian nr 24', '', '', '', '', '', 'da'),
(23, 'Preda', 'Robert', 'Str. Avram Iancu nr.12', 'NUSTIU', 'NUSTIU', '12', '4;88;324.8;139.2;', '', 'da'),
(25, 'Bejan', 'Dani', 'Ineu', 'oparola', 'altaparola', 'parola', '12;73.8;188.6;95;211.2;25;22.8;70;193.2;67.6;109.2;100.6;', '', 'da'),
(26, 'Popa', 'Robert-Denis', 'Str. Principala', '72815', '3851', '', '', '', 'da'),
(27, 'Jean1', 'de la Craiova1', 'Str. Valorii1', 'valoare2', 'valoare2', '', '', '', 'da'),
(29, 'Crainic', 'Marius', 'Str. Gheorghe Doja nr. 12', '1234', '5678', 'admin1234', '18;131.6;239.2;122;238.4;95.6;150;109.2;155.2;101.8;386.6;112.2;218.6;115.4;215.6;107.2;205.2;98.4;', '', 'da'),
(31, 'Munteanu', 'Cristian', 'Str. Principala', 'cristi1234', 'cristi1234', '', '', '', 'da'),
(32, 'Crainic', 'Gheorghe', 'Str. Gheorghe Doja nr.12', '12345', '12345', 'detrecicodridearama', '38;109.2;163.6;142.4;391.8;99.8;184.4;79.6;156.8;86;323.6;102;242.6;96.8;371.4;113.8;240.8;92;335.2;110.6;232.4;123.2;216.8;90;370.6;111;149.6;128.8;251.2;129.2;282.8;105;173.6;134.8;432.4;101.2;155.4;131.8;', '', 'da'),
(33, 'Ghita', 'Munteanu', 'Muntenia', 'mamalena', 'damibani', 'mamalenadamibani', '32;83;119.6;119;220.8;47.4;148.6;106;221.2;83.6;157.2;102.6;224.6;52.8;86.6;112.8;330;44.4;24.4;101;137.2;86.8;197.8;80.4;271.8;80.6;159.6;72.4;72.4;84;242.6;80.6;', '', 'da'),
(34, 'ion', 'Ion', 'asa', 'fAoQuykkUAVQI40vTk', 'XTcplC5S', 'admin1234', '18;140.2;262.2;105.6;233;108.6;165.2;107.4;190.6;110;382.4;131.8;248.4;130;268.4;134.2;262;121.4;', '', 'da'),
(35, 'ion1', 'Ion', 'asa', 'cdhTHy84EDULRKWqhn', '4U4YRpFl', '', '', '', 'da');

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `tr1`;
DELIMITER //
CREATE TRIGGER `tr1` AFTER INSERT ON `users`
 FOR EACH ROW BEGIN
  INSERT INTO radiusdb.radcheck 
  SET 
    username = NEW.Nume, 
    op = ":=", 
    value = NEW.Parola_1, 
    attribute = "Cleartext-Password";
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr2`;
DELIMITER //
CREATE TRIGGER `tr2` BEFORE DELETE ON `users`
 FOR EACH ROW BEGIN
  DELETE FROM radiusdb.radcheck WHERE OLD.Nume = username and OLD.Parola_1 = value; 
END
//
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
