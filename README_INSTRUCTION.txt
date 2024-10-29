1. Open the file and right click , click terminal or cmd
2. Type in terminal php artisan migrate:fresh
3. Insert some initial data for the system as below. Below code below are using mysql code and should be insert in order.
----------------
INSERT INTO `semesters` (`id`, `label`, `startdate`, `enddate`, `status`, `created_at`, `updated_at`) VALUES (2, 'Sem 02 2023/2024', '2024-05-31', '2024-10-14', 'Active', '2023-11-17 13:23:55', '2024-01-17 12:03:52');
INSERT INTO `semesters` (`id`, `label`, `startdate`, `enddate`, `status`, `created_at`, `updated_at`) VALUES (3, 'Sem 02 2022/2023', '2022-10-11', '2023-02-16', 'Prohibited', '2023-11-17 13:27:35', '2024-01-17 11:58:54');
INSERT INTO `semesters` (`id`, `label`, `startdate`, `enddate`, `status`, `created_at`, `updated_at`) VALUES (4, 'Sem 01 2023/2024', '2024-01-20', '2024-05-27', 'Prohibited', '2023-11-17 13:28:45', '2024-01-17 12:03:52');

------------------
INSERT INTO `faculties` (`id`, `fac_name`, `fac_code`, `created_at`, `updated_at`) VALUES (1, 'Fakulti Teknologi Maklumat & Komunikasi', 'FTMK', '2023-12-29 16:35:09', '2023-12-29 16:35:09');
------------------
INSERT INTO `programmes` (`id`, `prog_code`, `prog_name`, `prog_mode`, `fac_id`, `created_at`, `updated_at`) VALUES (1, 'PITA', 'Program Doctor of Information Technology', 'FT', 1, '2023-12-29 16:36:26', '2023-12-29 17:07:21');
INSERT INTO `programmes` (`id`, `prog_code`, `prog_name`, `prog_mode`, `fac_id`, `created_at`, `updated_at`) VALUES (2, 'PITA', 'Program Doctor of Information Technology', 'PT', 1, '2023-12-29 17:04:04', '2023-12-29 17:07:38');
INSERT INTO `programmes` (`id`, `prog_code`, `prog_name`, `prog_mode`, `fac_id`, `created_at`, `updated_at`) VALUES (3, 'MITA', 'Master of Information & Communication Technology', 'FT', 1, '2023-12-29 17:04:12', '2023-12-29 17:08:18');
INSERT INTO `programmes` (`id`, `prog_code`, `prog_name`, `prog_mode`, `fac_id`, `created_at`, `updated_at`) VALUES (4, 'MITA', 'Master of Information & Communication Technology', 'PT', 1, '2023-12-29 17:08:09', '2023-12-29 17:08:09');
----------
INSERT INTO `departments` (`id`, `dep_name`, `fac_id`, `created_at`, `updated_at`) VALUES (2, 'Dekan', 1, '2024-01-17 09:03:53', '2024-01-17 09:04:07');
INSERT INTO `departments` (`id`, `dep_name`, `fac_id`, `created_at`, `updated_at`) VALUES (1, 'Department of Software Engineering', 1, '2023-12-29 17:10:05', '2023-12-29 17:10:05');
---------
INSERT INTO `staff` (`id`, `staffNo`, `sname`, `email`, `sphoneNo`, `password`, `srole`, `s_status`, `dep_id`, `remember_token`, `created_at`, `updated_at`) VALUES (1, 'A2500', 'Dr. Nur Aqilah Binti Badrul', 'a2500@utem.my', '0196634411', '$2y$12$d6hmQj5lMwSVlqIozC2bTeRLZotw3drbf9yXYnolF3yyzw1wHic5G', 'Lecturer', NULL, 1, NULL, '2023-11-05 07:58:41', '2024-01-17 09:01:39');
INSERT INTO `staff` (`id`, `staffNo`, `sname`, `email`, `sphoneNo`, `password`, `srole`, `s_status`, `dep_id`, `remember_token`, `created_at`, `updated_at`) VALUES (2, 'A2350', 'Ts. Khairul Adzhar Bin Noraidi', 'a2350@utem.my', '0126674389', '$2y$12$C23xTVliPa3zg9ORcauZauIc.MqZjg2DmrsolQkb.AiQV/tI02Ufy', 'Lecturer', NULL, 1, NULL, '2023-11-03 10:53:46', '2023-11-05 14:00:28');
INSERT INTO `staff` (`id`, `staffNo`, `sname`, `email`, `sphoneNo`, `password`, `srole`, `s_status`, `dep_id`, `remember_token`, `created_at`, `updated_at`) VALUES (3, 'A2200', 'Dr. Zahriah Binti Othman', 'mzkstudio33@gmail.com', '0135676178', '$2y$12$3n3HrC9.K2VsKyLJ0JbWlefX6twoP2XeJmNSgSZKIvn/wltRgJS12', 'Committee', NULL, 1, NULL, '2023-11-05 07:57:30', '2024-01-01 18:23:21');
INSERT INTO `staff` (`id`, `staffNo`, `sname`, `email`, `sphoneNo`, `password`, `srole`, `s_status`, `dep_id`, `remember_token`, `created_at`, `updated_at`) VALUES (4, 'A3400', 'Dr. Nur Kalsum Umairah Binti Hassan', 'a3400@utem.my', '0198633452', '$2y$12$uKj1p6.I0bTDb9GQVRlCHef4NP1nBLqGO3uEh6eLFI07Nwo7Lntlu', 'Lecturer', NULL, 1, NULL, '2023-11-05 13:58:33', '2023-11-05 13:58:33');
INSERT INTO `staff` (`id`, `staffNo`, `sname`, `email`, `sphoneNo`, `password`, `srole`, `s_status`, `dep_id`, `remember_token`, `created_at`, `updated_at`) VALUES (5, 'A1200', 'Ts. Yahya Bin Ibrahim', 'a1200@gmail.com', '0146634897', '$2y$12$Q3LLPLYcEWEIYq9yoLveHOPCIE.sfPOPNKtOGdGX0oaGJKLuBzt5.', 'Lecturer', NULL, 1, NULL, '2023-11-05 14:00:07', '2023-11-05 14:00:07');
INSERT INTO `staff` (`id`, `staffNo`, `sname`, `email`, `sphoneNo`, `password`, `srole`, `s_status`, `dep_id`, `remember_token`, `created_at`, `updated_at`) VALUES (6, 'A4000', 'En. Azrul Bin Hisyam', 'a4000@utem.my', '0124456784', '$2y$12$AnTN/qdjW0W1Y2QH4pg4wuZeaJurlcFPDqUy/hNFJvWIsbSLN.Oai', 'Timbalan Dekan Pendidikan', NULL, 2, NULL, '2024-01-17 09:03:13', '2024-01-17 09:04:33');
INSERT INTO `staff` (`id`, `staffNo`, `sname`, `email`, `sphoneNo`, `password`, `srole`, `s_status`, `dep_id`, `remember_token`, `created_at`, `updated_at`) VALUES (7, 'A6700', 'Ts. Nor Mas Aina Md. Bohari', 'a6700@utem.my', '0124453786', '$2y$12$jezIkvy1KyLPh3Y4ViGiNexfR.sBwBhX5Dcv4qYZwf.O3/LVLx1/m', 'Lecturer', NULL, 1, NULL, '2024-01-17 09:06:51', '2024-01-17 09:06:51');
INSERT INTO `staff` (`id`, `staffNo`, `sname`, `email`, `sphoneNo`, `password`, `srole`, `s_status`, `dep_id`, `remember_token`, `created_at`, `updated_at`) VALUES (8, 'A7700', 'Ts. Dr. Shahjahan Bin Maidin', 'a7700@utem.my', '01116439878', '$2y$12$CFtEgoGd7N9FdVMoW/foauAK8ffKZgu9D1E7vnA7TO3I6hrmCgcVm', 'Lecturer', NULL, 1, NULL, '2024-01-17 09:43:52', '2024-01-17 09:43:52');

---------

Login credintial 
----------------
1) Committee User
Email: mzkstudio33@gmail.com
Password: 12345678


2) Lecturer User
Email: a6700@utem.my
Password: 12345678

3) TDP User
Email: a4000@utem.my
Password: 12345678



4.Then in CMD or terminal , type php artisan serve to run the laravel server.
5. Login using the credential details given based on roles.


