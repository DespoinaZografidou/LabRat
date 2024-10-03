-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 03 Οκτ 2024 στις 23:10:06
-- Έκδοση διακομιστή: 10.4.25-MariaDB
-- Έκδοση PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `sso_client_labrat`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `activity_choose_theme`
--

CREATE TABLE `activity_choose_theme` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `l_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `at_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `activity_choose_theme`
--

INSERT INTO `activity_choose_theme` (`id`, `l_id`, `title`, `text`, `created_at`, `updated_at`, `at_id`) VALUES
(1, '321-0121', 'Επιλογή Θέματος για την 1η Ομαδική Εργασία Εργαστηρίου', '<p>Αυτή είναι μια δραστηριότητα Επιλογής θεμάτων. Κάθε  ομάδα μπορεί να επιλέξει το θέμα που θέλει να συμμετέχει. <span style=\"text-decoration: underline;\">Προσοχή :</span> Καποιά από τα θέματα είναι αποκλειστικά δηλ. μόνο μια ομάδα μπορεί να τα επιλέξει. και κάποια απο αυτά δεν είναι αποκλειστικά δηλ. μπορει να τα επιλέξουν πάνω από μία ομάδα.</p>', '2024-01-07 16:30:00', '2024-01-09 14:18:00', 1),
(2, '321-0121', 'Επιλογή Θέματος για την 1η Ατομική Εργασία Εργαστηρίου', '<p>Αυτή είναι μια δραστηριότητα Επιλογής θεμάτων. Κάθε  ομάδα μπορεί να επιλέξει το θέμα που θέλει να συμμετέχει. <span style=\"text-decoration: underline;\">Προσοχή :</span> Καποιά από τα θέματα είναι αποκλειστικά δηλ. μόνο μια ομάδα μπορεί να τα επιλέξει. και κάποια απο αυτά δεν είναι αποκλειστικά δηλ. μπορει να τα επιλέξουν πάνω από μία ομάδα.</p>', '2024-01-07 15:12:00', '2024-01-09 15:12:00', NULL),
(3, '321-0121', 'Επιλογή Θέματος για ανάπτυξη και παρουσίαση - Ατομική εργασία', '<p>Επιλέξτε ένα θέμα για παρουσίαση για την ατομική εργασία θεωρίας. Η εργασία θα μετρήσει το 30% του συνολικού βαθμου θεωρίας.</p>', '2024-02-06 02:07:00', '2024-02-07 02:07:00', NULL),
(4, '321-0121', 'Επιλογή θεμάτων για ομαδική εργασία', '<p>Επιλέξτε ένα θέμα για ανάπτυξη και παρουσίαση για την ομαδική εργασία θεωρίας. Η εργασία θα μετρήσει το 30% του συνολικού βαθμου θεωρίας.</p>', '2024-02-12 13:40:00', '2024-02-15 13:40:00', 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `activity_determinate_themes`
--

CREATE TABLE `activity_determinate_themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `l_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `at_id` bigint(20) UNSIGNED DEFAULT NULL,
  `confirmation` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `activity_determinate_themes`
--

INSERT INTO `activity_determinate_themes` (`id`, `l_id`, `title`, `text`, `created_at`, `updated_at`, `at_id`, `confirmation`) VALUES
(1, '321-0121', 'Προσδιορισμός θέματος για 2η Ομαδική Εργαστηριάκη Εργασία', 'Εδώ είναι μια ομαδική δραστηριότητα προσδιορισμός θεμάτων με επιβεβαίωση. Σε αυτή τη δραστηριότητα ο καθηγητής έχει εισάγει κάποια περιοδικά (λινκ) και η κάθε ομάδα φοιτητών επιλέγει ένα θέμα με το οποίο αυτή επιθυμεί να ασχοληθεί. Επειτα ο καθηγητής έχει την επιλογή να το αποδεχτεί ή να το απορύψει.', '2024-01-07 15:44:00', '2024-01-09 15:44:00', 2, 1),
(2, '321-0121', 'Προσδιορισμός θέματος για 2η Ατομική Εργαστηριάκη Εργασία', 'Εδώ είναι μια ατομική δραστηριότητα προσδιορισμός θεμάτων χωρίς επιβεβαίωση. Σε αυτή τη δραστηριότητα ο καθηγητής έχει εισάγει κάποια συγκεκριμένα άρθρα και ο κάθε φοιτητής επιλέγει ένα θέμα με το οποίο αυτή επιθυμεί να ασχοληθεί. ', '2024-01-07 15:44:00', '2024-01-11 15:44:00', NULL, 0),
(3, '321-0121', 'Προσδιορισμός θεμάτων της Ομαδικής Θεωρητικής Εργασίας', 'Αυτή είναι μία Δραστηριότητα προσδιορισμού θέματος με επιβεβαίωση.', '2024-02-13 14:51:00', '2024-02-14 14:51:00', 1, 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `activity_quiz`
--

CREATE TABLE `activity_quiz` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `l_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tries` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `activity_quiz`
--

INSERT INTO `activity_quiz` (`id`, `l_id`, `title`, `text`, `created_at`, `updated_at`, `tries`) VALUES
(1, '321-0121', 'Γραπτή Εξέταση όλης της ύλης', 'Εδώ είναι η τελική γραπτή εξέταση σας. Μετράει το 40% του τελικού βαθμού σας και έχετε μέχρι 3 προσπάθειες.  \nΚαλή Επιτυχία !', '2024-01-07 19:39:00', '2024-01-11 19:39:00', 3),
(4, '321-0121', 'Εξέταση Ύλης τους μαθήματος', 'Η εξέταση αυτή θα αποτελέσει το 100% της τελικής βαθμολογίας. Έχετε έως και 2 προσπάθειες για το συγκεκριμένο κουιζ.\nΚαλή τύχη!!!', '2024-02-15 20:41:00', '2024-02-17 20:41:00', 2);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `activity_slot`
--

CREATE TABLE `activity_slot` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `l_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `at_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `activity_slot`
--

INSERT INTO `activity_slot` (`id`, `l_id`, `title`, `text`, `created_at`, `updated_at`, `at_id`) VALUES
(1, '321-0121', 'Επιλογή Slot παρουσίασης 1η Ατομικής Εργαστηριακής Εργασίας', 'Ο κάθε φοιτητής πρέπει να επιλέξει μία ημερομηνία και ώρα για να την παρουσίαση της 1η ατομικής Εργαστηριακής Εργασίας του στο μάθημα. ', '2024-02-04 03:06:00', '2024-02-07 03:06:00', NULL),
(2, '321-0121', 'Επιλογή slot για Ομαδική Εργασία', 'Επιλογή slot παρουσίασης για μία ατομική εργασία', '2024-01-30 20:50:00', '2024-01-30 20:50:00', 2),
(3, '321-0121', 'Επιλογή slot για τη 2η ατομική εργασία', 'Επιλογή slot παρουσίασης για τη 2η ατομική εργασία', '2024-02-12 12:30:00', '2024-02-14 12:30:00', NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `activity_team`
--

CREATE TABLE `activity_team` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `l_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mnp` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `activity_team`
--

INSERT INTO `activity_team` (`id`, `l_id`, `title`, `text`, `mnp`, `created_at`, `updated_at`, `status`) VALUES
(1, '321-0121', 'Δημιουργία Ομάδων για 1η Εργαστηριάκη Άσκηση', 'Κάθε φοιτητής πρέπει να δημιουργήσει την ομάδα του και να κάνει αίτημα συμμετοχής σε όποιον συμφοιτητή θέλει να συμμετέχει στην ομάδα του. Κάθε φοιτητής που έχει αίτημα σημετοχής θα έχει την επιλογή να πατήσει αποδοχή ή απορυψη του αιτήματός . Αν πατήσει απόρυψη του αιτήματος θα έχει την επιλογή να δημιουργήσει δικιά του ομάδα.', 2, '2024-01-04 12:07:00', '2024-01-07 22:00:00', 1),
(2, '321-0121', 'Δημιουργία Ομάδων για 2η Εργαστηριάκη Άσκηση', 'Κάθε φοιτητής πρέπει να δημιουργήσει την ομάδα του και να κάνει αίτημα συμμετοχής σε όποιον συμφοιτητή θέλει να συμμετέχει στην ομάδα του. Κάθε φοιτητής που έχει αίτημα σημετοχής θα έχει την επιλογή να πατήσει αποδοχή ή απορυψη του αιτήματός . Αν πατήσει απόρυψη του αιτήματος θα έχει την επιλογή να δημιουργήσει δικιά του ομάδα.', 2, '2024-01-30 11:40:00', '2024-02-01 11:40:00', 1),
(3, '321-0121', 'Δημιουργία Ομάδων για 3η Ομαδική Εργασία', 'Κάθε φοιτητής πρέπει να δημιουργήσει την ομάδα του και να κάνει αίτημα συμμετοχής σε όποιον συμφοιτητή θέλει να συμμετέχει στην ομάδα του. Κάθε φοιτητής που έχει αίτημα σημετοχής θα έχει την επιλογή να πατήσει αποδοχή ή απορυψη του αιτήματός . Αν πατήσει απόρυψη του αιτήματος θα έχει την επιλογή να δημιουργήσει δικιά του ομάδα.', 2, '2024-02-12 11:04:00', '2024-02-14 11:04:00', 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `activity_voting`
--

CREATE TABLE `activity_voting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `l_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `activity_voting`
--

INSERT INTO `activity_voting` (`id`, `l_id`, `title`, `text`, `created_at`, `updated_at`) VALUES
(1, '321-0121', 'Αξιολόγηση Καθηγητή στο Μάθημα', 'Κάθε Ίδρυμα είναι υπεύθυνο για τη διασφάλιση και συνεχή βελτίωση της ποιότητας του εκπαιδευτικού και ερευνητικού του έργου, καθώς και για την αποτελεσματική λειτουργία και απόδοση των υπηρεσιών του. Αυτή η προσπάθεια εναρμονίζεται με τις διεθνείς πρακτικές, ιδίως εκείνες του Ευρωπαϊκού Χώρου Ανώτατης Εκπαίδευσης, και τις αρχές και κατευθύνσεις της ανεξάρτητης Αρχής Διασφάλισης και Πιστοποίησης της Ποιότητας στην Ανώτατη Εκπαίδευση (Α.ΔΙ.Π.) η οποία ιδρύθηκε με τον Νόμο 3374/2005. Για τον παραπάνω σκοπό υπεύθυνη σε κάθε Α.Ε.Ι. είναι η Μονάδα Διασφάλισης της Ποιότητας (ΜΟ.ΔΙ.Π.).\r\nΩς ενεργά και υπεύθυνα μέλη της ακαδημαϊκής κοινότητας και ως άμεσα ενδιαφερόμενοι για την ποιότητα της Ανώτατης Εκπαίδευσης, οι φοιτητές μπορούν να συμμετέχουν σε όλα τα επίπεδα, σε όλα τα όργανα και σε όλες τις διαδικασίες της Διασφάλισης Ποιότητας. Εναρμονιζόμενη με αυτό το νομικό πλαίσιο, η ΜΟ.ΔΙ.Π. καλεί τους φοιτητές του Πανεπιστημίου μας να συμπληρώσουν ηλεκτρονικά ένα ♥ΑΝΩΝΥΜΟ♠ ερωτηματολόγιο αξιολόγησης για όλα τα μαθήματα που παρακολουθούν κατά το τρέχον εξάμηνο σπουδών.', '2024-01-07 20:18:00', '2024-01-09 16:57:00'),
(2, '321-0121', 'Ερωτηματολόγιο για διεξαγωγή συμπερασμάτων Μαθήματος', 'Παρακαλείται από τον κάθε συμμετέχοντα να απαντήσει τις ακόλουθες ερώτησεις που αφορούν τη διαξαγωγή θεωρίας και Εργαστηρίου του μαθήματος ♥\"Ανάλυση και Σχεδιασμό\"♠ για το Εαρινό εξάμηνο του 2024. \nΗ υποβολή των απαντήσεων σας είναι ♥ανώνυμη♠. \n ', '2024-02-13 16:49:00', '2024-02-14 16:49:00');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `answers`
--

CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `q_id` bigint(20) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `answers`
--

INSERT INTO `answers` (`id`, `q_id`, `text`) VALUES
(1, 1, '<p>Καθόλου</p>'),
(2, 1, '<p>Λίγο </p>'),
(3, 1, '<p>Μέτρια</p>'),
(4, 1, '<p>Πολύ</p>'),
(5, 1, '<p>Πάρα πολύ</p>'),
(6, 2, '<p>Καθόλου</p>'),
(7, 2, '<p>Λίγο </p>'),
(8, 2, '<p>Μέτρια</p>'),
(9, 2, '<p>Πολύ</p>'),
(10, 2, '<p>Πάρα πολύ</p>'),
(11, 3, '<p>Καθόλου</p>'),
(12, 3, '<p>Λίγο</p>'),
(13, 3, '<p>Μέτρια</p>'),
(14, 3, '<p>Πολύ</p>'),
(15, 3, '<p>Πάρα πολύ</p>'),
(16, 5, '<p>Ναι ήταν επαρκής.</p>'),
(17, 5, '<p>Χρειαζόταν περισσότερες ώρες θεωρίας για την κάλυψη της ύλης.</p>'),
(18, 5, '<p>Χρειαζόταν περισσότερες ώρες εργαστηρίου για την κάλυψη της ύλης.</p>'),
(19, 5, '<p>Χρειαζόταν φροντηστιριακό μάθημα για την καλύτερη κατανόηση του μαθήματος.</p>'),
(28, 6, '<p><span style=\"text-decoration: underline;\"><strong>1ος Τρόπος: Δύο απαλλακτίκες Εργασίας.</strong></span></p>\r\n<ul>\r\n<li><span style=\"text-decoration: underline;\">1η Εργασία Θεωρίας:</span> Ανάλυση ενός άρθρου και παρουσίαση θέματος. Ο βαθμός της εργασίας θα είναι το 50% του τελικού βαθμού.</li>\r\n<li><span style=\"text-decoration: underline;\">2η Εργαστηριάκη Εργασία :</span> Ανάλυση και Σχεδιασμός βάσης δεδομένων με χρήση διαγραμμάτων URL. Ο βαθμός της εργασίας θα είναι το 50% του τελικού βαθμού.</li>\r\n</ul>'),
(29, 6, '<p><span style=\"text-decoration: underline;\"><strong>2ος Τρόπος: Τελική Εξέταση</strong></span></p>\r\n<p>Να υπάρχει μόνο η τελική εξέταση που θα ορίζει το 100% του τελικού βαθμού του μαθήματος</p>'),
(30, 7, '<p>Το 3ώρο εβδομαδιαίο μαθήμα της θεωρίας  να χωριστεί σε 2ώρες θεωρία και 1ώρα για ανάλυσει ασκήσεων</p>'),
(31, 7, '<p>Να γίνεται ένα 2ωρο μάθημα θεωρίας και ξεχωριστά 2ώρο φροντηστήριο για της ασκήσεις του μαθήματος την εβδομάδα.</p>');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `choose_themes_notifications`
--

CREATE TABLE `choose_themes_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `th_id` bigint(20) UNSIGNED NOT NULL,
  `msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `choose_themes_notifications`
--

INSERT INTO `choose_themes_notifications` (`id`, `th_id`, `msg`, `receiver_am`) VALUES
(1, 1, 'icsd15087-AVRAAM KATSIGRAS,icsd18067-Anastasia Spinou', 'icsd15087'),
(2, 1, 'icsd15087-AVRAAM KATSIGRAS,icsd18067-Anastasia Spinou', 'icsd18067'),
(3, 2, 'icsd17015-ANTONIS PITTAS', 'icsd17015'),
(4, 2, 'icsd22115-Maria Kostova,icsd19157-Georgios Kalliopitsas', 'icsd22115'),
(5, 2, 'icsd22115-Maria Kostova,icsd19157-Georgios Kalliopitsas', 'icsd19157'),
(6, 5, '', 'icsd22115'),
(7, 6, '', 'icsd19157'),
(8, 7, '', 'icsd17015'),
(9, 7, '', 'icsd15087'),
(10, 8, '', 'icsd18067'),
(11, 9, '', 'icsd15087'),
(12, 10, '', 'icsd19157'),
(13, 10, '', 'icsd18067'),
(14, 14, 'icsd17015-ANTONIS PITTAS', 'icsd17015'),
(15, 15, 'icsd15087-AVRAAM KATSIGRAS,icsd18067-Anastasia Spinou αποδεσμεύτηκε αποδεσμεύτηκε', 'icsd15087'),
(16, 15, 'icsd15087-AVRAAM KATSIGRAS,icsd18067-Anastasia Spinou αποδεσμεύτηκε αποδεσμεύτηκε', 'icsd18067'),
(18, 16, 'icsd15087-AVRAAM KATSIGRAS,icsd18067-Anastasia Spinou αποδεσμεύτηκε', 'icsd18067'),
(20, 15, 'icsd15087-AVRAAM KATSIGRAS,icsd18067-Anastasia Spinou αποδεσμεύτηκε', 'icsd18067'),
(21, 16, 'icsd15087-AVRAAM KATSIGRAS,icsd18067-Anastasia Spinou', 'icsd15087'),
(22, 16, 'icsd15087-AVRAAM KATSIGRAS,icsd18067-Anastasia Spinou', 'icsd18067');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `determinate_themes`
--

CREATE TABLE `determinate_themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adt_id` bigint(20) UNSIGNED NOT NULL,
  `j_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `determinate_themes`
--

INSERT INTO `determinate_themes` (`id`, `adt_id`, `j_id`, `title`, `am`, `confirm`) VALUES
(1, 1, 1, 'Landing trajectory and control optimization for helicopter encountering different tail rotor pitch lockups', 'icsd15087', 1),
(2, 1, 1, 'Analysis of the integrated performance of hybrid fiber-reinforced polymer composite used for thermal protection based on a dual-scale ablation model', 'icsd22115', 0),
(4, 1, 2, 'Shielded HMSIW-based frequency-tunable self-quadruplexing antenna using different solid/liquid dielectrics', 'icsd18067', 2),
(5, 2, 4, 'Computer-controlled ultra high voltage amplifier for dielectric elastomer actuators', 'icsd18067', 1),
(6, 2, 4, 'LiDAR-based estimation of bounding box coordinates using Gaussian process regression and particle swarm optimization', ' ', 1),
(7, 2, 4, 'Image format pipeline and instrument diagram recognition method based on deep learning', 'icsd19157', 1),
(8, 2, 5, 'State inference for dynamically changing interfaces', 'icsd15087', 1),
(9, 2, 5, 'LAILA: a language for coordinating abductive reasoning among logic agents', 'icsd17015', 1),
(10, 2, 5, 'Languages for formalizing, visualizing and verifying software architectures', 'icsd22115', 1),
(17, 3, 7, '2ο Άρθρο', 'icsd17015', 1),
(19, 3, 7, '3ο Άρθρο', 'icsd15087', 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `determinate_themes_notifications`
--

CREATE TABLE `determinate_themes_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dt_id` bigint(20) UNSIGNED NOT NULL,
  `msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `determinate_themes_notifications`
--

INSERT INTO `determinate_themes_notifications` (`id`, `dt_id`, `msg`, `receiver_am`) VALUES
(1, 1, 'icsd15087-AVRAAM KATSIGRAS,icsd19157-Georgios Kalliopitsas', 'icsd15087'),
(2, 1, 'icsd15087-AVRAAM KATSIGRAS,icsd19157-Georgios Kalliopitsas', 'icsd19157'),
(3, 2, 'icsd22115-Maria Kostova', 'icsd22115'),
(6, 4, 'icsd18067-Anastasia Spinou,icsd17015-ANTONIS PITTAS', 'icsd18067'),
(7, 4, 'icsd18067-Anastasia Spinou,icsd17015-ANTONIS PITTAS', 'icsd17015'),
(8, 5, ' ', 'icsd18067'),
(9, 7, ' ', 'icsd19157'),
(10, 10, ' ', 'icsd22115'),
(11, 9, ' ', 'icsd17015'),
(12, 8, ' ', 'icsd15087'),
(24, 19, 'icsd15087-AVRAAM KATSIGRAS,icsd18067-Anastasia Spinou', 'icsd15087'),
(25, 19, 'icsd15087-AVRAAM KATSIGRAS,icsd18067-Anastasia Spinou', 'icsd18067');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `journals`
--

CREATE TABLE `journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adt_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `journals`
--

INSERT INTO `journals` (`id`, `adt_id`, `title`, `text`, `link`) VALUES
(1, 1, 'Aerospace Science and Technology', '<p>Πατήστε το λινκ και επιλέξτε ένα άρθρο που σας ενδιαφέρει.</p>', 'https://www.sciencedirect.com/journal/aerospace-science-and-technology'),
(2, 1, 'AEU - International Journal of Electronics and Communications', '<p>Πατήστε το λινκ και επιλέξτε ένα άρθρο που σας ενδιαφέρει.</p>', 'https://www.sciencedirect.com/journal/aeu-international-journal-of-electronics-and-communications'),
(4, 2, 'Biomimetic Intelligence and Robotics', '<div><strong>Computer-controlled ultra high voltage amplifier for dielectric elastomer actuators</strong></div>\r\n<div>            https://www.sciencedirect.com/science/article/pii/S2667379723000530</div>\r\n<div> </div>\r\n<div><strong>Image format pipeline and instrument diagram recognition method based on deep learning</strong></div>\r\n<div>            https://www.sciencedirect.com/science/article/pii/S2667379723000566</div>\r\n<div> </div>\r\n<div><strong>LiDAR-based estimation of bounding box coordinates using Gaussian process regression and particle swarm optimization</strong></div>\r\n<div>           https://www.sciencedirect.com/science/article/pii/S2667379723000542</div>\r\n<p> </p>', 'https://www.sciencedirect.com/journal/biomimetic-intelligence-and-robotics'),
(5, 2, 'Computer Languages', '<div><strong>LAILA: a language for coordinating abductive reasoning among logic agents </strong></div>\r\n<div>          https://www.sciencedirect.com/science/article/pii/S0096055101000200</div>\r\n<div> </div>\r\n<div><strong>Languages for formalizing, visualizing and verifying software architectures </strong></div>\r\n<div>          https://www.sciencedirect.com/science/article/pii/S0096055101000133</div>\r\n<div> </div>\r\n<div><strong>State inference for dynamically changing interfaces </strong></div>\r\n<div>         https://www.sciencedirect.com/science/article/pii/S0096055101000194</div>', 'https://www.sciencedirect.com/journal/computer-languages'),
(6, 3, '1ο Περιοδικό', '<p>Κάποια περιγραφή του περιοδικού</p>', 'https://www.computer.org/csdl/magazine/co'),
(7, 3, '3ο Περιοδικό', '<p>Κάποια περιγραφή του περιοδικού</p>\n', 'https://gr.pinterest.com/search/pins/?q=leo%20animal&rs=typed'),
(8, 3, '4ο Περιοδικό', '<p>Κάποια περιγραφή του περιοδικού</p>\n', 'https://gr.pinterest.com/search/pins/?q=leo%20animal&rs=typed'),
(9, 3, '5ο Περιοδικό', '<p>Κάποια περιγραφή του περιοδικού</p>\n', 'https://gr.pinterest.com/search/pins/?q=skorpio%20animal&rs=typed');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `lessons`
--

CREATE TABLE `lessons` (
  `l_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_id` bigint(20) UNSIGNED NOT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_area` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `lessons`
--

INSERT INTO `lessons` (`l_id`, `title`, `description`, `t_id`, `semester`, `type`, `l_area`, `created_at`, `updated_at`) VALUES
('321-0121', 'Ανάλυση και Σχεδιασμός Πληροφοριακών Συστημάτων', 'Η έννοια του Πληροφοριακού Συστήματος (Π.Σ.). Ανάλυση των εννοιών δεδομένα, πληροφορία και σύστημα. Προβλήματα στην ανάπτυξη Π.Σ. Παράγοντες που επηρεάζουν την ανάπτυξη ενός Π.Σ. Ο ρόλος του αναλυτή. Τεχνικές προσδιορισμού απαιτήσεων. Κύκλος ζωής του Π.Σ. Τεχνικές μοντελοποίησης και ανάλυσης δεδομένων. Τεχνικές μοντελοποίησης επεξεργασίας δεδομένων. Διαγράμματα Ροής Δεδομένων. Μοντέλο Οντοτήτων-Συσχετίσεων. Αντικειμενοστραφής ανάλυση και σχεδίαση με την UML.', 12, '3ο Εξάμηνο', 'Προπτυχιακό', 1, NULL, NULL),
('321-0127', 'Κρυπτογραφία', 'Περιγραφή...', 12, '2ο Εξάμηνο', 'Μεταπτυχιακό', 1, NULL, NULL),
('321-0129', 'Ασφάλεια Πληροφοριακών & Επικοινωνιακών Συστημάτων', 'Εννοιολογική Θεμελίωση όρων Ασφάλειας Πληροφοριακών και Επικοινωνιακών Συστημάτων. Ταυτοποίηση και Αυθεντικοποίηση. Έλεγχος Προσπέλασης. Πολιτικές και Φορμαλιστικά Μοντέλα Ασφάλειας. Ασφάλεια Λειτουργικών Συστημάτων, Μοντέλο περίπτωσης: Unix. Κακόβουλο Λογισμικό. Ανάλυση, Αποτίμηση και Διαχείριση Επικινδυνότητας Πληροφοριακών Συστημάτων. Πολιτικές Ασφάλειας Πληροφοριακών Συστημάτων. Σειρά Προτύπων ISO 2700X. Στοιχεία Εφαρμοσμένης Κρυπτογραφίας: Κλασικές Κρυπτογραφικές Μέθοδοι, Συμμετρικά και Ασύμμετρα Κρυπτοσυστήματα, Κώδικες Αυθεντικοποίησης Μηνυμάτων, Ψηφιακές Υπογραφές, Πάροχοι Υπηρεσιών Πιστοποίησης, Υποδομή Δημόσιων Κλειδιών, Νομοθετικό και Ρυθμιστικό Πλαίσιο στην Ελλάδα. Ιδιωτικότητα. Ασφάλεια Δικτύων Υπολογιστών. Απειλές και Ευπάθειες. Αναχώματα Ασφάλειας. Αρχιτεκτονική Ασφάλειας στο μοντέλο του Internet. Εφαρμογές.', 12, '3ο Εξάμηνο', 'Προπτυχιακό', 0, NULL, NULL),
('321-1200', 'Δομημένος Προγραμματισμός', 'Εισαγωγή στον προγραμματισμό υπολογιστών, Γλώσσες προγραμματισμού, Συστατικά ενός προγράμματος C, Μεταβλητές και Σταθερές, Δηλώσεις, Τελεστές, Εκφράσεις, Είσοδος / Έξοδος δεδομένων, Εντολές ελέγχου ροής και επανάληψης, Συναρτήσεις, Πίνακες, Δείκτες, Μορφοποιημένη Είσοδος / Έξοδος, Σύνθετες δομές δεδομένων, Χειρισμός αρχείων.', 16, '1ο Εξάμηνο', 'Προπτυχιακό', 1, NULL, NULL),
('321-1204', 'Θεωρία Κυκλωμάτων', 'Βασικές αρχές ηλεκτρικών κυκλωμάτων – επίπεδα αφαίρεσης λειτουργίας. Τεχνικές ανάλυσης κυκλωμάτων με αντιστάσεις: Νόμοι του Kirchhoff, ισοδυναμία αντιστάσεων σε σειρά και παράλληλα. Ισοδύναμα κυκλώματα: ισοδύναμο κύκλωμα κατά Thévenin, ισοδύναμο κύκλωμα κατά Norton. Μετασχηματισμοί κυκλωμάτων. H ψηφιακή λογική – περιθώρια θορύβου. Το τρανζίστορ σαν διακόπτης – σχεδίαση λογικών πυλών. Συμπεριφορά εισόδου - εξόδου λογικών πυλών. Πυκνωτές και πηνία: βασικές αρχές, συνδεσμολογίες σε σειρά και παράλληλα. Κυκλώματα πρώτης τάξης: κυκλώματα με αντιστάσεις και πυκνωτή (RC), κυκλώματα με αντιστάσεις και πηνίο (RL), ανάλυση κυκλωμάτων πρώτης τάξης. Η δομή του τρανζίστορ επίδρασης πεδίου MOS (MOS Field Effect Transistor – MOSFET). Καθυστέρηση λογικών πυλών. Ενέργεια και ισχύς: υπολογισμός ενέργειας, στατική κατανάλωση ισχύος, δυναμική κατανάλωση ισχύος. Οι πύλες CMOS.', 9, '1ο Εξάμηνο', 'Προπτυχιακό', 1, NULL, NULL),
('321-1228', 'Ψηφιακή Καινοτομία', 'Περιγραφή...', 9, '2ο Εξάμηνο', 'Διδακτορικό', 1, NULL, NULL),
('321-1278', 'Ψηφιακή Καινοτομία', 'Περιγραφή...', 12, '4ο Εξάμηνο', 'Διδακτορικό', 1, NULL, NULL),
('321-1501', 'Προγραμματισμός στο Διαδίκτυο', 'Εισαγωγή στις τεχνολογίες διαδικτύου και στον προγραμματισμό διαδικτυακών εφαρμογών, Αρχιτεκτονική εφαρμογών και πρωτόκολλα στο διαδίκτυο, Αρχιτεκτονικές εφαρμογών πολλών στρωμάτων, Προγραμματισμός περιεχομένου (HTML, XML, CSS), Βάσεις δεδομένων για εφαρμογές διαδικτύου, Προγραμματισμός στην πλευρά του πελάτη (JavaScript, DOM, DHTML), Προγραμματισμός στην πλευρά του εξυπηρετητή (Java Servlets, PHP, αποθήκευση και ανάκληση δεδομένων σε MySQL με PHP, PHP sessions, JSP), Τεχνολογία Υπηρεσιών Παγκόσμιου Ιστού (Web Services), Τεχνικές ασφαλείας εφαρμογών Διαδικτύου, Πλατφόρμες διαχείρισης περιεχομένου στο Διαδίκτυο. Εργαστηριακές εργασίες ανάπτυξης εφαρμογών και υπηρεσιών. H απόκτηση γνώσεων και εργαστηριακής εμπειρίας στις βασικές τεχνολογίες και τα εργαλεία του διαδικτυακού προγραμματισμού. Η εξοικείωση με βασικές προγραμματιστικές τεχνικές για την ανάπτυξη εφαρμογών διαχείρισης περιεχομένου και πληροφορίας.', 9, '2ο Εξάμηνο', 'Προπτυχιακό', 1, NULL, NULL),
('321-1506', 'Αντικειμενοστραφής Προγραμματισμός I', 'Αντικειμενοστραφής προγραμματισμός, Κλάσεις, Αντικειμενοστραφής Ανάλυση και Σχεδίαση, Αντικείμενα, Αναδρομή, Δομητής, Aποδομητής, Συναρτήσεις-μέλη, Συναρτήσεις const, Inline συναρτήσεις, Σύνθετες κλάσεις, Είσοδος / Έξοδος στη C++, Έξοδος σε αρχείο, Ανάγνωση από αρχείο, Βρόχοι ελέγχου, Χρήση δεικτών, Δέσμευση μνήμης, Αναφορές, Παράγωγη κλάση, Κληρονομικότητα, Overriding, Overloading vs. Overriding, Virtual Συναρτήσεις, Αφηρημένες κλάσεις, Πολυμορφισμός, Virtual Κληρονομικότητα.', 16, '2ο Εξάμηνο', 'Προπτυχιακό', 1, NULL, NULL),
('321-1537', 'Απειροστικός Λογισμός', 'Περιγραφή...', 9, '2ο Εξάμηνο', 'Μεταπτυχιακό', 1, NULL, NULL),
('321-2003', 'Δίκτυα Ηλεκτρονικών Υπολογιστών', 'Περιγραφή...', 9, '1ο Εξάμηνο', 'Μεταπτυχιακό', 1, NULL, NULL),
('321-2043', 'Επικοινωνία πληροφοριακών Συστημάτων', 'Περιγραφή...', 12, '2ο Εξάμηνο', 'Μεταπτυχιακό', 1, NULL, NULL),
('321-2450', 'Τεχνολογία Λογισμικού', 'Εισαγωγή στην τεχνολογία λογισμικού. Μοντέλα ανάπτυξης λογισμικού. Κύκλος ζωής λογισμικού (φάσεις, διαδικασία ανάπτυξης, μοντέλα κύκλου ζωής). Απαιτήσεις λογισμικού, στάδια προσδιορισμού απαιτήσεων. Ανάλυση απαιτήσεων λογισμικού (εκμαίευση απαιτήσεων, μοντελοποίηση και προτυποποίηση, δομημένη ανάλυση, αντικειμενοστραφής ανάλυση, πρότυπα προδιαγραφής απαιτήσεων). Σχεδίαση λογισμικού (σχέδιο λογισμικού, αποτελεσματική τμηματική σχεδίαση, δομημένη σχεδίαση, αντικειμενοστραφής σχεδίαση, πρότυπα προδιαγραφής σχεδίασης). Κωδικοποίηση και τεκμηρίωση λογισμικού (αρχές κωδικοποίησης, επιλογή αλγοριθμικών δομών, εσωτερική και εξωτερική τεκμηρίωση κώδικα, πρότυπα τεκμηρίωσης). Έλεγχος λογισμικού (στόχοι, σχεδίαση περιπτώσεων δοκιμής, δοκιμασία μονάδων, ολοκλήρωσης, επικύρωσης και συστήματος, δοκιμασία αντικειμενοστραφούς λογισμικού, τεχνικές αποσφαλμάτωσης), εργαλεία ελέγχου, εκτίμηση ποιότητας λογισμικού. Διοίκηση έργου, κοστολόγηση, εξασφάλιση ποιότητας, διαχείριση σχηματισμών, περιβάλλοντα ανάπτυξης, πρότυπα. Ειδικά, σύγχρονα μοντέλα ευέλικτου προγραμματισμού και ανάπτυξη πρωτοτύπου', 12, '5ο Εξάμηνο', 'Προπτυχιακό', 1, NULL, NULL),
('321-2458', 'Θεωρία Παιγνίων', 'Περιγραφή...', 12, '2ο Εξάμηνο', 'Διδακτορικό', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2022_11_16_190707_remove_unusable_columns_from_users_table', 1),
(11, '2022_12_14_022304_add_role_field_to_users', 2),
(12, '2023_01_06_014027_add_am_field_to_users', 2),
(13, '2023_01_08_181731_add_info_field_to_users', 2),
(14, '2023_01_18_152259_add_system_status_field_to_users', 2),
(15, '2023_02_05_025719_create_lessons_table', 2),
(16, '2023_02_05_030634_create_participations_table', 2),
(17, '2023_06_01_232525_create_activity_team', 2),
(18, '2023_06_02_001706_create_notifications', 2),
(19, '2023_06_25_195121_add_column_to_users', 2),
(20, '2023_07_01_142132_create_teams', 2),
(21, '2023_07_18_010243_create_reject_team_table', 2),
(22, '2023_07_24_200414_create_activity_slot', 2),
(23, '2023_08_01_181103_create_slots_table', 2),
(24, '2023_08_01_181113_create_slot_notification_table', 2),
(25, '2023_08_01_181934_modify_slot_time_default_in_your_table', 2),
(26, '2023_08_08_234228_create_activity_choose_theme_table', 2),
(27, '2023_08_08_234336_create_themes_table', 2),
(28, '2023_08_08_234441_create_themes_choises_table', 2),
(29, '2023_08_09_015011_create_activity_determinate_themes_table', 2),
(30, '2023_08_09_015920_create_journals_table', 2),
(31, '2023_08_09_015958_create_determinate_themes_table', 2),
(32, '2023_08_09_020040_create_determinate_themes_notifications_table', 2),
(33, '2023_08_09_021942_create_activity_voting_table', 2),
(34, '2023_08_09_022013_create_questions_table', 2),
(35, '2023_08_09_022119_create_answers_table', 2),
(36, '2023_08_09_022150_create_voting_table', 2),
(37, '2023_08_10_174418_create_activity_quiz_table', 2),
(38, '2023_08_24_060755_add_column_to_themes_choises', 2),
(39, '2023_08_25_110653_create_choose_themes_notifications', 2),
(40, '2023_08_29_062111_add_column_to_journals', 2),
(41, '2023_08_30_195040_add_column_to_acivity_determinate_themes', 2),
(42, '2023_09_05_142142_add_column_to_voting', 2),
(43, '2023_09_07_104122_create_quiz_tries_table', 2),
(44, '2023_09_07_104256_create_quiz_questions_table', 2),
(45, '2023_09_07_104400_create_quiz_answers_table', 2),
(46, '2023_09_07_104437_create_quiz_choices_table', 2),
(47, '2023_09_07_174438_make_column_nullable_in_quiz_tries', 2),
(48, '2023_09_09_162425_alter_quiz_tries', 3),
(49, '2023_09_09_162436_alter_quiz_questions', 4),
(50, '2023_09_09_162446_alter_quiz_answers', 5),
(51, '2023_09_11_212834_add_column_to_table_quiz_tries', 5),
(52, '2023_10_29_133046_add_column_to_quiz_choices', 5),
(53, '2024_01_04_222614_alter_description_to_text', 5),
(54, '2024_02_08_222141_alter_type_the_text', 6);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `l_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `notifications`
--

INSERT INTO `notifications` (`id`, `l_id`, `title`, `text`, `created_at`, `updated_at`) VALUES
(1, '321-0121', 'Δημιουργία Ομάδων 2 Ατόμων για την 1η Εργαστηριακή εργασία', 'Έχει ανοίξει η δραστηριότητα Ομάδεςγια όλους τους μαθητές που συμετέχουν στο μάθημα για να δημιουργήσουν την ομάδα τους έως και 2 άτομα για τη ♥1η Εργαστηριακή Άσκηση♠. \n♥Το λινκ της δραστηριότητας είναι :♠ \nhttp://127.0.0.1:8080/showTheTeams/321-0121/%CE%91%CE%BD%CE%AC%CE%BB%CF%85%CF%83%CE%B7%20%CE%A0%CE%BB%CE%B7%CF%81%CE%BF%CF%86%CE%BF%CF%81%CE%B9%CE%B1%CE%BA%CF%8E%CE%BD%20%CE%A3%CF%85%CF%83%CF%84%CE%B7%CE%BC%CE%AC%CF%84%CF%89%CE%BD/KOSTAS%20TSIFOUTIS/1  \nΗ δραστηριότητα θα είναι διαθέσημη μέχρι και τις ♥8/1/2024♠.', '2024-01-04 12:10:42', NULL),
(2, '321-0121', 'Δημιουργία Ομάδων 2 Ατόμων για την 2η Εργαστηριακή εργασία', 'Έχει ανοίξει η δραστηριότητα Ομάδεςγια όλους τους μαθητές που συμετέχουν στο μάθημα για να δημιουργήσουν την ομάδα τους έως και 2 άτομα για τη ♥2η Εργαστηριακή Άσκηση♠. \n♥Το λινκ της δραστηριότητας είναι :♠\r\nhttp://127.0.0.1:8080/showTheTeams/321-0121/%CE%91%CE%BD%CE%AC%CE%BB%CF%85%CF%83%CE%B7%20%CE%BA%CE%B1%CE%B9%20%CE%A3%CF%87%CE%B5%CE%B4%CE%B9%CE%B1%CF%83%CE%BC%CF%8C%CF%82%20%CE%A0%CE%BB%CE%B7%CF%81%CE%BF%CF%86%CE%BF%CF%81%CE%B9%CE%B1%CE%BA%CF%8E%CE%BD%20%CE%A3%CF%85%CF%83%CF%84%CE%B7%CE%BC%CE%AC%CF%84%CF%89%CE%BD/KOSTAS%20TSIFOUTIS/2 \n\nΗ δραστηριότητα θα είναι διαθέσημη μέχρι και τις ♥15/1/2024♠.', '2024-01-08 05:17:18', NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `participations`
--

CREATE TABLE `participations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `participations`
--

INSERT INTO `participations` (`id`, `am`, `l_id`, `created_at`, `updated_at`) VALUES
(1, 'icsd17015', '321-2003', NULL, NULL),
(2, 'icsd17015', '321-1537', NULL, NULL),
(3, 'icsd15087', '321-1204', NULL, NULL),
(4, 'icsd15087', '321-1501', NULL, NULL),
(5, 'icsd15087', '321-0121', NULL, NULL),
(6, 'icsd17015', '321-0121', NULL, NULL),
(7, 'icsd17015', '321-1501', NULL, NULL),
(8, 'icsd17015', '321-1204', NULL, NULL),
(9, 'icsd17015', '321-0127', NULL, NULL),
(10, 'icsd17015', '321-1228', NULL, NULL),
(11, 'icsd18067', '321-1204', NULL, NULL),
(12, 'icsd18067', '321-1501', NULL, NULL),
(13, 'icsd18067', '321-0121', NULL, NULL),
(14, 'icsd18067', '321-0127', NULL, NULL),
(15, 'icsd18067', '321-1228', NULL, NULL),
(16, 'icsd22115', '321-0121', NULL, NULL),
(17, 'icsd22115', '321-1204', NULL, NULL),
(18, 'icsd22115', '321-0127', NULL, NULL),
(19, 'icsd22115', '321-2003', NULL, NULL),
(20, 'icsd19157', '321-0121', NULL, NULL),
(21, 'icsd19157', '321-2450', NULL, NULL),
(22, 'icsd19157', '321-1204', NULL, NULL),
(23, 'icsd19157', '321-1501', NULL, NULL),
(24, 'icsd19157', '321-0127', NULL, NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `av_id` bigint(20) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `questions`
--

INSERT INTO `questions` (`id`, `av_id`, `text`, `type`) VALUES
(1, 1, '<p> Οι στόχοι του μαθήματος ήταν σαφείς;</p>', 'Μίας Επιλογής'),
(2, 1, '<p>Η ύλη που καλύφθηκε ανταποκρινόταν στους στόχους του μαθήματος;</p>', 'Μίας Επιλογής'),
(3, 1, '<p>Η ύλη που διδάχθηκε ήταν καλά οργανωμένη;</p>', 'Μίας Επιλογής'),
(5, 1, '<p>Ο τρόπος διεξαγωγής ήταν επαρκής; Και αν όχι τι θα θέλατε από τα παρακάτω.</p>', 'Πολλαπλής Επιλογής'),
(6, 2, '<p>Υπάρχουν δύο τρόπει διεξαγωγής του μαθήματος. Ποιο από τους παρακάτω τρόπους προτιμάτε;  </p>', 'Μίας Επιλογής'),
(7, 2, '<p>Τι θα επιθυμούσατε για τη διεξαγωγή του μαθήματος;</p>', 'Μίας Επιλογής');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `quiz_answers`
--

CREATE TABLE `quiz_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qq_id` bigint(20) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `quiz_answers`
--

INSERT INTO `quiz_answers` (`id`, `qq_id`, `text`, `grade`) VALUES
(1, 1, '<p>Λονδίνο</p>', '0.00'),
(2, 1, '<p>Παρίσι</p>', '1.50'),
(3, 1, '<p>Βερολίνο</p>', '0.00'),
(4, 1, '<p>Ρώμη</p>', '0.00'),
(5, 2, '<p>Γαλλία</p>', '1.00'),
(6, 2, '<p>Βραζιλία</p>', '0.00'),
(7, 2, '<p>Κίνα</p>', '0.00'),
(8, 2, '<p>Ισπανία</p>', '1.00'),
(9, 2, '<p>Καναδάς</p>', '0.00'),
(10, 2, '<p>Ιταλία</p>', '1.00'),
(11, 3, 'Ναι', '0.00'),
(12, 3, 'Όχι', '1.00'),
(13, 4, 'A=3', '0.25'),
(14, 4, 'A=6', '0.25'),
(15, 4, 'B=1', '0.25'),
(16, 4, 'B=5', '0.25'),
(17, 4, 'C=2', '0.25'),
(18, 4, 'C=4', '0.25'),
(20, 4, '=', '0.00'),
(24, 8, '<p>1η Πιθανή Απάντηση</p>', '1.00'),
(26, 8, '<p>3η Πιθανή Απάντηση</p>', '0.00'),
(27, 9, '<p>1η Πιθανή Απάντηση</p>', '0.00'),
(28, 9, '<p>2η Πιθανή Απάντηση</p>', '1.00'),
(29, 9, '<p>3η Πιθανή Απάντηση</p>', '1.00'),
(30, 9, '<p>4η Πιθανή Απάντηση</p>', '0.00'),
(31, 10, 'Ναι', '2.00'),
(32, 10, 'Όχι', '0.00'),
(39, 11, 'A=1', '0.50'),
(40, 11, 'B=2', '0.50'),
(41, 11, 'C=3', '0.50'),
(42, 11, 'D=4', '0.50'),
(43, 11, 'E=5', '0.50'),
(44, 11, 'F=6', '0.50'),
(45, 11, '=', '0.00');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `quiz_choices`
--

CREATE TABLE `quiz_choices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qq_id` bigint(20) UNSIGNED NOT NULL,
  `t_id` bigint(20) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `quiz_choices`
--

INSERT INTO `quiz_choices` (`id`, `qq_id`, `t_id`, `text`, `grade`) VALUES
(242, 4, 1, 'A=3', NULL),
(243, 4, 1, 'A=6', NULL),
(244, 4, 1, 'B=1', NULL),
(245, 4, 1, 'B=5', NULL),
(246, 4, 1, 'C=2', NULL),
(247, 4, 1, 'C=4', NULL),
(248, 5, 1, '<p>Η γεωγραφία επηρεάζει τον τρόπο ζωής στα μέρη όπου ζούμε με πολλούς τρόπους. Ένας σημαντικός παράγοντας είναι η φυσική γεωγραφία.</p>', '0.00'),
(249, 1, 1, '2', NULL),
(250, 2, 1, '5', NULL),
(251, 2, 1, '8', NULL),
(252, 2, 1, '10', NULL),
(253, 3, 1, '12', NULL),
(392, 4, 2, 'A=3', NULL),
(393, 4, 2, 'A=6', NULL),
(394, 4, 2, 'B=4', NULL),
(395, 4, 2, 'B=5', NULL),
(396, 4, 2, 'C=1', NULL),
(397, 4, 2, 'C=2', NULL),
(398, 5, 2, '<p>Η γεωγραφία επηρεάζει τον τρόπο ζωής στα μέρη όπου ζούμε με πολλούς τρόπους. Οι φυσικοί παράγοντες, όπως το κλίμα, η γεωλογία και η υδατοκαλλιέργεια, μπορούν να επηρεάσουν τη γεωργία και τη διαθεσιμότητα των τροφίμων. Επίσης, η παρουσία φυσικών σχηματισμών όπως βουνά, ποτάμια και θάλασσες επηρεάζει τις μεταφορές και τις επικοινωνίες.</p>\n<p>Επιπλέον, οι πολιτικές συνόρων μπορούν να διαμορφώσουν τις κοινωνικές και πολιτιστικές διαφορές μεταξύ περιοχών. Η παρουσία φυσικών πόρων, όπως πετρέλαιο και ορυκτά, επηρεάζει την οικονομία και την απασχόληση. Οι περιβαλλοντικές συνθήκες επηρεάζουν τον τρόπο ζωής και τις δραστηριότητες των κοινοτήτων.</p>\n<p>Συνολικά, η γεωγραφία παίζει σημαντικό ρόλο στον προσδιορισμό των χαρακτηριστικών μιας περιοχής και τον τρόπο ζωής των ανθρώπων που ζουν εκεί.</p>', NULL),
(399, 1, 2, '1', NULL),
(400, 2, 2, '5', NULL),
(401, 2, 2, '10', NULL),
(402, 3, 2, '12', NULL),
(410, 1, 3, '2', NULL),
(411, 2, 3, '5', NULL),
(412, 2, 3, '8', NULL),
(413, 2, 3, '10', NULL),
(414, 3, 3, '12', NULL),
(585, 1, 6, '2', NULL),
(586, 2, 6, '8', NULL),
(587, 2, 6, '10', NULL),
(588, 3, 6, '11', NULL),
(6185, 4, 7, 'A=3', NULL),
(6186, 4, 7, 'A=6', NULL),
(6187, 4, 7, 'B=1', NULL),
(6188, 4, 7, 'B=5', NULL),
(6189, 4, 7, 'C=4', NULL),
(6190, 4, 7, 'C=2', NULL),
(6191, 5, 7, '<p>Η γεωγραφία επηρεάζει τον τρόπο ζωής στα μέρη όπου ζούμε με πολλούς τρόπους. Ας εξετάσουμε μερικούς από αυτούς:</p>\n<ol>\n<li>\n<p><strong>Κλίμα και Φυσικό Περιβάλλον:</strong> Το κλίμα επηρεάζει τις δραστηριότητες και τον τρόπο ζωής. Για παράδειγμα, σε ζεστά κλίματα, οι άνθρωποι μπορεί να έχουν διαφορετικές συνήθειες και αγροτικές πρακτικές από εκείνους που ζουν σε ψυχρότερες περιοχές.</p>\n</li>\n<li>\n<p><strong>Τοπογραφία και Έδαφος:</strong> Η μορφολογία του εδάφους και η τοπογραφία επηρεάζουν τη γεωργία, την οικοδομή, και τη γενική οικονομική δραστηριότητα. Για παράδειγμα, σε ορεινές περιοχές, ο τρόπος ζωής μπορεί να είναι διαφορετικός από αυτόν σε πεδινές περιοχές.</p>\n</li>\n<li>\n<p><strong>Πόροι και Προσβασιμότητα:</strong> Οι διαθέσιμοι φυσικοί πόροι, όπως νερό και δάση, επηρεάζουν τις οικονομικές δραστηριότητες και τον τρόπο ζωής. Περιοχές με περιορισμένη πρόσβαση σε πόρους μπορεί να αναπτύσσουν διαφορετικές πρακτικές από περιοχές με άφθονους πόρους.</p>\n</li>\n<li>\n<p><strong>Συγκοινωνίες και Υποδομές:</strong> Η διαθεσιμότητα μεταφορικών μέσων επηρεάζει τον τρόπο ζωής, την απασχόληση και την κοινωνική δικτύωση. Περιοχές με καλές υποδομές μπορεί να έχουν διαφορετική δυναμική από αυτές που λείπουν από εξελιγμένες συγκοινωνίες.</p>\n</li>\n</ol>\n<p>Συνοπτικά, η γεωγραφία διαμορφώνει το περιβάλλον και τις προϋποθέσεις ζωής, επηρεάζοντας έτσι τον τρόπο ζωής στις διάφορες περιοχές του κόσμου.</p>', '3.00'),
(6192, 1, 7, '2', NULL),
(6193, 2, 7, '5', NULL),
(6194, 2, 7, '8', NULL),
(6195, 2, 7, '10', NULL),
(6196, 3, 7, '11', NULL),
(6396, 4, 9, 'A=3', NULL),
(6397, 4, 9, 'B=5', NULL),
(6398, 4, 9, 'C=2', NULL),
(6399, 4, 9, 'A=6', NULL),
(6400, 4, 9, 'B=1', NULL),
(6401, 4, 9, 'C=4', NULL),
(6402, 5, 9, '<p>Η γεωγραφία επηρεάζει τον τρόπο ζωής στα μέρη όπου ζούμε με πολλούς τρόπους. Τα γεωγραφικά χαρακτηριστικά, όπως η κλίμακαι η τοπογραφία, έχουν μεγάλη επίδραση στις δραστηριότητες και τις προτιμήσεις των κοινοτήτων.</p>\r\n<p>Το κλίμα, για παράδειγμα, επηρεάζει τον τρόπο ζωής μέσω των εποχικών αλλαγών και των αγροτικών δραστηριοτήτων. Σε ζεστά κλίματα, οι άνθρωποι μπορεί να έχουν διαφορετικές συνήθειες και δραστηριότητες από ό,τι σε ψυχρά κλίματα.</p>\r\n<p>Επίσης, η τοπογραφία, όπως τα βουνά και οι ποταμοί, επηρεάζει την οικοδομική δραστηριότητα και τις μετακινήσεις. Σε περιοχές με πολλά βουνά, οι μετακινήσεις μπορεί να είναι πιο περίπλοκες.</p>\r\n<p>Επιπλέον, η γεωγραφική τοποθεσία επηρεάζει τις πολιτιστικές πρακτικές και τις επικοινωνίες. Οι κοινότητες σε διάφορα μέρη του κόσμου έχουν διαφορετικές παραδόσεις και τρόπους ζωής λόγω της γεωγραφικής τους θέσης.</p>\r\n<p>Συνολικά, η γεωγραφία διαμορφώνει τον τρόπο ζωής μας, δημιουργώντας μια μοναδική ταυτότητα για κάθε περιοχή.</p>', NULL),
(6403, 1, 9, '1', NULL),
(6404, 2, 9, '5', NULL),
(6405, 2, 9, '8', NULL),
(6406, 2, 9, '10', NULL),
(6407, 3, 9, '12', NULL),
(6660, 4, 10, 'A=3', NULL),
(6661, 4, 10, 'A=5', NULL),
(6662, 4, 10, 'C=2', NULL),
(6663, 4, 10, 'C=4', NULL),
(6664, 4, 10, 'B=1', NULL),
(6665, 4, 10, 'B=6', NULL),
(6666, 5, 10, '<p>Η γεωγραφία επηρεάζει τον τρόπο ζωής στα μέρη όπου ζούμε με πολλούς τρόπους. Η κλιματολογία, η γεωλογία και η τοπογραφία μπορούν να διαμορφώσουν την οικολογία, τη γεωργία και την οικονομία μιας περιοχής.</p>\n<p>Για παράδειγμα, σε περιοχές με θερμό κλίμα, οι άνθρωποι πιθανόν να έχουν έναν τρόπο ζωής πιο εστιασμένο στις υπαίθριες δραστηριότητες και τη γεωργία. Αντίθετα, σε περιοχές με ψυχρό κλίμα, η οικονομία και ο τρόπος ζωής μπορεί να είναι πιο επικεντρωμένα στην βιομηχανία και την εκμετάλλευση των φυσικών πόρων.</p>\n<p>Επιπλέον, οι γεωγραφικές συνθήκες μπορεί να επηρεάσουν την πρόσβαση σε υπηρεσίες όπως εκπαίδευση, υγειονομική περίθαλψη και μεταφορές. Η πολιτιστική ποικιλομορφία μπορεί να επηρεάσει τις παραδόσεις, τα έθιμα και την κοινωνική δομή της περιοχής.</p>\n<p>Συνεπώς, η γεωγραφία διαδραματίζει σημαντικό ρόλο στον τρόπο ζωής των κοινοτήτων, διαμορφώνοντας την καθημερινότητα και τις ευκαιρίες των ανθρώπων.</p>', '3.00'),
(6667, 1, 10, '2', NULL),
(6668, 2, 10, '5', NULL),
(6669, 2, 10, '8', NULL),
(6670, 2, 10, '10', NULL),
(6671, 3, 10, '12', NULL),
(6745, 11, 11, 'A=1', NULL),
(6746, 11, 11, 'B=2', NULL),
(6747, 11, 11, 'C=3', NULL),
(6748, 11, 11, 'D=4', NULL),
(6749, 11, 11, 'E=6', NULL),
(6750, 11, 11, 'F=5', NULL),
(6751, 7, 11, '<p>Εδώ είναι η απάντηση μου για το ερωτημα αυτό</p>', '1.50'),
(6752, 8, 11, '24', NULL),
(6753, 9, 11, '28', NULL),
(6754, 9, 11, '29', NULL),
(6755, 10, 11, '31', NULL),
(6853, 11, 12, 'A=1', NULL),
(6854, 11, 12, 'B=2', NULL),
(6855, 11, 12, 'C=3', NULL),
(6856, 11, 12, 'D=4', NULL),
(6857, 11, 12, 'E=5', NULL),
(6858, 11, 12, 'F=6', NULL),
(6859, 7, 12, '<p>Εδω είναι μία απάντηση για το ερώτημα αυτό</p>', NULL),
(6860, 8, 12, '24', NULL),
(6861, 9, 12, '28', NULL),
(6862, 9, 12, '29', NULL),
(6863, 10, 12, '31', NULL),
(6926, 11, 13, 'A=1', NULL),
(6927, 11, 13, 'B=2', NULL),
(6928, 11, 13, 'C=3', NULL),
(6929, 11, 13, 'D=4', NULL),
(6930, 11, 13, 'E=6', NULL),
(6931, 11, 13, 'F=5', NULL),
(6932, 7, 13, '<p>Εδώ είναι μία απάντηση</p>', '1.50'),
(6933, 8, 13, '24', NULL),
(6934, 9, 13, '29', NULL),
(6935, 9, 13, '30', NULL),
(6936, 10, 13, '31', NULL),
(9541, 11, 14, 'A=1', NULL),
(9542, 11, 14, 'B=2', NULL),
(9543, 11, 14, 'C=4', NULL),
(9544, 11, 14, 'D=3', NULL),
(9545, 11, 14, 'E=5', NULL),
(9546, 11, 14, 'F=6', NULL),
(9547, 7, 14, '<p>Εδώ είναι μία απάντηση</p>', NULL),
(9548, 8, 14, '24', NULL),
(9549, 9, 14, '28', NULL),
(9550, 9, 14, '29', NULL),
(9551, 10, 14, '31', NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `aq_id` bigint(20) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maxgrade` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `aq_id`, `text`, `type`, `maxgrade`) VALUES
(1, 1, '<p>Ποια είναι η πρωτεύουσα της Γαλλίας;</p>', 'Μίας Επιλογής', '1.50'),
(2, 1, '<p>Ποια από τις παρακάτω χώρες βρίσκονται στην Ευρωπαϊκή Ένωση;</p>', 'Πολλαπλής Επιλογής', '3.00'),
(3, 1, '<p>Ο πύργος του Άιφελ βρήσκεται στην Ρώμη της Ιταλίας</p>', 'Ναι/Όχι', '1.00'),
(4, 1, '<p>Αντιστοιχίστε πόλης με τις χώρες τους:</p>\r\n<p> </p>\r\n<table border=\"1\" width=\"100%\"><colgroup><col style=\"width: 50%;\"><col style=\"width: 50%;\"></colgroup>\r\n<thead>\r\n<tr>\r\n<td style=\"text-align: center;\">ΛΙΣΤΑ 1</td>\r\n<td style=\"text-align: center;\">ΛΙΣΤΑ 2</td>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>A. Ελλάδα</td>\r\n<td>1.  Ρώμη</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 50%;\">B. Ιταλία</td>\r\n<td style=\"width: 50%;\">2. Μασσαλία</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 50%;\">C. Γαλλία</td>\r\n<td style=\"width: 50%;\">3. Θεσσαλονίκη</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 50%;\"> </td>\r\n<td style=\"width: 50%;\">4. Νίκαια</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 50%;\"> </td>\r\n<td style=\"width: 50%;\">5. Μιλάνο</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 50%;\"> </td>\r\n<td style=\"width: 50%;\">6. Ηράκλειο</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'Αντιστοίχιση', '1.50'),
(5, 1, '<p>Πώς η γεωγραφία επηρεάζει τον τρόπο ζωής στα μέρη όπου ζούμε;</p>', 'Ελεύθερου Κειμένου', '3.00'),
(7, 4, '<p>Εδώ είναι μία ερώτηση Ελευθέρου κειμένου </p>', 'Ελεύθερου Κειμένου', '2.00'),
(8, 4, '<p>Εδώ είναι μία ερώτηση μίας επιλογής</p>', 'Μίας Επιλογής', '1.00'),
(9, 4, '<p>Εδώ είναι μία ερώτηση πολλαπλής επιλογής</p>', 'Πολλαπλής Επιλογής', '2.00'),
(10, 4, '<p>Εδώ είναι μία ερωτηση ναι/οχι</p>', 'Ναι/Όχι', '2.00'),
(11, 4, '<p>Εδώ είναι μία ερώτηση Αντιστοίχησης</p>\r\n<p> </p>\r\n<table border=\"1\" width=\"100%\"><colgroup><col style=\"width: 50%;\"><col style=\"width: 50%;\"></colgroup>\r\n<thead>\r\n<tr>\r\n<td style=\"text-align: center;\">ΛΙΣΤΑ 1</td>\r\n<td style=\"text-align: center;\">ΛΙΣΤΑ 2</td>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>A. Στοιχείο Α</td>\r\n<td>1. Στοιχείο 1</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 50%;\">B. Στοιχείο B</td>\r\n<td style=\"width: 50%;\">2. Στοιχείο 2</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 50%;\">C. Στοιχείο C</td>\r\n<td style=\"width: 50%;\">3. Στοιχείο 3</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 50%;\">D.Στοιχείο D</td>\r\n<td style=\"width: 50%;\">4. Στοιχείο 4</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 50%;\">E. Στοιχείο E</td>\r\n<td style=\"width: 50%;\">5. Στοιχείο 5</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 50%;\">F. Στοιχείο F</td>\r\n<td style=\"width: 50%;\">6. Στοιχείο 6</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'Αντιστοίχιση', '3.00');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `quiz_tries`
--

CREATE TABLE `quiz_tries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `aq_id` bigint(20) UNSIGNED NOT NULL,
  `am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `finalscore` decimal(4,2) DEFAULT NULL,
  `delivered` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `quiz_tries`
--

INSERT INTO `quiz_tries` (`id`, `aq_id`, `am`, `finalscore`, `delivered`) VALUES
(1, 1, 'icsd15087', '7.00', 1),
(2, 1, 'icsd18067', NULL, 1),
(3, 1, 'icsd18067', NULL, 0),
(6, 1, 'icsd22115', '3.50', 1),
(7, 1, 'icsd22115', '9.00', 0),
(9, 1, 'icsd19157', NULL, 1),
(10, 1, 'icsd17015', '9.50', 1),
(11, 4, 'icsd15087', '8.50', 1),
(12, 4, 'icsd15087', NULL, 0),
(13, 4, 'icsd17015', '7.50', 0),
(14, 4, 'icsd19157', NULL, 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `reject_team`
--

CREATE TABLE `reject_team` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `at_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `reject_team`
--

INSERT INTO `reject_team` (`id`, `am`, `at_id`, `receiver_am`, `confirm`) VALUES
(1, 'icsd18067', 3, 'icsd17015', 2),
(2, 'icsd19157', 3, 'icsd15087', 2);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `slots`
--

CREATE TABLE `slots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `as_id` bigint(20) UNSIGNED NOT NULL,
  `slot_time` timestamp NULL DEFAULT NULL,
  `am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `slots`
--

INSERT INTO `slots` (`id`, `as_id`, `slot_time`, `am`) VALUES
(11, 3, '2024-02-05 23:00:00', ' '),
(12, 3, '2024-02-05 23:30:00', ' '),
(13, 3, '2024-02-06 00:00:00', ' '),
(14, 3, '2024-02-06 00:30:00', ' '),
(15, 3, '2024-02-06 01:00:00', ' '),
(53, 1, '2024-02-06 12:00:00', 'icsd19157'),
(54, 1, '2024-02-06 12:30:00', 'icsd22115'),
(55, 1, '2024-02-06 13:00:00', 'icsd15087'),
(56, 1, '2024-02-06 13:30:00', ' '),
(57, 1, '2024-02-06 14:00:00', ' '),
(58, 1, '2024-02-05 12:30:00', 'icsd18067'),
(59, 1, '2024-02-05 13:00:00', ' '),
(60, 1, '2024-02-05 13:30:00', ' '),
(61, 1, '2024-02-05 14:00:00', ' '),
(62, 1, '2024-02-05 14:30:00', ' '),
(63, 3, '2024-02-12 11:00:00', ' '),
(64, 3, '2024-02-12 11:30:00', ' '),
(65, 3, '2024-02-12 12:00:00', ' '),
(66, 3, '2024-02-12 12:30:00', 'icsd15087'),
(67, 3, '2024-02-12 13:00:00', ' '),
(68, 3, '2024-02-12 13:30:00', ' ');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `slot_notification`
--

CREATE TABLE `slot_notification` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slot_id` bigint(20) UNSIGNED NOT NULL,
  `msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `slot_notification`
--

INSERT INTO `slot_notification` (`id`, `slot_id`, `msg`, `receiver_am`) VALUES
(7, 11, ' αποδεσμεύτηκε', 'icsd17015'),
(14, 58, ' αποδεσμεύτηκε', 'icsd17015'),
(15, 60, ' αποδεσμεύτηκε', 'icsd18067'),
(16, 53, '', 'icsd19157'),
(17, 55, '', 'icsd15087'),
(18, 54, '', 'icsd22115'),
(20, 58, '', 'icsd18067'),
(21, 63, ' αποδεσμεύτηκε', 'icsd15087'),
(22, 66, '', 'icsd15087');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `at_id` bigint(20) UNSIGNED NOT NULL,
  `t_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `teams`
--

INSERT INTO `teams` (`id`, `am`, `at_id`, `t_id`, `confirm`) VALUES
(1, 'icsd15087', 1, 'icsd15087', 1),
(2, 'icsd15087', 2, 'icsd15087', 1),
(3, 'icsd18067', 1, 'icsd15087', 1),
(4, 'icsd22115', 1, 'icsd22115', 1),
(5, 'icsd19157', 1, 'icsd22115', 1),
(6, 'icsd17015', 1, 'icsd17015', 1),
(7, 'icsd19157', 2, 'icsd15087', 1),
(8, 'icsd22115', 2, 'icsd22115', 1),
(9, 'icsd18067', 2, 'icsd18067', 1),
(10, 'icsd17015', 2, 'icsd18067', 1),
(12, 'icsd17015', 3, 'icsd17015', 1),
(15, 'icsd18067', 3, 'icsd17015', 1),
(16, 'icsd15087', 3, 'icsd15087', 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ct_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `excusive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `themes`
--

INSERT INTO `themes` (`id`, `ct_id`, `title`, `text`, `file`, `excusive`) VALUES
(1, 1, '1ο Θέμα', '<p>Εδώ είναι μία περιγραφή του θέματος ή κάποιες παραπάνω λεπτομέρειες και ζητούμενα όπου ο φοιτητής μπορεί να δει. Αυτό το θέμα είναι αποκλειστικό.</p>\r\n<p>Δεν εμπεριέχει αρχείο</p>', ' ', 1),
(2, 1, '2ο Θέμα', '<p>Εδώ είναι μία περιγραφή του θέματος ή κάποιες παραπάνω λεπτομέρειες και ζητούμενα όπου ο φοιτητής μπορεί να δει. Αυτό το θέμα είναι δεν αποκλειστικό.</p>\r\n<p>Δεν εμπεριέχει αρχείο</p>', ' ', 0),
(3, 1, '3ο θέμα', '<p>Εδώ είναι μία περιγραφή του θέματος ή κάποιες παραπάνω λεπτομέρειες και ζητούμενα όπου ο φοιτητής μπορεί να δει. Αυτό το θέμα είναι αποκλειστικό.</p>\r\n<p>Εμπεριέχει αρχείο.</p>', '1704644844_Επιλογή θέματος.txt', 1),
(4, 1, '4ο Θέμα', '<p>Εδώ είναι μία περιγραφή του θέματος ή κάποιες παραπάνω λεπτομέρειες και ζητούμενα όπου ο φοιτητής μπορεί να δει. Αυτό το θέμα είναι μη αποκλειστικό.</p>\r\n<p>Εμπεριέχει αρχείο.</p>', '1704644882_Επιλογή θέματος.txt', 0),
(5, 2, '1ο Θέμα', '<p>Εδώ είναι μία περιγραφή του θέματος ή κάποιες παραπάνω λεπτομέρειες και ζητούμενα όπου ο φοιτητής μπορεί να δει. Αυτό το θέμα είναι αποκλειστικό.</p>\r\n<p>Δεν εμπεριέχει αρχείο</p>', ' ', 1),
(6, 2, '2ο Θέμα', '<p>Εδώ είναι μία περιγραφή του θέματος ή κάποιες παραπάνω λεπτομέρειες και ζητούμενα όπου ο φοιτητής μπορεί να δει. Αυτό το θέμα είναι αποκλειστικό.</p>\r\n<p>Εμπεριέχει αρχείο</p>', '1704647472_Επιλογή θέματος.txt', 1),
(7, 2, '3ο Θέμα', '<p>Εδώ είναι μία περιγραφή του θέματος ή κάποιες παραπάνω λεπτομέρειες και ζητούμενα όπου ο φοιτητής μπορεί να δει. Αυτό το θέμα είναι μη αποκλειστικό.</p>\r\n<p>Δεν εμπεριέχει αρχείο</p>', ' ', 0),
(8, 2, '4ο Θέμα', '<p>Εδώ είναι μία περιγραφή του θέματος ή κάποιες παραπάνω λεπτομέρειες και ζητούμενα όπου ο φοιτητής μπορεί να δει. Αυτό το θέμα είναι μη αποκλειστικό.</p>\r\n<p>Εμπεριέχει αρχείο</p>', '1704647523_Επιλογή θέματος.txt', 0),
(9, 3, 'Θέμα 1ο', '<p>Εδώ έχει κάποια περιγραφή θέματος.  Είναι αποκλειστικό θέμα και δεν περιέχει επισυναπτόμενο αρχείο.</p>', ' ', 1),
(10, 3, 'Θέμα 2ο', '<p>Εδώ υπάρχει κάποια περιγραφή του θέματος. Αυτό το θέμα δεν είναι αποκλειστικό και περιέχει αρχείο περιγραφής.</p>', '1707090433_Επιλογή θέματος.txt', 0),
(14, 4, '1ο θέμα', '<p>Εδώ είναι μια περιγραφή του θέματος. Είναι αποκλειστικό θέμα χωρις αρχείο.</p>', ' ', 1),
(15, 4, '2ο θέμα', '<p>Εδώ είναι μια περιγραφή του θέματος. Είναι μη αποκλειστικό θέμα χωρίς αρχείο.</p>', ' ', 0),
(16, 4, '3ο θέμα', '<p>Εδώ είναι μια περιγραφή του θέματος. Είναι αποκλειστικό θέμα με αρχείο.</p>', '1707751591_Επιλογή θέματος.txt', 1),
(17, 4, '4ο Θέμα', '<p>Εδώ είναι μια περιγραφή του θέματος. Είναι μη αποκλειστικό θέμα χωρις αρχείο.</p>', '1707751623_Επιλογή θέματος.txt', 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `themes_choises`
--

CREATE TABLE `themes_choises` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `th_id` bigint(20) UNSIGNED NOT NULL,
  `am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ct_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `themes_choises`
--

INSERT INTO `themes_choises` (`id`, `th_id`, `am`, `ct_id`) VALUES
(1, 1, 'icsd15087', 1),
(2, 2, 'icsd17015', 1),
(3, 2, 'icsd22115', 1),
(4, 5, 'icsd22115', 2),
(5, 6, 'icsd19157', 2),
(6, 7, 'icsd17015', 2),
(7, 7, 'icsd15087', 2),
(8, 8, 'icsd18067', 2),
(9, 9, 'icsd15087', 3),
(10, 10, 'icsd19157', 3),
(11, 10, 'icsd18067', 3),
(12, 14, 'icsd17015', 4),
(16, 16, 'icsd15087', 4);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `am` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `register_year` year(4) DEFAULT NULL,
  `system_status` tinyint(1) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `am`, `type`, `qualification`, `register_year`, `system_status`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `image`) VALUES
(1, 'Maria Papadaki', 'Aoicsd00025@icsd.aegean.gr', 'Διαχειριστής', 'Aoicsd00025', NULL, NULL, 2000, 1, NULL, NULL, '2023-02-05 03:22:37', '2023-02-05 03:22:37', '1704408311_8caf05fdf41402a4f850de4b57ecdb18.jpg'),
(9, 'DESPOINA ZOGRAFIDOU', 'icsd16041@icsd.aegean.gr', 'Καθηγητής', 'icsd16041', 'Μέλος ΔΕΠ', 'Επίκουρος', 2016, 1, NULL, NULL, '2024-01-04 07:39:54', '2024-01-04 07:39:54', '1704408731_b6d0efcf3f5e76a6fb763f8d42bb4dd7.jpg'),
(10, 'ANTONIS PITTAS', 'icsd17015@icsd.aegean.gr', 'Μαθητής', 'icsd17015', 'Μεταπτυχιακό', NULL, 2023, 1, NULL, NULL, '2024-01-04 07:46:24', '2024-01-04 07:46:24', '1704408683_ahcwf0.jpg'),
(11, 'AVRAAM KATSIGRAS', 'icsd15087@icsd.aegean.gr', 'Μαθητής', 'icsd15087', 'Προπτυχιακό', NULL, 2015, 1, NULL, NULL, '2024-01-04 07:49:48', '2024-01-04 07:49:48', '1704408702_scenery-artist-artwork-digital-art-wallpaper-thumb.jpg'),
(12, 'KOSTAS TSIFOUTIS', 'icsd16042@icsd.aegean.gr', 'Καθηγητής', 'icsd16042', 'Μέλος ΕΔΙΠ', 'Καθηγητής', 2016, 1, NULL, NULL, '2024-01-04 07:54:14', '2024-01-04 07:54:14', '1704408721_images.jpg'),
(13, 'Anastasia Spinou', 'icsd18067@icsd.aegean.gr', 'Μαθητής', 'icsd18067', 'Προπτυχιακό', NULL, 2018, 1, NULL, NULL, '2024-01-04 17:29:10', '2024-01-04 17:29:10', '1704408671_360_F_342699191_tfReqT0EEUj93OsOJpbIkJJMcVDItPfd.jpg'),
(14, 'Maria Kostova', 'icsd22115@icsd.aegean.gr', 'Μαθητής', 'icsd22115', 'Προπτυχιακό', NULL, 2022, 0, NULL, NULL, '2024-01-04 19:57:01', '2024-01-04 19:57:01', '1704405723_HD-wallpaper-night-time-minimal-minimalism-minimalist-artist-artwork-digital-art-deviantart.jpg'),
(15, 'Georgios Kalliopitsas', 'icsd19157@icsd.aegean.gr', 'Μαθητής', 'icsd19157', 'Προπτυχιακό', NULL, 2019, 1, NULL, NULL, '2024-01-04 19:58:14', '2024-01-04 19:58:14', '1704405679_54ba1aebeb5c5c92105f430009db074c.jpg'),
(16, 'Anastasia Douma', 'icsd10150@icsd.aegean.gr', 'Καθηγητής', 'icsd10150', 'Ερευνητής', 'Αναπληρωτής', 2010, 1, NULL, NULL, '2024-01-04 20:03:41', '2024-01-04 20:03:41', '1704405880_landscape_photography_tips_featured_image_1024x1024.webp');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `voting`
--

CREATE TABLE `voting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `a_id` bigint(20) UNSIGNED NOT NULL,
  `am` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `voting`
--

INSERT INTO `voting` (`id`, `a_id`, `am`, `q_id`) VALUES
(1, 4, 'icsd22115', 1),
(2, 9, 'icsd22115', 2),
(3, 14, 'icsd22115', 3),
(4, 18, 'icsd22115', 5),
(5, 19, 'icsd22115', 5),
(6, 3, 'icsd19157', 1),
(7, 9, 'icsd19157', 2),
(8, 13, 'icsd19157', 3),
(9, 17, 'icsd19157', 5),
(10, 18, 'icsd19157', 5),
(11, 19, 'icsd19157', 5),
(12, 4, 'icsd18067', 1),
(13, 10, 'icsd18067', 2),
(14, 15, 'icsd18067', 3),
(15, 16, 'icsd18067', 5),
(16, 3, 'icsd15087', 1),
(17, 10, 'icsd15087', 2),
(18, 15, 'icsd15087', 3),
(19, 19, 'icsd15087', 5),
(20, 4, 'icsd17015', 1),
(21, 9, 'icsd17015', 2),
(22, 14, 'icsd17015', 3),
(23, 19, 'icsd17015', 5),
(24, 29, 'icsd16042', 6),
(25, 31, 'icsd16042', 7),
(26, 28, 'icsd15087', 6),
(27, 30, 'icsd15087', 7),
(28, 28, 'icsd17015', 6),
(29, 30, 'icsd17015', 7);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `activity_choose_theme`
--
ALTER TABLE `activity_choose_theme`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_choose_theme_l_id_foreign` (`l_id`);

--
-- Ευρετήρια για πίνακα `activity_determinate_themes`
--
ALTER TABLE `activity_determinate_themes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_determinate_themes_l_id_foreign` (`l_id`);

--
-- Ευρετήρια για πίνακα `activity_quiz`
--
ALTER TABLE `activity_quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_quiz_l_id_foreign` (`l_id`);

--
-- Ευρετήρια για πίνακα `activity_slot`
--
ALTER TABLE `activity_slot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_slot_l_id_foreign` (`l_id`);

--
-- Ευρετήρια για πίνακα `activity_team`
--
ALTER TABLE `activity_team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_team_l_id_foreign` (`l_id`);

--
-- Ευρετήρια για πίνακα `activity_voting`
--
ALTER TABLE `activity_voting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_voting_l_id_foreign` (`l_id`);

--
-- Ευρετήρια για πίνακα `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_q_id_foreign` (`q_id`);

--
-- Ευρετήρια για πίνακα `choose_themes_notifications`
--
ALTER TABLE `choose_themes_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `choose_themes_notifications_th_id_foreign` (`th_id`);

--
-- Ευρετήρια για πίνακα `determinate_themes`
--
ALTER TABLE `determinate_themes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `determinate_themes_adt_id_foreign` (`adt_id`),
  ADD KEY `determinate_themes_j_id_foreign` (`j_id`);

--
-- Ευρετήρια για πίνακα `determinate_themes_notifications`
--
ALTER TABLE `determinate_themes_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `determinate_themes_notifications_dt_id_foreign` (`dt_id`);

--
-- Ευρετήρια για πίνακα `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Ευρετήρια για πίνακα `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journals_adt_id_foreign` (`adt_id`);

--
-- Ευρετήρια για πίνακα `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`l_id`),
  ADD KEY `lessons_t_id_foreign` (`t_id`);

--
-- Ευρετήρια για πίνακα `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_l_id_foreign` (`l_id`);

--
-- Ευρετήρια για πίνακα `participations`
--
ALTER TABLE `participations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participations_l_id_foreign` (`l_id`),
  ADD KEY `participations_am_foreign` (`am`);

--
-- Ευρετήρια για πίνακα `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Ευρετήρια για πίνακα `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_av_id_foreign` (`av_id`);

--
-- Ευρετήρια για πίνακα `quiz_answers`
--
ALTER TABLE `quiz_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_answers_qq_id_foreign` (`qq_id`);

--
-- Ευρετήρια για πίνακα `quiz_choices`
--
ALTER TABLE `quiz_choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_choices_qq_id_foreign` (`qq_id`),
  ADD KEY `quiz_choices_t_id_foreign` (`t_id`);

--
-- Ευρετήρια για πίνακα `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_questions_aq_id_foreign` (`aq_id`);

--
-- Ευρετήρια για πίνακα `quiz_tries`
--
ALTER TABLE `quiz_tries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_tries_aq_id_foreign` (`aq_id`);

--
-- Ευρετήρια για πίνακα `reject_team`
--
ALTER TABLE `reject_team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reject_team_at_id_foreign` (`at_id`);

--
-- Ευρετήρια για πίνακα `slots`
--
ALTER TABLE `slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slots_as_id_foreign` (`as_id`);

--
-- Ευρετήρια για πίνακα `slot_notification`
--
ALTER TABLE `slot_notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slot_notification_slot_id_foreign` (`slot_id`);

--
-- Ευρετήρια για πίνακα `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_at_id_foreign` (`at_id`);

--
-- Ευρετήρια για πίνακα `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `themes_ct_id_foreign` (`ct_id`);

--
-- Ευρετήρια για πίνακα `themes_choises`
--
ALTER TABLE `themes_choises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `themes_choises_th_id_foreign` (`th_id`),
  ADD KEY `themes_choises_ct_id_foreign` (`ct_id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_am_unique` (`am`);

--
-- Ευρετήρια για πίνακα `voting`
--
ALTER TABLE `voting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voting_a_id_foreign` (`a_id`),
  ADD KEY `voting_q_id_foreign` (`q_id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `activity_choose_theme`
--
ALTER TABLE `activity_choose_theme`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT για πίνακα `activity_determinate_themes`
--
ALTER TABLE `activity_determinate_themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT για πίνακα `activity_quiz`
--
ALTER TABLE `activity_quiz`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT για πίνακα `activity_slot`
--
ALTER TABLE `activity_slot`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT για πίνακα `activity_team`
--
ALTER TABLE `activity_team`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT για πίνακα `activity_voting`
--
ALTER TABLE `activity_voting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT για πίνακα `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT για πίνακα `choose_themes_notifications`
--
ALTER TABLE `choose_themes_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT για πίνακα `determinate_themes`
--
ALTER TABLE `determinate_themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT για πίνακα `determinate_themes_notifications`
--
ALTER TABLE `determinate_themes_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT για πίνακα `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `journals`
--
ALTER TABLE `journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT για πίνακα `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT για πίνακα `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT για πίνακα `participations`
--
ALTER TABLE `participations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT για πίνακα `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT για πίνακα `quiz_answers`
--
ALTER TABLE `quiz_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT για πίνακα `quiz_choices`
--
ALTER TABLE `quiz_choices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9552;

--
-- AUTO_INCREMENT για πίνακα `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT για πίνακα `quiz_tries`
--
ALTER TABLE `quiz_tries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT για πίνακα `reject_team`
--
ALTER TABLE `reject_team`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT για πίνακα `slots`
--
ALTER TABLE `slots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT για πίνακα `slot_notification`
--
ALTER TABLE `slot_notification`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT για πίνακα `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT για πίνακα `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT για πίνακα `themes_choises`
--
ALTER TABLE `themes_choises`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT για πίνακα `voting`
--
ALTER TABLE `voting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `activity_choose_theme`
--
ALTER TABLE `activity_choose_theme`
  ADD CONSTRAINT `activity_choose_theme_l_id_foreign` FOREIGN KEY (`l_id`) REFERENCES `lessons` (`l_id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `activity_determinate_themes`
--
ALTER TABLE `activity_determinate_themes`
  ADD CONSTRAINT `activity_determinate_themes_l_id_foreign` FOREIGN KEY (`l_id`) REFERENCES `lessons` (`l_id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `activity_quiz`
--
ALTER TABLE `activity_quiz`
  ADD CONSTRAINT `activity_quiz_l_id_foreign` FOREIGN KEY (`l_id`) REFERENCES `lessons` (`l_id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `activity_slot`
--
ALTER TABLE `activity_slot`
  ADD CONSTRAINT `activity_slot_l_id_foreign` FOREIGN KEY (`l_id`) REFERENCES `lessons` (`l_id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `activity_team`
--
ALTER TABLE `activity_team`
  ADD CONSTRAINT `activity_team_l_id_foreign` FOREIGN KEY (`l_id`) REFERENCES `lessons` (`l_id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `activity_voting`
--
ALTER TABLE `activity_voting`
  ADD CONSTRAINT `activity_voting_l_id_foreign` FOREIGN KEY (`l_id`) REFERENCES `lessons` (`l_id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_q_id_foreign` FOREIGN KEY (`q_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `choose_themes_notifications`
--
ALTER TABLE `choose_themes_notifications`
  ADD CONSTRAINT `choose_themes_notifications_th_id_foreign` FOREIGN KEY (`th_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `determinate_themes`
--
ALTER TABLE `determinate_themes`
  ADD CONSTRAINT `determinate_themes_adt_id_foreign` FOREIGN KEY (`adt_id`) REFERENCES `activity_determinate_themes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `determinate_themes_j_id_foreign` FOREIGN KEY (`j_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `determinate_themes_notifications`
--
ALTER TABLE `determinate_themes_notifications`
  ADD CONSTRAINT `determinate_themes_notifications_dt_id_foreign` FOREIGN KEY (`dt_id`) REFERENCES `determinate_themes` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `journals`
--
ALTER TABLE `journals`
  ADD CONSTRAINT `journals_adt_id_foreign` FOREIGN KEY (`adt_id`) REFERENCES `activity_determinate_themes` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_t_id_foreign` FOREIGN KEY (`t_id`) REFERENCES `users` (`id`);

--
-- Περιορισμοί για πίνακα `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_l_id_foreign` FOREIGN KEY (`l_id`) REFERENCES `lessons` (`l_id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `participations`
--
ALTER TABLE `participations`
  ADD CONSTRAINT `participations_am_foreign` FOREIGN KEY (`am`) REFERENCES `users` (`am`) ON DELETE CASCADE,
  ADD CONSTRAINT `participations_l_id_foreign` FOREIGN KEY (`l_id`) REFERENCES `lessons` (`l_id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_av_id_foreign` FOREIGN KEY (`av_id`) REFERENCES `activity_voting` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `quiz_answers`
--
ALTER TABLE `quiz_answers`
  ADD CONSTRAINT `quiz_answers_qq_id_foreign` FOREIGN KEY (`qq_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `quiz_choices`
--
ALTER TABLE `quiz_choices`
  ADD CONSTRAINT `quiz_choices_qq_id_foreign` FOREIGN KEY (`qq_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_choices_t_id_foreign` FOREIGN KEY (`t_id`) REFERENCES `quiz_tries` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_aq_id_foreign` FOREIGN KEY (`aq_id`) REFERENCES `activity_quiz` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `quiz_tries`
--
ALTER TABLE `quiz_tries`
  ADD CONSTRAINT `quiz_tries_aq_id_foreign` FOREIGN KEY (`aq_id`) REFERENCES `activity_quiz` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `reject_team`
--
ALTER TABLE `reject_team`
  ADD CONSTRAINT `reject_team_at_id_foreign` FOREIGN KEY (`at_id`) REFERENCES `activity_team` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `slots`
--
ALTER TABLE `slots`
  ADD CONSTRAINT `slots_as_id_foreign` FOREIGN KEY (`as_id`) REFERENCES `activity_slot` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `slot_notification`
--
ALTER TABLE `slot_notification`
  ADD CONSTRAINT `slot_notification_slot_id_foreign` FOREIGN KEY (`slot_id`) REFERENCES `slots` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_at_id_foreign` FOREIGN KEY (`at_id`) REFERENCES `activity_team` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `themes`
--
ALTER TABLE `themes`
  ADD CONSTRAINT `themes_ct_id_foreign` FOREIGN KEY (`ct_id`) REFERENCES `activity_choose_theme` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `themes_choises`
--
ALTER TABLE `themes_choises`
  ADD CONSTRAINT `themes_choises_ct_id_foreign` FOREIGN KEY (`ct_id`) REFERENCES `activity_choose_theme` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `themes_choises_th_id_foreign` FOREIGN KEY (`th_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `voting`
--
ALTER TABLE `voting`
  ADD CONSTRAINT `voting_a_id_foreign` FOREIGN KEY (`a_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `voting_q_id_foreign` FOREIGN KEY (`q_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
