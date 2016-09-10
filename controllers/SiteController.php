<?php

namespace app\controllers;

use app\models\Championates;
use app\models\StatisticMatches;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;


class SiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionShowStatistic()
    {
        $var = StatisticMatches::getAll();
        return $this->render('show-statistic',['statistics'=> $var]);
    }

    /**
     * Displays about page.
     * @var $id string
     * @return string
     */
    public function actionDetail($id)
    {
        $var = StatisticMatches::getOne($id);
        return $this->render('detail',['statistics'=> $var]);
    }

    /**
     * News page.
     *
     * @var $param string
     * @return string
     */
    public function actionBets()
    {
        return $this->render('bets');
    }

    /**
     * News page.
     *
     * @return string
     */
    public function actionInsertStatistic()
    {
        $chemps = Championates::getAll();

        if(isset($_POST['start'])){
            $errors = [];
            $echo = [
                'home' => 'Команда Хозяев',
                'chemp_home' => 'Чемпионат Хозяев',
                'MainGamesHome' => 'Общая статистика Хозяев',
                'GamesInHome' => 'Статистика игор Хозяев Вдома',
                'TableInHome' => 'Таблица Чемпионата Хозяев(Вдома)',
                'guests' => 'Команда Гостей',
                'chemp_guest' => 'Чемпионат Гостей',
                'MainGamesGuests' => 'Общая статистика Гостей',
                'GamesInGuests' => 'Статистика игор Гостей(На выезде)',
                'TableInGuests' => 'Таблица Чемпионата Гостей(На выезде)',
            ];

            foreach ($_POST as $key => $item) {
                if($key != "H2H" && ($item == "" || $item == 'null')){
                    $errors[$key] = 'Незаполненное поле '.$echo[$key];
                }
            }

            if(!empty($errors)){
                return $this->render('insert-statistic',['errors' => $errors,'chemps' => $chemps]);
            }else{
                if(StatisticMatches::insertStatistic($_POST)){
                    return $this->redirect('show-statistic');
                }else{
                    $errors[] = "Не удалось произвести запись!";
                    return $this->render('insert-statistic',['errors' => $errors,'chemps' => $chemps]);
                }
            }

        }

        return $this->render('insert-statistic',['chemps' => $chemps]);
    }

    /**
     * News page.
     *
     * @return string
     */
    public function actionSettingsStatistic()
    {
        return $this->render('settings-statistic');
    }

    /**
     * News page.
     *
     * @return string
     */
    public function actionAddChamp()
    {
        $model = new Championates();
        if(isset($_POST['Championates'])){
            $model->attributes = $_POST['Championates'];
            if($model->validate() && $model->save()){
                return $this->redirect('index');
            }
        }

        return $this->render('add-champ',['model' => $model]);
    }


}
