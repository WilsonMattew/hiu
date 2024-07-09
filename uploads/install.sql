-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 12, 2021 at 12:48 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mastery`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `bookmark_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `date_added` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slugify` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `icon_class` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` int(10) NOT NULL DEFAULT '0',
  `data` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `class_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8_unicode_ci,
  `description` longtext COLLATE utf8_unicode_ci,
  `class_thumbnail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_free` int(11) DEFAULT '0',
  `is_featured` int(11) DEFAULT NULL,
  `is_recommended` int(11) NOT NULL DEFAULT '0',
  `is_slider` int(11) DEFAULT NULL,
  `total_duration` int(11) NOT NULL DEFAULT '0',
  `status` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'active, pending, inactive',
  `date_added` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_updated` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `paypal_supported` int(11) DEFAULT NULL,
  `stripe_supported` int(11) DEFAULT NULL,
  `razorpay_supported` int(11) NOT NULL DEFAULT '1',
  `paytm_supported` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `code`, `symbol`, `paypal_supported`, `stripe_supported`, `razorpay_supported`, `paytm_supported`) VALUES
(1, 'Leke', 'ALL', 'Lek', 0, 1, 1, 1),
(2, 'Dollars', 'USD', '$', 1, 1, 1, 1),
(3, 'Afghanis', 'AFN', '؋', 0, 1, 1, 1),
(4, 'Pesos', 'ARS', '$', 0, 1, 1, 1),
(5, 'Guilders', 'AWG', 'ƒ', 0, 1, 1, 1),
(6, 'Dollars', 'AUD', '$', 1, 1, 1, 1),
(7, 'New Manats', 'AZN', 'ман', 0, 1, 1, 1),
(8, 'Dollars', 'BSD', '$', 0, 1, 1, 1),
(9, 'Dollars', 'BBD', '$', 0, 1, 1, 1),
(10, 'Rubles', 'BYR', 'p.', 0, 0, 1, 1),
(11, 'Euro', 'EUR', '€', 1, 1, 1, 1),
(12, 'Dollars', 'BZD', 'BZ$', 0, 1, 1, 1),
(13, 'Dollars', 'BMD', '$', 0, 1, 1, 1),
(14, 'Bolivianos', 'BOB', '$b', 0, 1, 1, 1),
(15, 'Convertible Marka', 'BAM', 'KM', 0, 1, 1, 1),
(16, 'Pula', 'BWP', 'P', 0, 1, 1, 1),
(17, 'Leva', 'BGN', 'лв', 0, 1, 1, 1),
(18, 'Reais', 'BRL', 'R$', 1, 1, 1, 1),
(19, 'Pounds', 'GBP', '£', 1, 1, 1, 1),
(20, 'Dollars', 'BND', '$', 0, 1, 1, 1),
(21, 'Riels', 'KHR', '៛', 0, 1, 1, 1),
(22, 'Dollars', 'CAD', '$', 1, 1, 1, 1),
(23, 'Dollars', 'KYD', '$', 0, 1, 1, 1),
(24, 'Pesos', 'CLP', '$', 0, 1, 1, 1),
(25, 'Yuan Renminbi', 'CNY', '¥', 0, 1, 1, 1),
(26, 'Pesos', 'COP', '$', 0, 1, 1, 1),
(27, 'Colón', 'CRC', '₡', 0, 1, 1, 1),
(28, 'Kuna', 'HRK', 'kn', 0, 1, 1, 1),
(29, 'Pesos', 'CUP', '₱', 0, 0, 1, 1),
(30, 'Koruny', 'CZK', 'Kč', 1, 1, 1, 1),
(31, 'Kroner', 'DKK', 'kr', 1, 1, 1, 1),
(32, 'Pesos', 'DOP ', 'RD$', 0, 1, 1, 1),
(33, 'Dollars', 'XCD', '$', 0, 1, 1, 1),
(34, 'Pounds', 'EGP', '£', 0, 1, 1, 1),
(35, 'Colones', 'SVC', '$', 0, 0, 1, 1),
(36, 'Pounds', 'FKP', '£', 0, 1, 1, 1),
(37, 'Dollars', 'FJD', '$', 0, 1, 1, 1),
(38, 'Cedis', 'GHC', '¢', 0, 0, 1, 1),
(39, 'Pounds', 'GIP', '£', 0, 1, 1, 1),
(40, 'Quetzales', 'GTQ', 'Q', 0, 1, 1, 1),
(41, 'Pounds', 'GGP', '£', 0, 0, 1, 1),
(42, 'Dollars', 'GYD', '$', 0, 1, 1, 1),
(43, 'Lempiras', 'HNL', 'L', 0, 1, 1, 1),
(44, 'Dollars', 'HKD', '$', 1, 1, 1, 1),
(45, 'Forint', 'HUF', 'Ft', 1, 1, 1, 1),
(46, 'Kronur', 'ISK', 'kr', 0, 1, 1, 1),
(47, 'Rupees', 'INR', '₹', 1, 1, 1, 1),
(48, 'Rupiahs', 'IDR', 'Rp', 0, 1, 1, 1),
(49, 'Rials', 'IRR', '﷼', 0, 0, 1, 1),
(50, 'Pounds', 'IMP', '£', 0, 0, 1, 1),
(51, 'New Shekels', 'ILS', '₪', 1, 1, 1, 1),
(52, 'Dollars', 'JMD', 'J$', 0, 1, 1, 1),
(53, 'Yen', 'JPY', '¥', 1, 1, 1, 1),
(54, 'Pounds', 'JEP', '£', 0, 0, 1, 1),
(55, 'Tenge', 'KZT', 'лв', 0, 1, 1, 1),
(56, 'Won', 'KPW', '₩', 0, 0, 1, 1),
(57, 'Won', 'KRW', '₩', 0, 1, 1, 1),
(58, 'Soms', 'KGS', 'лв', 0, 1, 1, 1),
(59, 'Kips', 'LAK', '₭', 0, 1, 1, 1),
(60, 'Lati', 'LVL', 'Ls', 0, 0, 1, 1),
(61, 'Pounds', 'LBP', '£', 0, 1, 1, 1),
(62, 'Dollars', 'LRD', '$', 0, 1, 1, 1),
(63, 'Switzerland Francs', 'CHF', 'CHF', 1, 1, 1, 1),
(64, 'Litai', 'LTL', 'Lt', 0, 0, 1, 1),
(65, 'Denars', 'MKD', 'ден', 0, 1, 1, 1),
(66, 'Ringgits', 'MYR', 'RM', 1, 1, 1, 1),
(67, 'Rupees', 'MUR', '₨', 0, 1, 1, 1),
(68, 'Pesos', 'MXN', '$', 1, 1, 1, 1),
(69, 'Tugriks', 'MNT', '₮', 0, 1, 1, 1),
(70, 'Meticais', 'MZN', 'MT', 0, 1, 1, 1),
(71, 'Dollars', 'NAD', '$', 0, 1, 1, 1),
(72, 'Rupees', 'NPR', '₨', 0, 1, 1, 1),
(73, 'Guilders', 'ANG', 'ƒ', 0, 1, 1, 1),
(74, 'Dollars', 'NZD', '$', 1, 1, 1, 1),
(75, 'Cordobas', 'NIO', 'C$', 0, 1, 1, 1),
(76, 'Nairas', 'NGN', '₦', 0, 1, 1, 1),
(77, 'Krone', 'NOK', 'kr', 1, 1, 1, 1),
(78, 'Rials', 'OMR', '﷼', 0, 0, 1, 1),
(79, 'Rupees', 'PKR', '₨', 0, 1, 1, 1),
(80, 'Balboa', 'PAB', 'B/.', 0, 1, 1, 1),
(81, 'Guarani', 'PYG', 'Gs', 0, 1, 1, 1),
(82, 'Nuevos Soles', 'PEN', 'S/.', 0, 1, 1, 1),
(83, 'Pesos', 'PHP', 'Php', 1, 1, 1, 1),
(84, 'Zlotych', 'PLN', 'zł', 1, 1, 1, 1),
(85, 'Rials', 'QAR', '﷼', 0, 1, 1, 1),
(86, 'New Lei', 'RON', 'lei', 0, 1, 1, 1),
(87, 'Rubles', 'RUB', 'руб', 1, 1, 1, 1),
(88, 'Pounds', 'SHP', '£', 0, 1, 1, 1),
(89, 'Riyals', 'SAR', '﷼', 0, 1, 1, 1),
(90, 'Dinars', 'RSD', 'Дин.', 0, 1, 1, 1),
(91, 'Rupees', 'SCR', '₨', 0, 1, 1, 1),
(92, 'Dollars', 'SGD', '$', 1, 1, 1, 1),
(93, 'Dollars', 'SBD', '$', 0, 1, 1, 1),
(94, 'Shillings', 'SOS', 'S', 0, 1, 1, 1),
(95, 'Rand', 'ZAR', 'R', 0, 1, 1, 1),
(96, 'Rupees', 'LKR', '₨', 0, 1, 1, 1),
(97, 'Kronor', 'SEK', 'kr', 1, 1, 1, 1),
(98, 'Dollars', 'SRD', '$', 0, 1, 1, 1),
(99, 'Pounds', 'SYP', '£', 0, 0, 1, 1),
(100, 'New Dollars', 'TWD', 'NT$', 1, 1, 1, 1),
(101, 'Baht', 'THB', '฿', 1, 1, 1, 1),
(102, 'Dollars', 'TTD', 'TT$', 0, 1, 1, 1),
(103, 'Lira', 'TRY', 'TL', 0, 1, 1, 1),
(104, 'Liras', 'TRL', '£', 0, 0, 1, 1),
(105, 'Dollars', 'TVD', '$', 0, 0, 1, 1),
(106, 'Hryvnia', 'UAH', '₴', 0, 1, 1, 1),
(107, 'Pesos', 'UYU', '$U', 0, 1, 1, 1),
(108, 'Sums', 'UZS', 'лв', 0, 1, 1, 1),
(109, 'Bolivares Fuertes', 'VEF', 'Bs', 0, 0, 1, 1),
(110, 'Dong', 'VND', '₫', 0, 1, 1, 1),
(111, 'Rials', 'YER', '﷼', 0, 1, 1, 1),
(112, 'Zimbabwe Dollars', 'ZWD', 'Z$', 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE `discussions` (
  `discussion_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `added_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `follower_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `follower_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_settings`
--

CREATE TABLE `frontend_settings` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `frontend_settings`
--

INSERT INTO `frontend_settings` (`id`, `type`, `description`) VALUES
(3, 'favicon', 'favicon.png'),
(4, 'light-logo', 'light-logo.png'),
(7, 'privacy_policy', '&lt;p class=&quot;rich-content-wrapper&quot;&gt;&lt;h2 id=&quot;What_Is_A_Privacy_Policy&quot; style=&quot;margin-top: 2.4rem; margin-bottom: 1.4rem; font-weight: 700; line-height: 1.2; color: rgb(70, 72, 85); font-size: 2rem; font-family: &amp;quot;Helvetica Neue&amp;quot;, Arial, sans-serif, &amp;quot;Apple Color Emoji&amp;quot;, &amp;quot;Segoe UI Emoji&amp;quot;, &amp;quot;Segoe UI Symbol&amp;quot;, &amp;quot;Noto Color Emoji&amp;quot;;&quot;&gt;What is a Privacy Policy?&lt;/h2&gt;&lt;h1&gt;&lt;p style=&quot;margin-bottom: 1.6rem; color: rgb(70, 72, 85); font-family: &amp;quot;Helvetica Neue&amp;quot;, Arial, sans-serif, &amp;quot;Apple Color Emoji&amp;quot;, &amp;quot;Segoe UI Emoji&amp;quot;, &amp;quot;Segoe UI Symbol&amp;quot;, &amp;quot;Noto Color Emoji&amp;quot;; font-size: 20px;&quot;&gt;A Privacy Policy is a statement or a legal document that states how a company or website&amp;nbsp;&lt;span style=&quot;font-weight: 700;&quot;&gt;collects&lt;/span&gt;,&amp;nbsp;&lt;span style=&quot;font-weight: 700;&quot;&gt;handles&lt;/span&gt;&amp;nbsp;and&amp;nbsp;&lt;span style=&quot;font-weight: 700;&quot;&gt;processes data&lt;/span&gt;&amp;nbsp;of its customers and visitors. It explicitly describes whether that information is kept confidential, or is shared with or sold to third parties.&lt;/p&gt;&lt;/h1&gt;&lt;/p&gt;'),
(8, 'terms_and_condition', '&lt;p&gt;This is terms &amp;amp; condition&lt;br&gt;&lt;/p&gt;'),
(9, 'top_notification', '&lt;strong class=&quot;text-13&quot;&gt;Get 7 free days of Mastery Premium for unlimited access to all of the online classes. &lt;a href=&quot;http://localhost/mastery/membership&quot;&gt;Click here!&lt;/a&gt;&lt;/strong&gt;'),
(10, 'top_notification_status', '1'),
(11, 'faq', '&lt;p&gt;This is faq.&lt;br&gt;&lt;/p&gt;'),
(12, 'home_page_blogs', '[{\"title\":\"North America choose Mastery for Business to build skills for a digital future\",\"description\":\"&lt;p style=&quot;text-align: justify; &quot;&gt;Today, we\\u2019re excited to announce that more than 30 leading companies throughout North America have selected Mastery for Business to accelerate their digital transformation strategy. These customers represent a wide range of industries with skilling needs unique to their business.&amp;nbsp;&lt;\\/p&gt;&lt;p style=&quot;text-align: justify; &quot;&gt;&amp;nbsp;The growing adoption of IoT, electric, and autonomous driving trends are reshaping the future of the automotive industry. Toyota Motor North America R&amp;amp;D, part of one of the world\\u2019s largest automakers, is collaborating with Mastery to help employees develop high-demand digital skills.\\r\\n&lt;\\/p&gt;\",\"image\":\"fd09bc43ed16d74592c7fcf954666872.png\"},{\"title\":\"Upskilling the Public Sector for the Digital World\",\"description\":\"&lt;p style=&quot;text-align: justify; &quot;&gt;Seventy percent of US government IT leaders believe that a lack of digital skills in areas such as cloud development, artificial intelligence (AI), data analysis, and enterprise engineering will significantly impact their agency\\u2019s mission, according to a WorkScoop and FedScoop survey.&amp;nbsp;&lt;\\/p&gt;&lt;p style=&quot;text-align: justify; &quot;&gt;The report states: \\u201cFederal agency leaders will need to support nimble and agile management of the workforce, including reskilling and redeploying existing workers to keep pace with the current pace of change.\\u201d In 2020, when the COVID-19 pandemic hit, the pressure to move everything online and the need to drastically expand teleworking further heightened upskilling requirements.&lt;\\/p&gt;\",\"image\":\"62909df6fa127449d0e03e66347f7211.png\"},{\"title\":\"Online Learning - What Is It And How Does It Work?\",\"description\":\"&lt;p style=&quot;text-align: justify; &quot;&gt;Thanks to the rapid advancement of technology, online learning is a part of many institutions\' course offerings around the world. From certificates, PhDs, impactful online language learning and everything in between, learning online has never been so easy!&amp;nbsp;&lt;\\/p&gt;&lt;p style=&quot;text-align: justify; &quot;&gt;Offered by some of the world\'s top-ranked institutions, online learning offers you all the perks of attending your dream university, with the added convenience of a learning experience tailored to your schedule.  With courses available in almost every subject, and flexible timetables to suit almost every lifestyle, students are increasingly turning to online learning as a viable alternative to on-campus study. It could allow you to study abroad remotely, at a university not in your home country!&lt;\\/p&gt;\",\"image\":\"3cf16572b575b9f156e94310f6649565.png\"}]'),
(13, 'dark-logo', 'dark-logo.png'),
(14, 'about_us', '&lt;p&gt;This is about us.&lt;/p&gt;'),
(15, 'lesson_done_seconds', '180');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phrase` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `translated` varchar(300) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `phrase`, `translated`) VALUES
(1, 'english', 'english', 'English'),
(2, 'english', 'home', 'Home'),
(3, 'english', 'admin', 'Admin'),
(4, 'english', 'view_profile', 'View profile'),
(5, 'english', 'my_classes', 'my classes'),
(6, 'english', 'account', 'account'),
(7, 'english', 'sign_out', 'sign out'),
(8, 'english', 'browse', 'browse'),
(9, 'english', 'all_classes', 'all classes'),
(10, 'english', 'featured_classes', 'featured classes'),
(11, 'english', 'recommended_classes', 'recommended classes'),
(12, 'english', 'what_do_you_want_to_learn_today', 'what do you want to learn today'),
(13, 'english', 'administrator', 'administrator'),
(14, 'english', 'search', 'search'),
(15, 'english', 'class_banner_image', 'class banner image'),
(16, 'english', 'watch_now', 'watch now'),
(17, 'english', 'previous', 'previous'),
(18, 'english', 'next', 'next'),
(19, 'english', 'Featured_On_Mastery', 'Featured On Mastery'),
(20, 'english', 'students', 'students'),
(21, 'english', 'save', 'save'),
(22, 'english', 'remove_from_saved_classes', 'remove from saved classes'),
(23, 'english', 'instructor', 'instructor'),
(24, 'english', 'Recommended_Lists', 'Recommended Lists'),
(25, 'english', 'top_categories', 'top categories'),
(26, 'english', 'top_skills', 'top skills'),
(27, 'english', 'useful_links', 'useful links'),
(28, 'english', 'go_premium', 'go premium'),
(29, 'english', 'about_us', 'about us'),
(30, 'english', 'privacy_policy', 'privacy policy'),
(31, 'english', 'terms_&_condition', 'terms & condition'),
(32, 'english', 'faq', 'faq'),
(33, 'english', 'join_Mastery_for_free', 'join Mastery for free'),
(34, 'english', 'explore_your_creativity_with_thousands_of_inspiring_classes_in_design,_illustration,_photography,_and_more.', 'explore your creativity with thousands of inspiring classes in design, illustration, photography, and more.'),
(35, 'english', 'continue_with_google', 'continue with google'),
(36, 'english', 'sign_up_using_email', 'sign up using email'),
(37, 'english', 'first_name', 'first name'),
(38, 'english', 'last_name', 'last name'),
(39, 'english', 'email_address', 'email address'),
(40, 'english', 'password', 'password'),
(41, 'english', 'sign_up', 'sign up'),
(42, 'english', 'already_a_member', 'already a member'),
(43, 'english', 'sign_in', 'sign in'),
(44, 'english', 'by_signing_up_you_agree_to_our', 'by signing up you agree to our'),
(45, 'english', 'terms_of_service', 'terms of service'),
(46, 'english', 'and', 'and'),
(47, 'english', 'this_page_is_protected_by_reCAPTCHA_and_is_subject_to_Google\'s', 'this page is protected by reCAPTCHA and is subject to Google\'s'),
(48, 'english', 'are_you_sure_to_delete', 'are you sure to delete'),
(49, 'english', 'cancel', 'cancel'),
(50, 'english', 'mail_successfully_sent_to_your_inbox', 'mail successfully sent to your inbox'),
(51, 'english', 'session_time_out', 'session time out'),
(52, 'english', 'user_not_found', 'user not found'),
(53, 'english', 'unfollow', 'unfollow'),
(54, 'english', 'follow', 'follow'),
(55, 'english', 'continue', 'continue'),
(56, 'english', 'Congratulations', 'Congratulations'),
(57, 'english', 'attention_please', 'attention please'),
(58, 'english', 'oops', 'oops'),
(59, 'english', 'browse_classes', 'browse classes'),
(60, 'english', 'featured', 'featured'),
(61, 'english', 'recommended', 'recommended'),
(62, 'english', 'free', 'free'),
(63, 'english', 'premium', 'premium'),
(64, 'english', 'less_than_30_min', 'less than 30 min'),
(65, 'english', '30_to_60_min', '30 to 60 min'),
(66, 'english', 'greater_than_60_min', 'greater than 60 min'),
(67, 'english', 'reset', 'reset'),
(68, 'english', 'related_skills', 'related skills'),
(69, 'english', 'total', 'total'),
(70, 'english', 'results', 'results'),
(71, 'english', 'remove', 'remove'),
(72, 'english', 'dashboard', 'dashboard'),
(73, 'english', 'classes', 'classes'),
(74, 'english', 'approval_request', 'approval request'),
(75, 'english', 'add_new_class', 'add new class'),
(76, 'english', 'teachers', 'teachers'),
(77, 'english', 'add_new_teacher', 'add new teacher'),
(78, 'english', 'add_new_student', 'add new student'),
(79, 'english', 'categories', 'categories'),
(80, 'english', 'add_new_category', 'add new category'),
(81, 'english', 'skills', 'skills'),
(82, 'english', 'purchase_history', 'purchase history'),
(83, 'english', 'packages', 'packages'),
(84, 'english', 'settings', 'settings'),
(85, 'english', 'system_settings', 'system settings'),
(86, 'english', 'website_settings', 'website settings'),
(87, 'english', 'payment_settings', 'payment settings'),
(88, 'english', 'language_settings', 'language settings'),
(89, 'english', 'smtp_settings', 'smtp settings'),
(90, 'english', 'about', 'about'),
(91, 'english', 'profile', 'profile'),
(92, 'english', 'website', 'website'),
(93, 'english', 'edit_profile', 'edit profile'),
(94, 'english', 'change_password', 'change password'),
(95, 'english', 'yearly_sales_report', 'yearly sales report'),
(96, 'english', 'january', 'january'),
(97, 'english', 'february', 'february'),
(98, 'english', 'march', 'march'),
(99, 'english', 'april', 'april'),
(100, 'english', 'may', 'may'),
(101, 'english', 'june', 'june'),
(102, 'english', 'july', 'july'),
(103, 'english', 'august', 'august'),
(104, 'english', 'september', 'september'),
(105, 'english', 'october', 'october'),
(106, 'english', 'november', 'november'),
(107, 'english', 'december', 'december'),
(108, 'english', 'this_month', 'this month'),
(109, 'english', 'total_classes', 'total classes'),
(110, 'english', 'total_teachers', 'total teachers'),
(111, 'english', 'total_students', 'total students'),
(112, 'english', 'top_10_classes', 'top 10 classes'),
(113, 'english', 'class', 'class'),
(114, 'english', 'lesson', 'lesson'),
(115, 'english', 'class_owner', 'class owner'),
(116, 'english', 'lessons', 'lessons'),
(117, 'english', 'are_you_sure_to_delete_this_information', 'are you sure to delete this information'),
(118, 'english', 'delete', 'delete'),
(119, 'english', 'are_you_sure_to_update_this_information', 'are you sure to update this information'),
(120, 'english', 'yes', 'yes'),
(121, 'english', 'no', 'no'),
(122, 'english', 'John Doe', 'John Doe'),
(123, 'english', 'followers', 'followers'),
(124, 'english', 'following', 'following'),
(125, 'english', 'facebook', 'facebook'),
(126, 'english', 'twitter', 'twitter'),
(127, 'english', 'linkedin', 'linkedin'),
(128, 'english', 'account_settings', 'account settings'),
(129, 'english', 'Change_photo', 'Change photo'),
(130, 'english', 'upload', 'upload'),
(131, 'english', 'social', 'social'),
(132, 'english', 'joined', 'joined'),
(133, 'english', 'enter_your_first_name', 'enter your first name'),
(134, 'english', 'enter_your_last_name', 'enter your last name'),
(135, 'english', 'surname', 'surname'),
(136, 'english', 'enter_your_surname_name', 'enter your surname name'),
(137, 'english', 'phone', 'phone'),
(138, 'english', 'address', 'address'),
(139, 'english', 'my_Bio', 'my Bio'),
(140, 'english', 'Save_Changes', 'Save Changes'),
(141, 'english', 'subscriptions', 'subscriptions'),
(142, 'english', 'package', 'package'),
(143, 'english', 'total_amout', 'total amout'),
(144, 'english', 'purchase_date', 'purchase date'),
(145, 'english', 'expiry_date', 'expiry date'),
(146, 'english', 'option', 'option'),
(147, 'english', 'social_links', 'social links'),
(148, 'english', 'email', 'email'),
(149, 'english', 'current_password', 'current password'),
(150, 'english', 'new_password', 'new password'),
(151, 'english', 'confirm_password', 'confirm password'),
(152, 'english', 'all_saved_classes', 'all saved classes'),
(153, 'english', 'watch_history', 'watch history'),
(154, 'english', 'removed_from_watch_history', 'removed from watch history'),
(155, 'english', 'Elit tempora assume', 'Elit tempora assume'),
(156, 'english', 'no_lesson_found', 'no lesson found'),
(157, 'english', 'view_my_notes', 'view my notes'),
(158, 'english', 'saved', 'saved'),
(159, 'english', 'share', 'share'),
(160, 'english', 'reviews', 'reviews'),
(161, 'english', 'discussions', 'discussions'),
(162, 'english', 'About_This_Class', 'About This Class'),
(163, 'english', 'advanced_level', 'advanced level'),
(164, 'english', 'projects', 'projects'),
(165, 'english', 'see_full_profile', 'see full profile'),
(166, 'english', 'this_class_has_been_saved', 'this class has been saved'),
(167, 'english', 'choose_a_social_media_and_share_the_class_with_others', 'choose a social media and share the class with others'),
(168, 'english', 'this_class_has_been_removed', 'this class has been removed'),
(169, 'english', 'how_students_rated_this_class', 'how students rated this class'),
(170, 'english', 'Leave_Review', 'Leave Review'),
(171, 'english', 'best_suited_for', 'best suited for'),
(172, 'english', 'advanced', 'advanced'),
(173, 'english', 'the_teachers_recommendation_is_shown_until_at_least_5_student_responses_are_collected', 'the teachers recommendation is shown until at least 5 student responses are collected'),
(174, 'english', 'the_level_is_determined_by_a_majority_opinion_of_students_who_have_reviewed_this_class', 'the level is determined by a majority opinion of students who have reviewed this class'),
(175, 'english', 'based_on_the_teachers_recommendation', 'based on the teachers recommendation'),
(176, 'english', 'Most_Liked', 'Most Liked'),
(177, 'english', 'Expectations_Met', 'Expectations Met'),
(178, 'english', 'exceeded', 'exceeded'),
(179, 'english', 'somewhat', 'somewhat'),
(180, 'english', 'not_really', 'not really'),
(181, 'english', 'post', 'post'),
(182, 'english', 'tell_us_what_you_think_about_this_class', 'tell us what you think about this class'),
(183, 'english', 'did_this_class_meet_your_expectations', 'did this class meet your expectations'),
(184, 'english', 'what_level_of_experience_would_you_suggest_for_students_taking_this_class', 'what level of experience would you suggest for students taking this class'),
(185, 'english', 'beginner', 'beginner'),
(186, 'english', 'intermediate', 'intermediate'),
(187, 'english', 'any_level', 'any level'),
(188, 'english', 'what_did_you_like_most_about_this_class', 'what did you like most about this class'),
(189, 'english', 'anything_else', 'anything else'),
(190, 'english', 'write_a_public_review', 'write a public review'),
(191, 'english', 'optional', 'optional'),
(192, 'english', 'submit_review', 'submit review'),
(193, 'english', 'post_successfully_published', 'post successfully published'),
(194, 'english', 'Edit_Review', 'Edit Review'),
(195, 'english', 'this_class', 'this class'),
(196, 'english', 'my_expectations', 'my expectations'),
(197, 'english', 'i_recommend_it_for', 'i recommend it for'),
(198, 'english', 'all_level', 'all level'),
(199, 'english', 'posted', 'posted'),
(200, 'english', 'review_deleted_successfully', 'review deleted successfully'),
(201, 'english', 'year', 'year'),
(202, 'english', 'month', 'month'),
(203, 'english', 'day', 'day'),
(204, 'english', 'hour', 'hour'),
(205, 'english', 'minute', 'minute'),
(206, 'english', 'second', 'second'),
(207, 'english', 'ago', 'ago'),
(208, 'english', 'reply', 'reply'),
(209, 'english', 'post_reply', 'post reply'),
(210, 'english', 'discussion_deleted_successfully', 'discussion deleted successfully'),
(211, 'english', 'sorry,_it_looks_like_it\'s_you', 'sorry, it looks like it\'s you'),
(212, 'english', 'so,_you_can_follow_other_users', 'so, you can follow other users'),
(213, 'english', 'terms_and_condition', 'terms and condition'),
(214, 'english', 'checkout_membership', 'checkout membership'),
(215, 'english', 'start_your_premium_subscription', 'start your premium subscription'),
(216, 'english', 'no_commitments', 'no commitments'),
(217, 'english', 'cancel_anytime', 'cancel anytime'),
(218, 'english', 'pick_a_plan_to_start_after_your_trial', 'pick a plan to start after your trial'),
(219, 'english', 'billed_monthly', 'billed monthly'),
(220, 'english', 'billed_annually', 'billed annually'),
(221, 'english', 'billed_after_333_days', 'billed after 333 days'),
(222, 'english', 'select_a_payment_gateway', 'select a payment gateway'),
(223, 'english', 'checkout_with_Paypal', 'checkout with Paypal'),
(224, 'english', 'checkout_with_stripe', 'checkout with stripe'),
(225, 'english', 'select_a_package', 'select a package'),
(226, 'english', 'please_wait', 'please wait'),
(227, 'english', 'your_subscription_day_will_be_counted_automatically_and_start_on', 'your subscription day will be counted automatically and start on'),
(228, 'english', 'by_clicking_checkout_button', 'by clicking checkout button'),
(229, 'english', 'you_agree_to_our_Terms_of_Service_and_authorize_this_recurring_charge', 'you agree to our Terms of Service and authorize this recurring charge'),
(230, 'english', 'Premium_Member_Benefits', 'Premium Member Benefits'),
(231, 'english', 'Unlimited_Access_to_all_of_The_Online_Classes', 'Unlimited Access to all of The Online Classes'),
(232, 'english', 'take_as_many_classes_as_you_want_Ad_Free', 'take as many classes as you want Ad Free'),
(233, 'english', 'Quality_Teachers', 'Quality Teachers'),
(234, 'english', 'experts_in_design,_business,_technology,_and_more', 'experts in design, business, technology, and more'),
(235, 'english', 'comfortable', 'comfortable'),
(236, 'english', 'access_on_the_mobile,_laptop,_and_TV_responsively', 'access on the mobile, laptop, and TV responsively'),
(237, 'english', 'yearly_on_Mastery', 'yearly on Mastery'),
(238, 'english', 'title', 'title'),
(239, 'english', 'category', 'category'),
(240, 'english', 'status', 'status'),
(241, 'english', 'featured_class', 'featured class'),
(242, 'english', 'recommended_class', 'recommended class'),
(243, 'english', 'inactive', 'inactive'),
(244, 'english', 'action', 'action'),
(245, 'english', 'view_in_frontend', 'view in frontend'),
(246, 'english', 'manage_class', 'manage class'),
(247, 'english', 'mark_as_active', 'mark as active'),
(248, 'english', 'pending', 'pending'),
(249, 'english', 'active', 'active'),
(250, 'english', 'mark_as_inactive', 'mark as inactive'),
(251, 'english', 'mark_as_pending_for_review', 'mark as pending for review'),
(252, 'english', 'pending_requests', 'pending requests'),
(253, 'english', 'teacher', 'teacher'),
(254, 'english', 'review_this_class', 'review this class'),
(255, 'english', 'teachers_mail', 'teachers mail'),
(256, 'english', 'view_message', 'view message'),
(257, 'english', 'approve_the_request', 'approve the request'),
(258, 'english', 'reject_the_request', 'reject the request'),
(259, 'english', 'add_class', 'add class'),
(260, 'english', 'back_to_list', 'back to list'),
(261, 'english', 'add_a_new_class', 'add a new class'),
(262, 'english', 'class_title', 'class title'),
(263, 'english', 'select_a_category', 'select a category'),
(264, 'english', 'level', 'level'),
(265, 'english', 'select_a_level', 'select a level'),
(266, 'english', 'all_levels', 'all levels'),
(267, 'english', 'highlight_this_class', 'highlight this class'),
(268, 'english', 'this_is_a_free_class', 'this is a free class'),
(269, 'english', 'if_you_add_the_class_for_free,_all_the_lessons_will_be_considered_free', 'if you add the class for free, all the lessons will be considered free'),
(270, 'english', 'mark_as_featured', 'mark as featured'),
(271, 'english', 'add_this_course_to_the_home_page_slider', 'add this course to the home page slider'),
(272, 'english', 'thumbnail', 'thumbnail'),
(273, 'english', 'select_a_class_thumbnail', 'select a class thumbnail'),
(274, 'english', 'change', 'change'),
(275, 'english', 'banner', 'banner'),
(276, 'english', 'select_a_class_banner', 'select a class banner'),
(277, 'english', 'short_description', 'short description'),
(278, 'english', 'long_description', 'long description'),
(279, 'english', 'save_and_next', 'save and next'),
(280, 'english', 'all_teachers', 'all teachers'),
(281, 'english', 'photo', 'photo'),
(282, 'english', 'name', 'name'),
(283, 'english', 'contact', 'contact'),
(284, 'english', 'options', 'options'),
(285, 'english', 'disable_this_user', 'disable this user'),
(286, 'english', 'edit', 'edit'),
(287, 'english', 'add_teacher', 'add teacher'),
(288, 'english', 'back', 'back'),
(289, 'english', 'enter_first_name', 'enter first name'),
(290, 'english', 'enter_last_name', 'enter last name'),
(291, 'english', 'designation', 'designation'),
(292, 'english', 'enter_a_password', 'enter a password'),
(293, 'english', 'phone_number', 'phone number'),
(294, 'english', 'select_user_photo', 'select user photo'),
(295, 'english', 'socials', 'socials'),
(296, 'english', 'send_account_access_to_the_user', 'send account access to the user'),
(297, 'english', 'all_students', 'all students'),
(298, 'english', 'add_student', 'add student'),
(299, 'english', 'add_parent_category', 'add parent category'),
(300, 'english', 'sub_categories', 'sub categories'),
(301, 'english', 'add_sub_category', 'add sub category'),
(302, 'english', 'add', 'add'),
(303, 'english', 'add_category', 'add category'),
(304, 'english', 'category_add_form', 'category add form'),
(305, 'english', 'category_title', 'category title'),
(306, 'english', 'provide_category_name', 'provide category name'),
(307, 'english', 'icon_picker', 'icon picker'),
(308, 'english', 'category_thumbnail', 'category thumbnail'),
(309, 'english', 'select_image', 'select image'),
(310, 'english', 'class_skills', 'class skills'),
(311, 'english', 'add_new_skill', 'add new skill'),
(312, 'english', 'skill_title', 'skill title'),
(313, 'english', 'purchase_histories', 'purchase histories'),
(314, 'english', 'filter', 'filter'),
(315, 'english', 'user', 'user'),
(316, 'english', 'paid_amount', 'paid amount'),
(317, 'english', 'subscription', 'subscription'),
(318, 'english', 'actions', 'actions'),
(319, 'english', 'yearly', 'yearly'),
(320, 'english', 'paid_via_stripe', 'paid via stripe'),
(321, 'english', 'included_free', 'included free'),
(322, 'english', 'days', 'days'),
(323, 'english', 'invoice', 'invoice'),
(324, 'english', 'all_packages', 'all packages'),
(325, 'english', 'price', 'price'),
(326, 'english', 'monthly', 'monthly'),
(327, 'english', 'edit_package', 'edit package'),
(328, 'english', 'disable_this_package', 'disable this package'),
(329, 'english', 'website_title', 'website title'),
(330, 'english', 'system_name', 'system name'),
(331, 'english', 'slogan', 'slogan'),
(332, 'english', 'meta_keyword', 'meta keyword'),
(333, 'english', 'write_your_key_and_press_enter', 'write your key and press enter'),
(334, 'english', 'meta_description', 'meta description'),
(335, 'english', 'system_email', 'system email'),
(336, 'english', 'timezone', 'timezone'),
(337, 'english', 'select_timezone', 'select timezone'),
(338, 'english', 'system_language', 'system language'),
(339, 'english', 'select_language', 'select language'),
(340, 'english', 'purchase_code', 'purchase code'),
(341, 'english', 'footer_text', 'footer text'),
(342, 'english', 'text', 'text'),
(343, 'english', 'footer_link', 'footer link'),
(344, 'english', 'url', 'url'),
(345, 'english', 'youtube_api_key', 'youtube api key'),
(346, 'english', 'make_sure_that', 'make sure that'),
(347, 'english', 'is_enabled_on_your_server_to_use_youtube_videos', 'is enabled on your server to use youtube videos'),
(348, 'english', 'vimeo_api_key', 'vimeo api key'),
(349, 'english', 'free_days', 'free days'),
(350, 'english', 'give_some_free_days_with_the_subscriptions', 'give some free days with the subscriptions'),
(351, 'english', 'enter_0_if_you_don\'t_want_it', 'enter 0 if you don\'t want it'),
(352, 'english', 'product_version', 'product version'),
(353, 'english', 'current_version', 'current version'),
(354, 'english', 'file', 'file'),
(355, 'english', 'update_product_version', 'update product version'),
(356, 'english', 'website_information', 'website information'),
(357, 'english', 'basic', 'basic'),
(358, 'english', 'website_logo', 'website logo'),
(359, 'english', 'home_page_blogs', 'home page blogs'),
(360, 'english', 'update_basic_information', 'update basic information'),
(361, 'english', 'top_header_notification', 'top header notification'),
(362, 'english', 'enabled', 'enabled'),
(363, 'english', 'disabled', 'disabled'),
(364, 'english', 'top_header_notification_message', 'top header notification message'),
(365, 'english', 'update_website_logo', 'update website logo'),
(366, 'english', 'select_a_light_logo', 'select a light logo'),
(367, 'english', 'select_a_dark_logo', 'select a dark logo'),
(368, 'english', 'select_a_favicon', 'select a favicon'),
(369, 'english', 'update_logo', 'update logo'),
(370, 'english', 'update_the_home_page_blogs', 'update the home page blogs'),
(371, 'english', 'image', 'image'),
(372, 'english', 'system_currency_settings', 'system currency settings'),
(373, 'english', 'system_currency', 'system currency'),
(374, 'english', 'select_system_currency', 'select system currency'),
(375, 'english', 'currency_position', 'currency position'),
(376, 'english', 'left', 'left'),
(377, 'english', 'right', 'right'),
(378, 'english', 'left_with_a_space', 'left with a space'),
(379, 'english', 'right_with_a_space', 'right with a space'),
(380, 'english', 'update_system_currency', 'update system currency'),
(381, 'english', 'heads_up', 'heads up'),
(382, 'english', 'please_make_sure_that', 'please make sure that'),
(383, 'english', 'paypal_currency', 'paypal currency'),
(384, 'english', 'stripe_currency', 'stripe currency'),
(385, 'english', 'are_same', 'are same'),
(386, 'english', 'setup_paypal_settings', 'setup paypal settings'),
(387, 'english', 'paypal_active', 'paypal active'),
(388, 'english', 'mode', 'mode'),
(389, 'english', 'paypal_mode', 'paypal mode'),
(390, 'english', 'sandbox', 'sandbox'),
(391, 'english', 'production', 'production'),
(392, 'english', 'select_paypal_currency', 'select paypal currency'),
(393, 'english', 'sandbox_client_id', 'sandbox client id'),
(394, 'english', 'sandbox_secret_key', 'sandbox secret key'),
(395, 'english', 'production_client_id', 'production client id'),
(396, 'english', 'production_secret_key', 'production secret key'),
(397, 'english', 'update_paypal_keys', 'update paypal keys'),
(398, 'english', 'setup_stripe_settings', 'setup stripe settings'),
(399, 'english', 'stripe_active', 'stripe active'),
(400, 'english', 'test_mode', 'test mode'),
(401, 'english', 'on', 'on'),
(402, 'english', 'off', 'off'),
(403, 'english', 'select_stripe_currency', 'select stripe currency'),
(404, 'english', 'test_secret_key', 'test secret key'),
(405, 'english', 'test_public_key', 'test public key'),
(406, 'english', 'live_secret_key', 'live secret key'),
(407, 'english', 'live_public_key', 'live public key'),
(408, 'english', 'update_stripe_keys', 'update stripe keys'),
(409, 'english', 'multi_language_settings', 'multi language settings'),
(410, 'english', 'language_list', 'language list'),
(411, 'english', 'add_language', 'add language'),
(412, 'english', 'language', 'language'),
(413, 'english', 'edit_phrase', 'edit phrase'),
(414, 'english', 'delete_language', 'delete language'),
(415, 'english', 'add_new_language', 'add new language'),
(416, 'english', 'smtp_protocol', 'smtp protocol'),
(417, 'english', 'smtp_host', 'smtp host'),
(418, 'english', 'smtp_port', 'smtp port'),
(419, 'english', 'smtp_user', 'smtp user'),
(420, 'english', 'smtp_password', 'smtp password'),
(421, 'english', 'email_template', 'email template'),
(422, 'english', 'email_verification_mail', 'email verification mail'),
(423, 'english', 'account_access_mail', 'account access mail'),
(424, 'english', 'forgot_password_mail', 'forgot password mail'),
(425, 'english', 'not_found', 'not found'),
(426, 'english', 'about_this_product', 'about this product'),
(427, 'english', 'software_version', 'software version'),
(428, 'english', 'check_update', 'check update'),
(429, 'english', 'php_version', 'php version'),
(430, 'english', 'curl_enable', 'curl enable'),
(431, 'english', 'purchase_code_status', 'purchase code status'),
(432, 'english', 'support_expiry_date', 'support expiry date'),
(433, 'english', 'customer_name', 'customer name'),
(434, 'english', 'get_customer_support', 'get customer support'),
(435, 'english', 'customer_support', 'customer support'),
(436, 'english', 'write_down_facebook_url', 'write down facebook url'),
(437, 'english', 'write_down_twitter_url', 'write down twitter url'),
(438, 'english', 'write_down_linkedin_url', 'write down linkedin url'),
(439, 'english', 'write_down_website_url', 'write down website url'),
(440, 'english', 'user_image', 'user image'),
(441, 'english', 'update_profile', 'update profile'),
(442, 'english', 'edit_sub_category', 'edit sub category'),
(443, 'english', 'update_category', 'update category'),
(444, 'english', 'update_password', 'update password'),
(445, 'english', 'sign_in_to_your_Mastery_account', 'sign in to your Mastery account'),
(446, 'english', 'remember_me', 'remember me'),
(447, 'english', 'forgot_password', 'forgot password'),
(448, 'english', 'not_a_member_yet', 'not a member yet'),
(449, 'english', 'We\'ll_send_password_reset_instructions_to_the_email_address_associated_with_your_account', 'We\'ll send password reset instructions to the email address associated with your account'),
(450, 'english', 'reset_password', 'reset password'),
(451, 'english', 'start_your_premium_subscription_of_unlimited_classes', 'start your premium subscription of unlimited classes'),
(452, 'english', 'online_classes', 'online classes'),
(453, 'english', 'search_all_the_classes_you_need_here_and_start_acquiring_your_knowledge', 'search all the classes you need here and start acquiring your knowledge'),
(454, 'english', 'signin_to_checkout', 'signin to checkout'),
(455, 'english', 'Course title', 'Course title'),
(456, 'english', 'your_creative_journey_starts_here', 'your creative journey starts here'),
(457, 'english', 'unlimited_access_to_every_class', 'unlimited access to every class'),
(458, 'english', 'supportive_online_creative_community', 'supportive online creative community'),
(459, 'english', 'access_on_mobile,_laptop_and_TV', 'access on mobile, laptop and TV'),
(460, 'english', 'Get_Started_For_Free', 'Get Started For Free'),
(461, 'english', 'Meet_Your_Teacher', 'Meet Your Teacher'),
(462, 'english', 'Class_Ratings', 'Class Ratings'),
(463, 'english', 'go_premium_to_continue_this_class', 'go premium to continue this class'),
(464, 'english', 'buy_a_subscroption_to_get_access_to_this_premium_class_and_all_on', 'buy a subscroption to get access to this premium class and all on'),
(465, 'english', 'Start_your_Mastery_premium_subscription_today', 'Start your Mastery premium subscription today'),
(466, 'english', 'page_not_found', 'page not found'),
(467, 'english', 'back_to_home', 'back to home'),
(468, 'english', 'signed_in_successfully', 'signed in successfully'),
(469, 'english', 'student', 'student'),
(470, 'english', 'paid_via', 'paid via'),
(471, 'english', 'stripe', 'stripe'),
(472, 'english', 'expired', 'expired'),
(473, 'english', 'Iusto id explicabo ', 'Iusto id explicabo '),
(474, 'english', 'asdAD', 'asdAD'),
(475, 'english', 'Omnis aliqua At ips', 'Omnis aliqua At ips'),
(476, 'english', 'please_sign_in_first', 'please sign in first'),
(477, 'english', 'ponkoj roy', 'ponkoj roy'),
(478, 'english', 'invalid_email_address', 'invalid email address'),
(479, 'english', 'your_registration_has_been_successfully_done', 'your registration has been successfully done'),
(480, 'english', 'please_check_your_mail_inbox_to_verify_your_email_address', 'please check your mail inbox to verify your email address'),
(481, 'english', 'email_verification', 'email verification'),
(482, 'english', 'let_us_know_that_this_email_address_belongs_to_you', 'let us know that this email address belongs to you'),
(483, 'english', 'enter_the_code_from_the_email_sent_to', 'enter the code from the email sent to'),
(484, 'english', 'enter_your_verification_code', 'enter your verification code'),
(485, 'english', 'resend_mail', 'resend mail'),
(486, 'english', 'submit', 'submit'),
(487, 'english', 'system_settings_updated_successfully', 'system settings updated successfully'),
(488, 'english', 'Pollob ', 'Pollob '),
(489, 'english', 'manage_class_information', 'manage class information'),
(490, 'english', 'class_information', 'class information'),
(491, 'english', 'add_lesson', 'add lesson'),
(492, 'english', 'add_new_lesson', 'add new lesson'),
(493, 'english', 'edit_lesson', 'edit lesson'),
(494, 'english', 'view_on_frontend', 'view on frontend'),
(495, 'english', 'printed_on', 'printed on'),
(496, 'english', 'billing_to', 'billing to'),
(497, 'english', 'billing_from', 'billing from'),
(498, 'english', 'payment_details', 'payment details'),
(499, 'english', 'package_name', 'package name'),
(500, 'english', 'sub_total_amount', 'sub total amount'),
(501, 'english', 'grand_total', 'grand total'),
(502, 'english', 'print_invoice', 'print invoice'),
(503, 'english', 'total_paid_amount', 'total paid amount'),
(504, 'english', 'print', 'print'),
(505, 'english', 'class_added_successfully', 'class added successfully'),
(506, 'english', 'class_updated_successfully', 'class updated successfully'),
(507, 'english', 'edit_category', 'edit category'),
(508, 'english', 'category_edit_form', 'category edit form'),
(509, 'english', 'Introduction to Data Visualization', 'Introduction to Data Visualization'),
(510, 'english', 'all', 'all'),
(511, 'english', 'edit_teacher', 'edit teacher'),
(512, 'english', 'update_user_data', 'update user data'),
(513, 'english', 'Eliades Vicki', 'Eliades Vicki'),
(514, 'english', 'Freelancing for Creatives', 'Freelancing for Creatives'),
(515, 'english', 'enter_your_skill_title', 'enter your skill title'),
(516, 'english', 'save_skill', 'save skill'),
(517, 'english', 'skill_added_successfully', 'skill added successfully'),
(518, 'english', 'class_deleted_successfully', 'class deleted successfully'),
(519, 'english', 'status_changed_successfully', 'status changed successfully'),
(520, 'english', 'Simple Character Animation', 'Simple Character Animation'),
(521, 'english', 'lesson_title', 'lesson title'),
(522, 'english', 'lesson_type', 'lesson type'),
(523, 'english', 'select_a_lesson_type', 'select a lesson type'),
(524, 'english', 'youtube', 'youtube'),
(525, 'english', 'vimeo', 'vimeo'),
(526, 'english', 'html5_video_url', 'html5 video url'),
(527, 'english', 'video_file', 'video file'),
(528, 'english', 'video_url', 'video url'),
(529, 'english', 'enter_your_video_url', 'enter your video url'),
(530, 'english', 'duration', 'duration'),
(531, 'english', 'minutes', 'minutes'),
(532, 'english', 'seconds', 'seconds'),
(533, 'english', 'enter_video_duration', 'enter video duration'),
(534, 'english', 'if_you_want_to_keep_it_free,_checked_here', 'if you want to keep it free, checked here'),
(535, 'english', 'upload_lesson', 'upload lesson'),
(536, 'english', 'syncing', 'syncing'),
(537, 'english', 'done', 'done'),
(538, 'english', 'please_enter_a_valid_url', 'please enter a valid url'),
(539, 'english', 'enter_manually', 'enter manually'),
(540, 'english', 'lesson_uploaded_successfully', 'lesson uploaded successfully'),
(541, 'english', 'lesson_deleted_successfully', 'lesson deleted successfully'),
(542, 'english', 'update_lesson', 'update lesson'),
(543, 'english', 'Creative Writing for All', 'Creative Writing for All'),
(544, 'english', 'profile_photo_updated_successfully', 'profile photo updated successfully'),
(545, 'english', 'profile_updated_successfully', 'profile updated successfully'),
(546, 'english', 'skill_deleted_successfully', 'skill deleted successfully'),
(547, 'english', 'Music Production For Songwriters', 'Music Production For Songwriters'),
(548, 'english', 'beginner_level', 'beginner level'),
(549, 'english', 'Documentary Photography', 'Documentary Photography'),
(550, 'english', 'intermediate_level', 'intermediate level'),
(551, 'english', 'John Alex', 'John Alex'),
(552, 'english', 'fill_out_the_form', 'fill out the form'),
(553, 'english', 'invalid_login_credentials', 'invalid login credentials'),
(554, 'english', 'no_related_skills', 'no related skills'),
(555, 'english', 'no_data_found', 'no data found'),
(556, 'english', 'try_again_with_another_category', 'try again with another category'),
(557, 'english', 'start_study_with_a_premium_class_quickly', 'start study with a premium class quickly'),
(558, 'english', 'category_updated_successfully', 'category updated successfully'),
(559, 'english', 'some_thing_is_wrong', 'some thing is wrong'),
(560, 'english', 'basic_information_updated_successfully', 'basic information updated successfully'),
(561, 'english', 'this_category_already_exists', 'this category already exists'),
(562, 'english', 'Content Marketing', 'Content Marketing'),
(563, 'english', 'start_a_free_trial_to_continue_this_class', 'start a free trial to continue this class'),
(564, 'english', 'start_your_free_trial_to_get_access_to_this_premium_class_and_all_on', 'start your free trial to get access to this premium class and all on'),
(565, 'english', 'Start_Your_Free_Trial', 'Start Your Free Trial'),
(566, 'english', 'start_your_free', 'start your free'),
(567, 'english', 'Today\'s_Total', 'Today\'s Total'),
(568, 'english', 'free_for_your_first_7_days', 'free for your first 7 days'),
(569, 'english', 'days_of_unlimited_classes', 'days of unlimited classes'),
(570, 'english', 'did_this_class_meet_my_expectations', 'did this class meet my expectations'),
(571, 'english', 'update_review', 'update review'),
(572, 'english', 'Creative Filmmaking', 'Creative Filmmaking'),
(573, 'english', 'create_sub_category', 'create sub category');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `lesson_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lesson_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'youtube, vimeo,video_file, html5_video_url',
  `lesson_src` text COLLATE utf8_unicode_ci,
  `lesson_thumbnail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'count seconds',
  `is_free` int(11) DEFAULT NULL,
  `lesson_status` int(11) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `date_added` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date_updated` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `package_id` int(11) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `package_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_id`, `price`, `package_type`, `days`, `status`) VALUES
(1, 100, 'monthly', NULL, 1),
(2, 150, 'yearly', NULL, 1),
(4, 150, 'days', 333, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `paid_amount` float NOT NULL DEFAULT '0',
  `payment_method` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_key` longtext COLLATE utf8_unicode_ci,
  `expire_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `free_days` int(11) DEFAULT NULL,
  `date_updated` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_thumbnail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_details` longtext COLLATE utf8_unicode_ci,
  `likes` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `added_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expectation` int(11) DEFAULT '0' COMMENT '0=Not really, 1=Somewhat, 2=yes, 3=Exceeded',
  `review_tag_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_tags`
--

CREATE TABLE `review_tags` (
  `review_tag_id` int(11) NOT NULL,
  `review_tag_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `review_tags`
--

INSERT INTO `review_tags` (`review_tag_id`, `review_tag_title`) VALUES
(1, 'Helpful Examples'),
(2, 'Clarity of Instruction'),
(3, 'Engaging Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `description`) VALUES
(1, 'language', 'english'),
(2, 'system_name', 'Subscription-based learning management system'),
(3, 'system_title', 'Mastery'),
(4, 'system_email', 'mastery@example.com'),
(5, 'address', 'Sydeny, Australia'),
(6, 'phone', '+143-52-9933631'),
(7, 'purchase_code', 'your-purchase-code'),
(8, 'paypal_keys', '[{\"active\":\"1\",\"mode\":\"sandbox\",\"sandbox_client_id\":\"AfGaziKslex-scLAyYdDYXNFaz2aL5qGau-SbDgE_D2E80D3AFauLagP8e0kCq9au7W4IasmFbirUUYc\",\"sandbox_secret_key\":\"EMa5pCTuOpmHkhHaCGibGhVUcKg0yt5-C3CzJw-OWJCzaXXzTlyD17SICob_BkfM_0Nlk7TWnN42cbGz\",\"production_client_id\":\"12345\",\"production_secret_key\":\"12345\"}]'),
(16, 'system_currency', 'USD'),
(19, 'author', 'Creativeitem'),
(20, 'currency_position', 'left'),
(23, 'footer_text', 'Creativeitem'),
(24, 'footer_link', 'http://creativeitem.com/'),
(25, 'protocol', 'smtp'),
(26, 'smtp_host', 'ssl://smtp.googlemail.com'),
(27, 'smtp_port', '465'),
(28, 'smtp_user', 'Your email'),
(29, 'smtp_pass', 'email password'),
(30, 'version', '1.0'),
(36, 'facebook', 'https://www.facebook.com/teacher1'),
(38, 'linkedin', 'https://www.linkedin.com/teacher1'),
(40, 'paypal_currency', 'USD'),
(42, 'twitter', 'https://www.twitter.com/teacher1'),
(43, 'paytm_keys', '[{\"ACTIVE\":\"1\",\"MODE\":\"TEST\",\"PAYTM_MERCHANT_KEY\":\"PAYTM_MERCHANT_KEY\",\"PAYTM_MERCHANT_MID\":\"PAYTM_MERCHANT_MID\",\"PAYTM_MERCHANT_WEBSITE\":\"DEFAULT\",\"INDUSTRY_TYPE_ID\":\"Retail\",\"CHANNEL_ID\":\"WEB\"}]'),
(44, 'paytm_currency', 'USD'),
(45, 'razorpay_currency', 'USD'),
(46, 'razorpay_keys', '[{\"active\":\"1\",\"key\":\"rzp_test_J60bqBOi1z1aF5\",\"secret_key\":\"uk935K7p4j96UCJgHK8kAU4q\",\"theme_color\":\"#08129b\"}]'),
(47, 'email_verification', '0'),
(48, 'forgot_password_mail', '<p><strong>Hello [user_name]</strong>,</p><p>Your new password is <strong>[new_password]</strong></p>'),
(49, 'email_verification_mail', '<p><strong>Hello [user_name],</strong></p><p>Your email verification code is <strong>[verification_code]</strong></p>'),
(50, 'instagram', 'https://www.instagram.com\r\n'),
(51, 'signin_with_google', '1'),
(52, 'google_client_id', 'google-client-ID'),
(53, 'google_client_secret', 'google-client-secret'),
(54, 'free_subscription_days', '7'),
(57, 'stripe_keys', '[{\"active\":\"1\",\"testmode\":\"on\",\"public_key\":\"pk_test_LnMXAA8Rox0ITcpDgkIjbcR600u09yZlhQ\",\"secret_key\":\"sk_test_9iN1igv6l9R5tolcyZLrIgMP00rcDJMVnJ\",\"public_live_key\":\"pk_live_xxxxxxxxxxxxxxxxxxxxxxxx\",\"secret_live_key\":\"sk_live_xxxxxxxxxxxxxxxxxxxxxxxx\"}]'),
(58, 'stripe_currency', 'USD'),
(59, 'youtube_api_key', 'Youtube-api-key'),
(60, 'vimeo_api_key', 'Vimeo-api-key'),
(61, 'slogan', 'Join us, grow your creativity.'),
(62, 'account_access_mail', '<p><strong>Hello [user_name],</strong></p><p>We have created a new account for you in Mastery. Your account access is</p><p>Email: <strong>[email]</strong></p><p>Password: <strong>[password]</strong></p>'),
(63, 'timezone', 'America/New_York'),
(64, 'meta_keywords', 'mastery,lms,masterylms,teacher,online teaching,mastery lms,online class,video tutorial,teaching business,subscription based lms system,subscription,monthly,yearly,skills,classes,multi language system,free online classs,free online course,premium class,premium course,premium software,best lms,best lms system,creativeitem,academy'),
(65, 'meta_description', 'Mastery is an online subscription-based LMS software. In Mastery LMS, Admin and teacher creates the class on a particular topic and make it published for the users, helping students learn things or provide training to employees or any users.');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL,
  `skill_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `slugify` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skill_threades`
--

CREATE TABLE `skill_threades` (
  `skill_threade_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `is_active_class` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8_unicode_ci,
  `about` longtext COLLATE utf8_unicode_ci,
  `social` text COLLATE utf8_unicode_ci,
  `photo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verification_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_verified` int(11) NOT NULL DEFAULT '0',
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `watch_histories`
--

CREATE TABLE `watch_histories` (
  `watch_history_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `playing_lesson` int(11) DEFAULT NULL,
  `in_history` int(11) DEFAULT NULL,
  `progress_percent` int(11) NOT NULL DEFAULT '0',
  `lesson_done` mediumtext COLLATE utf8_unicode_ci,
  `lesson_current_duration` mediumtext COLLATE utf8_unicode_ci,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `website_notification`
--

CREATE TABLE `website_notification` (
  `notification_id` int(11) NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail_from` int(11) DEFAULT NULL COMMENT 'user_id',
  `mail_to` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'all, admin, teachers, students, user_id',
  `details` longtext COLLATE utf8_unicode_ci,
  `status` int(11) DEFAULT NULL COMMENT '0=unread, 1=read',
  `date_added` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`bookmark_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`discussion_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`follower_id`);

--
-- Indexes for table `frontend_settings`
--
ALTER TABLE `frontend_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `review_tags`
--
ALTER TABLE `review_tags`
  ADD PRIMARY KEY (`review_tag_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indexes for table `skill_threades`
--
ALTER TABLE `skill_threades`
  ADD PRIMARY KEY (`skill_threade_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `watch_histories`
--
ALTER TABLE `watch_histories`
  ADD PRIMARY KEY (`watch_history_id`);

--
-- Indexes for table `website_notification`
--
ALTER TABLE `website_notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `bookmark_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `discussions`
--
ALTER TABLE `discussions`
  MODIFY `discussion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `follower_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_settings`
--
ALTER TABLE `frontend_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=574;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_tags`
--
ALTER TABLE `review_tags`
  MODIFY `review_tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skill_threades`
--
ALTER TABLE `skill_threades`
  MODIFY `skill_threade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `watch_histories`
--
ALTER TABLE `watch_histories`
  MODIFY `watch_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `website_notification`
--
ALTER TABLE `website_notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
