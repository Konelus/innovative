<?php
/**
 * User: Konel
 * Date: 25.10.2022
 * Time: 21:25
 */
?>
<div class = 'row form-main-div'>
    <div class = 'col'></div>
    <div class = 'col-4'>
        <div class = 'alert alert-info'><?= $infoText ?></div>
        <?php if ($orderNum != '') { ?>
        <div class = 'alert alert-success'><?= $successText ?></div>
        <?php } ?>
        <form method = "post">
            <div class = 'row input-row'>
                <div class = 'col label-div'>
                    <label for = 'fio'>ФИО (полностью)</label>
                </div>
                <div class = 'col input-div'>
                    <input type = 'text' class = 'form-control' id = 'fio' name = 'fio' placeholder = 'ФИО (полностью)' autocomplete = 'off' required>
                </div>
            </div>
            <div class = 'row input-row'>
                <div class = 'col label-div'>
                    <label for = 'type'>Тип посетителя</label>
                </div>
                <div class = 'col input-div'>
                    <select class = 'form-control' id = 'type' name = 'type' required>
                        <option selected hidden value = ''>Тип посетителя</option>
                        <option>Студент</option>
                        <option>Выпускник</option>
                        <option>Сотрудник</option>
                        <option>Гость</option>
                    </select>
                </div>
            </div>
            <?php if ($currentUser['status'] == 'user') { ?>
            <div class = 'row input-row'>
                <div class = 'col label-div'>
                    <label for = 'department'>Подразделение</label>
                </div>
                <div class = 'col input-div'>
                    <input type = 'text' class = 'form-control' id = 'department' value = '<?= $currentUser['department_full'] ?>' placeholder = 'Подразделение' readonly>
                </div>
            </div>
            <div class = 'row input-row'>
                <div class = 'col label-div'>
                    <label for = 'room'>Номер корпуса и комнаты</label>
                </div>
                <div class = 'col input-div'>
                    <input type = 'text' class = 'form-control' id = 'room' value = '<?= $currentUser['room'] ?>' placeholder = 'Номер корпуса и комнаты' readonly>
                </div>
            </div>
            <div class = 'row input-row'>
                <div class = 'col label-div'>
                    <label for = 'phone'>Служебный номер телефона</label>
                </div>
                <div class = 'col input-div'>
                    <input type = 'text' class = 'form-control' id = 'phone' value = '<?= $currentUser['phone'] ?>' placeholder = 'Служебный номер телефона' readonly>
                </div>
            </div>
            <?php } ?>
            <div class = 'row input-row'>
                <div class = 'col label-div'>
                    <label for = 'comment'>Комментарий</label>
                </div>
                <div class = 'col input-div'>
                    <input type = 'text' class = 'form-control' id = 'comment' name = 'comment' placeholder = 'Необязательное поле' autocomplete = 'off'>
                </div>
            </div>
            <?php if ($currentUser['status'] != 'user') { ?>
            <div class = 'row input-row'>
                <div class = 'col label-div'>
                    <label for = 'key'>Ключ</label>
                </div>
                <div class = 'col input-div'>
                    <input type = 'text' class = 'form-control' id = 'key' name = 'key' placeholder = 'Ключ' autocomplete = 'off' required>
                </div>
            </div>
            <?php } ?>
            <div class = 'row'>
                <div class = 'submit-div'>
                    <input type = 'submit' class = 'btn btn-success' name = 'order_create' value = '<?= $btnText ?>'>
                </div>
            </div>
        </form>
    </div>
    <div class = 'col'></div>
</div>