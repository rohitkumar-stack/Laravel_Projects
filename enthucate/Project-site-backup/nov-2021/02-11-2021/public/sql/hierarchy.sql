
--
-- Dumping data for table `hierarchy`
--

INSERT INTO `hierarchy` (`id`, `level_name`, `description`, `license_type`, `is_del`, `created_at`, `updated_at`) VALUES
(1, 'Global  Organisation', 'Highest Level can add sub-division organisation and affiliate organisation', 'Global', '0', '2021-08-26 03:53:15', '2021-08-26 03:53:15'),
(2, 'Partner Organisation', 'affiliate partner of Global organisation', 'Non', '0', '2021-08-26 03:53:15', '2021-08-26 03:53:15'),
(3, 'Subdivision', '2nd level organisation can be a member of global organisation. Can standalone', 'Sub-Division', '0', '2021-08-26 03:53:15', '2021-08-26 03:53:15'),
(4, 'Local Sub-division', 'can be a member of subdivision which means will automatically associate with subdivision global organisation. Can have local subdivisions as well', 'Local Subdivision', '0', '2021-08-26 03:53:15', '2021-08-26 03:53:15'),
(5, 'School', 'School license which allows you to add Teachers, Students and Parents', 'School', '0', '2021-08-26 03:53:15', '2021-08-26 03:53:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hierarchy`
--
ALTER TABLE `hierarchy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hierarchy`
--
ALTER TABLE `hierarchy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
