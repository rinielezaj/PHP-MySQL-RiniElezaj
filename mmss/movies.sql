CREATE TABLE `users` (
`id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
`emri` varchar(255) not null,
`username` varchar(255) not null,
`email` varchar(255) not null,
`password` varchar(255) not null,
`confirm_password` varchar(255) not null,
`is_admin` varchar(255) not null
);

CREATE TABLE `movies` (
`id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
`mobvie_name` varchar(255) not null,
`movie_desc` varchar(255) not null,
`movie_quality` varchar(255) not null,
`movie_ratoing` varchar(255) not null,
`confirm_password` varchar(255) not null

    
);

CREATE TABLE `booking` (
`id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
`user_id` varchar(255) not null,
`movie_id` varchar(255) not null,
`nr_tickets` varchar(255) not null,
`date` varchar(255) not null,
`time` varchar(255) not null
    
);