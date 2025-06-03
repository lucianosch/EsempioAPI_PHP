<?php
header("Content-Type: application/json");
include 'db.php';

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            getUtente($id);
        } else {
            getUtenti();
        }
        break;

    case 'POST':
        addUtente();
        break;

    case 'PUT':
        $id = intval($_GET["id"]);
        updateUtente($id);
        break;

    case 'DELETE':
        $id = intval($_GET["id"]);
        deleteUtente($id);
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function getUtenti() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users");
    $utenti = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($utenti);
}

function getUtente($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $utente = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($utente);
}

function addUtente() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"));
   
    $stmt = $pdo->prepare("INSERT INTO users (name, eta) VALUES (?, ?)");
    $stmt->execute([$data->name, $data->eta]);
    echo json_encode(["message" => "Utente aggiunto con successo"]);
}

function updateUtente($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"));
    $stmt = $pdo->prepare("UPDATE users SET name = ?, eta = ? WHERE id = ?");
    $stmt->execute([$data->name, $data->eta, $id]);
    echo json_encode(["message" => "Utente aggiornato con successo"]);
}

function deleteUtente($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(["message" => "Utente eliminato con successo"]);
}
?>
