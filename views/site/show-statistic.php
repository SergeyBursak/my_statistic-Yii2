
<h3 align="center">Результаты полученой статистики</h3>
<table class="main_table" align="center" border="1">
    <tr>
        <th>№ Матча</th>
        <th>Хозяева</th>
        <th>Гости</th>
        <th title="Время полученой статистики">Время</th>
        <th title="Показатель проходимости матчей в сезоне - Хозяева">ППСХ</th>
        <th title="Показатель проходимости матчей в сезоне - Гости">ППСГ</th>
        <th title="Показатель проходимости матчей в дома - Хозяева">ППДХ</th>
        <th title="Показатель проходимости матчей на выезде - Гости">ППВГ</th>
        <th title="Показатель проходимости матчей между собой">ПВП</th>
        <th title="Шанс прохода события">Проход</th>
        <th>Статистика</th>
        <th title="Конечный Счет матча">Счет</th>
        <th title="Прошло/Не прошло">Результат</th>
    </tr>
    <?php $i = 0;
    foreach ($statistics as $stat):
        $i++;
        if($stat->shance_success > 70 && $stat->shance_success >= 65) {
            $style = "#47FF47";
            $title = "Ого Очень редкий Результат - Нужно 100% ставить";
            $text = "Очень редкий Результат - Вы можете, да что там, Вы объязаны сделать ставку на этот матч =)";
        }elseif($stat->shance_success < 70 && $stat->shance_success >= 65){
            $style = "yellowgreen";
            $title = "Очень Хороший результат - Можно спокойно ставить";
            $text = "Очень Хороший результат";

        }elseif($stat->shance_success < 65 && $stat->shance_success >= 60){
            $style = "yellow";
            $title = "Хороший результат - Вполне хорошая ставка";
            $text = "Хороший результат";

        }elseif($stat->shance_success < 60 && $stat->shance_success >= 55) {
            $style = "orange";
            $title = "Средний результат - Можно ставить, но риском";
            $text = "Средний результат";

        }elseif($stat->shance_success < 55 && $stat->shance_success >= 50) {
            $style = "#F75727";
            $title = "Плохой результат - Не советуюю ставить";
            $text = "Плохой результат";
        }elseif($stat->shance_success < 50){
            $style = "red";
            $title = "Очень Плохой результат - обходите этот матч мимо";
            $text = "Очень Плохой результат";
        }?>

        <tr>
            <td><?=$stat->id?></td>
            <td><?=$stat->team_home?></td>
            <td><?=$stat->team_guest?></td>
            <td><?=$stat->date?></td>
            <td><?=$stat->h_team_in_season?>%</td>
            <td><?=$stat->g_team_in_season?>%</td>
            <td><?=$stat->h_team_in_home?>%</td>
            <td><?=$stat->g_team_in_guest?>%</td>
            <td><?=$stat->pvp?>%</td>

            <td style="background-color: <?=$style?>" title="<?=$title?>">
                <?=$stat->shance_success?>%
            </td>
            <td><input title="" style="cursor: pointer"  type="button" value="Показать" data-id="<?=$i?>" id="statistic<?=$i?>" class="buttOpen btn btn-info" ></td>
            <td><?=$stat->score?></td>
            <td><?=($stat->result == 'none')?'Не состоялся':$stat->result?></td>
        </tr>
        <tr style="display: none" id="detailStatistic<?=$i?>">
            <td colspan="13">
                <table class="detStat" style="display: inline-table;float: left">
                    <tr style="background-color: #D4D4D4">
                        <td>Рубрика</td>
                        <td><?=$stat->team_home?></td>
                        <td><?=$stat->team_guest?></td>
                    </tr>
                    <tr style="background-color: #C5EAF1">
                        <td>% проходимости матчей в сезоне</td>
                        <td><?=$stat->h_team_in_season?>%</td>
                        <td><?=$stat->g_team_in_season?>%</td>
                    </tr >
                    <tr style="background-color: #C5EAF1">
                        <td>% проходимости матчей Дома/Выезд</td>
                        <td><?=$stat->h_team_in_home?>%</td>
                        <td><?=$stat->g_team_in_guest?>%</td>
                    </tr>
                    <tr style="background-color: #C5EAF1">
                        <td>Забивают в среднем за матч</td>
                        <td><?=$stat->h_chemp_scored?></td>
                        <td><?=$stat->g_chemp_scored?></td>
                    </tr>
                    <tr style="background-color: #C5EAF1">
                        <td>Пропускают в среднем за матч</td>
                        <td><?=$stat->h_chemp_missing?></td>
                        <td><?=$stat->g_chemp_missing?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #74E261" >
                            <span>Возможные результаты матча:</span><br>
                            <span><?=$stat->supposed_score_one?>,</span>
                            <span><?=$stat->supposed_score_two?>,</span>
                            <span><?=$stat->supposed_score_three?>,</span>
                            <span><?=$stat->supposed_score_four?></span>
                        </td>
                        <td style="background-color: #FF5144" colspan="2">Шанс прохода - <?=$stat->shance_success?>%</td>
                    </tr>
                </table>
                <table >
                    <tr>
                        <td style="float:left;">
                            <p style="font-size: 17px">Судя по всем этим данным можно сделать такие выводы:</p>
                            <p>Шанс прохода события у нас составляет <em style="text-decoration: underline"><?=$stat->shance_success?>%</em> - это <?=$text?></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach?>
</table>
