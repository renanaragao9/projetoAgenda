<?php
    include_once(__DIR__ . "/../templates/header.php");
?>
    
    <div class="container">
        <?php if(isset($printMsg) && $printMsg != ''):  ?>
            <p id="msg"><?= $printMsg ?></p>
        <?php endif; ?>
        
        <h1 id="main-title">Minha Agenda</h1>
        
        <?php if(count($contacts) > 0): ?>
            <table class="table" id="contacts-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Telefone</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($contacts as $contact): ?>
                        <tr>
                            <td scope="row" class="col-id"><?= htmlspecialchars($contact["id"]) ?></td>
                            <td scope="row"><?= htmlspecialchars($contact["name"]) ?></td>
                            <td scope="row"><?= htmlspecialchars($contact["phone"]) ?></td>
                            <td class="actions">
                                <a href="<?= $BASE_URL ?>show.php?id=<?= urlencode($contact["id"]) ?>"><i class="fa fa-eye check-icon"></i></a>
                                <a href="<?= $BASE_URL ?>edit.php?id=<?= urlencode($contact["id"]) ?>"><i class="far fa-edit edit-icon"></i></a>
                                <form class="delete-form" action="<?= $BASE_URL ?>process.php" method="POST">
                                    <input type="hidden" name="type" value="delete">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($contact["id"]) ?>">
                                    <button type="submit" class="delete-btn"><i class="fas fa-times delete-icon"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p id="empty-list-text">Ainda não há contatos na sua agenda, <a href="<?= $BASE_URL ?>create.php">Clique aqui para adicionar</a>.</p>
        <?php endif; ?>
    </div>

<?php
    include_once(__DIR__ . "/../templates/footer.php");
?>