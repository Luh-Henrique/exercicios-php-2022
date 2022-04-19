<?php

namespace Galoa\ExerciciosPhp2022\War\GamePlay\Country;

/**
 * Defines a country, that is also a player.
 */
class BaseCountry implements CountryInterface {

  /**
   * The name of the country.
   *
   * @var string
   */
  protected $name;

  /**
   * O array com os vizinhos do país.
   *
   * @var array
   */
  protected $arr_neighbors;

  /**
   * A flag de conquistado ou não.
   *
   * @var bool
   */
  protected $conquered;

  /**
   * O país conquistador caso tenha sido conquistado.
   *
   * @var CountryInterface
   */
  protected $conquerorCountry;

  /**
   * Numero de paises conquistados por este pais, para ser usado ao dar tropas no inicio do round.
   *
   * @var int
   */
  protected $num_conquered;

  /**
   * Numero de tropas do país.
   *
   * @var int
   */
  protected $troops;

  /**
   * Retorna o nome do país.
   * 
   * @return string
   */

  public function getName(): string{
    return $this->name;
  }

  /**
   * Modifica os vizinhos do país.
   * 
   * @return void
   */

  public function setNeighbors(array $neighbors): void{
    $this->arr_neighbors = $neighbors;
  }

  /**
   * Retorna os vizinhos do país.
   * 
   * @return array
   */

  public function getNeighbors(): array{
    return $this->arr_neighbors;
  }

  /**
   * Retorna o numero de tropas do país.
   * 
   * @return int
   */

  public function getNumberOfTroops(): int{
    return $this->troops;
  }

  /** 
   * Renova as tropas ao inicio de cada round como descrito nas regras.
   * 
   */
  public function giveTroops(): void{
    $this->troops+=(3+($this->num_conquered));
  }

   /**
   * Retorna se o pais esta conquistado.
   * 
   * @return bool
   */

  public function isConquered(): bool{
    return $this->conquered;
  }

  /**
   * Define o país como conquistado e define o nome do consquistador.
   * 
   * @return void
   */

  public function setConquered(CountryInterface $conquerorCountry): void{
    $this->conquered = true;
    $this->conquerorCountry = $conquerorCountry;
  }

  /**
   * Retorna o conquistador do pais caso haja um.
   * 
   * @return CountryInterface | null
   */

  public function getConquer(): CountryInterface | null{
    return $this->conquerorCountry;
  }
  
  /**
   * Chamado quando um pais perde suas tropas e é conquistada.
   * @return void
   */
  public function conquer(CountryInterface $conqueredCountry): void{

    
    //Cria um array temporario somando os vizinhos do pais com o pais conquistado
    $newNeighbors = array_unique(array_merge($this->getNeighbors(), $conqueredCountry->getNeighbors()), SORT_REGULAR);

    //Remove as ocorrencias do pais conquistado e do pais conquistador
    unset($newNeighbors[array_search($conqueredCountry, $newNeighbors)]);
    unset($newNeighbors[array_search($this, $newNeighbors)]);
    
    //Remove paises ja conquistados pelo conquistador ou pelo pais conquistado.
    foreach($newNeighbors as $key => $country){
      if($country->getConquer() === $this || $country->getConquer() === $conqueredCountry){ 
        unset($newNeighbors[$key]);
      }
    }

    //Atualiza os vizinhos
    $this->arr_neighbors = array_values($newNeighbors);
    
    //Define o pais conquistado e adiciona 1 no numero de conquistados do conquistador
    $conqueredCountry->setConquered($this);
    $this->num_conquered++;
  }

  /**
   * Decreases the number of troops in this country by a given number.
   * @return void
   */
  public function killTroops(int $killedTroops): void{
    $this->troops-=$killedTroops;
  }

  /**
   * Builder.
   *
   * @param string $name
   *   The name of the country.
   */
  public function __construct(string $name) {
    $this->name = $name;
    $this->troops = 3;
    $this->conquered = false;
    $this->num_conquered = 0;
  }

}
