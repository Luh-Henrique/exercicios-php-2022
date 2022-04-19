<?php

namespace Galoa\ExerciciosPhp2022\WebScrapping;

//Importando bibliotecas necessarias para manipulação do DOM
use DOMNodeList;
use DOMXPath;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper {

  //Função adicional para tranformar DOMNodeList em array para melhor manipulação de dados
  function DOMtoArray(DOMNodeList $domItem): array{

    $array = array();

    foreach($domItem as $i){
      array_push($array, $i->textContent);
    }

    return $array;
}

  /**
   * Loads paper information from the HTML and creates a XLSX file.
   */
  public function scrap(\DOMDocument $dom): void {
    
    //Inicializa o XPath para manipular e capturar dados do DOM.
    $xPath = new DOMXPath($dom);

    //Realiza as buscas dos dados no DOM.
    $ids = $xPath->query('.//div[@class="volume-info"]');
    $titles = $xPath->query('.//h4[@class="my-xs paper-title"]');
    $types = $xPath->query('.//div[@class="tags mr-sm"]');
    $authorNames = $xPath->query('.//div[@class="authors"]');
    $authorInstitutions = $xPath->query('.//div[@class="authors"]/span/@title');

    //Transformando os DOMNodeList em array padrão para melhor manipulação dos dados.
    $arrayID = $this->DOMtoArray($ids);
    $arrayTitle = $this->DOMtoArray($titles);
    $arrayType  = $this->DOMtoArray($types);
    $arrayAuthorName = $this->DOMtoArray($authorNames);
    $arrayAuthorInstitution = $this->DOMtoArray($authorInstitutions);
  }

}
