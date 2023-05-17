<?php
/**
 * @var array $currentUser
 * @var string $dormitoryNumLabel
 * @var int $dormitoriesQuantity
 * @var array $roomers
 * @var array $roomersColumns
 */
 ?>

<div class = 'row dormitories'>
    <div class = 'col'>
        <?php if ($currentUser['status'] == 'admin') { ?>
        <div class = 'row'>
            <div class = 'col'></div>
            <div class = 'col-2 form-main-div'>
                <form method = "post" name = 'dormitory'>
                    <select class = 'form-control' name = 'dormitory-num' onchange = 'dormitory.submit()'>
                        <option selected hidden><?= $dormitoryNumLabel ?></option>
                        <?php for ($count = 1; $count <= $dormitoriesQuantity; $count++) { ?>
                            <option><?= $count ?></option>
                        <?php } ?>
                    </select>
                </form>
            </div>
            <div class = 'col'></div>
        </div>
        <?php } ?>

        <?php if ($roomers['roomersCount']['all'] > 0) { ?>
        <div class = 'row'>
            <div class = 'col'></div>
            <div class = 'col-3 roomers-quantity'>
                <div class = 'row all-roomers'>
                    <div class = 'col alert alert-dark'>Общее число жильцов: <b><?= $roomers['roomersCount']['all'] ?></b></div>
                </div>
                <div class = 'row'>
                    <div class = 'col alert alert-success'>Активных: <b><?= $roomers['roomersCount']['active'] ?></b></div>
                    <div class = 'col alert alert-danger'>Заблокированных: <b><?= $roomers['roomersCount']['blocked'] ?></b></div>
                </div>
            </div>
            <div class = 'col'></div>
        </div>
        <?php } ?>

        <div class = 'row'>
            <div class = 'col'></div>
            <div class = 'col-10'>
                <div class = 'table-main-div'>
                    <form method = "post">
                        <table class = 'table table-bordered table-striped'>
                            <thead>
                            <tr>
                                <td>№</td>
                                <?php foreach($roomersColumns as $key => $value) { ?>
                                <td class = 'sorting'>
                                    <a href = '<?= $value['link'] ?>'>
                                        <div><?= $value['name'] ?></div>
                                    </a>
                                </td>
                                <?php } ?>
                                <td>Блок</td>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if (($roomers['citizens'] != null) && ($_GET['dormitory'])) { foreach ($roomers['citizens'] as $key => $value) { ?>
                                <tr class = '<?= $value['status']['table'] ?>'>
                                    <td class = 'td-centered'><?= $key + 1 ?></td>
                                    <td><?= $value['fio'] ?></td>
                                    <td class = 'td-centered'><?= $value['id'] ?></td>
                                    <td class = 'td-centered'><?= $value['roomer-status'] ?></td>
                                    <td class = 'td-centered'><?= $value['room'] ?></td>
                                    <td class = 'td-centered'><?= $value['last-date'] ?></td>
                                    <td class = 'td-centered'><input type = 'submit' value = '<?= $value['status']['btn-text'] ?>' class = 'btn <?= $value['status']['btn'] ?>' name = '<?= $value['status']['btn-action']."[{$value['id']}]" ?>'></td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class = 'col'></div>
        </div>
    </div>
</div>

