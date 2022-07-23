-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2022 at 12:56 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestabsence`
--

-- --------------------------------------------------------

--
-- Table structure for table `assiduite`
--

CREATE TABLE `assiduite` (
  `id_assiduite` int(11) NOT NULL,
  `id_course` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `isAbsent` tinyint(4) NOT NULL,
  `proof` varchar(200) NOT NULL,
  `note_test` varchar(10) NOT NULL,
  `remark` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assiduite`
--

INSERT INTO `assiduite` (`id_assiduite`, `id_course`, `id_etudiant`, `isAbsent`, `proof`, `note_test`, `remark`) VALUES
(1, 2, 5, 1, '', '0.50', ''),
(2, 2, 6, 0, '', '12.57', ''),
(3, 4, 5, 0, '', '', ''),
(4, 4, 6, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `coursesession`
--

CREATE TABLE `coursesession` (
  `id_seance` int(11) NOT NULL,
  `id_matiere` int(11) NOT NULL,
  `id_groupe` int(11) NOT NULL,
  `id_ens` int(11) NOT NULL,
  `date_seance` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `type_seance` tinyint(4) NOT NULL,
  `test_evaluation` tinyint(4) NOT NULL,
  `status_abs` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coursesession`
--

INSERT INTO `coursesession` (`id_seance`, `id_matiere`, `id_groupe`, `id_ens`, `date_seance`, `heure_debut`, `heure_fin`, `type_seance`, `test_evaluation`, `status_abs`) VALUES
(2, 2, 3, 3, '2022-01-01', '12:00:00', '13:00:00', 2, 1, 1),
(3, 2, 3, 3, '2022-01-02', '09:00:00', '12:30:00', 1, 1, 0),
(4, 2, 3, 3, '2022-01-03', '09:00:00', '11:30:00', 1, 1, 1),
(5, 2, 1, 3, '2022-01-04', '09:00:00', '11:00:00', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `enseignant`
--

CREATE TABLE `enseignant` (
  `numEns` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `dateNaissance` date NOT NULL,
  `photo` varchar(150) NOT NULL,
  `adresseMail` varchar(100) NOT NULL,
  `dateEmbauche` date NOT NULL,
  `grade` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enseignant`
--

INSERT INTO `enseignant` (`numEns`, `nom`, `prenom`, `dateNaissance`, `photo`, `adresseMail`, `dateEmbauche`, `grade`, `password`) VALUES
(1, 'Masmoudi', 'Nissen', '1985-01-02', '', 'nissen.masmoudi@gmail.com', '2015-07-12', 'Professeur', 'e10adc3949ba59abbe56e057f20f883e'),
(3, 'Chenini', 'Taoufik', '1993-01-01', '', 'taoufikchenini@gmail.com', '2019-01-01', 'Technicien', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `etudiant`
--

CREATE TABLE `etudiant` (
  `numEtd` int(11) NOT NULL,
  `nomEtd` varchar(50) NOT NULL,
  `prenomEtd` varchar(50) NOT NULL,
  `DateNaissanceEtd` date NOT NULL,
  `photoEtd` varchar(150) NOT NULL,
  `adresseMailEtd` varchar(100) NOT NULL,
  `numInscription` varchar(50) NOT NULL,
  `dateInscription` date NOT NULL,
  `au` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `groupe` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `etudiant`
--

INSERT INTO `etudiant` (`numEtd`, `nomEtd`, `prenomEtd`, `DateNaissanceEtd`, `photoEtd`, `adresseMailEtd`, `numInscription`, `dateInscription`, `au`, `password`, `groupe`) VALUES
(1, 'Chenini', 'Taoufik', '1993-01-01', '', 'taoufikchenini@gmail.com', '0111', '2021-01-10', 0, 'e10adc3949ba59abbe56e057f20f883e', '1'),
(4, 'najlaoui', 'Sonia', '1993-01-01', '', 'sonianajlaoui@gmail.com', '0112', '2021-01-10', 0, 'e10adc3949ba59abbe56e057f20f883e', '1'),
(5, 'Mahfoudhi', 'Mohamed', '1993-05-12', '', 'mahfoudhi@gmail.com', '00125', '2021-01-01', 0, 'e10adc3949ba59abbe56e057f20f883e', '3'),
(6, 'Belgacem', 'Wael', '1994-12-02', '', 'wael@gmail.com', '1223', '2022-01-05', 0, 'e10adc3949ba59abbe56e057f20f883e', '3');

-- --------------------------------------------------------

--
-- Table structure for table `groupe`
--

CREATE TABLE `groupe` (
  `idGroupe` int(11) NOT NULL,
  `nomGroupe` varchar(100) NOT NULL,
  `dateCreation` varchar(20) NOT NULL,
  `au` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groupe`
--

INSERT INTO `groupe` (`idGroupe`, `nomGroupe`, `dateCreation`, `au`) VALUES
(1, 'MPDSIR 1 ', '0000-00-00', 0),
(3, 'MPGL 3', '23-06-2022', 0);

-- --------------------------------------------------------

--
-- Table structure for table `matieres`
--

CREATE TABLE `matieres` (
  `id_mat` int(11) NOT NULL,
  `nom_mat` varchar(100) NOT NULL,
  `coefMat` varchar(10) NOT NULL,
  `NbreHeureCours` varchar(10) NOT NULL,
  `NbreHeureTP` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `matieres`
--

INSERT INTO `matieres` (`id_mat`, `nom_mat`, `coefMat`, `NbreHeureCours`, `NbreHeureTP`) VALUES
(1, 'Mini projet', '3', '22', '0'),
(2, 'Developpement Mobile', '3', '21', '41'),
(5, 'Anglais', '2', '12', '0'),
(6, 'Developpement Web', '3', '21', '21'),
(7, 'Big Data', '2', '21', '40'),
(8, 'Algorithme Avancée', '3', '15', '20');

-- --------------------------------------------------------

--
-- Table structure for table `subject_affected`
--

CREATE TABLE `subject_affected` (
  `idSA` int(11) NOT NULL,
  `idEns` int(11) NOT NULL,
  `idMat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject_affected`
--

INSERT INTO `subject_affected` (`idSA`, `idEns`, `idMat`) VALUES
(1, 1, 1),
(5, 1, 6),
(7, 1, 8),
(8, 3, 2),
(9, 3, 7),
(10, 3, 1),
(11, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `subject_groupe`
--

CREATE TABLE `subject_groupe` (
  `idSG` int(11) NOT NULL,
  `idGroupe` int(11) NOT NULL,
  `IdMatiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject_groupe`
--

INSERT INTO `subject_groupe` (`idSG`, `idGroupe`, `IdMatiere`) VALUES
(1, 1, 1),
(2, 3, 6),
(4, 1, 6),
(5, 3, 2),
(6, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `codeuser` int(11) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `userrole` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`codeuser`, `prenom`, `nom`, `mail`, `password`, `userrole`) VALUES
(1, 'Taouik', 'Chenini', 'taoufikchenini@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assiduite`
--
ALTER TABLE `assiduite`
  ADD PRIMARY KEY (`id_assiduite`);

--
-- Indexes for table `coursesession`
--
ALTER TABLE `coursesession`
  ADD PRIMARY KEY (`id_seance`);

--
-- Indexes for table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`numEns`);

--
-- Indexes for table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`numEtd`);

--
-- Indexes for table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`idGroupe`);

--
-- Indexes for table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`id_mat`);

--
-- Indexes for table `subject_affected`
--
ALTER TABLE `subject_affected`
  ADD PRIMARY KEY (`idSA`);

--
-- Indexes for table `subject_groupe`
--
ALTER TABLE `subject_groupe`
  ADD PRIMARY KEY (`idSG`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`codeuser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assiduite`
--
ALTER TABLE `assiduite`
  MODIFY `id_assiduite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coursesession`
--
ALTER TABLE `coursesession`
  MODIFY `id_seance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enseignant`
--
ALTER TABLE `enseignant`
  MODIFY `numEns` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `numEtd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `idGroupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `id_mat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subject_affected`
--
ALTER TABLE `subject_affected`
  MODIFY `idSA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subject_groupe`
--
ALTER TABLE `subject_groupe`
  MODIFY `idSG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `codeuser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
