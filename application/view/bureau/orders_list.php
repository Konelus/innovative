<?php
/**
 * User: Konel
 * Date: 26.10.2022
 * Time: 0:15
 */
?>

<div class = 'row table-main-div'>
    <div class = 'col'>

        <?php if ($currentUser['status'] != 'user') { ?>
        <form method = "post">
            <div class = 'row show-div'>
                <div class = 'col-7 search-div'>
                    <input type = 'text' class = 'form-control' name = 'order-search[value]' value = '<?= trim($_POST['order-search']['value']) ?>' placeholder = 'Поле поиска' autocomplete = 'off'>
                    <select class = 'form-control' name = 'order-search[type]'>
                        <option value = 'visitor' <?= $searchType['visitor'] ?>>Поиск по ФИО</option>
                        <option value = 'id' <?= $searchType['id'] ?>>Поиск по номеру</option>
                    </select>
                    <input type = 'submit' class = 'btn btn-success' value = 'Найти'>
                    <input type = 'submit' class = 'btn btn-info' name = 'order-search[refresh]' value = 'Сброс'>
                </div>
                <div class = 'col-5 navigation-div'>
                    <a href = '/?page=orders_list&show=all' class = 'btn <?= $showBtn['all'] ?>'>Все заявки</a>
                    <a href = '/?page=orders_list&show=completed' class = 'btn <?= $showBtn['completed'] ?>'>Выполнено: <span class = 'orders-completed'><?= $ordersCount['completed'] ?></span></a>
                    <a href = '/?page=orders_list&show=waiting' class = 'btn <?= $showBtn['waiting'] ?>'>Ожидают: <span class = 'orders-waiting'><?= $ordersCount['waiting'] ?></span></a>
                </div>
            </div>
        </form>
        <?php } if ($currentUser['status'] == 'admin') { ?>
        <div class = 'row statistics-div'>
            <div class = 'col'>
                <div class = 'row'>
                    <div class = 'col statistics'>
                        <div>Отчёт по заявкам (<?= date("d.m.Y", strtotime("-1 weeks")) ?> - <?= date("d.m.Y") ?>)</div>
                        <div class = 'current'><span class = 'total-created'>Всего создано - <?= $ordersCount['weak-total'] ?></span> || <span class = 'total-completed'>Всего выполнено - <?= $ordersCount['weak-completed'] ?></span></div>
                    </div>
                    <div class = 'col statistics'>
                        <div>Статистика за неделю: <span class = 'statistics-first'>ДГТУ - <?= $ordersCount['weak-user-first'] ?></span>&nbsp;||&nbsp; <span class = 'statistics-second'>АСА - <?= $ordersCount['weak-user-second'] ?></span></div>
                        <div class = 'current'>Статистика за сегодня: <span class = 'statistics-first'>ДГТУ - <?= $ordersCount['today-user-first'] ?></span>&nbsp;||&nbsp; <span class = 'statistics-second'>АСА - <?= $ordersCount['today-user-second'] ?></span></div>
                    </div>
                </div>
                <div class = 'row'>
                    <div class = 'col statistics'>Отчёт по заявкам за <?= date("Y") ?> год: <span class = 'total-completed'>Всего выполнено - <?= $ordersCount['year-all-users'] ?></span> || <span class = 'statistics-first'>ДГТУ - <?= $ordersCount['year-user-first'] ?></span> || <span class = 'statistics-second'>АСА - <?= $ordersCount['year-user-second'] ?></span></div>
                </div>
                <div class = 'row'>
                    <div class = 'col statistics'>За всё время утеряно <b><?= $ordersCount['total-missed'] ?></b> пропуск</div>
                </div>
            </div>
        </div>
        <?php } ?>

        <form method = "post">
            <table class = 'table table-bordered table-striped'>
                <thead>
                    <tr>
                        <td>№</td>
                        <td>ФИО посетителя</td>
                        <td>Тип посетителя</td>
                        <td>Подразделение</td>
                        <td>Номер комнаты</td>
                        <td>Дата заявки</td>
                        <td>Время заявки</td>
                        <td>Комментарий</td>
                        <td>Номер заявки</td>
                    </tr>
                </thead>
                <tbody>
                <?php if ($ordersList != null) { foreach ($ordersList[$_GET['number']] as $key => $value) { ?>
                    <tr class = '<?= $value['status'] ?>'>
                        <td class = 'td-centered'><?= $recordsCount - (50 * ($_GET['number'] - 1)) ?></td>
                        <td><?= $value['fio'] ?></td>
                        <td><?= $value['type'] ?></td>
                        <td><?= $value['department'] ?></td>
                        <td class = 'td-centered'><?= $value['room'] ?></td>
                        <td class = 'td-centered'><?= $value['date'] ?></td>
                        <td class = 'td-centered'><?= $value['time'] ?></td>
                        <td><?= $value['comment'] ?></td>
                        <?php if (($currentUser['status'] != 'user') && ($value['status'] == 'bg-light')) { ?>
                        <td class = 'td-centered'>
                            <input type = 'submit' name = 'order-edit[<?= $key ?>]' class = 'btn btn-info' value = '<?= $value['order'] ?>'>
                        </td>
                        <?php } else { ?>
                        <td class = 'td-centered'><?= $value['order'] ?><?php } ?>
                    </tr>
                <?php $recordsCount--; } } ?>
                </tbody>
            </table>
        </form>

        <?php if ($pageList > 1) { ?>
        <div class = 'row pages-list'>
            <div class = 'col'>
                <?php foreach ($pageList as $key => $value) { ?>
                <a class = 'btn <?= $value ?>' href = '/?page=orders_list&show=<?= $_GET[$key] ?>'><?= $value ?></a>
                <?php } ?>
            </div>
        </div>
        <?php } ?>

    </div>
</div>

<?php if ($_POST['order-edit'] ) { require_once ($_SERVER['DOCUMENT_ROOT'])."/view/bureau/orders_list_modal.php"; ?>
    <script>
        $('#orders-list-modal').modal('show');
        $('#orders-list-modal').on('shown.bs.modal', function () { $('#key').focus(); });
    </script>
<?php } ?>