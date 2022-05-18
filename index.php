<?php

    $method = $_SERVER['REQUEST_METHOD'];
    //$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
    
    require("datalayer.php");
    header('Content-Type: application/json');
    $page = @$_POST["start"] ?? 0;
    $size = @$_POST["length"] ?? 10;
    $id = @$_POST["id"] ?? 0;
    $searchVal = $_POST["search[value]"];
    $count = countRow();
    $results = countResults($searchVal);
    $draw = $_SESSION["counter"] + 1;
    $baseurl = "http://localhost:8090/index.php";

    switch($method){

        case 'POST':

            if(!is_null($searchVal)){
                $arrayJSON['data'] = GET_FILTERED($searchVal);
                $arrayJSON['recordsFiltered'] = $count;
                $arrayJSON['recordsTotal'] = $count;
                echo json_encode($arrayJSON);
            }else{
                $arrayJSON['data'] = GET($page*$size, $size);
                $arrayJSON['recordsFiltered'] = $count;
                $arrayJSON['recordsTotal'] = $count;
                echo json_encode($arrayJSON);
            }


            /*
            if($id != 0){
                $arrayJSON['_embedded']['employees'] = GET_BY_ID($id);
                echo json_encode($arrayJSON);
            }else{
                $arrayJSON['_embedded']['employees'] = GET($page*$size, $size);
                echo json_encode($arrayJSON);
            }*/
            break;

        /*
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            POST($data["first_name"], $data["last_name"], $data["gender"]);

            echo json_encode($data);
            break;
        */
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            PUT($data["first_name"], $data["last_name"], $data["gender"], $id);

            echo json_encode($data);
            break;

        case 'DELETE':
            DELETE($id);

            echo json_encode($arrayJSON);
            break;
        
        //in case of bad request
        default:
            header("HTTP/1.1 400 BAD REQUEST");
            break;
    }

    function href($baseurl, $page, $size){
        return $baseurl . "?page=" . $page . "&size=" . $size;
    }

    function links($page, $size, $last, $baseurl){
        $links = array(
            "first" => array ( "href" => href($baseurl, 0, $size)),
            "self" => array ( "href" => href($baseurl, $page, $size), "templated" => true),
            "last" => array ( "href" => href($baseurl, $last, $size))
        );
        
        if($page > 0){
            $links["prev"] = array( "href" => href($baseurl, $page - 1, $size));
        }
        
        if($page < $last){
            $links["next"] = array ( "href" => href($baseurl, $page + 1, $size));
        }
        
        return $links;
    }
?>