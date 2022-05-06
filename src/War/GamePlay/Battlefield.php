<?php

namespace Galoa\ExerciciosPhp2022\War\GamePlay;

use Galoa\ExerciciosPhp2022\War\GamePlay\Country\CountryInterface;

/**
 * A manager that will roll the dice and compute the winners of a battle.
 */
class Battlefield implements BattlefieldInterface
{

    /**
     * Roda os dados para um país de acordo com as regras.
     *
     */
    public function rollDice(CountryInterface $country, bool $isAtacking): array
    {

        //Inicializa o array que vai ser retornado
        $array = array();

        //Pega o numero de tropas do país
        $aux_troops = $country->getNumberOfTroops();

        //Caso esteja atacando deixa uma tropa
        if ($isAtacking) {
            $aux_troops -= 1;
        }

        //Gera os valores do array do tamanho da tropa
        for ($i = 0; $i < ($aux_troops); $i++) {
            array_push($array, random_int(1, 6));
        }

        //Organiza o array do maior pro menor como descrito nas regras
        rsort($array);

        //Retorna o array gerado.
        return $array;
    }

    /**
     * Calcula os vencedores e perdedores de uma batalha.
     *
     */
    public function computeBattle(CountryInterface $attackingCountry, array $attackingDice, CountryInterface $defendingCountry, array $defendingDice): void
    {

        //Realiza as batalhas verificando o valor de cada tropa.

        for ($i = 0; $i < count($attackingDice) && $i < count($defendingDice); $i++) {

            //Caso o numero analisado do atacante seja maior ou igual ao do defensor, o atacante ganha.
            if ($attackingDice[$i] >= $defendingDice[$i]) {
                $defendingCountry->killTroops(1);
            }

            //Caso o do defensor seja maior o defensor ganha.
            else {
                $attackingCountry->killTroops(1);
            }
        }

        //Caso no final da batalha o time defensor perca todas as tropas.
        if ($defendingCountry->getNumberOfTroops() <= 0) {

            //Define como um pais conquistado, passando o nome de seu conquistador
            $defendingCountry->setConquered($attackingCountry);
        }
    }
}
