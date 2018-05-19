-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2018-01-30 08:40:18
-- 服务器版本： 5.7.19
-- PHP Version: 5.6.31

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

-- --------------------------------------------------------

--
-- 替换视图以便查看 `gradeview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `gradeview`;
CREATE TABLE IF NOT EXISTS `gradeview` (
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
CREATE TABLE IF NOT EXISTS `lasttimeview` (
`stuid` int(11)
,`lastTime` datetime
);

-- --------------------------------------------------------

--
-- 表的结构 `loginhistory`
--

DROP TABLE IF EXISTS `loginhistory`;
CREATE TABLE IF NOT EXISTS `loginhistory` (
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
CREATE TABLE IF NOT EXISTS `nextquestion` (
`Qid` int(11)
);

-- --------------------------------------------------------

--
-- 表的结构 `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `Qid` int(11) NOT NULL AUTO_INCREMENT,
  `Qcontent` text CHARACTER SET utf8,
  `QAnswer` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `QScore` int(11) DEFAULT NULL,
  `TeacherId` int(11) DEFAULT NULL,
  `CreateTime` datetime DEFAULT NULL,
  `QChoice` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`Qid`),
  KEY `TeacherId` (`TeacherId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `question_sets`
--

DROP TABLE IF EXISTS `question_sets`;
CREATE TABLE IF NOT EXISTS `question_sets` (
  `QsetId` int(11) NOT NULL AUTO_INCREMENT,
  `QsetName` varchar(255) NOT NULL,
  `Qinclude` varchar(255) NOT NULL,
  `CreateTime` datetime DEFAULT NULL,
  `Author` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`QsetId`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `StuId` int(11) NOT NULL,
  `StuName` varchar(20) DEFAULT NULL,
  `StuPassword` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`StuId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `stugrade`
--

DROP TABLE IF EXISTS `stugrade`;
CREATE TABLE IF NOT EXISTS `stugrade` (
  `Stuid` int(11) NOT NULL,
  `SetId` int(11) NOT NULL,
  `RightCNT` int(11) NOT NULL,
  `WrongCNT` int(11) NOT NULL,
  `Total` int(11) NOT NULL,
  `StartTime` datetime DEFAULT NULL,
  `FinishTime` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `stuview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `stuview`;
CREATE TABLE IF NOT EXISTS `stuview` (
`StuId` int(11)
,`StuName` varchar(20)
,`lastTime` datetime
);

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `TeacherId` int(11) NOT NULL,
  `TeacherName` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `TeacherPassword` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`TeacherId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `testhistory`
--

DROP TABLE IF EXISTS `testhistory`;
CREATE TABLE IF NOT EXISTS `testhistory` (
  `StuId` int(11) DEFAULT NULL,
  `Qset` int(11) NOT NULL,
  `Qid` int(11) DEFAULT NULL,
  `StuChoise` varchar(20) DEFAULT NULL,
  `StuScore` int(11) DEFAULT NULL,
  `TestTime` datetime DEFAULT NULL,
  KEY `StuId` (`StuId`),
  KEY `Qid` (`Qid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `totalscore`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `totalscore`;
CREATE TABLE IF NOT EXISTS `totalscore` (
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
