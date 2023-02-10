<?php
    include_once("templates/header.php");
?>
    
    <div class="container">
        <?php include_once("templates/backbtn.php"); ?>
        <h1 id="main-title">Editar contato</h1>
        <form id="create-form" action="<?= $BASE_URL ?>config/process.php" method="POST">
            <input type="hidden" name="type" value="create">
            <input type="hidden" name="id" value="<?= $contact['id'] ?>">
            <div class="form-group">
                <label for="name">Nome do contato:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $contact['name'] ?>" placeholder="Digite seu nome" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefone de contato:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $contact['phone'] ?>" placeholder="Digite o seu telefone" required>
            </div>
            <div class="form-group">
                <label for="observations">Observações:</label>
                <textarea type="text" class="form-control" id="observations" name="observations" placeholder="Insira as observações" rows="3" ><?= $contact['observations'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form> 
    </div>

<?php
    include_once("templates/footer.php");
?>