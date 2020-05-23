-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2020 at 08:33 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialfreak`
--

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE `connections` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `platform_id` int(11) NOT NULL,
  `access_token` text NOT NULL,
  `fb_id` varchar(255) DEFAULT NULL,
  `l_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `twitter_id` varchar(255) DEFAULT NULL,
  `twitter_secret` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `connections`
--

INSERT INTO `connections` (`id`, `user_id`, `platform_id`, `access_token`, `fb_id`, `l_id`, `name`, `email`, `avatar`, `twitter_id`, `twitter_secret`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'EAAJZAeBEajZAUBAMSxIlcoV7NtjJtAUxbuSz1pLjagVMWZB8uOJ4ha1z7uoonNLykvCA1v6Kyy46BPfD3jziJZCb03AQEzqEvqQZBnNpoAuEYm792Sm6vfAwtzgOfDIStJvuJIjwKE3ZCuYIh5mE1IZC6rKeH7kO9YKXjkbxlrdfQZDZD', '2689964261126079', '', 'Abhey Khan', 'abheykhan2011@hotmail.com', 'https://graph.facebook.com/v3.3/2689964261126079/picture?type=normal', '', '', '2020-05-05 21:48:40', '2020-05-05 17:20:26'),
(2, 1, 1, 'EAAJZAeBEajZAUBAHTo6FUDR28ETrWkysdmsKHAXh4SUiuMbL6YZB9voH0ikGx5cZBRq2yTSG2VIYrEZBuAvUgTSdv6t8J1i6BLOwxEZAMscD3tlkjUCJSFWZCzSr9lqwiZAoh0XZCGLI4vTSGgkbb97OT0yMAGB183M6ch3PSUUZB9mgZDZD', '2878472165607153', '', 'Mike Hussey', 'lovelysingh9373@yahoo.com', 'https://graph.facebook.com/v3.3/2878472165607153/picture?type=normal', '', '', '2020-05-05 21:48:43', '2020-05-05 17:20:45'),
(3, 1, 2, '336221145-D55v3zqQg1YvaGr8rkAD29s988Uaq9cDLq9SwFy9', NULL, '', 'AmmarBrohi', NULL, 'http://abs.twimg.com/sticky/default_profile_images/default_profile_normal.png', '336221145', '7vTqJIjdOABZYraVuK94GXHQYek3iFnvfOCMpsluRcSE1', '2020-05-05 17:45:00', '2020-05-05 17:45:00'),
(4, 1, 2, '934128505666916352-6a3HF8xNhqo9jaHdJBhYOeCSh2BnBdA', NULL, '', 'DevnaniVikram', NULL, 'http://pbs.twimg.com/profile_images/1067826234581794816/kO9MI3wN_normal.jpg', '934128505666916352', 'qqy2rzs002kSN5ZJAtPvetkPWb3vQ80DuIjYizSWgtg74', '2020-05-05 18:08:33', '2020-05-05 18:08:33'),
(5, 1, 4, 'AQVVCixTwkD0OV4Y0W0ayKLOI8Wqnl-x3YhhFBNuMBhxA6e175_PmvL_akasjj2KqWo-yJxanhIHS1bIRSTQZPfw5Ph-h1ZKlU_khXk8GlSdgzx6t1iISbPLpyJgeWH_M_cSRRVACkyPSDcKqbjgt85XFdnMVx0eoF65VN-G_PEy49XXbHqPbEVNAJrNkf-BsEjmrGgu51wovv7ECVBa-N4TG3KccrHIWb9Db5O2fA4vCWXd5xcLZrnwCnnlsLXjElj2Il0Y-xMOYrjHBB_cRlVQ4fZ_zCbfdqfFFOcB9lWJeXVY-snjf4m4wFLufCCcQEvnsJ4ALX3vmo73tzrEoLVYWh8Jjw', NULL, '7SvioaOGQy', 'Ammar Hassan', NULL, NULL, NULL, NULL, '2020-05-08 22:37:52', '2020-05-08 18:21:39'),
(6, 1, 3, 'AQXiQng3ZywphKC4YVgDmseELGAs8PXXHYu0q-aP4LsSsPB_B8FJ-g_aQrfZ9er_d_rOOWkD-91EfoUgVDQkZ_LWo3dXXbPe3V7EIBTE9ipnRPubdKO-l50aNhulWs3oVf8aWLIj5K0LV2rXQrtY6uMCcB_u36akKknwSHwkpjY3yHSyTSpfjqUjmyKpX1huDrhLZreot6euo4mH5Vu18tdH36wVaNq9D6FN53IfPpB3eeI0byxDiGIzt9yK2Ky0GDO9Qo4OuGJKFxzNSiUyBfosZku05U9Ppuxgi4Rl4ctS3EapJX8C64Gt0RxOCbtiF79_2EjtGZ1QzMBv9Dqq6kGW8KfRKQ', NULL, 'SfMlXyMBDm', 'Marilyn Lloyd', NULL, NULL, NULL, NULL, '2020-05-08 18:40:06', '2020-05-08 18:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `connection_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `platform_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `user_id`, `connection_id`, `name`, `fb_id`, `platform_id`, `created_at`) VALUES
(1, 1, 2, 'Buy And Sale Dubai, Ajman, Sharjah', '1338640492868023', 1, '2020-05-05 21:20:46'),
(2, 1, 2, 'Facebook Page Promotion', '734517669952568', 1, '2020-05-05 21:20:46'),
(3, 1, 2, 'Buy And sell Used Item Dubai, Sharjah & Abu Dhabi', '1955514801350620', 1, '2020-05-05 21:20:46'),
(4, 1, 2, 'Facebook Friends 💋', '2458790761054312', 1, '2020-05-05 21:20:46'),
(5, 1, 2, 'SHARE & PROMOTE FACEBOOK GROUPS, PAGES,YOURSELF, YOUR BUSINESS, ANYTHING .', '1299935723476000', 1, '2020-05-05 21:20:46'),
(6, 1, 2, '🖤Best💛 Facebook 💜Friends💙', '1153037088205287', 1, '2020-05-05 21:20:46'),
(7, 1, 2, 'Facebook friends', '281108129383192', 1, '2020-05-05 21:20:46'),
(8, 1, 2, 'facebook apps', '490326737740002', 1, '2020-05-05 21:20:46'),
(9, 1, 2, 'FACEBOOK SALE POINT FB PAGE AND VERIFY IDS', '250581874982834', 1, '2020-05-05 21:20:46'),
(10, 1, 2, 'Buy & Sell in UAE', '1532379913692290', 1, '2020-05-05 21:20:46'),
(11, 1, 2, 'FACEBOOK COMPLAINTS', '1067509923294669', 1, '2020-05-05 21:20:46'),
(12, 1, 2, 'TEST', '592092871662189', 1, '2020-05-05 21:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2020_05_02_075954_create_platforms_table', 1),
(4, '2020_05_02_081630_create_posts_table', 2),
(5, '2020_05_02_084916_create_pages_table', 3),
(6, '2020_05_02_085207_create_groups_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `connection_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `platform_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `user_id`, `connection_id`, `name`, `page_id`, `access_token`, `platform_id`, `created_at`) VALUES
(1, 1, 1, 'Aboo Jatoi', '101381008240623', 'EAAJZAeBEajZAUBAOiriCcpE4RFDBAl0bUZCxPxx5wgcgIShORBqzZApQj0NL10zNnbhC5bKhLh1MmZCPrmz4lAhH20S2yDeroACS9nhWGSZCmxxUwHFpxMnxsVZCJ0JZAgon0l5W04O4dhxTVZCq1B4TQcpO1DmpZBS9sKZBJPoHxO1XQZDZD', 1, '2020-05-05 21:20:27'),
(2, 1, 2, 'Hello Mike Bro', '101520564879312', 'EAAJZAeBEajZAUBACHgAwMJrAnNdt18zuiJ0KOr0Gb03O0C9ZChWH4Xq6bWuVXuA5aYoWX4OeYVsTdZAvTPxNMAuifZB2HJZB2xYZBZAeNda0FGKqXArhs2oFN33RRlbZBZAGX1YUtjVLgZAC1YpsbgmSGNZCa6QpWbDUaspP0JxjJwdYTQZDZD', 1, '2020-05-05 21:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `platforms`
--

CREATE TABLE `platforms` (
  `id` int(10) UNSIGNED NOT NULL,
  `platform_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `platforms`
--

INSERT INTO `platforms` (`id`, `platform_title`, `created_at`) VALUES
(1, 'Facebook', '2020-05-02 08:13:29'),
(2, 'Twitter', '2020-05-02 08:13:54'),
(3, 'Instagram', '2020-05-02 08:14:08'),
(4, 'LinkedIn', '2020-05-02 08:14:20');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `connection_id` int(11) NOT NULL,
  `platform_id` int(11) NOT NULL,
  `image_path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `story_path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `shares` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `scheduled_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isPosted` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `connection_id`, `platform_id`, `image_path`, `video_path`, `story_path`, `link`, `title`, `caption`, `page_id`, `group_id`, `likes`, `shares`, `comments`, `scheduled_date`, `isPosted`, `created_at`) VALUES
(1, 1, 1, 1, '', '', '', '', '', 'Hello world, this is just an quick demo.', 1, 0, 0, 0, 0, '2020-05-05 21:58:58', 1, '2020-05-05 21:21:02'),
(2, 1, 1, 1, '', '', '', '', '', 'I am abhay khan, how are you? 😍', 1, 0, 0, 0, 0, '2020-05-05 21:59:00', 1, '2020-05-05 21:21:17'),
(3, 1, 3, 2, '', '', '', '', '', 'TEST', 0, 0, 0, 0, 0, '2020-05-05 22:01:35', 1, '2020-05-05 21:49:42'),
(4, 1, 3, 2, '', '', '', 'https://ammarbrohi.com', '', 'My Link', 0, 0, 0, 0, 0, '2020-05-05 22:03:58', 1, '2020-05-05 22:03:53'),
(5, 1, 3, 2, 'Screenshot at May 04 02-01-59_1588716264.png', '', '', '', '', 'TEST 🤩', 0, 0, 0, 0, 0, '2020-05-05 22:04:30', 1, '2020-05-05 22:04:24'),
(6, 1, 3, 2, '', 'Save AS_1588716320.mp4', '', '', '', 'TEST Video', 0, 0, 0, 0, 0, '2020-05-05 22:05:25', 1, '2020-05-05 22:05:20'),
(7, 1, 4, 2, '', '', '', '', '', 'Hello from Mars!', 0, 0, 0, 0, 0, '2020-05-05 22:12:59', 1, '2020-05-05 22:09:03'),
(10, 1, 5, 4, '', '', '', '', '', 'Testing', 0, 0, 0, 0, 0, '2020-05-09 00:27:00', 1, '2020-05-08 22:36:24'),
(11, 1, 6, 4, '', '', '', '', '', 'Hello from the other side.', 0, 0, 0, 0, 0, '2020-05-09 00:27:02', 1, '2020-05-08 22:43:04'),
(12, 1, 6, 4, 'STO_vs_ICO_1588984066.png', '', '', '', '', 'STO vs ICOs', 0, 0, 0, 0, 0, '2020-05-09 00:36:36', 1, '2020-05-09 00:27:46'),
(13, 1, 6, 4, '', '', '', 'https://infura.io/', '', 'A fastest way to build Eth apps.', 0, 0, 0, 0, 0, '2020-05-09 00:37:47', 1, '2020-05-09 00:37:40'),
(14, 1, 6, 4, 'Banner_1589046974.png', '', '', '', '', 'Test LinkedIn', 0, 0, 0, 0, 0, '2020-05-09 17:55:00', 0, '2020-05-09 17:56:14'),
(15, 1, 3, 2, 'Banner_1589047914.png', '', '', '', '', 'TEST BY RIDA AMMAR', 0, 0, 0, 0, 0, '2020-05-09 18:10:00', 0, '2020-05-09 18:11:54'),
(16, 1, 6, 4, 'https://scotch-res.cloudinary.com/image/upload/w_1500,q_auto:good,f_auto/media/1/c5m2t51SnOzWGC71qV8P_laravel-custom-validation-messages.png.jpg', '', '', '', '', 'Laravel is 🔤', 0, 0, 0, 0, 0, '2020-05-09 18:20:00', 0, '2020-05-09 18:20:45'),
(17, 1, 3, 2, '', 'test_1589048587.mp4', '', '', '', 'Testing video', 0, 0, 0, 0, 0, '2020-05-09 18:22:00', 0, '2020-05-09 18:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook_id` int(11) NOT NULL,
  `linkedin_id` int(11) NOT NULL,
  `instagram_id` int(11) NOT NULL,
  `twitter_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `facebook_id`, `linkedin_id`, `instagram_id`, `twitter_id`, `created_at`, `updated_at`) VALUES
(1, 'asd', 123, 12123, 123, 123, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `connections`
--
ALTER TABLE `connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
