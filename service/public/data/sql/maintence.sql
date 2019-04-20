-- --------------------------------------------------------
-- Host:                         172.19.24.25
-- Server version:               10.1.36-MariaDB - Source distribution
-- Server OS:                    Linux
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping data for table mpwt_roadcare_dev_final_data.maintence: ~53 rows (approximately)
/*!40000 ALTER TABLE `maintence` DISABLE KEYS */;
INSERT INTO `maintence` (`id`, `group_id`, `type_id`, `subtype_id`, `unit_id`, `code`, `kh_name`, `en_name`, `rate`, `description`, `creator_id`, `updater_id`, `deleter_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 1, 1, 1, '1100', 'ការងារលុបសំបុកមាន់លើផ្លូវបេតុងកៅស៊ូ​(កៅស៊ូអ៊ុតលាយពីរោងចក្រ)', 'Pothole Repair - Asphalt Concrete (AC) by Plant Hot Mix', '0', NULL, NULL, NULL, NULL, '2018-12-06 23:23:59', '2018-12-08 11:45:22', NULL),
	(2, 1, 1, 1, 1, '1101', 'ការជួសជុលសំបុកមាន់លើផ្លូវបេតុងកៅស៊ូ (កៅស៊ូអ៊ុតលាយនៅការដ្ឋាន)', 'Pothole Repair - Asphalt Concrete (AC) by Site Mix', '0', NULL, NULL, NULL, NULL, '2018-12-06 23:28:52', '2018-12-06 23:28:59', NULL),
	(3, 1, 1, 1, 1, '1131', 'ការងារស្រោចកៅស៊ូ, បាចថ្ម លើផ្ទៃថ្នល់ប្រេះ១ជាន់ (ថ្ម ១២ ម.ម)', 'Crack Filling 1 layer 12mm Aggregate with CRS-2', '0', NULL, NULL, NULL, NULL, '2018-12-06 23:30:59', '2018-12-06 23:31:02', NULL),
	(4, 1, 1, 1, 1, '1132', 'ការងារស្រោចកៅស៊ូ, បាចថ្ម លើផ្ទៃថ្នល់ប្រេះ២ជាន់ (ថ្ម ១៩ ម.ម និង១២ ម.ម)', 'Crack Filling 2 layers 19mm then 12mm Aggregate with CRS-2', '0', NULL, NULL, NULL, NULL, '2018-12-06 23:32:17', '2018-12-06 23:32:22', NULL),
	(5, 1, 1, 1, 1, '1150', 'ការងារធ្វើផ្ទៃថ្នល់កៅស៊ូឱ្យរាបស្មើ', 'Shape Correction (Ruts/Settlement)', '0', NULL, NULL, NULL, NULL, '2018-12-06 23:33:43', '2018-12-06 23:33:45', NULL),
	(6, 1, 1, 1, 1, '1160', 'ការងារធ្វើផ្ទៃថ្នល់កៅស៊ូឲ្យរាបស្មើ,រៀបថ្មស្រោចកៅស៊ូ', 'ការងារធ្វើផ្ទៃថ្នល់កៅស៊ូឲ្យរាបស្មើ,រៀបថ្មស្រោចកៅស៊ូ', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:19:12', '2018-12-07 00:19:12', NULL),
	(7, 1, 1, 1, 1, '1161', 'ការងារលុបសំបុកមាន់ផ្លូវគ្រឹះថ្មចំរុះ - DBST', 'Pothole Repair - Mixed Stone Based-DBST', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:19:53', '2018-12-07 00:19:53', NULL),
	(8, 1, 1, 1, 1, '1162', 'ការងារលុបសំបុកមាន់ផ្លូវគ្រឹះល្បាយដី និងស៊ីម៉ង់ - DBST', 'Pothole Repair - Cement Mixed Based-DBST', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:20:34', '2018-12-07 00:20:34', NULL),
	(9, 1, 1, 1, 1, '1163', 'ការងារលុបសំបុកមាន់ផ្លូវគ្រឹះល្បាយថ្ម កៅស៊ូ និងស៊ីម៉ង់ - DBST', 'Pothole Repair - Mixed Gravel CRS2 & Cement Based-DBST', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:21:28', '2018-12-07 00:21:28', NULL),
	(10, 1, 1, 1, 1, '1164', 'ការងារលុបសំបុកមាន់លើផ្លូវកៅស៊ូដោយប្រើល្បាយកៅស៊ូត្រជាក់លាយស្រាប់', 'Pothole Repair - Cold Mix AC', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:21:59', '2018-12-07 00:21:59', NULL),
	(11, 1, 1, 1, 1, '1180', 'ផ្លូវបេតុងសរសៃដែក - កម្រាស់ ២០០ មីលីម៉ែត្រ', 'Reinforced Concrete Road - Thickness 200mm', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:22:32', '2018-12-07 00:22:32', NULL),
	(12, 1, 1, 2, 1, '1160-3', 'ការងារកៀរសំរួលផ្លូវកៅស៊ូបណ្ដោះអាសន្ន - គ្រួសក្រហម', 'Temporary Road Restore to Facilitate Traffic - Laterite', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:23:21', '2018-12-07 00:23:21', NULL),
	(13, 1, 1, 2, 1, '1160-c3', 'ការងារកៀរសំរួលផ្លូវកៅស៊ូបណ្ដោះអាសន្ន - ថ្មចំរុះ', 'Temporary Road Restore to Facilitate Traffic - Mixed Gravel', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:23:55', '2018-12-07 00:23:55', NULL),
	(14, 1, 1, 2, 1, '1201', 'ការងារកៀរថែមដីគ្រួសក្រហម', 'Adding Laterite to Road Shoulder', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:24:44', '2018-12-07 00:24:44', NULL),
	(15, 1, 1, 2, 1, '1250', 'ការឈូសពង្រាយដីគ្រួសក្រហម', 'Grading Laterite Road', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:25:34', '2018-12-07 00:25:34', NULL),
	(17, 1, 1, 2, 1, '4610', 'ការប្រើផ្លូវ AC ក្នុងការតភ្ជាប់ផ្លូវ (ផ្លូវលំទៅផ្លូវជាតិ)', 'Access Road (Public to National Road) by AC', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:26:59', '2018-12-07 00:26:59', NULL),
	(18, 1, 1, 2, 1, '1260', 'ការពង្រាបផ្លូវដីគ្រួសក្រហមកម្រិតធ្ងន់', 'Heavy Grading Laterite Road', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:26:19', '2018-12-07 00:26:19', NULL),
	(19, 1, 1, 2, 1, '4620', 'ការប្រើផ្លូវ DBST ក្នុងការតភ្ជាប់ផ្លូវ (ផ្លូវលំទៅផ្លូវជាតិ)', 'Access Road (Public to National Road) by DBST', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:27:26', '2018-12-07 00:27:26', NULL),
	(20, 1, 1, 2, 1, '4630', 'ការប្រើផ្លូវក្រាលដោយក្រួសតូចៗ ក្នុងការតភ្ជាប់ផ្លូវ (ផ្លូវលំទៅផ្លូវជាតិ)', 'Access Road (Public to National Road) by Macadam', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:27:59', '2018-12-07 00:27:59', NULL),
	(21, 1, 1, 3, 1, '1140', 'ការងារតំរង់ជាយផ្លូវកៅស៊ូ', 'Repaired Paved Shoulders', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:28:43', '2018-12-07 00:28:43', NULL),
	(22, 1, 1, 3, 1, '1200', 'ការងារកៀរសំរួលចិញ្ចើមផ្លូវ', 'Grading Shoulders', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:31:37', '2018-12-07 00:31:37', NULL),
	(23, 1, 1, 3, 1, '1201', 'ការងារកៀរថែមដីគ្រួសក្រហម', 'Adding Laterite to Road Shoulder', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:32:45', '2018-12-07 00:32:45', NULL),
	(24, 1, 2, 4, 2, '2100', 'ស្ដារសម្អាតប្រឡាយដោយកម្លាំងពលកម្ម', 'Channel Cleaning by Labour', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:33:27', '2018-12-07 00:33:27', NULL),
	(25, 1, 2, 4, 2, '2110', 'ការងារសម្អាតប្រឡាយដោយម៉ាស៊ីន(នីវីលឺ) (០.៥០ម)', 'Channel Cleaning by Machine', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:34:04', '2018-12-07 00:34:04', NULL),
	(26, 1, 2, 4, 2, '2150', 'កាយប្រឡាយដោយម៉ាស៊ីន', 'Excavate Channels by Machine', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:35:02', '2018-12-07 00:35:02', NULL),
	(27, 1, 2, 4, 2, '4150', 'ការសម្អាតរុក្ខជាតិតាមសងខាងផ្លូវ (ស្មៅ រុក្ខជាតិ និងដើមឈើតូចៗ)', 'Vegetation Control (Shrub, Plant and Tree)', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:35:41', '2018-12-07 00:35:41', NULL),
	(28, 1, 2, 4, 2, '4160', 'ការងារថែទាំសួនច្បារកណ្តាលទ្រូងផ្លូវ', 'ការងារថែទាំសួនច្បារកណ្តាលទ្រូងផ្លូវ', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:36:13', '2018-12-07 00:36:13', NULL),
	(29, 1, 2, 4, 2, '4200', 'បាវខ្សាច់ការពារជម្រាលភ្នំសងខាងផ្លូវ', 'Sand Bag Work - Slope Protection', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:39:25', '2018-12-07 00:39:25', NULL),
	(30, 1, 2, 4, 2, '4300', 'ការងារធ្វើរបាំងការពារទឹករលក', 'ការងារធ្វើរបាំងការពារទឹករលក', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:40:16', '2018-12-07 00:40:16', NULL),
	(31, 1, 2, 4, 2, '4400', 'ការដាំស្មៅនៅលើជម្រាល', 'Grass Planting on The Slope', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:41:45', '2018-12-07 00:41:45', NULL),
	(32, 1, 2, 4, 2, '4500', 'ការដាក់បន្ថែមដីលើជើងទេផ្លូវ', 'Adding Soil to The Slope', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:42:27', '2018-12-07 00:42:27', NULL),
	(33, 1, 2, 4, 2, '4700', 'ការលុបរូងនាគ', 'Dragon Hole Filling', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:43:17', '2018-12-07 00:43:17', NULL),
	(34, 1, 2, 4, 2, '4800', 'ការសម្អាតថ្មធ្លាក់', 'Clearing Rock Falling', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:43:48', '2018-12-07 00:43:48', NULL),
	(35, 1, 3, 5, 3, '3100', 'សម្អាតលូទទឹងផ្លូវ​', 'Cleaning Culvert Transversal', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:45:13', '2018-12-07 00:45:13', NULL),
	(36, 1, 3, 5, 3, '3110', 'ការសម្អាតលូបណ្ដោយផ្លូវ', 'Cleaning Culvert Longitudinal', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:46:30', '2018-12-07 00:46:30', NULL),
	(37, 1, 3, 5, 3, '3130', 'ការងារជួសជុលលូទទឹងផ្លូវ', 'Repair Pipe Culvert Transversal', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:49:18', '2018-12-07 00:49:18', NULL),
	(38, 1, 3, 5, 3, '3140', 'ការងារដាក់លូមូលបណ្តោយផ្លូវ', 'ការងារដាក់លូមូលបណ្តោយផ្លូវ', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:50:29', '2018-12-07 00:50:29', NULL),
	(39, 1, 3, 5, 3, '3141', 'ជួសជុលលូបណ្ដោយផ្លូវ', 'Repair Pipe Culvert Longitudinal', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:51:24', '2018-12-07 00:51:24', NULL),
	(40, 1, 3, 4, 3, '3142', 'ជួសជុលលូប្រអប់ (ប្រភេទលូបេតុង)', 'Repair Box Culvert Longitudinal (concrete)', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:52:02', '2018-12-07 00:52:02', NULL),
	(41, 1, 3, 5, 3, '3150', 'ការងារដាក់លូបេតុង', 'Install Pipe Culvert', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:52:39', '2018-12-07 00:52:39', NULL),
	(42, 1, 3, 5, 3, '3200', 'ការជួសជុលស្ពានកំរិតមធ្យម', 'Minor Bridge Repair', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:53:29', '2018-12-07 00:53:29', NULL),
	(43, 1, 4, 5, 4, '5100', 'គូសគំនូសចរាចរណ៍', 'Road Marking Painting (Thermoplastic)', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:54:30', '2018-12-07 00:54:30', NULL),
	(44, 1, 4, 5, 4, '5200', 'ការសម្អាត និងការលាបស្លាកសញ្ញាចរាចរណ៍', 'Clean and Paint Traffic Sign', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:55:03', '2018-12-07 00:55:03', NULL),
	(45, 1, 4, 5, 4, '5230', 'ការជួសជុលស្លាកសញ្ញាចរាចរណ៍', 'Traffic Sign Repair', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:55:39', '2018-12-07 00:55:39', NULL),
	(46, 1, 4, 5, 4, '5250', 'ការតម្លើងស្លាកសញ្ញាចរាចរណ៍ថ្មី', 'New Traffic Sign Installation', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:56:26', '2018-12-07 00:56:26', NULL),
	(47, 1, 4, 5, 4, '6100', 'ការសម្អាត និងលាបបង្គោលសុវត្ថិភាព​', 'Cleaning and Painting Safety Pole', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:57:57', '2018-12-07 00:57:57', NULL),
	(48, 1, 4, 5, 4, '6150', 'ការតម្លើងបង្គោលសុវត្ថិភាព', 'Safety Poles Installation', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:58:48', '2018-12-07 00:58:48', NULL),
	(49, 1, 4, 5, 4, '6151', 'ការងារតំឡើងបង្គោលសុវត្ថិភាព (មធ្យម)', 'ការងារតំឡើងបង្គោលសុវត្ថិភាព (មធ្យម)', '0', NULL, NULL, NULL, NULL, '2018-12-07 00:59:37', '2018-12-07 00:59:41', NULL),
	(50, 1, 4, 5, 4, '5252', 'ការងារបំពាក់ភ្លើងពញ្ញាក់អារម្មណ៍', 'ការងារបំពាក់ភ្លើងពញ្ញាក់អារម្មណ៍', '0', NULL, NULL, NULL, NULL, '2018-12-07 01:00:13', '2018-12-07 01:00:13', NULL),
	(51, 1, 4, 5, 4, '7100', 'ការងារសំអាត លាបថ្នាំថ្មីបង្គោលគីឡូម៉ែត្រ', 'Cleaning and Painting Kilometer Post', '0', NULL, NULL, NULL, NULL, '2018-12-07 01:02:34', '2018-12-07 01:02:34', NULL),
	(52, 1, 4, 5, 4, '7150', 'ការតម្លើងបង្គោលគីឡូម៉ែត្រ', 'Kilometer Post Installation', '0', NULL, NULL, NULL, NULL, '2018-12-07 01:03:41', '2018-12-07 01:03:41', NULL),
	(53, 1, 4, 5, 4, '7200', 'ថែទាំផ្លូវថ្នល់ជាប្រចាំ', 'Replacing Safety Guardrail (steel)', '0', NULL, NULL, NULL, NULL, '2018-12-07 01:04:15', '2018-12-07 01:04:15', NULL),
	(54, 1, 4, 5, 4, '7130', 'ការជួសជុលបង្គោលគីឡូម៉ែត្រ', 'Repairing Kilometers Post', '0', NULL, NULL, NULL, NULL, '2018-12-07 01:03:08', '2018-12-07 01:03:08', NULL);
/*!40000 ALTER TABLE `maintence` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
