CREATE TABLE mc_groups
( id integer NOT NULL AUTO_INCREMENT,
  grname varchar(120) NOT NULL,
  PRIMARY KEY (id )
);

CREATE TABLE mc_users
( id integer NOT NULL AUTO_INCREMENT,
  name varchar(120) NOT NULL,
  lastname varchar(220) NOT NULL,
  firstname varchar(220) NOT NULL,
  email varchar(220),
  phone varchar(16),
  pass varchar(64),
  PRIMARY KEY (id )
);

CREATE TABLE mc_usergroups
( user_id integer NOT NULL AUTO_INCREMENT,
  group_id integer NOT NULL,
  PRIMARY KEY (user_id , group_id ),
  FOREIGN KEY (user_id) references mc_users(id) on update cascade,
  FOREIGN KEY (group_id) references mc_groups(id) on update cascade
);

CREATE TABLE mc_sessions
( id integer NOT NULL AUTO_INCREMENT,
  user_id integer NOT NULL,
  session varchar(50) NOT NULL,
  ttl bigint,
  PRIMARY KEY (id ),
  FOREIGN KEY (user_id) references mc_users(id) on delete cascade on update cascade
);

insert into mc_groups values (1,'admin'),(2,'user'),(3,'tutor'),(4,'student');
insert into mc_users values (1,'admin','','Администратор','','','21232f297a57a5a743894a0e4a801fc3');
insert into mc_usergroups values (1,1);

