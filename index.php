<?php
/**
 * @var array $module
 * @var array $currentUser;
 * @var string $currentYear
 */

    //ini_set('display_errors','Off');
    require_once 'application/controller/controller.php';
	$production = 0;
?>

<!DOCTYPE html>

<html lang = 'ru'>
    <head>
		<title>Innovative <?= $module['title'] ?></title>
		<link rel = 'icon' href = '/public/img/logo.png'>

		<script src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js'></script>
		<script src = '/public/bootstrap/js/bootstrap.min.js'></script>
		<link rel = 'stylesheet' href = '/public/bootstrap/css/bootstrap.min.css'>

		<?php if ($production): ?>
			<script src = '/public/jQuery.js'></script>
			<link rel = 'stylesheet' type = 'text/css' href = 'public/styles/main.css'>
			<link rel = 'stylesheet' type = 'text/css' href = 'public/styles/form.css'>
			<link rel = 'stylesheet' type = 'text/css' href = 'public/styles/table.css'>
			<link rel = 'stylesheet' type = 'text/css' href = 'public/styles/<?= $currentUser['module'] ?>.css'>
		<?php else: ?>
			<link rel ='stylesheet/less' type = 'text/css' href = 'public/styles/main.less'>
			<link rel = 'stylesheet/less' type = 'text/css' href = 'public/styles/form.less'>
			<link rel = 'stylesheet/less' type = 'text/css' href = 'public/styles/table.less'>
			<link rel = 'stylesheet/less' type = 'text/css' href = 'public/styles/<?= $currentUser['module'] ?>./orders.less'>

			<script src = 'https://cdn.jsdelivr.net/npm/less'></script>
		<?php endif; ?>


        <?php if ((date('Y') == 12) || (date('Y') == 1) || (date('Y') == 2)): ?>
			<script src='/public/snowfall.jquery.js'></script>
			<script>
				$(document).ready(function () {
					$(document).snowfall({
						flakeCount: 100, // Количество снежинок
						flakeColor: 'snow', // Цвет снежинок
						flakeIndex: 999999, // z-index снежинок
						minSize: 1, // Минимальный размер снежинки
						maxSize: 2, // Максимальный размер снежинки
						minSpeed: 1, // Минимальная скорость снежинки
						maxSpeed: 5, // Максимальная скорость снежинки
						round: true, // Закруглённые снежинки (true/false)
						shadow: false, // С тенью (true/false)
						collection: false, // Накапливаются ли снизу, образуя сугробы (true/false)
						collectionHeight: 2000, // Количество накапливаемого снега
						deviceorientation: true // Подстраиваться ли под устройство
					});
				});
			</script>
		<?php endif; ?>

    </head>
    <body>
        <?php if ($currentUser != ''): ?>
			<header>
				<form method = "post">
					<div class = 'container-fluid'>
						<div class = 'row site-header'>
							<div class = 'col title-div'>
								<div><img src = '/public/img/logo.png' alt = ''></div>
								<div class = 'title'>Innovative <?= $module['title'] ?></div>
							</div>
							<div class = 'col-2 user-div'>
								<div class = 'greetings'>Вы авторизованы, как:</div>
								<div><?= $currentUser['description'] ?></div>
							</div>
						</div>
						<div class = 'row page-header'>
							<div class = 'col-2'></div>
							<div class = 'col-2 pre-nav'></div>
							<div class = 'col title'><?= $currentUser['navigation'][$_GET['page']] ?></div>
							<div class = 'col-2'>
								<div class = 'exit'>
									<input type = 'submit' value = 'Выход' name = 'exit'>
								</div>
							</div>
						</div>
					</div>
				</form>
			</header>
			<main>
				<div class = 'container-fluid'>
					<div class = 'row'>
						<div class = 'col-2 nav-main-div'>
							<nav>
								<?php if ($currentUser['navigation'] != ''): ?>
									<?php foreach ($currentUser['navigation'] as $key => $value): ?>
										<a href = '/?page=<?= $key ?>'>
											<div class = 'nav-div'><?= $value ?></div>
										</a>
									<?php endforeach; ?>
								<?php endif; ?>
							</nav>
						</div>
						<div class = 'col'>
							<?php require_once "application/view/{$currentUser['module']}/{$_GET['page']}.php"; ?>
						</div>
					</div>
				</div>
			</main>
			<footer>
				<div class = 'title'>Innovative Pass Office<sup>©</sup> <?= $currentYear ?></div>
				<div class = 'description'>Все права защищены</div>
			</footer>
        <?php else: ?>
			<?php require_once 'application/view/login.php'; ?>
        	<script>$('#login-modal').modal('show');</script>
        <?php endif; ?>
    </body>
</html>