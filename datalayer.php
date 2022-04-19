<?php

    function countRow(){
        require("database.php");
        $query = "SELECT count(*) FROM employees";

        $result = $mysqli-> query($query);
        $row = $result-> fetch_row();

        return $row[0];
    }    

    function getPageInfo(){}

    function GET($first, $lenght){
        require("database.php");
        $query = "SELECT * FROM employees ORDER BY id LIMIT $first, $lenght";
        $rows = array();

        if($result = $mysqli-> query($query)){
            while($row = $result-> fetch_assoc()){
                $rows[] = $row;
            }
        }

        return $rows;
    }

    function POST($firstN, $lastN, $g){
        require("database.php");
        $query = "INSERT INTO employees (firstName, lastName, gender)
        VALUES ($firstN, $lastN, $g)";
        $rows = array();

        if($result = $mysqli-> query($query)){
            while($row = $result-> fetch_assoc()){
                $rows[] = $row;
            }
        }

        return $rows;

    }

    function PUT($firstN, $lastN, $g, $id){
        require("database.php");
        $query = "UPDATE employees SET firstName = $firstN, lastName = $lastN, gender = $g WHERE id = $id";
        $rows = array();

        if($result = $mysqli-> query($query)){
            while($row = $result-> fetch_assoc()){
                $rows[] = $row;
            }
        }

        return $rows;
        
    }

    function DELETE($id){
        require("database.php");
        $query = "DELETE FROM employees WHERE id = $id";
        $result = $mysqli-> query($query)
        
    }
?>