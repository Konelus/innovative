<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 29.10.2022
 * Time: 23:54
 */
?>

<div class = 'form-main-div'>
    <form method = "post">
        <div class = 'modal' id = 'login-modal'>
            <div class = 'modal-dialog'>
                <div class = 'modal-content'>
                    <div class = 'modal-header'>
                        <div class = 'container-fluid'>
                            <div class = 'row'>
                                <div class = 'title'>Авторизация</div>
                            </div>
                            <?php if ($_POST['authorization']) { ?>
                                <div class = 'row'>
                                    <div class = 'alert alert-danger'>Неверный логин или пароль</div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class = 'modal-body'>
                        <div class = 'container'>
                            <div class = 'row'>
                                <div class = 'col modal-body-content'>
                                    <div class = 'row input-row'>
                                        <div class = 'col-4 modal-label-div'>
                                            <label for = 'login'>Логин</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'text' class = 'form-control' id = 'login' name = 'login' placeholder = 'Логин' required>
                                        </div>
                                    </div>
                                    <div class = 'row input-row'>
                                        <div class = 'col-4 modal-label-div'>
                                            <label for = 'password'>Пароль</label>
                                        </div>
                                        <div class = 'col input-div'>
                                            <input type = 'password' class = 'form-control' id = 'password' name = 'password' placeholder = 'Пароль' required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = 'modal-footer'>
                        <input type = 'submit' class = 'btn btn-success' value = 'Войти' name = 'authorization'>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
