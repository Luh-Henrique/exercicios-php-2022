<?php

namespace Galoa\ExerciciosPhp2022\WebScrapping;

//Importação para utilização do Spout e escrever xlxs.
require_once 'src\Spout\Autoloader\autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

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

    //Criando map com os dados.
    $info = array_combine($arrayID, array_map(null, $arrayTitle, $arrayType, $arrayAuthors));

    //Processo de escrita em arquivo xlxs
    $writer = WriterEntityFactory::createXLSXWriter();

    //O resultado é escrito num arquivo result.xlsx no folder webscrapping onde tambem esta o modelo.
    $writer->openToFile('webscrapping\result.xlsx');

    //Criando linha com os titulos de cada coluna.
    $cells = [
      WriterEntityFactory::createCell('ID'),
      WriterEntityFactory::createCell('Title'),
      WriterEntityFactory::createCell('Type'),
      WriterEntityFactory::createCell('Author 1'),
      WriterEntityFactory::createCell('Author 1 Instituition'),
      WriterEntityFactory::createCell('Author 2'),
      WriterEntityFactory::createCell('Author 2 Instituition'),
      WriterEntityFactory::createCell('Author 3'),
      WriterEntityFactory::createCell('Author 3 Instituition'),
      WriterEntityFactory::createCell('Author 4'),
      WriterEntityFactory::createCell('Author 4 Instituition'),
      WriterEntityFactory::createCell('Author 5'),
      WriterEntityFactory::createCell('Author 5 Instituition'),
      WriterEntityFactory::createCell('Author 6'),
      WriterEntityFactory::createCell('Author 6 Instituition'),
      WriterEntityFactory::createCell('Author 7'),
      WriterEntityFactory::createCell('Author 7 Instituition'),
      WriterEntityFactory::createCell('Author 8'),
      WriterEntityFactory::createCell('Author 8 Instituition'),
      WriterEntityFactory::createCell('Author 9'),
      WriterEntityFactory::createCell('Author 9 Instituition'),
      WriterEntityFactory::createCell('Author 10'),
      WriterEntityFactory::createCell('Author 10 Instituition'),
      WriterEntityFactory::createCell('Author 11'),
      WriterEntityFactory::createCell('Author 11 Instituition'),
      WriterEntityFactory::createCell('Author 12'),
      WriterEntityFactory::createCell('Author 12 Instituition'),
      WriterEntityFactory::createCell('Author 13'),
      WriterEntityFactory::createCell('Author 13 Instituition'),
      WriterEntityFactory::createCell('Author 14'),
      WriterEntityFactory::createCell('Author 14 Instituition'),
      WriterEntityFactory::createCell('Author 15'),
      WriterEntityFactory::createCell('Author 15 Instituition'),
      WriterEntityFactory::createCell('Author 16'),
      WriterEntityFactory::createCell('Author 16 Instituition'),
  ];

  $singleRow = WriterEntityFactory::createRow($cells);
  $writer->addRow($singleRow);

  //Fechando o writer de xlxs.
  $writer->close();

  }

}
