
CREATE TABLE IF NOT EXISTS `treeview` (
`id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `text` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `parent_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `treeview` (`id`, `name`, `text`, `link`, `parent_id`) VALUES
(1, 'MySQL', 'MySQL', '#', '0'),
(2, 'Java', 'Java', '#', '0'),
(3, 'PHP', 'PHP', '#', '0'),
(4, 'PHP Tutorial', 'Tutorial', '#', '3'),
(5, 'PHP Script', 'Script', '#', '3'),
(6, 'Email', 'Email', '#', '5'),
(7, 'Java Tutorial', 'Tutorial','#', '2'),
(8, 'Java Resources', 'Resources', '#', '2'),
(9, 'MySQL Tutorial', 'Tutorial', '#', '1'),
(10, 'Login', 'Login', '#', '5'),
(11, 'PHP Resources', 'Resources', '#', '3');

