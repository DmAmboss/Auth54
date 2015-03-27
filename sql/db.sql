--
-- Database: `auth54`
--
CREATE DATABASE IF NOT EXISTS `auth54` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `auth54`;

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8_bin NOT NULL,
  `email` varchar(45) COLLATE utf8_bin NOT NULL,
  `md5_pass` varchar(64) COLLATE utf8_bin NOT NULL,
  `md5` varchar(45) COLLATE utf8_bin NOT NULL,
  `god_mode` int(1) NOT NULL,
  `last_visit` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

INSERT INTO `users` (`id`, `username`, `email`, `md5_pass`, `md5`, `god_mode`, `last_visit`, `created`) VALUES
(1, 'Demo', 'demo@example.com', '783f2173123855ae653a78e12d923130', '7792146b1348bb52a200053661189521', 0, '2015-03-15 00:00:00', '2015-03-15 00:00:00'),
(2, 'Admin', 'admin@example.com', 'cd21670f72aa24e7c4527d039bb94b6c', '52fabdf5f53d8f7400e0bd34db791132', 1, '2015-03-15 00:00:00', '2015-07-15 00:00:00');