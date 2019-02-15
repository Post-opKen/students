<?php
/**
 * User: Ean Daus
 * Date: 2/13/2019
 * Database functions
 */

require_once '/home/edausgre/config.php';

//returns a new database object if connection is successful, otherwise returns false
function connect()
{
    try{
        //instantiate a new database object
        $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        return $dbh;

    }catch(PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

function getStudents()
{
    global $dbh;

    //define the statement
    $sql = "SELECT * FROM student ORDER BY last, first";

    //prepare the statement
    $statement = $dbh->prepare($sql);

    //execute the statement
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

//adds a new student to the DB, returns true if successful, false otherwise.
function addStudent($sid, $last, $first, $birthdate, $gpa, $advisor)
{
    global $dbh;

    //write the query
    $sql = "INSERT INTO student VALUES :sid, :last, :first, :birthdate, :gpa, :advisor";

    //prepare the statement
    $statement = $dbh->prepare($sql);

    //bind params
    $statement->bindParam(':sid', $sid, PDO::PARAM_STR);
    $statement->bindParam(':last', $last, PDO::PARAM_STR);
    $statement->bindParam(':first', $first, PDO::PARAM_STR);
    $statement->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
    $statement->bindParam(':gpa', $gpa, PDO::PARAM_STR);
    $statement->bindParam(':advisor', $advisor, PDO::PARAM_STR);

    //execute query
    $success = $statement->execute();
    return $success;
}
