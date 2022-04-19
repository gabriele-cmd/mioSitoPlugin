<?php
    $method = $_SERVER['REQUEST_METHOD'];
    //$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
    
    require("datalayer.php");
    header('Content-Type: application/json');
    $page = @$_GET["page"] ?? 0;
    $size = @$_GET["size"] ?? 20;
    $count = countRow();
    $last = ceil($count/$size);
    $baseurl = "http://localhost:8080/index.php";


    $arrayJSON = array ();

    $arrayJSON['_embedded'] = array(
        "employees" => array(
            
        )
    );

    $arrayJSON['_links'] = links($page, $size, $last, $baseurl);

    $arrayJSON['pages'] = array (
        "size" => $size,
        "totalElements" => $count,
        "totalPages" => $last,
        "number" => $page
    );

    switch($method){

        case 'GET':
            $arrayJSON['_embedded']['employees'] = GET($page*$size, $size);
            echo json_encode($arrayJSON);
            break;

        case 'POST':
            $arrayJSON['_embedded']['employees'] = GET($page*$size, $size);
            array_push($arrayJSON['_embedded']['employees'], PUSH($_POST["nome"], $_POST["cognome"], $_POST["genere"]));

            echo json_encode($arrayJSON);
            break;

        case 'PUT':
            
            break;

        case 'DELETE':
            $arrayJSON['_embedded']['employees'] = GET($page*$size, $size);
            DELETE($_POST["id"]);

            if(($key = array_search('id: '. $_POST["id"], $arrayJSON)) !== false){
                unset($arrayJSON[$key]);
            }

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