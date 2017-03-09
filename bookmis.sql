-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2016-12-18 13:15:23
-- 服务器版本： 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookmis`
--

DELIMITER $$
--
-- 存储过程
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `borr` (IN `Reader_id` VARCHAR(5), IN `Book_id` VARCHAR(5), IN `Date_borrow` DATE, IN `Date_return` DATE, OUT `result` INT)  label : BEGIN 
	DECLARE inDate_borrow DATE; 
	DECLARE inQuantity int;
    DECLARE inloss int;
    DECLARE innum int;
    DECLARE inuse int;
    DECLARE inborrow int;
	SELECT history_borr.Date_borrow INTO inDate_borrow from history_borr WHERE history_borr.Reader_id=Reader_id AND history_borr.Book_id=Book_id; 
	if inDate_borrow=Date_borrow THEN 
    	
		SET result = 0; 
        LEAVE label; 
	END IF;
	SELECT Quantity_in-Quantity_out-Quantity_loss AS Quantity INTO inQuantity from books WHERE books.Book_id = Book_id; 
	if inQuantity=0 THEN 
    	
		SET result = 1; 
		LEAVE label; 
	END IF;
    SELECT COUNT(*) as loss INTO inloss from loss_reporting WHERE loss_reporting.Reader_id = Reader_id ;
    IF inloss > 0 THEN
    	
        SET result = 2;
     	LEAVE label;
    END IF;
    SELECT maxnum,used INTO innum,inuse from card_info WHERE card_info.Reader_id = Reader_id;
    IF innum =inuse THEN
    	
    	SET result=3;
        LEAVE label;
    END IF;
    SELECT COUNT(*) AS borr INTO inborrow FROM borrow_info WHERE borrow_info.Book_id = Book_id AND borrow_info.Reader_id = Reader_id;
    IF inborrow>0 THEN
    	SET result = 4;
        LEAVE label;
    END IF;
	insert borrow(Book_id,Reader_id,Date_borrow,Date_return,loss) value(Book_id,Reader_id,Date_borrow,Date_return,'否'); 
	UPDATE books SET Quantity_out=Quantity+1 WHERE books.Book_id = Book_id; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ret` (IN `Book_id` VARCHAR(5), IN `Reader_id` VARCHAR(5), IN `Date_borrow` DATE, IN `Date_return` DATE, OUT `result` INT)  label : BEGIN
	DECLARE inreader int;
    DECLARE inbook int;
	SELECT COUNT(*)as reader INTO inreader from borrow WHERE borrow.Reader_id = Reader_id AND borrow.Book_id = Book_id;
    IF inreader = 0 THEN
    	SET result = 0;
        LEAVE label;
    END IF;
    SET result = 1;
    delete from borrow where borrow.Book_id=Book_id and borrow.Reader_id = Reader_id;
    insert into history_borr(Reader_id,Book_id,Date_borrow,Date_return)values(Reader_id,Book_id,Date_borrow,Date_return);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `name` varchar(10) NOT NULL COMMENT '用户名',
  `password` varchar(20) NOT NULL COMMENT '密码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`name`, `password`) VALUES
('admin', '123'),
('r', '1'),
('root', '1');

-- --------------------------------------------------------

--
-- 表的结构 `books`
--

CREATE TABLE `books` (
  `Book_id` varchar(5) NOT NULL COMMENT '书号',
  `Book_name` varchar(50) NOT NULL COMMENT '书名',
  `author` varchar(20) NOT NULL COMMENT '作者',
  `publishing` varchar(20) NOT NULL COMMENT '出版社',
  `Category_id` varchar(5) NOT NULL COMMENT '分类号',
  `price` float NOT NULL COMMENT '价格',
  `Date_in` date NOT NULL COMMENT '入库时间',
  `Quantity_in` int(11) NOT NULL COMMENT '入库数',
  `Quantity_out` int(11) NOT NULL COMMENT '出库数',
  `Quantity_loss` int(11) NOT NULL COMMENT '丢失数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `books`
--

INSERT INTO `books` (`Book_id`, `Book_name`, `author`, `publishing`, `Category_id`, `price`, `Date_in`, `Quantity_in`, `Quantity_out`, `Quantity_loss`) VALUES
('b001', '并行计算', '王一', '北京交通大学出版社', 'ca01', 20, '2016-11-30', 2, 2, 2),
('b002', '建筑艺术', '李白', '清华大学出版社', 'ca07', 40, '2016-12-06', 8, 3, 0),
('b003', '神奇的科学', '刘力', '清华大学出版社', 'ca04', 18, '2009-12-09', 5, 0, 0),
('b004', '网络原理', '张扬', '邮电出版社', 'ca05', 38, '2010-02-23', 10, 1, 0),
('b005', '肺病防治', '李小明', '人民卫生出版社', 'ca03', 16, '2009-04-05', 5, 0, 0),
('b006', '养殖技术', '王平', '中国农业出版社', 'ca02', 11, '2010-08-01', 2, 1, 3),
('b007', '分布式系统', '陈东', '武汉大学出版社', 'ca01', 32, '2010-06-13', 9, 0, 0);

--
-- 触发器 `books`
--
DELIMITER $$
CREATE TRIGGER `loss` AFTER UPDATE ON `books` FOR EACH ROW BEGIN
	IF new.Quantity_loss>old.Quantity_in THEN 				UPDATE books SET Quantity_loss = old.Quantity_in;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `book_info`
-- (See below for the actual view)
--
CREATE TABLE `book_info` (
`Book_id` varchar(5)
,`Book_name` varchar(50)
,`category` varchar(10)
,`author` varchar(20)
,`publishing` varchar(20)
,`price` float
,`Quantity_in` int(11)
,`Quantity_left` bigint(12)
);

-- --------------------------------------------------------

--
-- 表的结构 `borrow`
--

CREATE TABLE `borrow` (
  `Reader_id` varchar(5) NOT NULL COMMENT '读者证号',
  `Book_id` varchar(5) NOT NULL COMMENT '书号',
  `Date_borrow` date NOT NULL COMMENT '借出日期',
  `Date_return` date NOT NULL COMMENT '归还日期',
  `loss` char(2) NOT NULL COMMENT '是否丢失'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `borrow`
--

INSERT INTO `borrow` (`Reader_id`, `Book_id`, `Date_borrow`, `Date_return`, `loss`) VALUES
('r001', 'b001', '2016-08-02', '2016-09-02', '否'),
('r001', 'b002', '2016-08-02', '2016-09-02', '否'),
('r002', 'b006', '2016-07-09', '2016-08-09', '否'),
('r004', 'b001', '2015-08-02', '2015-11-02', '否'),
('r004', 'b002', '2016-08-10', '2016-09-10', '否'),
('r006', 'b001', '2016-08-10', '2016-09-10', '否'),
('r006', 'b002', '2016-06-25', '2016-07-25', '否'),
('r006', 'b004', '2016-06-24', '2016-07-24', '否');

--
-- 触发器 `borrow`
--
DELIMITER $$
CREATE TRIGGER `t_borrow` AFTER INSERT ON `borrow` FOR EACH ROW BEGIN
	UPDATE books SET Quantity_out = Quantity_out+1 WHERE books.Book_id = new.Book_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `t_return` AFTER DELETE ON `borrow` FOR EACH ROW BEGIN
	UPDATE books SET Quantity_out = Quantity_out-1 WHERE books.Book_id = old.Book_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `borrow_info`
-- (See below for the actual view)
--
CREATE TABLE `borrow_info` (
`Book_id` varchar(5)
,`Book_name` varchar(50)
,`author` varchar(20)
,`price` float
,`Reader_id` varchar(5)
,`Reader_name` varchar(20)
,`Date_borrow` date
,`Date_return` date
,`Date_more` int(7)
);

-- --------------------------------------------------------

--
-- 表的结构 `b_category`
--

CREATE TABLE `b_category` (
  `Category_id` varchar(5) NOT NULL COMMENT '分类号',
  `category` varchar(10) NOT NULL COMMENT '分类名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `b_category`
--

INSERT INTO `b_category` (`Category_id`, `category`) VALUES
('ca01', '计算机'),
('ca02', '农林'),
('ca03', '医学'),
('ca04', '科普'),
('ca05', '通讯'),
('ca06', '自然科学'),
('ca07', '建筑');

-- --------------------------------------------------------

--
-- 替换视图以便查看 `card_info`
-- (See below for the actual view)
--
CREATE TABLE `card_info` (
`Reader_id` varchar(5)
,`Reader_name` varchar(20)
,`level` varchar(5)
,`maxdays` smallint(6)
,`maxnum` int(11)
,`used` bigint(21)
);

-- --------------------------------------------------------

--
-- 替换视图以便查看 `history`
-- (See below for the actual view)
--
CREATE TABLE `history` (
`Book_id` varchar(5)
,`Book_name` varchar(50)
,`author` varchar(20)
,`price` float
,`Reader_id` varchar(5)
,`Reader_name` varchar(20)
,`Date_borrow` date
,`Date_return` date
);

-- --------------------------------------------------------

--
-- 表的结构 `history_borr`
--

CREATE TABLE `history_borr` (
  `Reader_id` varchar(5) NOT NULL COMMENT '读者证号',
  `Book_id` varchar(5) NOT NULL COMMENT '书编号',
  `Date_borrow` date NOT NULL COMMENT '借书日期',
  `Date_return` date NOT NULL COMMENT '还书日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `history_borr`
--

INSERT INTO `history_borr` (`Reader_id`, `Book_id`, `Date_borrow`, `Date_return`) VALUES
('r001', 'b004', '2015-01-01', '2016-12-10'),
('r001', 'b005', '2016-12-10', '2016-12-10'),
('r002', 'b002', '2016-12-10', '2016-12-10'),
('r002', 'b002', '2016-12-11', '2016-12-11'),
('r003', 'b002', '2016-12-10', '2016-12-10');

-- --------------------------------------------------------

--
-- 表的结构 `loss_reporting`
--

CREATE TABLE `loss_reporting` (
  `Reader_id` varchar(5) NOT NULL COMMENT '读者证号',
  `Loss_date` date NOT NULL COMMENT '挂失日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `loss_reporting`
--

INSERT INTO `loss_reporting` (`Reader_id`, `Loss_date`) VALUES
('r005', '2016-09-01');

-- --------------------------------------------------------

--
-- 表的结构 `member_level`
--

CREATE TABLE `member_level` (
  `level` varchar(6) NOT NULL COMMENT '会员等级',
  `days` smallint(6) NOT NULL COMMENT '天数',
  `num` int(11) NOT NULL COMMENT '最多借阅册书',
  `numbers` smallint(6) NOT NULL COMMENT '会员个数',
  `fee` smallint(6) NOT NULL COMMENT '价格'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `member_level`
--

INSERT INTO `member_level` (`level`, `days`, `num`, `numbers`, `fee`) VALUES
('普通', 30, 5, 2, 10),
('金卡', 90, 15, 5, 100),
('银卡', 60, 10, 3, 50);

-- --------------------------------------------------------

--
-- 表的结构 `readers`
--

CREATE TABLE `readers` (
  `Reader_id` varchar(5) NOT NULL COMMENT '读者证号',
  `Reader_name` varchar(20) NOT NULL COMMENT '读者姓名',
  `sex` char(2) DEFAULT NULL COMMENT '性别',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `password` varchar(20) NOT NULL COMMENT '密码',
  `phone` int(11) DEFAULT NULL COMMENT '电话',
  `mobile` varchar(11) NOT NULL COMMENT '手机',
  `Card_name` varchar(8) NOT NULL COMMENT '卡名',
  `Card_id` varchar(18) NOT NULL COMMENT '卡号',
  `level` varchar(5) NOT NULL COMMENT '会员等级',
  `day` date NOT NULL COMMENT '办卡日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `readers`
--

INSERT INTO `readers` (`Reader_id`, `Reader_name`, `sex`, `birthday`, `password`, `phone`, `mobile`, `Card_name`, `Card_id`, `level`, `day`) VALUES
('r001', '李红', '女', '1988-03-07', '2', 62127790, '13671100110', '身份证', '230106198803070178', '金卡', '2016-12-04'),
('r002', '刘晓', '男', '1990-08-09', '1', 84778123, '13671007896', '身份证', '210103199008094326', '普通', '2011-08-01'),
('r003', '张英', '女', '2001-02-21', '1', NULL, '13901020111', '身份证', '230106200102216634', '普通', '2010-08-01'),
('r004', '张刚', '男', '1970-11-12', '1', 51681212, '13812669002', '身份证', '230106197011120145', '金卡', '2010-06-20'),
('r005', '刘静', '女', '1999-10-07', '1', 51681213, '13756705671', '身份证', '230106199910070766', '普通', '2009-04-05'),
('r006', '王成林', '男', '1990-05-18', '1', 82161100, '13683304305', '身份证', '230106199005180842', '银卡', '2010-08-01'),
('r007', '许晨', '男', '2001-09-24', '1', 82190703, '13901229706', '身份证', '230106200109247092', '普通', '2010-05-15'),
('r008', '范晓天', '女', '1998-08-25', '1', 62220506, '15851327667', '身份证', '230106199808258261', '普通', '2008-12-20'),
('r009', '姜武', '男', '1997-07-09', '1', 62220712, '15810034321', '身份证', '230106199707095578', '普通', '2013-08-01');

-- --------------------------------------------------------

--
-- 视图结构 `book_info`
--
DROP TABLE IF EXISTS `book_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `book_info`  AS  select `books`.`Book_id` AS `Book_id`,`books`.`Book_name` AS `Book_name`,`b_category`.`category` AS `category`,`books`.`author` AS `author`,`books`.`publishing` AS `publishing`,`books`.`price` AS `price`,`books`.`Quantity_in` AS `Quantity_in`,(`books`.`Quantity_in` - `books`.`Quantity_out`) AS `Quantity_left` from (`books` join `b_category`) where (`b_category`.`Category_id` = `books`.`Category_id`) ;

-- --------------------------------------------------------

--
-- 视图结构 `borrow_info`
--
DROP TABLE IF EXISTS `borrow_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `borrow_info`  AS  select `books`.`Book_id` AS `Book_id`,`books`.`Book_name` AS `Book_name`,`books`.`author` AS `author`,`books`.`price` AS `price`,`card_info`.`Reader_id` AS `Reader_id`,`card_info`.`Reader_name` AS `Reader_name`,`borrow`.`Date_borrow` AS `Date_borrow`,`borrow`.`Date_return` AS `Date_return`,(to_days(curdate()) - to_days(`borrow`.`Date_return`)) AS `Date_more` from ((`books` join `card_info`) join `borrow`) where ((`books`.`Book_id` = `borrow`.`Book_id`) and (`card_info`.`Reader_id` = `borrow`.`Reader_id`)) ;

-- --------------------------------------------------------

--
-- 视图结构 `card_info`
--
DROP TABLE IF EXISTS `card_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `card_info`  AS  select `readers`.`Reader_id` AS `Reader_id`,`readers`.`Reader_name` AS `Reader_name`,`readers`.`level` AS `level`,`member_level`.`days` AS `maxdays`,`member_level`.`num` AS `maxnum`,count(`borrow`.`Reader_id`) AS `used` from ((`readers` left join `member_level` on((`member_level`.`level` = `readers`.`level`))) left join `borrow` on((`borrow`.`Reader_id` = `readers`.`Reader_id`))) group by `readers`.`Reader_id` ;

-- --------------------------------------------------------

--
-- 视图结构 `history`
--
DROP TABLE IF EXISTS `history`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `history`  AS  select `books`.`Book_id` AS `Book_id`,`books`.`Book_name` AS `Book_name`,`books`.`author` AS `author`,`books`.`price` AS `price`,`readers`.`Reader_id` AS `Reader_id`,`readers`.`Reader_name` AS `Reader_name`,`history_borr`.`Date_borrow` AS `Date_borrow`,`history_borr`.`Date_return` AS `Date_return` from ((`books` join `readers`) join `history_borr`) where ((`history_borr`.`Reader_id` = `readers`.`Reader_id`) and (`history_borr`.`Book_id` = `books`.`Book_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`Book_id`),
  ADD KEY `Category_id` (`Category_id`),
  ADD KEY `Category_id_2` (`Category_id`);

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`Reader_id`,`Book_id`),
  ADD KEY `Reader_id` (`Reader_id`),
  ADD KEY `Book_id` (`Book_id`),
  ADD KEY `Book_id_2` (`Book_id`);

--
-- Indexes for table `b_category`
--
ALTER TABLE `b_category`
  ADD PRIMARY KEY (`Category_id`);

--
-- Indexes for table `history_borr`
--
ALTER TABLE `history_borr`
  ADD PRIMARY KEY (`Reader_id`,`Book_id`,`Date_borrow`),
  ADD KEY `Book_id` (`Book_id`);

--
-- Indexes for table `loss_reporting`
--
ALTER TABLE `loss_reporting`
  ADD PRIMARY KEY (`Reader_id`);

--
-- Indexes for table `member_level`
--
ALTER TABLE `member_level`
  ADD PRIMARY KEY (`level`);

--
-- Indexes for table `readers`
--
ALTER TABLE `readers`
  ADD PRIMARY KEY (`Reader_id`),
  ADD KEY `level` (`level`);

--
-- 限制导出的表
--

--
-- 限制表 `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`Category_id`) REFERENCES `b_category` (`Category_id`);

--
-- 限制表 `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrow_ibfk_1` FOREIGN KEY (`Reader_id`) REFERENCES `readers` (`Reader_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `borrow_ibfk_2` FOREIGN KEY (`Book_id`) REFERENCES `books` (`Book_id`);

--
-- 限制表 `history_borr`
--
ALTER TABLE `history_borr`
  ADD CONSTRAINT `history_borr_ibfk_1` FOREIGN KEY (`Reader_id`) REFERENCES `readers` (`Reader_id`),
  ADD CONSTRAINT `history_borr_ibfk_2` FOREIGN KEY (`Book_id`) REFERENCES `books` (`Book_id`);

--
-- 限制表 `loss_reporting`
--
ALTER TABLE `loss_reporting`
  ADD CONSTRAINT `loss_reporting_ibfk_1` FOREIGN KEY (`Reader_id`) REFERENCES `readers` (`Reader_id`);

--
-- 限制表 `readers`
--
ALTER TABLE `readers`
  ADD CONSTRAINT `readers_ibfk_1` FOREIGN KEY (`level`) REFERENCES `member_level` (`level`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
