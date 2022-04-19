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

    //Logica especial para autores e suas instituições
    $arrayAuthors = array();
    $arrayAux = array();
    $j=0;

    //Para cada conjunto de autores por publicação
    for($i=0;$i<count($arrayAuthorName);$i++){

      //Explode os autores num array adicional
      $aux = explode(';', $arrayAuthorName[$i]);

      $arrayAux = array();

      //Cria um array onde o autor vem seguido de sua instituição.
      foreach($aux as $item){

        if(!empty(trim($item))){
        array_push($arrayAux, $item);

        //Verificação adicional para o erro no item 137475, onde tem uma virgula ao inves de autor em um span dentro do DOM
        if(empty(trim($arrayAuthorInstitution[$j]))){
          $j++;
        }

        //Escreve o nome da instituição correspondente uma posição após o nome do autor.
        array_push($arrayAux, $arrayAuthorInstitution[$j]);
        $j++;
        }
      }
        //Finaliza o array.
        array_push($arrayAuthors, $arrayAux); 
    }
  }

}
