CREATE TABLE mc_groups
( id integer NOT NULL AUTO_INCREMENT,
  grname varchar(120) NOT NULL,
  PRIMARY KEY (id )
) DEFAULT CHARSET=utf8 ;

CREATE TABLE mc_users
( id integer NOT NULL AUTO_INCREMENT,
  name varchar(120) NOT NULL,
  lastname varchar(220) NOT NULL,
  firstname varchar(220) NOT NULL,
  email varchar(220),
  phone varchar(16),
  pass varchar(64),
  PRIMARY KEY (id )
) DEFAULT CHARSET=utf8;

CREATE TABLE mc_usergroups
( user_id integer NOT NULL AUTO_INCREMENT,
  group_id integer NOT NULL,
  PRIMARY KEY (user_id , group_id ),
  FOREIGN KEY (user_id) references mc_users(id) on update cascade,
  FOREIGN KEY (group_id) references mc_groups(id) on update cascade
) DEFAULT CHARSET=utf8;

CREATE TABLE mc_sessions
( id integer NOT NULL AUTO_INCREMENT,
  user_id integer NOT NULL,
  session varchar(50) NOT NULL,
  ttl bigint,
  PRIMARY KEY (id ),
  FOREIGN KEY (user_id) references mc_users(id) on delete cascade on update cascade
) DEFAULT CHARSET=utf8;

insert into mc_groups values (1,'admin'),(2,'user'),(3,'editor');
insert into mc_users values (1,'admin','','Administrator','','','21232f297a57a5a743894a0e4a801fc3');
insert into mc_usergroups values (1,1);

-- signup -------------------------------
CREATE TABLE signup
(  id integer NOT NULL AUTO_INCREMENT,
   created timestamp not null,
   email varchar(255) not null,
   unique(email),
   PRIMARY KEY (id )
) DEFAULT CHARSET=utf8;


-- templates ----------------------------

CREATE TABLE templates
(  name varchar(50) not null,
   created timestamp not null,
   updated timestamp,
   usersubj varchar(255) not null,
   userbody text not null,
   adminsubj varchar(255) not null,
   adminbody text not null,
   autorespsubj varchar(255) not null,
   autorespbody text not null,
   PRIMARY KEY (name)
) DEFAULT CHARSET=utf8;

INSERT INTO templates VALUES ('evnamegl','2016-10-05 13:05:36','2016-10-04 11:31:56', 'Event Name Guest List Confirmation','Voluptua molestiae complectitur mea an, semper\ndignissim his eu. Ei nec adhuc nusquam salutandi, scripta\nvulputate qui ut.\nCompany Name\nVisit: www.companywebsite.com\nEmail: companynewsletter@companybrand.com\nFollow @companyname on Facebook | Instagram | Twitter','Event Name Guest List Submission','GUESTLIST\n========\nEmail Address\nFirst Name: $firstname\nLast Name: $lastname\nConfirm Email Address: $confirm_email\nEmail Address: $email\n\nGUESTS\n======\n$guests\n','Form Submission Message','Lorem ipsum dolor sit amet, consectetur adipisicing elit,\nsed do eiusmod tempor incididunt ut labore et dolore\nmagna aliqua.'),('signup','2016-10-04 11:52:33','2016-10-04 11:31:56','Email Newsletter Submission','Thank you for subscribing to our\n        e-newsletter. You\\\'ll periodically update of upcoming\n        events.<br>\n        Company Name<br>\n        Visit: www.companywebsite.com<br>\n        Email: companynewsletter@companybrand.com<br>\n        Follow @companyname on Facebook | Instagram | Twitter','Administrator Email Newsletter Submission','e-mail: $email','Thank You','Thank you for subscribing to our\n        e-newsletter. You\\\'ll periodically update of upcoming\n        events.<br>\n'),('vipreserv','2016-10-06 11:55:32','2016-10-04 11:31:56','VIP Reservation Email Confirmation','Voluptua molestiae complectitur mea an, semper\ndignissim his eu. Ei nec adhuc nusquam salutandi, scripta\nvulputate qui ut.\nCompany Name\nVisit: www.companywebsite.com\nEmail: companynewsletter@companybrand.com\nFollow @companyname on Facebook | Instagram | Twitter','Administrator VIP Reservation Email Alert','Reservation Date: $bookdate\nFirst Name: $firstname\nLast Name: $lastname\nEmail Address: $email\nContact Number:: $phone\n\nVIP PACKAGE\n==========\n$vippackage\n\nGUESTS\n======\n$guests\n','Form Submission Message','Lorem ipsum dolor sit amet, consectetur adipisicing elit,\nsed do eiusmod tempor incididunt ut labore et dolore\nmagna aliqua.');

CREATE TABLE settings
(  name varchar(128) not null,
   json text  not null,
   PRIMARY KEY (name)
) DEFAULT CHARSET=utf8;

insert into settings values ('email','{}');


CREATE TABLE evnamegl
( id integer NOT NULL AUTO_INCREMENT,
  created timestamp not null default current_timestamp,
  firstname varchar(128) not null,
  lastname varchar(128) not null,
  email varchar(255) not null,
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

CREATE TABLE evnamegl_guests
( id integer NOT NULL AUTO_INCREMENT,
  engl_id integer NOT NULL,
  firstname varchar(128) not null,
  lastname varchar(128) not null,
  PRIMARY KEY (id),
  FOREIGN KEY (engl_id) REFERENCES evnamegl(id) on update cascade on delete cascade
) DEFAULT CHARSET=utf8;


CREATE TABLE vipreserv
( id integer NOT NULL AUTO_INCREMENT,
  created timestamp not null default current_timestamp,
  bookdate date not null,
  vippackage_id integer not null,
  firstname varchar(128) not null,
  lastname varchar(128) not null,
  email varchar(255) not null,
  phone varchar(20) not null,
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

CREATE TABLE vipreserv_guests
( id integer NOT NULL AUTO_INCREMENT,
  vipreserv_id integer NOT NULL,
  firstname varchar(128) not null,
  lastname varchar(128) not null,
  PRIMARY KEY (id),
  FOREIGN KEY (vipreserv_id) REFERENCES vipreserv(id) on update cascade on delete cascade
) DEFAULT CHARSET=utf8;
