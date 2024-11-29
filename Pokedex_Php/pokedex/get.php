<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        
        require_once('../conexion.php');

        $mysqli->select_db("pokedex");

        $consulta_pokemones = "select pokemon_id, nombre, numero, imagen from pokemon";

        $result = $mysqli->query($consulta_pokemones);

        $pokemones = [];
        
        foreach ($result as $row) {
            /* Processing of the data retrieved from the database */
            $pokemones[] = $row;
        }

        header('Content-type: application/json; charset=utf-8');
		header("access-control-allow-origin: *");

        //la codificamos en un json y la imprimimos
        print(json_encode($pokemones));

        $mysqli->close();
    }
?>

