<?php
    session_start();

    include_once("connection.php");
    include_once("url.php");
    
    $data = $_POST;
    // MODIFICAÇÕES NO BANCO
    if(!empty($data)) {

        // CRIAR CONTATO
        if($data["type"] === "create") {
            $name = $data["name"];
            $phone = $data["phone"];
            $observations = $data["observations"];

            $query = "INSERT INTO contacts (name, phone, observations) VALUES (:name, :phone, :observations)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":observations", $observations);

            try {
                $stmt->execute();
                $_SESSION["msg"] = "Contato criado com sucesso!";
            } catch(PDOException $e) {
                // erro na conexão
                $error = $e->getMessage();
                echo "Erro: $error";
            }
        }

        //  REDIRECT HOME
        header("Location:" . $BASE_URL . "../index.php");

     // SELEÇÃO DE DADOS
    } else {
        $id;

        if(!empty($_GET)) {
            $id = $_GET["id"];
        }
        
        // Retorna os dados de um contato
        if(!empty($id)) {
            $query = "SELECT * FROM contacts WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $contact = $stmt->fetch();

        } else {
            // Retorna todos os contatos
            $contacts = [];
            $query = "SELECT * FROM contacts";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $contacts = $stmt->fetchAll();
        }
    }

    //FECHAR CONEXÃO
    $conn = null;
?>