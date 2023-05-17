<?php
/**
 * User: Konel
 * Date: 26.10.2022
 * Time: 18:58
 */
?>

<div class = 'row form-main-div'>
    <div class = 'col'></div>
    <div class = 'col-4'>
        <div class = 'alert alert-info'>Форма редактирования учётных данных</div>
        <form method = "post">
            <div class = 'row input-row'>
                <div class = 'col label-div'>
                    <label for = 'department-full'>Подразделение (полностью)</label>
                </div>
                <div class = 'col input-div'>
                    <input type = 'text' class = 'form-control' id = 'department-full' name = 'department_full' value = '<?= $currentUser['department_full'] ?>' placeholder = 'Подразделение (полностью)' autocomplete = 'off'>
                </div>
            </div>
            <div class = 'row input-row'>
                <div class = 'col label-div'>
                    <label for = 'department-short'>Подразделение (кратко)</label>
                </div>
                <div class = 'col input-div'>
                    <input type = 'text' class = 'form-control' id = 'department-short' name = 'department_short' value = '<?= $currentUser['department_short'] ?>' placeholder = 'Подразделение (кратко)' autocomplete = 'off'>
                </div>
            </div>
            <div class = 'row input-row'>
                <div class = 'col label-div'>
                    <label for = 'room'>Номер корпуса и комнаты</label>
                </div>
                <div class = 'col input-div'>
                    <input type = 'text' class = 'form-control' id = 'room' name = 'room' value = '<?= $currentUser['room'] ?>' placeholder = 'Номер корпуса и комнаты' autocomplete = 'off'>
                </div>
            </div>
            <div class = 'row input-row'>
                <div class = 'col label-div'>
                    <label for = 'phone'>Номер телефона (служебный)</label>
                </div>
                <div class = 'col input-div'>
                    <input type = 'text' class = 'form-control' id = 'phone' name = 'phone' value = '<?= $currentUser['phone'] ?>' placeholder = 'Номер телефона (служебный)' autocomplete = 'off'>
                </div>
            </div>
            <div class = 'row'>
                <div class = 'submit-div'>
                    <input type = 'submit' class = 'btn btn-success' name = 'profile_update' value = 'Сохранить изменения'>
                </div>
            </div>
        </form>
    </div>
    <div class = 'col'></div>
</div>
