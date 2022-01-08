-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 Eyl 2015, 14:07:53
-- Sunucu sürümü: 5.6.21
-- PHP Sürümü: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `kimlika`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kimlik`
--

CREATE TABLE IF NOT EXISTS `kimlik` (
`id` int(11) NOT NULL,
  `okulid` int(11) NOT NULL,
  `Gbgcolor` varchar(7) NOT NULL DEFAULT '#ffffff',
  `Gtxtcolor` varchar(7) NOT NULL DEFAULT '#000000',
  `Gbordercolor` varchar(7) NOT NULL DEFAULT '#000000',
  `Gtcgoster` varchar(4) DEFAULT NULL,
  `Gbolumgoster` varchar(4) DEFAULT NULL,
  `Gokulogrenci` varchar(4) DEFAULT NULL,
  `Gfont` varchar(30) NOT NULL DEFAULT 'Verdana',
  `Gline` varchar(6) NOT NULL DEFAULT '1em',
  `Gtxsize` varchar(5) NOT NULL DEFAULT '12px',
  `Gmdsize` varchar(5) NOT NULL DEFAULT '10px',
  `Gmduzk` varchar(5) NOT NULL DEFAULT '0px',
  `Bbgcolor` varchar(7) NOT NULL DEFAULT '#ff0000',
  `Btxcolor` varchar(7) NOT NULL DEFAULT '#ffffff',
  `Bfont` varchar(30) NOT NULL DEFAULT 'Verdana',
  `Btxsize` varchar(5) NOT NULL DEFAULT '12px',
  `Bline` varchar(6) NOT NULL DEFAULT '1em',
  `Baltgoster` varchar(4) DEFAULT NULL,
  `Baltsize` varchar(5) NOT NULL DEFAULT '10px',
  `Baltuzk` varchar(5) NOT NULL DEFAULT '0px',
  `Baltczg` varchar(4) DEFAULT NULL,
  `tur` int(1) NOT NULL DEFAULT '1',
  `arkares` varchar(159) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrenci`
--

CREATE TABLE IF NOT EXISTS `ogrenci` (
`id` int(11) NOT NULL,
  `okulid` int(11) NOT NULL,
  `sinif` varchar(10) NOT NULL,
  `numara` varchar(10) DEFAULT NULL,
  `isim` varchar(30) NOT NULL,
  `soyisim` varchar(30) NOT NULL,
  `tcno` int(11) DEFAULT NULL,
  `bolum` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `okul`
--

CREATE TABLE IF NOT EXISTS `okul` (
`id` int(11) NOT NULL,
  `yil` varchar(20) DEFAULT NULL,
  `okuladi` varchar(80) DEFAULT NULL,
  `sef` varchar(100) DEFAULT NULL,
  `muduradi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `kimlik`
--
ALTER TABLE `kimlik`
 ADD PRIMARY KEY (`id`), ADD KEY `okulid` (`okulid`);

--
-- Tablo için indeksler `ogrenci`
--
ALTER TABLE `ogrenci`
 ADD PRIMARY KEY (`id`), ADD KEY `okulid` (`okulid`);

--
-- Tablo için indeksler `okul`
--
ALTER TABLE `okul`
 ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `kimlik`
--
ALTER TABLE `kimlik`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `ogrenci`
--
ALTER TABLE `ogrenci`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `okul`
--
ALTER TABLE `okul`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `kimlik`
--
ALTER TABLE `kimlik`
ADD CONSTRAINT `kimlik_ibfk_1` FOREIGN KEY (`okulid`) REFERENCES `okul` (`id`);

--
-- Tablo kısıtlamaları `ogrenci`
--
ALTER TABLE `ogrenci`
ADD CONSTRAINT `ogrenci_ibfk_1` FOREIGN KEY (`okulid`) REFERENCES `okul` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
