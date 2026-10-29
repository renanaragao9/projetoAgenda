<?php
    include_once(__DIR__ . "/../templates/header.php");
?>
    
    <div class="container" id="view-contact-container">
        <?php include_once(__DIR__ . "/../templates/backbtn.php"); ?>
        <h1 id="main-title"><?= htmlspecialchars($contact["name"]) ?></h1> 
        <p class="bold">Telefone:</p>
        <p><?= htmlspecialchars($contact["phone"]) ?></p>
        <p class="bold">Observações:</p>
        <p><?= htmlspecialchars($contact["observations"]) ?></p>
    </div>

<?php
    include_once(__DIR__ . "/../templates/footer.php");
?>