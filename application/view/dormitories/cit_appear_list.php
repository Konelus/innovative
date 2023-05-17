<?php
/**
 * @var array $currentUser
 * @var string $dormitoryNumLabel
 * @var int $dormitoriesQuantity
 * @var array $roomers
 * @var array $roomersColumns
 */
?>

<?php if ($currentUser['status'] == 'admin') { ?>
<div class = 'row'>
    <div class = 'col'></div>
    <div class = 'col-2 form-main-div'>
        <form method = "post" name = 'dormitory'>
            <select class = 'form-control' name = 'dormitory-num' onchange = 'dormitory.submit()'>
                <option selected hidden><?= $dormitoryNumLabel ?></option>
                	<?php for ($count = 1; $count <= $dormitoriesQuantity; $count++): ?>
                <option><?= $count ?></option>
                <?php endfor; ?>
            </select>
        </form>
    </div>
    <div class = 'col'></div>
</div>
<?php } ?>

<div class = 'row'>
    <div class = 'col-1'></div>
    <div class = 'col table-main-div'>
        <table class = 'table table-bordered table-striped'>
            <thead>
                <tr><th class = 'bg-danger' colspan = '4'>Больше трёх дней без активности</th></tr>
                <tr>
                    <td>№</td>
                    <?php foreach($roomersColumns as $key => $value) { ?>
                        <td class = 'sorting'>
                            <a href = '<?= $value['link'] ?>'>
                                <div><?= $value['name'] ?></div>
                            </a>
                        </td>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php if (($roomers['misses']['danger'] != null) && ($_GET['dormitory'])) { $count = 1; foreach ($misses['danger'] as $key => $value) { ?>
                <tr>
                    <td class = 'td-centered'><?= $count ?></td>
                    <td><?= $value['fio'] ?></td>
                    <td class = 'td-centered'><?= $value['room'] ?></td>
                    <td class = 'td-centered'><?= $value['last-date'] ?></td>
                </tr>
                <?php $count++; } } ?>
            </tbody>
        </table>
    </div>

    <div class = 'col table-main-div'>
        <table class = 'table table-bordered table-striped'>
            <thead>
                <tr><th class = 'bg-info' colspan = '4'>До трёх дней без активности</th></tr>
                <tr>
                    <td>№</td>
                    <?php foreach($roomersColumns as $key => $value) { ?>
                        <td class = 'sorting'>
                            <a href = '<?= $value['link'] ?>'>
                                <div><?= $value['name'] ?></div>
                            </a>
                        </td>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($roomers['misses']['warning'] != null) { $count = 1; foreach ($roomers['misses']['warning'] as $key => $value) { ?>
                <tr>
                    <td class = 'td-centered'><?= $count ?></td>
                    <td><?= $value['fio'] ?></td>
                    <td class = 'td-centered'><?= $value['room'] ?></td>
                    <td class = 'td-centered'><?= $value['last-date'] ?></td>
                </tr>
                <?php $count++; } } ?>
            </tbody>
        </table>
    </div>
    <div class = 'col-1'></div>
</div>