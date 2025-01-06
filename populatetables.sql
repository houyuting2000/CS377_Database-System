use canvasDB;

LOAD DATA LOCAL INFILE 'class_name.csv' INTO TABLE class_name
FIELDS TERMINATED BY ',' IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'class.csv' INTO TABLE class
FIELDS TERMINATED BY ',' IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'student.csv' INTO TABLE student
FIELDS TERMINATED BY ',' IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'take_class.csv' INTO TABLE take_class
FIELDS TERMINATED BY ',' IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'instruct_class.csv' INTO TABLE instruct_class
FIELDS TERMINATED BY ',' IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'TA_class.csv' INTO TABLE TA_class
FIELDS TERMINATED BY ',' IGNORE 1 LINES;

######### 75 - 77
LOAD DATA LOCAL INFILE 'assignment.csv' INTO TABLE assignment
FIELDS TERMINATED BY ',' IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'do_assignment.csv' INTO TABLE do_assignment
FIELDS TERMINATED BY ',' IGNORE 1 LINES;

######### 34 - 35
LOAD DATA LOCAL INFILE 'post.csv' INTO TABLE post
FIELDS TERMINATED BY ',' IGNORE 1 LINES;

############## 42 - 43
LOAD DATA LOCAL INFILE 'post_tags.csv' INTO TABLE post_tags
FIELDS TERMINATED BY ',' IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'response.csv' INTO TABLE response
FIELDS TERMINATED BY ',' IGNORE 1 LINES;