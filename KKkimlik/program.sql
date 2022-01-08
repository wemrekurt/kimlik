-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Anamakine: localhost
-- Üretim Zamanı: 28 Şubat 2014 saat 16:58:23
-- Sunucu sürümü: 5.0.51
-- PHP Sürümü: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Veritabanı: `program`
-- 

-- --------------------------------------------------------

-- 
-- Tablo yapısı: `okul`
-- 

CREATE TABLE `okul` (
  `id` int(11) NOT NULL auto_increment,
  `okuladi` text,
  `ogretimyili` varchar(9) default NULL,
  `logo` longtext,
  `muduradi` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `okul`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `tasarim`
-- 

CREATE TABLE `tasarim` (
  `id` int(11) NOT NULL auto_increment,
  `ustrenk` varchar(7) default NULL,
  `arkaplan` text,
  `logo` text,
  `qr` varchar(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `tasarim`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `yemek`
-- 

CREATE TABLE `yemek` (
  `id` int(11) NOT NULL auto_increment,
  `isim` varchar(255) character set latin5 default NULL,
  `soyisim` varchar(255) character set latin5 default NULL,
  `numara` varchar(255) character set latin5 default NULL,
  `sinif` varchar(255) character set latin5 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=198 ;

-- 
-- Tablo döküm verisi `yemek`
-- 

INSERT INTO `yemek` VALUES (123, 'REYYAN', 'YANIK', '191', '10-D');
INSERT INTO `yemek` VALUES (122, 'HATİCE', 'BAYRAK', '471', '10-D');
INSERT INTO `yemek` VALUES (121, 'ZEHRA', 'KELEŞ', '451', '10-D');
INSERT INTO `yemek` VALUES (120, 'ALEYNA', 'ÇELEBİ', '283', '10-D');
INSERT INTO `yemek` VALUES (119, 'GÖKÇE AYŞE', 'AÇIŞ', '321', '10-C');
INSERT INTO `yemek` VALUES (118, 'ECEM', 'CENGİZ', '11', '10-C');
INSERT INTO `yemek` VALUES (117, 'ZEYNEP', 'KESKİN', '370', '10-C');
INSERT INTO `yemek` VALUES (116, 'HÜDANUR', 'GENÇ', '448', '10-C');
INSERT INTO `yemek` VALUES (115, 'NAZLI AYŞE', 'GÖKMEN', '141', '10-C');
INSERT INTO `yemek` VALUES (114, 'KADER', 'ÇAKMAK', '8', '10-C');
INSERT INTO `yemek` VALUES (113, 'BURCU', 'ACAR', '257', '10-C');
INSERT INTO `yemek` VALUES (112, 'KÜBRA', 'TURAN', '18', '10-B');
INSERT INTO `yemek` VALUES (111, 'TUĞÇE', 'SAĞDIÇ', '24', '10-B');
INSERT INTO `yemek` VALUES (110, 'KAMİL', 'UYANIK', '72', '10-B');
INSERT INTO `yemek` VALUES (109, 'ŞEVKİ', 'KARAGÖL', '43', '10-B');
INSERT INTO `yemek` VALUES (108, 'ELİF BEGÜM', 'ATEŞ', '211', '10-B');
INSERT INTO `yemek` VALUES (107, 'ÖZHAN', 'BAŞAR', '275', '10-B');
INSERT INTO `yemek` VALUES (106, 'SERAP', 'ÇAKIR', '35', '10-B');
INSERT INTO `yemek` VALUES (105, 'DEMET', 'ALIŞKAN', '9', '10-A');
INSERT INTO `yemek` VALUES (104, 'KÜBRA', 'ÇAY', '10', '10-A');
INSERT INTO `yemek` VALUES (103, 'EMİNE', 'İBRAHİMBAŞ', '13', '10-A');
INSERT INTO `yemek` VALUES (102, 'ÖYKÜ', 'GÜNEY', '247', '10-A');
INSERT INTO `yemek` VALUES (101, 'ONUR', 'SALKUM', '25', '10-A');
INSERT INTO `yemek` VALUES (100, 'HÜMEYRA', 'UYSAL', '478', '10-A');
INSERT INTO `yemek` VALUES (170, 'BURHAN', 'KARAGÖZ', '508', '9-C');
INSERT INTO `yemek` VALUES (169, 'MÜCAHİT MUHAMMET', 'AŞCI', '311', '9-C');
INSERT INTO `yemek` VALUES (168, 'CANSEL', 'GÜLLER', '393', '9-C');
INSERT INTO `yemek` VALUES (167, 'DİLARA', 'KELEŞ', '312', '9-C');
INSERT INTO `yemek` VALUES (166, 'BÜŞRA', 'ŞİŞMAN', '379', '9-C');
INSERT INTO `yemek` VALUES (165, 'NUR EFŞAN', 'BÜLBÜL', '453', '9-C');
INSERT INTO `yemek` VALUES (164, 'ALEYNA', 'ŞİMŞEK', '300', '9-C');
INSERT INTO `yemek` VALUES (163, 'ASLIHAN', 'GÜVEN', '323', '9-C');
INSERT INTO `yemek` VALUES (162, 'BURHAN', 'KARAGÖZ', '508', '9-C');
INSERT INTO `yemek` VALUES (161, 'MÜCAHİT MUHAMMET', 'AŞCI', '311', '9-C');
INSERT INTO `yemek` VALUES (160, 'ESMA', 'AK', '363', '9-B');
INSERT INTO `yemek` VALUES (159, 'DİLARA', 'DEMİRCİ', '397', '9-B');
INSERT INTO `yemek` VALUES (158, 'BETÜL', 'ÖZAYDIN', '493', '9-B');
INSERT INTO `yemek` VALUES (157, 'ESRA', 'YEŞİLYURT', '497', '9-B');
INSERT INTO `yemek` VALUES (156, 'AKİF İHSAN', 'NAS', '337', '9-B');
INSERT INTO `yemek` VALUES (155, 'MUHAMMED', 'YEŞİLYURT', '502', '9-B');
INSERT INTO `yemek` VALUES (154, 'CEMİLE', 'GÜVERCİN', '507', '9-A');
INSERT INTO `yemek` VALUES (153, 'ECE', 'KURT', '244', '9-A');
INSERT INTO `yemek` VALUES (152, 'HÜSEYİN', 'ŞENYÜZ', '98', '9-A');
INSERT INTO `yemek` VALUES (151, 'NURTEN', 'CİVELEK', '418', '12-D');
INSERT INTO `yemek` VALUES (150, 'CANSU', 'ÖNÇLER', '404', '12-C');
INSERT INTO `yemek` VALUES (149, 'HASRET', 'BULUT', '80', '12-A');
INSERT INTO `yemek` VALUES (148, 'BAHAR', 'KARACA', '139', '12-A');
INSERT INTO `yemek` VALUES (147, 'BÜŞRANUR', 'DUMAN', '173', '11-D');
INSERT INTO `yemek` VALUES (146, 'ENGİNCAN', 'ŞİŞİK', '430', '11-D');
INSERT INTO `yemek` VALUES (145, 'ELİF NUR', 'ALTUNTAŞ', '406', '11-D');
INSERT INTO `yemek` VALUES (144, 'YASİN', 'KILIÇ', '228', '11-D');
INSERT INTO `yemek` VALUES (143, 'RAMAZAN', 'BARDAK', '213', '11-C');
INSERT INTO `yemek` VALUES (142, 'BÜNYAMİN ÖMER', 'COŞKUN', '203', '11-C');
INSERT INTO `yemek` VALUES (141, 'MUHAMMED BAKİ', 'SEKMEN', '221', '11-C');
INSERT INTO `yemek` VALUES (140, 'ÇAĞLA', 'ÖZTÜRK', '401', '11-B');
INSERT INTO `yemek` VALUES (139, 'BAHAR', 'ULUÇAY', '457', '11-B');
INSERT INTO `yemek` VALUES (138, 'FURKAN', 'İNAN', '395', '11-B');
INSERT INTO `yemek` VALUES (137, 'BAYRAM CAN', 'KAYA', '216', '11-B');
INSERT INTO `yemek` VALUES (136, 'FURKAN', 'DAĞKUŞ', '171', '11-B');
INSERT INTO `yemek` VALUES (135, 'MAHMUT UĞURCAN', 'KÖROĞLU', '444', '11-B');
INSERT INTO `yemek` VALUES (134, 'ABDULLAH CEYLAN', 'İNAN', '443', '11-B');
INSERT INTO `yemek` VALUES (133, 'MECİT', 'SÖNMEZ', '186', '11-A');
INSERT INTO `yemek` VALUES (132, 'MAHMUT ONUR', 'ÖCAL', '396', '11-A');
INSERT INTO `yemek` VALUES (131, 'NİHAT', 'ALPTEKİN', '168', '11-A');
INSERT INTO `yemek` VALUES (130, 'SEMİH', 'DEMİR', '183', '11-A');
INSERT INTO `yemek` VALUES (129, 'BUSENUR', 'BALKAYA', '19', '10-D');
INSERT INTO `yemek` VALUES (128, 'YELİZ', 'YALÇIN', '20', '10-D');
INSERT INTO `yemek` VALUES (127, 'AHMET CAN', 'ÇİL', '429', '10-D');
INSERT INTO `yemek` VALUES (126, 'SEDANUR', 'YILMAZ', '315', '10-D');
INSERT INTO `yemek` VALUES (125, 'BEYZANUR', 'AKSOY', '303', '10-D');
INSERT INTO `yemek` VALUES (124, 'MERVE', 'YILDIZ', '227', '10-D');
INSERT INTO `yemek` VALUES (171, 'GİZEM NUR', 'OCAK', '82', '9-D');
INSERT INTO `yemek` VALUES (172, 'ZEYNEP', 'YILDIRIM', '481', '9-D');
INSERT INTO `yemek` VALUES (173, 'ZEYNEP', 'YILDIRIM', '481', '9-D');
INSERT INTO `yemek` VALUES (174, 'EDA', 'GEVECİ', '74', '9-D');
INSERT INTO `yemek` VALUES (175, 'BEYZA', 'ATEŞLİ', '38', '9-D');
INSERT INTO `yemek` VALUES (176, 'ZEYNEP', 'AYFER', '57', '9-D');
INSERT INTO `yemek` VALUES (177, 'GİZEM', 'DEMİRCAN', '42', '9-D');
INSERT INTO `yemek` VALUES (178, 'SUDENAS', 'TEBER', '264', '9-D');
INSERT INTO `yemek` VALUES (179, 'İREM', 'GÜVEN', '360', '9-D');
INSERT INTO `yemek` VALUES (180, 'ŞAHAN', 'ÖZKAL', '34', '9-E');
INSERT INTO `yemek` VALUES (181, 'BATUHAN', 'SEĞMEN', '479', '9-E');
INSERT INTO `yemek` VALUES (182, 'SEVGİ VUSLAT', 'SORUKLU', '335', '9-E');
INSERT INTO `yemek` VALUES (183, 'BEYZA', 'KORKMAZ', '437', '9-E');
INSERT INTO `yemek` VALUES (184, 'CANSU', 'KURUL', '87', '9-E');
INSERT INTO `yemek` VALUES (185, 'ABDULLAH TEMELHAN', 'BAYRAM', '105', '9-E');
INSERT INTO `yemek` VALUES (186, 'EMRE CEM', 'AYDIN', '306', '9-E');
INSERT INTO `yemek` VALUES (187, 'AHMET ÇAĞATAY', 'ÇAĞLIYAN', '147', '9-A');
INSERT INTO `yemek` VALUES (188, 'OĞUZHAN', 'HOPAÇ', '503', '9-A');
INSERT INTO `yemek` VALUES (189, 'ABDURRAHİM', 'SAYIM', '352', '12-C');
INSERT INTO `yemek` VALUES (190, 'YAREN', 'NAZLIM', '215', '11-A');
INSERT INTO `yemek` VALUES (191, 'AHMET CAN', 'UYAR', '194', '11-A');
INSERT INTO `yemek` VALUES (192, 'ASEL', 'CENGİZ', '420', '11-C');
INSERT INTO `yemek` VALUES (193, 'BANU', 'GÜN', '164', '11-C');
INSERT INTO `yemek` VALUES (194, 'CEREN', 'AKGÜN', '37', '11-C');
INSERT INTO `yemek` VALUES (195, 'NESLİHAN', 'AKBAŞ', '163', '11-C');
INSERT INTO `yemek` VALUES (196, 'BEYZA', 'UÇAR', '460', '10-B');
INSERT INTO `yemek` VALUES (197, 'BİRKAN', 'KÖSE', '392', '9-E');
