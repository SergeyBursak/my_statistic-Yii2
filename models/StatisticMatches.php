<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;

/**
 * This is the model class for table "statistic_matches".
 *
 * @property integer $id
 * @property string $team_home
 * @property string $team_guest
 * @property string $date
 * @property string $h_team_in_season
 * @property string $g_team_in_season
 * @property string $h_team_in_home
 * @property string $g_team_in_guest
 * @property string $h_chemp_scored
 * @property string $h_chemp_missing
 * @property string $g_chemp_scored
 * @property string $g_chemp_missing
 * @property string $pvp
 * @property string $supposed_score_one
 * @property string $supposed_score_two
 * @property string $supposed_score_three
 * @property string $supposed_score_four
 * @property string $shance_success
 * @property string $score
 * @property string $result
 */
class StatisticMatches extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statistic_matches';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_home', 'team_guest', 'h_team_in_season', 'g_team_in_season', 'h_team_in_home', 'g_team_in_guest', 'h_chemp_scored', 'h_chemp_missing', 'g_chemp_scored', 'g_chemp_missing', 'pvp', 'supposed_score_one', 'supposed_score_two', 'supposed_score_three', 'supposed_score_four', 'shance_success'], 'required'],
            [['date'], 'safe'],
            [['result'], 'string'],
            [['team_home', 'team_guest'], 'string', 'max' => 100],
            [['h_team_in_season', 'g_team_in_season', 'h_team_in_home', 'g_team_in_guest', 'h_chemp_scored', 'h_chemp_missing', 'g_chemp_scored', 'g_chemp_missing', 'shance_success', 'score'], 'string', 'max' => 5],
            [['pvp'], 'string', 'max' => 15],
            [['supposed_score_one', 'supposed_score_two', 'supposed_score_three', 'supposed_score_four'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_home' => 'Team Home',
            'team_guest' => 'Team Guest',
            'date' => 'Date',
            'h_team_in_season' => 'H Team In Season',
            'g_team_in_season' => 'G Team In Season',
            'h_team_in_home' => 'H Team In Home',
            'g_team_in_guest' => 'G Team In Guest',
            'h_chemp_scored' => 'H Chemp Scored',
            'h_chemp_missing' => 'H Chemp Missing',
            'g_chemp_scored' => 'G Chemp Scored',
            'g_chemp_missing' => 'G Chemp Missing',
            'pvp' => 'Pvp',
            'supposed_score_one' => 'Supposed Score One',
            'supposed_score_two' => 'Supposed Score Two',
            'supposed_score_three' => 'Supposed Score Three',
            'supposed_score_four' => 'Supposed Score Four',
            'shance_success' => 'Shance Success',
            'score' => 'Score',
            'result' => 'Result',
        ];
    }

    public static function getAll(){
        $data = self::find()->all();
        return $data;
    }

    public static function getOne($id){
        $data = self::find()->where(['id' => $id])->one();
        return $data;
    }

    public static function insertStatistic($param){

        $trueResult = ["1-0","2-0","2-1","0-1","1-1","1-2"];

        $h_proc_in_season = self::getStatistic(trim($param['MainGamesHome']));
        $g_proc_in_season = self::getStatistic(trim($param['MainGamesGuests']));
        $h_proc_in_home = self::getStatistic(trim($param['GamesInHome']));
        $g_proc_in_guest = self::getStatistic(trim($param['GamesInGuests']));
        $statChempHome = self::getStatChamp(trim($param['TableInHome']),trim($param['home']));
        $statChempGuest = self::getStatChamp(trim($param['TableInGuests']),trim($param['guests']));
        $pvp = self::getStatistic(trim($param['H2H']));

        $chemp_home = Championates::getOne($param['chemp_home']);
        $chemp_guest = Championates::getOne($param['chemp_guest']);

        $hps = ($h_proc_in_season+$chemp_home)/2*0.85;
        $gps = ($g_proc_in_season+$chemp_guest)/2*0.85;
        $hph = ($h_proc_in_home+$chemp_home)/2*1.15;
        $gpg = ($g_proc_in_guest+$chemp_guest)/2*1.15;

        if($pvp == 0){
            $pvp_avr = ($chemp_home+$chemp_guest)/2;
        }else{
            $pvp_avr = ($pvp+$chemp_home+$chemp_guest)/3;
        }
        $proc_success = round(((((($pvp_avr+$hps+$gps)/3)+$hph)/2)+$gpg)/2,2);
        $gol_1 = ($statChempHome['chemp_scored']*1.2+$statChempGuest['chemp_missing']*1.2)/2;
        $gol_2 = ($statChempGuest['chemp_scored']*0.8+$statChempHome['chemp_missing']*0.8)/2;

        $score = [
            "supposed_score_one" => ceil($gol_1) ."-".floor($gol_2),
            "supposed_score_two" => ceil($gol_1) ."-".ceil($gol_2),
            "supposed_score_three" => floor($gol_1) ."-".floor($gol_2),
            "supposed_score_four" => floor($gol_1) ."-".ceil($gol_2),
        ];

        $i = 0;
        foreach ($score as $item) {
            if(!in_array($item,$trueResult)){
                $i += 5;
            }
        }
        if($i == 0 ){
            $proc_success += 5;
        }else{
            $proc_success -= $i;
        }


        $insert = new StatisticMatches();
        $insert->team_home = $param['home'];
        $insert->team_guest = $param['guests'];
        $insert->h_team_in_season = strval($h_proc_in_season);
        $insert->g_team_in_season = strval($g_proc_in_season);
        $insert->h_team_in_home = strval($h_proc_in_home);
        $insert->g_team_in_guest = strval($g_proc_in_guest);
        $insert->h_chemp_scored = strval($statChempHome['chemp_scored']);
        $insert->h_chemp_missing = strval($statChempHome['chemp_missing']);
        $insert->g_chemp_scored = strval($statChempGuest['chemp_scored']);
        $insert->g_chemp_missing = strval($statChempGuest['chemp_missing']);
        $insert->pvp = strval($pvp);
        $insert->supposed_score_one = strval($score['supposed_score_one']);
        $insert->supposed_score_two =  strval($score['supposed_score_two']);
        $insert->supposed_score_three = strval($score['supposed_score_three']);
        $insert->supposed_score_four =  strval($score['supposed_score_four']);
        $insert->shance_success = strval($proc_success);
        if($insert->save()){
            return true;
        }else{
            return false;
        }
    }


    private static function getStatistic($games){
        $trueResult = ["1-0","2-0","2-1","0-1","1-1","1-2"];
        $score = [];
        $count = 0;

        $games = str_replace(" ","",$games);
        $arr = explode(":",$games);
        foreach ($arr as $key => $item) {
            if($key >= 1){
                $score[] = $item{0};
            }
        }
        array_splice($arr, -1);

        foreach ($arr as $key => &$item) {
            $item .= "-".$score[$key];
            $item = substr($item,-3);

            if(in_array($item,$trueResult)){
                $count++;
            }
        }

        if($count == 0 ){
            $percent = 0;
        }else{
            $percent = round($count / count($arr) * 100,2);

        }
        return $percent;

    }

    private static function getStatChamp($table,$comand){

        $TableHome = str_replace(" ","",$table);
        $arr = explode(".",$TableHome);
        array_splice($arr,0, 1);
        $result = [];
        $team = "";
        $count = count($arr)-1;
        foreach ($arr as $key => &$item) {
            $item = substr($item,1);
            if($key != $count){
                $item = substr($item,0,strlen($item)-6);
            }

            $team = str_replace(" ","",$comand);

            $pos = strripos($item, $team);
            if ($pos !== false) {
                $result = ["Table_place" => $key];
            }
        }

        $string = str_replace($team,"",$arr[$result['Table_place']]);
        $string = preg_replace("/[^x\d|*\.]/","|",$string);
        $string = substr($string,1);
        $arr_res = explode("|",$string);


        $match_count = $arr_res[0];
        $scored  = $arr_res[4];
        $missing = $arr_res[5];

        $arrayTable = [
            "chemp_scored" => round($scored/$match_count, 2),
            "chemp_missing" => round($missing/$match_count, 2),
        ];

        return $arrayTable;
    }

}
