<?php
/**
 * User: Konel
 * Date: 09.12.2022
 * Time: 12:04
 */
?>
<div class = 'row single-report'>
    <div class = 'col'>
        <form method = "post">
            <div class = 'row form-main-div'>
                <div class = 'col'></div>
                <div class = 'col-6'>

                        <div class = 'row input-report-row'>
                            <input type = 'text' class = 'form-control' placeholder = 'ФИО' autocomplete = 'off' name = 'fio' required value = '<?= $_POST['fio'] ?>'>
                            <input type = 'date' class = 'form-control' name = 'date-1' required value = '<?= $_POST['date-1'] ?>'>
                            <input type = 'date' class = 'form-control' name = 'date-2' required value = '<?= $_POST['date-2'] ?>'>
                            <input type = 'submit' class = 'btn btn-success' value = 'Показать отчёт' name = 'create'>
                        </div>

                </div>
                <div class = 'col'></div>
            </div>


            <div class = 'row'>
                <div class = 'col'></div>
                <div class = 'col-5 report-info table-main-div'>
                    <div class = 'row'>
                        <div class = 'col'>
                            <img src = '/public/img/photo.png' alt = ''>
                            <div class = 'download-div'>
                                <input type = 'submit' class = 'btn btn-success' value = 'Создать выгрузку' name = 'download'>
                            </div>
                        </div>
                        <div class = 'col'>
                            <div class = 'row'>
                                <div class = 'col'>
                                    <div class = 'paragraph'><b>Досье №</b> <br><?= $userInfo['id'] ?></div>
                                    <div class = 'paragraph'><b>Фамилия Имя Отчество</b> <br><?= $userInfo['fio'] ?></div>
                                    <div class = 'paragraph'><b>Подразделение</b> <br><?= $userInfo['department'] ?></div>
                                    <div class = 'paragraph'><b>Должность</b> <br><?= $userInfo['position'] ?></div>
                                    <div class = 'paragraph'><b>Маршруты</b> <br><?= $userInfo['rotes'] ?></div>
                                    <div class = 'paragraph'><b>Дата рождения</b> <br><?= $userInfo['birthday'] ?></div>
                                    <div class = 'paragraph'><b>Номер телефона</b> <br><?= $userInfo['phone'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = 'col-6 table-main-div'>
                    <table class = 'table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <td>№</td>
                                <td>Дата</td>
                                <td>День недели</td>
                                <td>Время</td>
                                <td>Место</td>
                                <?php if ($currentUser['status'] == 'admin') { ?>
                                <td>Ред</td>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 0; if ($singleReport != null) { foreach ($singleReport as $key => $value) { $count++; ?>
                            <tr class = '<?= $value['row'] ?>'>
                                <td class = 'td-centered' rowspan = '2'><?= $count ?></td>
                                <td class = 'td-centered' rowspan = '2'><?= $value['date'] ?></td>
                                <td class = 'td-centered' rowspan = '2'><?= $value['weekday'] ?></td>
                                <td class = 'td-centered <?= $value['record-1']['col'] ?>'><?= $value['record-1']['time'] ?></td>
                                <td class = '<?= $value['record-1']['col'] ?>'><?= $value['record-1']['place'] ?></td>
                                <?php if ($currentUser['status'] == 'admin') { ?>
                                <td class = 'td-centered <?= $value['record-1']['col'] ?>'><input type = 'submit' class = 'btn btn-info' value = '✎'></td>
                                <?php } ?>
                            </tr>
                            <tr class = '<?= $value['row'] ?>'>
                                <td class = 'td-centered <?= $value['record-2']['col'] ?>'><?= $value['record-2']['time'] ?></td>
                                <td class = '<?= $value['record-2']['col'] ?>'><?= $value['record-2']['place'] ?></td>
                                <?php if ($currentUser['status'] == 'admin') { ?>
                                <td class = 'td-centered <?= $value['record-2']['col'] ?>'><input type = 'submit' class = 'btn btn-info' value = '✎'></td>
                                <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
                <div class = 'col'></div>
            </div>
        </form>
    </div>
</div>

