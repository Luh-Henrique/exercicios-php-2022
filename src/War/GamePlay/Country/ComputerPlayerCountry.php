<?php

namespace Galoa\ExerciciosPhp2022\War\GamePlay\Country;

/**
 * Defines a country that is managed by the Computer.
 */
class ComputerPlayerCountry extends BaseCountry {

  /**
   * Choose one country to attack, or none.
   *
   * The computer may choose to attack or not. If it chooses not to attack,
   * return NULL. If it chooses to attack, return a neighbor to attack.
   *
   * It must NOT be a conquered country.
   *
   * @return \Galoa\ExerciciosPhp2022\War\GamePlay\Country\CountryInterface|null
   *   The country that will be attacked, NULL if none will be.
   */
  public function chooseToAttack(): ?CountryInterface {
    // @TODO

    //Caso vai atacar e tem tropas para isso.
    if(rand(0,1) == 1 && $this->getNumberOfTroops()>1){

        //Pega um alvo aleatorio dentro dos seus vizinhos.
        $target = $this->arr_neighbors[array_rand($this->arr_neighbors)];
        
        //Enquanto seu alvo ja tiver sido conquistado continua procurando quem é o atual dono do territorio (quem o conquistou).
        while($target->isConquered()){
            $target = $target->getConquer();
          }

        //Retorna o alvo final.
        return $target;
    }

    //Caso não vá atacar.
    else{
      return null;
    }
}
}