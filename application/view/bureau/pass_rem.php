<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 30.10.2022
 * Time: 1:57
 */
?>

<div class = 'row form-main-div'>
    <div class = 'col'></div>
    <div class = 'col-4'>
        <div class = 'alert alert-info'>Для очистки пропуска приложите его к считывателю!</div>
        <form method = "post" id = 'rem'>
            <input type = 'text' class = 'form-control' id = 'key' name = 'pass_remove' autofocus onkeyup = 'rem()' placeholder = 'Код пропуска' autocomplete = 'off' required>
        </form>
    </div>
    <div class = 'col'></div>
</div>

<script>
    function rem()
    {
        setTimeout(function(){$("#rem").delay(5000).submit();}, 500);

    }
</script>