<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once('../conexion.php');

        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, true);

        $nombre = $data["nombre"];
        $numero = $data["numero"];
        $imagen = $data["imagen"];

        $mysqli->select_db("pokedex");

        $query_insert_pokemon = "insert into pokemon (nombre, numero, imagen) values (?, ?, ?)";

        $stmt = $mysqli->prepare($query_insert_pokemon);
        $stmt->bind_param('sss', $nombre , $numero, $imagen);

        $stmt->execute();

        //printf("%d row inserted.\n", $stmt->affected_rows);
        $result_insert_id = $mysqli->query("select LAST_INSERT_ID() as id");
        $row = $result_insert_id->fetch_row();
        $id_inserted = $row[0];

        header('Content-type: application/json; charset=utf-8');
		header("access-control-allow-origin: *");

        $data_response["nombre"] = $nombre;
        $data_response["numero"] = $numero;
        $data_response["imagen"] = $imagen;
        $data_response["pokemon_id"] = (int)$id_inserted;

        print(json_encode($data_response));

        $mysqli->close();
    }

?>