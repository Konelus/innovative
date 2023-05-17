<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 27.10.2022
 * Time: 22:51
 */
?>
<div class = 'form-main-div'>
    <form method = "post">
        <div class = 'modal' id = 'users-list-modal'>
            <div class = 'modal-dialog'>
                <div class = 'modal-content'>
                    <div class = 'modal-header'>
                        <div class = 'title'>Редактирование</div>
                    </div>
                    <div class = 'modal-body'>
                        <div class = 'container'>
                            <div class = 'row'>
                                <div class = 'col modal-body-content'>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'department_full'>Подразделение</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'department_full' name = 'department_full' value = '<?= $usersList[key($_POST['user-edit'])]['department_full'] ?>' placeholder = 'Подразделение' autocomplete = 'off' required>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'department_short'>Подразделение (кратко)</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'department_short' name = 'department_short' value = '<?= $usersList[key($_POST['user-edit'])]['department_short'] ?>' placeholder = 'Подразделение (кратко)' autocomplete = 'off' required>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'type'>Тип подразделения</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <select class = 'form-control' id = 'type' name = 'type'>
                                                <option hidden selected><?= $usersList[key($_POST['user-edit'])]['type'] ?></option>
                                                <option>Служба</option>
                                                <option>Отдел</option>
                                                <option>Управление</option>
                                                <option>Центр</option>
                                                <option>Кафедра</option>
                                                <option>Факультет</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'room'>Номер комнаты</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'room' name = 'room' value = '<?= $usersList[key($_POST['user-edit'])]['room'] ?>' placeholder = 'Номер комнаты' autocomplete = 'off'>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'phone'>Номер телефона</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'phone' name = 'phone' value = '<?= $usersList[key($_POST['user-edit'])]['phone'] ?>' placeholder = 'Номер телефона' autocomplete = 'off'>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'login'>Логи</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'login' name = 'login' value = '<?= $usersList[key($_POST['user-edit'])]['login'] ?>' placeholder = 'Логин' autocomplete = 'off' required>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'password'>Пароль</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'password' name = 'password' value = '<?= $usersList[key($_POST['user-edit'])]['password'] ?>' placeholder = 'Пароль' autocomplete = 'off' required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = 'modal-footer'>
                        <input type = 'hidden' name = 'id' value = '<?= key($_POST['user-edit']) ?>'>
                        <input type = 'submit' class = 'btn btn-success' value = 'Создать' name = 'user-edit-modal'>
                        <input type = 'submit' class = 'btn btn-danger' value = 'Удалить' name = 'user-delete-modal'>
                        <input type = 'button' class = 'btn btn-secondary' data-dismiss = 'modal' value = 'Закрыть'>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>