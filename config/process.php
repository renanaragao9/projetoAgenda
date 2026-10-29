<?php
    session_start();

    require_once(__DIR__ . "/../vendor/autoload.php");
    include_once(__DIR__ . "/connection.php");
    include_once(__DIR__ . "/url.php");

    use App\ContactRepository;

    $repository = new ContactRepository($conn);

    $data = $_POST;
    // MODIFICAÇÕES NO BANCO
    if(!empty($data)) {

        $type = $data["type"] ?? "";

        try {
            // CRIAR CONTATO
            if($type === "create") {
                $repository->create(
                    $data["name"] ?? "",
                    $data["phone"] ?? "",
                    $data["observations"] ?? ""
                );
                $_SESSION["msg"] = "Contato criado com sucesso!";

            } else if($type === "edit") {
                $repository->update(
                    (int) ($data["id"] ?? 0),
                    $data["name"] ?? "",
                    $data["phone"] ?? "",
                    $data["observations"] ?? ""
                );
                $_SESSION["msg"] = "Contato atualizado com sucesso!";

            } else if($type === "delete") {
                $repository->delete((int) ($data["id"] ?? 0));
                $_SESSION["msg"] = "Contato removido com sucesso!";
            }
        } catch(PDOException $e) {
            // erro na conexão
            $error = $e->getMessage();
            echo "Erro: $error";
        }

        //  REDIRECT HOME
        header("Location:" . $BASE_URL . "index.php");

     // SELEÇÃO DE DADOS
    } else {
        $id = $_GET["id"] ?? null;

        // Retorna os dados de um contato
        if(!empty($id)) {
            $contact = $repository->find((int) $id);

            // Evita erros caso o contato não exista
            if(!$contact) {
                $contact = ["id" => "", "name" => "", "phone" => "", "observations" => ""];
            }

        } else {
            // Retorna todos os contatos
            $contacts = $repository->all();
        }
    }

    //FECHAR CONEXÃO
    $conn = null;
?>
