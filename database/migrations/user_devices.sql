CREATE TABLE IF NOT EXISTS `user_devices` (
  `device_id` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL,
  `access_token` varchar(255) NOT NULL DEFAULT '',
  `rest_access_token` varchar(255) DEFAULT NULL,
  `access_token_expires` timestamp NULL DEFAULT NULL,
  `rest_access_token_expires` timestamp NULL DEFAULT NULL,
  `os_type` enum('iOS','Android') NOT NULL DEFAULT 'iOS',
  `os_version` varchar(255) NOT NULL DEFAULT '',
  `hardware` varchar(25) NOT NULL DEFAULT '',
  `app_version` varchar(255) NOT NULL DEFAULT '',
  `rest_app_version` varchar(255) NOT NULL DEFAULT '1.0.4',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD PRIMARY KEY (`device_id`),
  ADD KEY `fk_ud_user_idx` (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD CONSTRAINT `fk_ud_user_idx` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

