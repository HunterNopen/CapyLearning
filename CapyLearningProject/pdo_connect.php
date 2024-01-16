<?php

//$dbuser = 'root';
//$dbpass = '';
//$db = new PDO("mysql:host=localhost;dbname=capylearning", $dbuser,$dbpass);

$dbuser = 's28856';
$dbpass = 'Rom.Hera';
$host='szuflandia.pjwstk.edu.pl';
$db=new PDO("mysql:host=$host;dbname=s28856", $dbuser,$dbpass);
$db->query('
        
    CREATE TABLE users(
        idUser INTEGER NOT NULL AUTO_INCREMENT,
        loginUser VARCHAR(30) NOT NULL,
        passwordUser VARCHAR(20) NOT NULL,
        email VARCHAR(30) NOT NULL,
        image VARCHAR(100) NOT NULL DEFAULT "images_source/no_image.png",
        about VARCHAR(100),

	    PRIMARY KEY (idUser));
	    
	CREATE TABLE tutors(
	    idTutor INTEGER NOT NULL AUTO_INCREMENT,
	    idUser INTEGER NOT NULL,
	    publicName VARCHAR(100),
	    
	    PRIMARY KEY (idTutor));
	ALTER TABLE tutors
    ADD FOREIGN KEY (idUser) REFERENCES users(idUser) ON DELETE CASCADE;
    
    CREATE TABLE admins(
	    idAdmin INTEGER NOT NULL AUTO_INCREMENT,
	    idUser INTEGER NOT NULL,
	    
	    PRIMARY KEY (idAdmin));
	ALTER TABLE admins
    ADD FOREIGN KEY (idUser) REFERENCES users(idUser) ON DELETE CASCADE;
      
    CREATE TABLE courses(
	    idCourse INTEGER NOT NULL AUTO_INCREMENT,
	    idTutor INTEGER NOT NULL,
	    nameCourse VARCHAR(30) NOT NULL,
	    dateUp date NOT NULL DEFAULT CURRENT_TIMESTAMP,
	    statusCourse VARCHAR(10) NOT NULL DEFAULT "active",
	    image VARCHAR(100) DEFAULT "images_source/no_image.png",
	    tags VARCHAR(25) NOT NULL DEFAULT "all",
	    likesNumber INTEGER NOT NULL DEFAULT 0,
	    
	    PRIMARY KEY (idCourse));
	ALTER TABLE courses
    ADD FOREIGN KEY (idTutor) REFERENCES tutors(idTutor) ON DELETE CASCADE;
    
    CREATE TABLE courseMaterials(
        idCourseMaterials INTEGER NOT NULL AUTO_INCREMENT,
        idCourse INTEGER NOT NULL, 
        description VARCHAR(500),
        video VARCHAR(100) NOT NULL DEFAULT "https://www.youtube.com/watch?v=msg4kEAJ7mw&t=1826s",
	    
	    PRIMARY KEY (idCourseMaterials));
	ALTER TABLE courseMaterials
    ADD FOREIGN KEY (idCourse) REFERENCES courses(idCourse) ON DELETE CASCADE;
    
    CREATE TABLE practice(
        idPractice INTEGER NOT NULL AUTO_INCREMENT,
        idCourse INTEGER NOT NULL,
        number INTEGER NOT NULL DEFAULT 1,
        description VARCHAR(500) NOT NULL,
        video VARCHAR(100),
        image VARCHAR(100),
        answer VARCHAR(100) NOT NULL,
        
	    
	    PRIMARY KEY (idPractice),
	    FOREIGN KEY (idCourse) REFERENCES courses(idCourse) ON DELETE CASCADE);
	    
	ALTER TABLE courseMaterials
    ADD FOREIGN KEY (idCourse) REFERENCES courses(idCourse) ON DELETE CASCADE;
   
    CREATE TABLE savedCourses(
	    idUser INTEGER NOT NULL,
	    idCourse INTEGER NOT NULL);
	    
	CREATE TABLE likeCourses(
	    idUser INTEGER NOT NULL,
	    idCourse INTEGER NOT NULL);
	    
	ALTER TABLE savedCourses
    ADD FOREIGN KEY (idUser) REFERENCES users(idUser) ON DELETE CASCADE;
    ALTER TABLE savedCourses
    ADD FOREIGN KEY (idCourse) REFERENCES courses(idCourse) ON DELETE CASCADE;
    
    CREATE TABLE comments(
	    idComment INTEGER NOT NULL AUTO_INCREMENT,
	    idUser INTEGER NOT NULL,
	    idCourse INTEGER NOT NULL,
	    comment VARCHAR(500) NOT NULL,
	    dateUp date NOT NULL DEFAULT CURRENT_TIMESTAMP,
	    PRIMARY KEY (idComment),
	    FOREIGN KEY (idUser) REFERENCES users(idUser) ON DELETE CASCADE,
	    FOREIGN KEY (idCourse) REFERENCES courses(idCourse) ON DELETE CASCADE);
	    
	    CREATE TABLE progress(
	    idProgress INTEGER NOT NULL AUTO_INCREMENT,
	    idUser INTEGER NOT NULL,
	    idPractice INTEGER NOT NULL,
	    progress INTEGER NOT NULL DEFAULT 0,
	    PRIMARY KEY (idProgress),
	    FOREIGN KEY (idUser) REFERENCES users(idUser) ON DELETE CASCADE,
	    FOREIGN KEY (idPractice) REFERENCES practice(idPractice) ON DELETE CASCADE);
	    ');
$db->query("INSERT INTO users(loginUser, passwordUser, email) VALUES ('HunterNope', 'HunterNope1!','hunternope01@gmail.com');
INSERT INTO tutors(idUser, publicName) VALUES (1, 'Roman H');
INSERT INTO courses(idTutor, nameCourse, tags) VALUES (1, 'JS Profi', 'development');
INSERT INTO coursematerials(idCourse, description, video) VALUES (1, 'Why Study JavaScript?
JavaScript is one of the 3 languages all web developers must learn:

   1. HTML to define the content of web pages

   2. CSS to specify the layout of web pages

   3. JavaScript to program the behavior of web pages

This tutorial covers every version of JavaScript:

The Original JavaScript ES1 ES2 ES3 (1997-1999)
The First Main Revision ES5 (2009)
The Second Revision ES6 (2015)
All Yearly Additions (2016, 2017, 2018, 2019, 2020)', 'https://www.youtube.com/watch?v=N2bXEUSAiTI');
INSERT INTO courses(idTutor, nameCourse) VALUES (1, 'PHP Profi');
INSERT INTO coursematerials(idCourse, description, video) VALUES (2, 'Why Study JavaScript?
JavaScript is one of the 3 languages all web developers must learn:

   1. HTML to define the content of web pages

   2. CSS to specify the layout of web pages

   3. JavaScript to program the behavior of web pages

This tutorial covers every version of JavaScript:

The Original JavaScript ES1 ES2 ES3 (1997-1999)
The First Main Revision ES5 (2009)
The Second Revision ES6 (2015)
All Yearly Additions (2016, 2017, 2018, 2019, 2020)', 'https://www.youtube.com/watch?v=N2bXEUSAiTI');
INSERT INTO practice (idCourse, description, answer) VALUES (1,'Write Hello World!', 'Hello World');
INSERT INTO practice (idCourse, description, answer, number) VALUES (1,'Write Helloo World!', 'Helloo World', 2);
INSERT INTO practice (idCourse, description, answer, number) VALUES (1,'Write Hello Worldddd!', 'Hello Worldddd', 3);
INSERT INTO admins(idUser) VALUES (1)");
?>
