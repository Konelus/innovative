<?php
/**
 * User: Konel
 * Date: 27.10.2022
 * Time: 1:17
 */
?>

<div class = 'row table-main-div'>
    <div class = 'col'>
        <form method = "post">
            <table class = 'table table-bordered table-striped'>
                <thead>
                <tr>
                    <td>Подразделение (полностью)</td>
                    <td>Подразделение (кратко)</td>
                    <td>Тип</td>
                    <td>Комната</td>
                    <td>Телефон</td>
                    <td>Логин</td>
                    <td>Пароль</td>
                    <td>Ред</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($usersList as $key => $value) { ?>
                    <tr>
                        <td><?= $value['department_full'] ?></td>
                        <td><?= $value['department_short'] ?></td>
                        <td><?= $value['type'] ?></td>
                        <td><?= $value['room'] ?></td>
                        <td><?= $value['phone'] ?></td>
                        <td><?= $value['login'] ?></td>
                        <td><?= $value['password'] ?></td>
                        <td class = 'td-centered'>
                            <input type = 'submit' class = 'btn btn-info' name = 'user-edit[<?= $key ?>]' value = '✎'>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<?php if ($_POST['user-edit'] ) {
	require_once(__DIR__ . "/users_list_modal.php") ?>
    <script>
        $('#users-list-modal').modal('show');
        $('#users-list-modal-list-modal').on('shown.bs.modal', function() {
            $('#key').focus()
        });</script>
<?php } ?>