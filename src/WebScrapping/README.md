# GaloScrapper
## Web Scrapping
Neste segundo exercício você deve capturar os dados de uma página HTML e converter em uma planilha. O arquivo a ser lido é `webscrapping/origin.html`, ele é uma página (com algumas adaptações) de um Proceedings do Galoá. O seu objetivo é extrair as informações sobre trabalhos e montar uma planilha similar a `webscrapping/model.xlsx`.

Para a resolução do exercício, você pode alterar qualquer arquivo dentro da pasta `src/WebScrapping`.

### Como rodar

Dependências:

* PHP - linha de comando
* Extensões do PHP: ZIP, DOM, XML
* [Composer](https://getcomposer.org/)

Rode o seguinte comando para instalar o ambiente:

```
composer install
```

Para rodar o scrapping, rode o seguinte comando:

```
composer webscrapping
```

### Dicas de resolução

Duas ferramentas vão ser especialmente úteis para você resolver este exercício.

* DOM, para ler o HTML - https://www.php.net/manual/pt_BR/class.domdocument.php
* Spout, para escrever a planilha - https://opensource.box.com/spout/

### Obs Adicionais By Luiz Henrique

Existe um código adicional para "consertar" um erro encontrado no DOM utilizado no teste. No item com ID 137475, existe um span que está vazio, que na minha lógica fez pegar uma instituição a mais durante as buscas. Para corrigir e ignorar este item escrevi uma verificação na linha 76-79 que se torna útil apenas para este caso de erro no DOM.