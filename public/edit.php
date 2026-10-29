<?php
    include_once(__DIR__ . "/../templates/header.php");
?>
    
    <div class="container">
        <?php include_once(__DIR__ . "/../templates/backbtn.php"); ?>
        <h1 id="main-title">Editar contato</h1>
        <form id="create-form" action="<?= $BASE_URL ?>process.php" method="POST">
            <input type="hidden" name="type" value="edit">
            <input type="hidden" name="id" value="<?= htmlspecialchars($contact['id']) ?>">
            <div class="form-group">
                <label for="name">Nome do contato:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($contact['name']) ?>" placeholder="Digite seu nome" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefone de contato:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($contact['phone']) ?>" placeholder="Digite o seu telefone" required>
            </div>
            <div class="form-group">
                <label for="observations">Observações:</label>
                <textarea type="text" class="form-control" id="observations" name="observations" placeholder="Insira as observações" rows="3" ><?= htmlspecialchars($contact['observations']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form> 
    </div>

<?php
    include_once(__DIR__ . "/../templates/footer.php");
?>