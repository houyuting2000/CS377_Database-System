/* Create the canvasDB schema */
CREATE DATABASE canvasDB;

/* Specify the database to use */               
USE canvasDB; 

CREATE TABLE class
(
	cnumber CHAR(10),
	semester CHAR(9) NOT NULL,
	year INT,
    CONSTRAINT pri_c PRIMARY KEY (cnumber, semester, year)
);

CREATE TABLE class_name
(
	cnumber CHAR(10),
    cname CHAR(40),
    CONSTRAINT pri_cn PRIMARY KEY (cnumber, cname),
	CONSTRAINT foreign_cn1 FOREIGN KEY (cnumber) REFERENCES class(cnumber)

);

/* Create the student table */                              
CREATE TABLE student
(
  identifier CHAR(15),
  loginID CHAR(15) NOT NULL,
  fname CHAR(15) NOT NULL,
  lname CHAR(15) NOT NULL,
  CONSTRAINT id_const PRIMARY KEY (identifier)
);          

/* Create the instruct_class table -- a instructor instructs a class */                              
CREATE TABLE instruct_class
(
  inst_identifier CHAR(15),
  
  cnumber CHAR(10),
  semester CHAR(9) NOT NULL,
  year INT,
  
  CONSTRAINT const_ic PRIMARY KEY (inst_identifier, cnumber, semester, year),
  
  CONSTRAINT foreign_ic1 FOREIGN KEY (inst_identifier) REFERENCES student(identifier),
  CONSTRAINT foreign_ic2 FOREIGN KEY (cnumber, semester, year) REFERENCES class(cnumber, semester, year)
  #CONSTRAINT foreign_ic2 FOREIGN KEY (cnumber, semester, year) REFERENCES class(cnumber, semester, year)
  #CONSTRAINT foreign_3 FOREIGN KEY (semester) REFERENCES class(semester),
  #CONSTRAINT foreign_4 FOREIGN KEY (year) REFERENCES class(year)
);    

/* Create the take_class table -- a student takes a class */                              
CREATE TABLE take_class
(
  identifier CHAR(15),
  
  cnumber CHAR(10),
  semester CHAR(9) NOT NULL,
  year INT,
  
  grade CHAR(3), # can be null
  
  CONSTRAINT const_tc PRIMARY KEY (identifier, cnumber, semester, year),
  CONSTRAINT foreign_tc1 FOREIGN KEY (identifier) REFERENCES student(identifier),
  CONSTRAINT foreign_tc2 FOREIGN KEY (cnumber, semester, year) REFERENCES class(cnumber, semester, year)
  #CONSTRAINT foreign_3 FOREIGN KEY (semester) REFERENCES class(semester),
  #CONSTRAINT foreign_4 FOREIGN KEY (year) REFERENCES class(year)
);     



/* Create the TA_class table -- a class corresponds to a few TAs */                              
CREATE TABLE TA_class
(
  TA_identifier CHAR(15),
  
  cnumber CHAR(10),
  semester CHAR(9) NOT NULL,
  year INT,
  
  CONSTRAINT const_tac PRIMARY KEY (TA_identifier, cnumber, semester, year),
  
  CONSTRAINT foreign_tac1 FOREIGN KEY (TA_identifier) REFERENCES student(identifier),
  CONSTRAINT foreign_tac2 FOREIGN KEY (cnumber, semester, year) REFERENCES class(cnumber, semester, year)
  #CONSTRAINT foreign_3 FOREIGN KEY (semester) REFERENCES class(semester),
  #CONSTRAINT foreign_4 FOREIGN KEY (year) REFERENCES class(year)
);   

/* Create the assignment table -- a class has a number of assignments */                              
CREATE TABLE assignment
(
  cnumber CHAR(10),
  semester CHAR(9) NOT NULL,
  year INT,
  
  a_name CHAR(20),
  due_date DATETIME,
  text CHAR(30) NOT NULL,
  points DECIMAL(7,2),
  
  CONSTRAINT const_a PRIMARY KEY (cnumber, semester, year, a_name),
  
  CONSTRAINT foreign_a1 FOREIGN KEY (cnumber, semester, year) REFERENCES class(cnumber, semester, year)
  #CONSTRAINT foreign_2 FOREIGN KEY (semester) REFERENCES class(semester),
  #CONSTRAINT foreign_3 FOREIGN KEY (year) REFERENCES class(year)
);   

/* Create the do_assignment table -- a student does an assignment */                              
CREATE TABLE do_assignment
(
  cnumber CHAR(10),
  semester CHAR(9) NOT NULL,
  year INT,
  
  a_name CHAR(20),
  
  user_id CHAR(15),
  grade DECIMAL(7,2),
  
  CONSTRAINT const_da PRIMARY KEY (cnumber, semester, year, a_name, user_id),
  
  CONSTRAINT foreign_da1 FOREIGN KEY (cnumber, semester, year, a_name) REFERENCES assignment(cnumber, semester, year, a_name),
  #CONSTRAINT foreign_2 FOREIGN KEY (semester) REFERENCES class(semester),
  #CONSTRAINT foreign_3 FOREIGN KEY (year) REFERENCES class(year),
  #CONSTRAINT foreign_4 FOREIGN KEY (a_name) REFERENCES assignment(a_name),  
  CONSTRAINT foreign_da2 FOREIGN KEY (user_id) REFERENCES student(identifier)
);   

/* Create the question table -- a course can have multiple questions */                              
CREATE TABLE post
(
  cnumber CHAR(10),
  semester CHAR(9) NOT NULL,
  year INT,
  
  post_title CHAR(30) NOT NULL,
  post_date DATETIME,
  post_text CHAR(50), 
  
  user_id CHAR(20),
  #fname CHAR(10),
  #lname CHAR(10),
  
  CONSTRAINT const_p PRIMARY KEY (cnumber, semester, year, post_date, user_id),
  
  CONSTRAINT foreign_p1 FOREIGN KEY (cnumber, semester, year) REFERENCES class(cnumber, semester, year),
  CONSTRAINT foreign_p2 FOREIGN KEY (user_id) REFERENCES student(identifier)

  #CONSTRAINT foreign_2 FOREIGN KEY (semester) REFERENCES class(semester),
  #CONSTRAINT foreign_3 FOREIGN KEY (year) REFERENCES class(year),
  #CONSTRAINT foreign_p2 FOREIGN KEY (user_id) REFERENCES student(identifier)
);   

/* Create the question table -- a course can have multiple questions */                              
CREATE TABLE post_tags
(
  cnumber CHAR(10),
  semester CHAR(9) NOT NULL,
  year INT,
  post_date DATETIME,
  user_id CHAR(20),
  
  tag CHAR(15),
  
  CONSTRAINT const_pt PRIMARY KEY (cnumber, semester, year, post_date, user_id, tag),
  
  CONSTRAINT foreign_pt1 FOREIGN KEY (cnumber, semester, year, post_date, user_id) REFERENCES post(cnumber, semester, year, post_date, user_id)
  #CONSTRAINT foreign_2 FOREIGN KEY (semester) REFERENCES post(semester),
  #CONSTRAINT foreign_3 FOREIGN KEY (year) REFERENCES post(year),
  #CONSTRAINT foreign_4 FOREIGN KEY (user_id) REFERENCES post(user_id),
  #CONSTRAINT foreign_5 FOREIGN KEY (post_date) REFERENCES post(post_date)
);   

/* Create the replies table -- a question can have multiple replies */                              
CREATE TABLE response
(
  cnumber CHAR(10),
  semester CHAR(9) NOT NULL,
  year INT,
  poster_id CHAR(15),
  post_date DATETIME,
  
  replier_id CHAR(15),
  #replier_fname CHAR(10),
  #replier_lname CHAR(10),
  reply_date DATETIME,
  reply_text CHAR(50),
  
  CONSTRAINT const_r PRIMARY KEY (cnumber, semester, year, poster_id, post_date, replier_id, reply_date),
  
  CONSTRAINT foreign_r1 FOREIGN KEY (cnumber, semester, year, post_date, poster_id) REFERENCES post(cnumber, semester, year, post_date, user_id)
  #CONSTRAINT foreign_2 FOREIGN KEY (semester) REFERENCES post(semester),
  #CONSTRAINT foreign_3 FOREIGN KEY (year) REFERENCES post(year),
  #CONSTRAINT foreign_4 FOREIGN KEY (poster_id) REFERENCES post(user_id),
  #CONSTRAINT foreign_5 FOREIGN KEY (post_date) REFERENCES post(post_date)
);  







