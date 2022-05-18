<?php

    function countRow(){
        require("database.php");
        $query = "SELECT count(*) FROM employees";

        $result = $mysqli-> query($query);
        $row = $result-> fetch_row();

        return $row[0];
    }    

    function countResults($filter){
        require("database.php");
        $query = "SELECT count(*) FROM employees 
                  WHERE id like '$filter' 
                  OR birth_date like '$filter' 
                  OR first_name like '$filter' 
                  OR last_name like '$filter' 
                  OR gender like '$filter' 
                  OR hire_date like '$filter'";
        
        $result = $mysqli-> query($query);
        $row = $result-> fetch_row();

        return $row[0];
    }

    function GET($page, $lenght){
        require("database.php");
        $query = "SELECT * FROM employees ORDER BY id LIMIT $page, $lenght";
        $rows = array();

        if($result = $mysqli-> query($query)){
            while($row = $result-> fetch_assoc()){
                $rows[] = $row;
            }
        }

        return $rows;
    }

    function GET_FILTERED($searchValue){
        require("database.php");
        $query = "SELECT * FROM employees
        WHERE id like '%$searchValue%'
        OR first_name like '%$searchValue%'
        OR birth_date like '%$searchValue%'
        OR last_name like '%$searchValue%'
        OR hire_date like '%$searchValue%'
        OR M like '%$searchValue%'";

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
        $query = "INSERT INTO employees (first_name, last_name, gender) VALUES ('$firstN', '$lastN', '$g')";
        $result = $mysqli-> query($query);

    }

    function PUT($firstN, $lastN, $g, $id){
        require("database.php");
        $query = "UPDATE employees SET first_name = '$firstN', last_name = '$lastN', gender = '$g' WHERE id = $id";
        $result = $mysqli-> query($query);
        
    }

    function DELETE($id){
        require("database.php");
        $query = "DELETE FROM employees WHERE id = $id";
        $result = $mysqli-> query($query);
        
    }
?>