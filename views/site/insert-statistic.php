
<?php
use yii\widgets\ActiveForm;

ActiveForm::begin();
?>
<h2 align="center">Введите статистику!</h2>

<div class="row">
    <?php
    if(isset($errors)){
        echo '<div class="error-summary">';
        foreach ($errors as $key => $error) {
            echo "<p class='anchor' data-field='$key' style='color: red;cursor: pointer'>$error</p>";
        }
        echo '</div>';
    }
    ?>
    <div class="col-md-6" align="center">
        <span>Команда Хозяев</span>
        <input title="" class="form-control prettyWidth" type="text" name="home" >
        <select title="" name="chemp_home" class="form-control prettyWidth" >
            <option value="null">Выберите Чемпионат Команды</option>
            <?php foreach($chemps as $chemp){
               echo "<option value='$chemp->id'>$chemp->name</option>";
            }?>
        </select><br>

        <span>Общая статистика последних игор Хозяев</span>
        <textarea  title=""  class="form-control"   rows="15" name="MainGamesHome" ></textarea>

        <span>Статистика последних игор Хозяев Вдома</span>
        <textarea  title=""  class="form-control"    rows="15" name="GamesInHome" ></textarea>

        <span>Таблица Чемпионата Хозяев(Вдома)</span>
        <textarea  title=""  class="form-control"   rows="15" name="TableInHome" ></textarea>
    </div>
    <div class="col-md-6"  align="center">
        <span>Команда Гостей</span>
        <input title="" class="form-control prettyWidth" name="guests" type="text"  >
        <select title="" name="chemp_guest" class="form-control prettyWidth" >
            <option value="null">Выберите Чемпионат Команды</option>
            <?php foreach($chemps as $chemp){
                echo "<option value='$chemp->id'>$chemp->name</option>";
            }?>
        </select><br>

        <span>Общая статистика последних игор Гостей</span>
        <textarea  title="" class="form-control" rows="15" name="MainGamesGuests"></textarea>

        <span>Статистика последних игор Гостей (На выезде)</span>
        <textarea  title="" class="form-control"   rows="15" name="GamesInGuests" ></textarea>

        <span>Таблица Чемпионата Гостей(На выезде)</span>
        <textarea  title="" class="form-control" rows="15" name="TableInGuests" ></textarea>
    </div>
    <div class="col-md-12" align="center">
        <span>Очные встречи команд за последние 5 лет (минимум 4-5 матчей)</span>
        <textarea  title="" class="form-control"  rows="10" name="H2H" ></textarea><br>
        <input class="btn btn-success btn-lg" name="start" type="submit" value="Рассчитать!">
    </div>
</div>
<?php ActiveForm::end();?>
