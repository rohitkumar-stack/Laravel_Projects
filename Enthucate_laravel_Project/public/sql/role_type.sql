--
-- Dumping data for table `role_type`
--

INSERT INTO `role_type` (`id`, `role`, `is_del`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', '1', '2021-08-26 03:54:03', '2021-08-26 03:54:03'),
(2, 'Admin', '0', '2021-08-26 03:54:03', '2021-08-26 03:54:03'),
(3, 'School', '1', '2021-08-26 03:54:03', '2021-08-26 03:54:03'),
(4, 'School Admin', '0', '2021-08-26 03:54:03', '2021-08-26 03:54:03'),
(5, 'Principal', '0', '2021-08-26 03:56:27', '2021-08-26 03:56:27'),
(6, 'Official', '0', '2021-08-26 03:56:27', '2021-08-26 03:56:27'),
(7, 'H.O.D', '0', '2021-08-26 03:58:39', '2021-08-26 03:58:39'),
(8, 'Staff', '0', '2021-08-26 03:58:39', '2021-08-26 03:58:39'),
(9, 'Teacher', '0', '2021-08-26 03:58:39', '2017-05-25 15:34:18'),
(10, 'Student', '0', '2021-08-26 03:58:39', '2021-07-08 04:10:55'),
(11, 'Parent', '0', '2021-08-26 03:58:39', '2017-05-25 15:34:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `role_type`
--
ALTER TABLE `role_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `role_type`
--
ALTER TABLE `role_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
