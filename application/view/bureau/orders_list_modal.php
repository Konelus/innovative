<?php
/**
 * User: Konel
 * Date: 27.10.2022
 * Time: 22:51
 */
?>

<div class = 'form-main-div'>
    <form method = "post">
        <div class = 'modal' id = 'orders-list-modal'>
            <div class = 'modal-dialog <?= $modalWidth ?>'>
                <div class = 'modal-content'>
                    <div class = 'modal-header'>
                        <div class = 'title'>Создание записи</div>
                    </div>
                    <div class = 'modal-body'>
                        <div class = 'container'>
                            <div class = 'row'>
                                <div class = 'col modal-body-content'>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'order-num'>Номер заявки</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'order-num' name = 'order-num' value = '<?= $ordersList[$_GET['number']][key($_POST['order-edit'])]['order'] ?>' readonly>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'fio'>ФИО (полностью)</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'fio' name = 'fio' value = '<?= $ordersList[$_GET['number']][key($_POST['order-edit'])]['fio'] ?>' placeholder = 'ФИО (полностью)' autocomplete = 'off' required>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'type'>Тип посетителя</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <select class = 'form-control' id = 'type' name = 'type' required>
                                                <option <?= $ordersList[$_GET['number']][key($_POST['order-edit'])]['selected-type'][0] ?>>Студент</option>
                                                <option <?= $ordersList[$_GET['number']][key($_POST['order-edit'])]['selected-type'][1] ?>>Выпускник</option>
                                                <option <?= $ordersList[$_GET['number']][key($_POST['order-edit'])]['selected-type'][2] ?>>Сотрудник</option>
                                                <option <?= $ordersList[$_GET['number']][key($_POST['order-edit'])]['selected-type'][3] ?>>Гость</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'department'>Подразделение</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'department' name = 'department' value = '<?= $ordersList[$_GET['number']][key($_POST['order-edit'])]['department'] ?>' readonly>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'room'>Номер комнаты</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'room' name = 'room' value = '<?= $ordersList[$_GET['number']][key($_POST['order-edit'])]['room'] ?>' readonly>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'comment'>Комментарий</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'comment' name = 'comment' value = '<?= $ordersList[$_GET['number']][key($_POST['order-edit'])]['comment'] ?>' readonly>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-5 modal-label-div'>
                                            <label for = 'key'>Ключ</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'key' name = 'key' placeholder = 'Ключ' autofocus autocomplete = 'off' required>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($modalWidth == 'modal-lg') { ?>
                                <div class = 'col-4 modal-body-content visitor-last-orders'>
                                    <div class = 'last-orders-title'>Прошлые заявки</div>
                                    <div class = 'last-orders-list'>
                                        <?php $count = 0; foreach ($lastOrders as $key => $value) { ?>
                                        <div class = 'current-last-order'>
                                            <input type = 'checkbox' disabled <?= $value['check-status'] ?> name = 'last-order[<?= $key ?>]' id = '<?= $count ?>'>
                                            <label class = '<?= $value['label-status'] ?>' for = '<?= $count ?>'>bp_<?= $key ?></label>
                                        </div>
                                        <?php $count++; } ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class = 'modal-footer'>
                        <input type = 'hidden' name = 'id' value = '<?= key($_POST['order-edit']) ?>'>
                        <input type = 'submit' class = 'btn btn-success' value = 'Создать' name = 'pass-create'>
                        <input type = 'button' class = 'btn btn-secondary' data-dismiss = 'modal' value = 'Закрыть'>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>