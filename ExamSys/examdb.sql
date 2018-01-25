-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-01-25 15:58:16
-- 服务器版本： 5.7.20
-- PHP Version: 5.6.32

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examdb`
--
CREATE DATABASE IF NOT EXISTS `examdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `examdb`;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `gradeview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `gradeview`;
CREATE TABLE `gradeview` (
`StuId` int(11)
,`StuName` varchar(20)
,`lastTime` datetime
,`total` decimal(32,0)
);

-- --------------------------------------------------------

--
-- 替换视图以便查看 `lasttimeview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `lasttimeview`;
CREATE TABLE `lasttimeview` (
`stuid` int(11)
,`lastTime` datetime
);

-- --------------------------------------------------------

--
-- 表的结构 `loginhistory`
--

DROP TABLE IF EXISTS `loginhistory`;
CREATE TABLE `loginhistory` (
  `stuid` int(11) DEFAULT NULL,
  `isTeacher` tinyint(1) DEFAULT '0',
  `LoginTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `nextquestion`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `nextquestion`;
CREATE TABLE `nextquestion` (
`Qid` int(11)
);

-- --------------------------------------------------------

--
-- 表的结构 `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `Qid` int(11) NOT NULL,
  `Qcontent` text CHARACTER SET utf8,
  `QAnswer` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `QScore` int(11) DEFAULT NULL,
  `TeacherId` int(11) DEFAULT NULL,
  `CreateTime` datetime DEFAULT NULL,
  `QChoice` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `StuId` int(11) NOT NULL,
  `StuName` varchar(20) DEFAULT NULL,
  `StuPassword` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `stuview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `stuview`;
CREATE TABLE `stuview` (
`StuId` int(11)
,`StuName` varchar(20)
,`lastTime` datetime
);

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `TeacherId` int(11) NOT NULL,
  `TeacherName` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `TeacherPassword` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `testhistory`
--

DROP TABLE IF EXISTS `testhistory`;
CREATE TABLE `testhistory` (
  `StuId` int(11) DEFAULT NULL,
  `Qid` int(11) DEFAULT NULL,
  `StuChoise` varchar(20) DEFAULT NULL,
  `StuScore` int(11) DEFAULT NULL,
  `TestTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `totalscore`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `totalscore`;
CREATE TABLE `totalscore` (
`StuId` int(11)
,`total` decimal(32,0)
);

-- --------------------------------------------------------

--
-- 视图结构 `gradeview`
--
DROP TABLE IF EXISTS `gradeview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Exam`@`%` SQL SECURITY DEFINER VIEW `gradeview`  AS  select `stuview`.`StuId` AS `StuId`,`stuview`.`StuName` AS `StuName`,`stuview`.`lastTime` AS `lastTime`,`totalscore`.`total` AS `total` from (`stuview` join `totalscore`) where (`stuview`.`StuId` = `totalscore`.`StuId`) ;

-- --------------------------------------------------------

--
-- 视图结构 `lasttimeview`
--
DROP TABLE IF EXISTS `lasttimeview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Exam`@`%` SQL SECURITY DEFINER VIEW `lasttimeview`  AS  select `loginhistory`.`stuid` AS `stuid`,max(`loginhistory`.`LoginTime`) AS `lastTime` from `loginhistory` where (`loginhistory`.`isTeacher` = 0) group by `loginhistory`.`stuid` ;

-- --------------------------------------------------------

--
-- 视图结构 `nextquestion`
--
DROP TABLE IF EXISTS `nextquestion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Exam`@`%` SQL SECURITY DEFINER VIEW `nextquestion`  AS  select `question`.`Qid` AS `Qid` from (`question` left join (select `testhistory`.`Qid` AS `i` from `testhistory`) `t1` on((`question`.`Qid` = `t1`.`i`))) where isnull(`t1`.`i`) ;

-- --------------------------------------------------------

--
-- 视图结构 `stuview`
--
DROP TABLE IF EXISTS `stuview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Exam`@`%` SQL SECURITY DEFINER VIEW `stuview`  AS  select `student`.`StuId` AS `StuId`,`student`.`StuName` AS `StuName`,`lasttimeview`.`lastTime` AS `lastTime` from (`student` join `lasttimeview`) where (`student`.`StuId` = `lasttimeview`.`stuid`) ;

-- --------------------------------------------------------

--
-- 视图结构 `totalscore`
--
DROP TABLE IF EXISTS `totalscore`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Exam`@`%` SQL SECURITY DEFINER VIEW `totalscore`  AS  select `testhistory`.`StuId` AS `StuId`,sum(`testhistory`.`StuScore`) AS `total` from `testhistory` group by `testhistory`.`StuId` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`Qid`),
  ADD KEY `TeacherId` (`TeacherId`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`StuId`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`TeacherId`);

--
-- Indexes for table `testhistory`
--
ALTER TABLE `testhistory`
  ADD KEY `StuId` (`StuId`),
  ADD KEY `Qid` (`Qid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `question`
--
ALTER TABLE `question`
  MODIFY `Qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 限制导出的表
--

--
-- 限制表 `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`TeacherId`) REFERENCES `teacher` (`TeacherId`);

--
-- 限制表 `testhistory`
--
ALTER TABLE `testhistory`
  ADD CONSTRAINT `testhistory_ibfk_1` FOREIGN KEY (`StuId`) REFERENCES `student` (`StuId`),
  ADD CONSTRAINT `testhistory_ibfk_2` FOREIGN KEY (`Qid`) REFERENCES `question` (`Qid`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
