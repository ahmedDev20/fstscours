-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2020 at 02:24 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fstscours`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE DATABASE fstscours;

CREATE TABLE `articles` (
  `id_article` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `lien` varchar(200) NOT NULL,
  `image` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id_article`, `titre`, `lien`, `image`) VALUES
(1, 'Stage pour une assistante de saisie', 'https://clubetudiants.ma/post/actualites/Stage-pour-une-assistante-de-saisie', '1.png'),
(2, 'Programmation Orientée Objets en C++', 'https://clubetudiants.ma/post/cours/programmation-orientee-objets-en-c', '2.png'),
(3, 'Offre d\'emploi : Altran Maroc recrute des ingénieurs', 'https://clubetudiants.ma/post/actualites/Offre-demploi-Altran-Maroc-recrute-des-ingenieurs-debutants', '3.png'),
(4, 'Bourses Erasmus Mundus pour les étudiants marocains', 'https://clubetudiants.ma/post/actualites/Bourses-Erasmus-Mundus-pour-les-etudiants-marocains', '4.png'),
(5, 'Offre d\'emploi chez mega international', 'https://clubetudiants.ma/post/actualites/Offre-demploi-chez-mega-international', '5.png'),
(6, 'CPGE Maroc Concours national commun CNC 2020', 'https://clubetudiants.ma/post/actualites/CPGE-Maroc-Concours-national-commun-CNC-2020', '6.png');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id_document` int(11) NOT NULL,
  `filiere` varchar(5) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `module` varchar(200) NOT NULL,
  `type` enum('Cours','TD','TP') NOT NULL,
  `description` text NOT NULL,
  `fichier` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id_document`, `filiere`, `titre`, `module`, `type`, `description`, `fichier`) VALUES
(1, 'GI', 'UML Unified Modeling Language', 'Génie logiciel et UML', 'Cours', 'Cours de UML redigé par Mr.Madani Abdellah</br>\r\nContact : madaniabdellah@gmail.com\r\n', 'UML_Unified_Modeling_Language.pdf'),
(2, 'GI', 'Cours de base de données MS SQL Server', 'Base de données avancées', 'Cours', 'Redigé par Mr.Nabil Laachfoubi', 'BD-Cours.pdf'),
(3, 'EEA', 'Exercices de base de données MS SQL Server', 'Base de données avancées', 'TD', 'Redigé par Mr.Nabil Laachfoubi', 'BD-TD.pdf'),
(4, 'GESA', 'Travaux pratiques de base de données MS SQL Server', 'Base de données avancées', 'TP', 'Redigé par Mr.Nabil Laachfoubi', 'BD-TP.pdf'),
(5, 'MECA', 'Exercices de base de données MS SQL Server (Correction)', 'Base de données avancées', 'TD', 'Redigé par Mr.Nabil Laachfoubi', 'BD-STD.pdf'),
(6, 'GM', 'Travaux pratiques de base de données MS SQL Server (Correction)', 'Base de données avancées', 'TP', 'Redigé par Mr.Nabil Laachfoubi', 'BD-STP.pdf'),
(16, 'GI', 'Programmation Web Dynamique', 'Programmation Web', 'Cours', 'Cours de la programmation WEB dynamique,ce cours contient 5 parties éxpilquant le langage PHP.Rédigé par le Prof.Rachid DAKIR.', 'WEB_DYNAMIQUE_DAKIR.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `filieres`
--

CREATE TABLE `filieres` (
  `id_filiere` int(11) NOT NULL,
  `abrev_fil` varchar(5) NOT NULL,
  `intitule_fil` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `filieres`
--

INSERT INTO `filieres` (`id_filiere`, `abrev_fil`, `intitule_fil`, `image`) VALUES
(1, 'EEA', 'ELECTRONIQUE-ELECTROTECHNIQUE-AUTOMATIQUE', 'EEA.png'),
(2, 'GESA', 'GENIE ELECTRIQUE ET SYSTEMES AUTOMATISES', 'GESA.png'),
(3, 'GI', 'GENIE INFORMATIQUE', 'GI.png'),
(4, 'MECA', 'MECATRONIQUE', 'MECA.png'),
(5, 'GM', 'GENIE MECANIQUE', 'GM.png');

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
  `id_mail` int(11) NOT NULL,
  `sender_name` varchar(30) NOT NULL,
  `sender_email` varchar(30) NOT NULL,
  `message_subject` varchar(200) NOT NULL,
  `message_body` text NOT NULL,
  `date_envoi` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mails`
--

INSERT INTO `mails` (`id_mail`, `sender_name`, `sender_email`, `message_subject`, `message_body`, `date_envoi`) VALUES
(1, 'ahmed', 'test@test.test', 'ahmed', 'hahahaha', '2020-08-30 12:50:08'),
(2, 'ahmed', 'test@test.test', 'test@test.test', 'testtestest', '2020-08-30 12:50:08'),
(3, 'test', 'test@test.test', 'test', 'test', '2020-08-30 12:50:08'),
(4, 'test', 'df@ee.sd', 'ffff', 'hahahaaha', '2020-08-30 12:50:08');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id_member` int(11) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `occupation` text NOT NULL,
  `description` text NOT NULL,
  `avatar` text NOT NULL,
  `social_media` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id_member`, `full_name`, `occupation`, `description`, `avatar`, `social_media`) VALUES
(2, 'BALADY Ahmed', 'Full Stack WEB Developper', 'I\'m a 20 years old freelancer and bachelor\'s degree student in software engineering at the faculty of science and technology in Settat Morocco.', 'ahmed.jpg', 'https://www.facebook.com/ahmed.balady/,\r\nhttps://www.instagram.com/ahmedbalady/,\r\nhttps://github.com/ahmedKing20/');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(200) NOT NULL,
  `admin` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `first_name`, `last_name`, `username`, `email`, `password`, `admin`) VALUES
(1, 'Ahmed', 'Balady', 'ahmed19', 'ahmed@gmail.com', '9193ce3b31332b03f7d8af056c692b84', b'0'),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id_article`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id_document`),
  ADD KEY `abrev_fil` (`filiere`);

--
-- Indexes for table `filieres`
--
ALTER TABLE `filieres`
  ADD PRIMARY KEY (`id_filiere`),
  ADD UNIQUE KEY `UNIQUE` (`abrev_fil`) USING BTREE;

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id_mail`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id_document` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `filieres`
--
ALTER TABLE `filieres`
  MODIFY `id_filiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id_mail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`filiere`) REFERENCES `filieres` (`abrev_fil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
