<?php

namespace App\Service;

class RouletteService
{
    public const CHANCE_OPTIONS = [
        [0,140], //14% => 10$
        [141,530], //39% => Lose
        [531,750], // 21% => 2$
        [751,780], // 3% => 40$
        [781,850], // 7% => 10$
        [851,854], // 0.4% => 100$
        [825,870], // 4.5% => 20$
        [871,996], // 12.5% => Lose
        [997,999], // 0.3% => 100$
        [1000,1000], // 0.1 => 1000$
    ];

    public function getNumber(){
        $random = rand(0,1000);
        for($i=0;$i<count(self::CHANCE_OPTIONS);$i++){
            if(self::CHANCE_OPTIONS[$i][0] <= $random and $random <= self::CHANCE_OPTIONS[$i][1]){
                return $i;
            }
        }
    }
}