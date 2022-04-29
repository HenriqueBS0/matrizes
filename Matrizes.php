<?php

class Matrizes
{

    // Essa funçaão conta o número de elementos do primeiro elemento da matriz, pois cada linha tem um elemento pertencente a uma coluna
    public static function getNumeroColunas(array $matriz): int
    {
        return count($matriz[0]);
    }

    //Essa função conta o número de elementos de uma matriz
    public static function getNumeroLinhas(array $matriz): int
    {
        return count($matriz);
    }

    //Essa função verifica se todas as linhas tem o mesmo numero de elementos
    public static function isMatrizValida(array $matriz): bool
    {
        $numeroColunas = count($matriz[0]);

        foreach ($matriz as $linha) {
            if (count($linha) !== $numeroColunas) {
                return false;
            }
        }

        return true;
    }

    //Essa função verifica se duas matrizes tem o mesmo número de linhas e colunas
    public static function hasMesmaOrdem($matrizUm, $matrizDois): bool
    {
        $mesmoNumeroDeLinhas = self::getNumeroLinhas($matrizUm) === self::getNumeroLinhas($matrizDois);
        $mesmoNumeroDeColunas = self::getNumeroColunas($matrizUm) === self::getNumeroColunas($matrizDois);

        return $mesmoNumeroDeLinhas && $mesmoNumeroDeColunas;
    }


    //Essa função verifica se é uma matriz válida então percorre todos os elementos das duas matrizes criando uma nova com a soma dos elementos 
    public static function soma(array $matrizUm, array $matrizDois): array
    {
        if (!self::isMatrizValida($matrizUm)) {
            throw new Exception("A matriz um não possuí o mesmo número de elementos em todas as linhas");
        } else if (!self::isMatrizValida($matrizDois)) {
            throw new Exception("A matriz dois não possuí o mesmo número de elementos em todas as linhas");
        } else if (!self::hasMesmaOrdem($matrizUm, $matrizDois)) {
            throw new Exception("As matrizes informadas não possuem a mesma ordem");
        }

        $matrizResultante = [];

        $numeroLinhas = self::getNumeroLinhas($matrizUm);
        $numeroColunas = self::getNumeroColunas($matrizUm);

        for ($linha = 0; $linha < $numeroLinhas; $linha++) {
            for ($coluna = 0; $coluna < $numeroColunas; $coluna++) {
                $matrizResultante[$linha][$coluna] = $matrizUm[$linha][$coluna] + $matrizDois[$linha][$coluna];
            }
        }

        return $matrizResultante;
    }

    //Essa função verifica se é uma matriz válida então percorre todos os elementos das duas matrizes criando uma nova com a subtração dos elementos
    public static function subtrai(array $matrizUm, array $matrizDois): array
    {
        if (!self::isMatrizValida($matrizUm)) {
            throw new Exception("A matriz um não possuí o mesmo número de elementos em todas as linhas");
        } else if (!self::isMatrizValida($matrizDois)) {
            throw new Exception("A matriz dois não possuí o mesmo número de elementos em todas as linhas");
        } else if (!self::hasMesmaOrdem($matrizUm, $matrizDois)) {
            throw new Exception("As matrizes informadas não possuem a mesma ordem");
        }

        $matrizResultante = [];

        $numeroLinhas = self::getNumeroLinhas($matrizUm);
        $numeroColunas = self::getNumeroColunas($matrizUm);

        for ($linha = 0; $linha < $numeroLinhas; $linha++) {
            for ($coluna = 0; $coluna < $numeroColunas; $coluna++) {
                $matrizResultante[$linha][$coluna] = $matrizUm[$linha][$coluna] - $matrizDois[$linha][$coluna];
            }
        }

        return $matrizResultante;
    }

    //Essa função multiplica a primeira matriz pela segunda, para isso ela verifica se o número de colunas da primeira é igual ao número de linhas da segunda, então percorre as linhas da primerira matriz e as colunas da segunda e salva os resultados de linhas * coluna na matriz resultate
    public static function multiplica(array $matrizUm, array $matrizDois): array
    {
        if (!self::isMatrizValida($matrizUm)) {
            throw new Exception("A matriz um não possuí o mesmo número de elementos em todas as linhas");
        } else if (!self::isMatrizValida($matrizDois)) {
            throw new Exception("A matriz dois não possuí o mesmo número de elementos em todas as linhas");
        } else if (self::getNumeroColunas($matrizUm) !== self::getNumeroLinhas($matrizDois)) {
            throw new Exception("As o número de colunas da matriz um é diferente do número de linhas da matriz dois");
        }

        $matrizResultante = [];
 
        $numeroElementos = self::getNumeroColunas($matrizUm);

        $linhasMatrizUm = self::getNumeroLinhas($matrizUm);
        $colunasMatrizDois = self::getNumeroColunas($matrizDois);

        for ($i = 0; $i < $linhasMatrizUm; $i++) {
            $matrizResultante[$i] = [];
            for ($j = 0; $j < $colunasMatrizDois; $j++) {
                $matrizResultante[$i][] = 0;
                for ($e = 0; $e < $numeroElementos; $e++) {
                    $matrizResultante[$i][$j] += $matrizUm[$i][$e] * $matrizDois[$e][$j];
                }
            }
        }

        return $matrizResultante;
    }


    //Essa função verifica se o número de linhas é igual ao número de colunas
    private static function isMatrizQuadrada($matriz) : bool
    {
        return self::getNumeroLinhas($matriz) === self::getNumeroColunas($matriz);
    }


    //Essa função verifica da um retorno de acordo com a ordem da matriz:
        // Caso ordem um retorna o elemento
        // Caso ordem dois retorna a multiplicação da diagonal principal menos a multiplicação da diagonal secundária
        // Caso a ordem seja maior que 3 passa pelos elementos da primeira linha somando o a multiplicação dele pelo seu cofator
    public static function determinante(array $matriz): float
    {
        if (!self::isMatrizValida($matriz)) {
            throw new Exception("A matriz não possuí o mesmo número de elementos em todas as linhas");
        }
        if (!self::isMatrizQuadrada($matriz)) {
            throw new Exception("A matriz não é quadrada");
        }

        if (self::getNumeroLinhas($matriz) === 1) {
            return $matriz[0][0];
        } else if (self::getNumeroLinhas($matriz) === 2) {
            return $matriz[0][0] * $matriz[1][1] - $matriz[0][1] * $matriz[1][0];
        }

        $primeiraLinha = $matriz[0];

        $determinante = 0;

        foreach ($primeiraLinha as $indice => $elemento) {
            $determinante += $elemento * self::cofator($matriz, 1, ($indice + 1));
        }

        return $determinante;
    }

    // Essa função retorna -1 elevado a posicao da linha mais a coluna tudo isso vezes o menor do elemento
    private static function cofator(array $matriz, int $linha, int $coluna): float
    {
        return pow(-1, ($linha + $coluna)) * self::menor($matriz, $linha, $coluna);
    }

    // Essa função remove uma linha e uma coluna da matriz e então retorna a determinante dessa
    private static function menor(array $matriz, int $linha, int $coluna): float
    {
        $matriz = self::removerColunaMatriz($coluna, self::removerLinhaMatriz($linha, $matriz));
        return self::determinante($matriz);
    }


    // Essa função remove o elemento do array que corresponde a linha da matriz na posicao indicada pela linha
    private static function removerLinhaMatriz(int $linha, array $matriz): array
    {
        return self::removerElementoArrayPelaPosicao($linha, $matriz);
    }

    // Essa função cria uma nova matriz, ela passa percorrendo a matriz original exclui da linha um elemento correspondente a coluna informada e então retorna salva esse resultado na linha da cova matriz
    private static function removerColunaMatriz(int $coluna, array $matriz): array
    {
        $novaMatriz = [];

        foreach ($matriz as $linha) {
            $novaMatriz[] = self::removerElementoArrayPelaPosicao($coluna, $linha);
        }

        return $novaMatriz;
    }


    // Essa função cria um novo array sem o elemento que ocupa a posicao informada no array informado
    private static function removerElementoArrayPelaPosicao(int $posicao, array $array): array
    {
        $novoArray = [];

        foreach ($array as $indice => $elemento) {
            if ($indice !== ($posicao - 1)) {
                $novoArray[] = $elemento;
            }
        }

        return $novoArray;
    }

    //Essa função gera uma matriz com os cofatores de uma matriz
    private static function getMatrizCofatores(array $matriz) : array
    {
        $matrizCofatores = [];

        for($linha = 0; $linha < self::getNumeroLinhas($matriz); $linha++) {
            $matrizCofatores[$linha] = [];

            for ($coluna=0; $coluna < self::getNumeroColunas($matriz); $coluna++) { 
                $matrizCofatores[$linha][] = self::cofator($matriz, ($linha + 1), ($coluna + 1));
            }
        }

        return $matrizCofatores;
    }

    // Essa função cria uma matriz trasposta a partir da matriz informada
    private static function transposta(array $matriz) : array 
    {
        $transposta = [];

        for ($coluna=0; $coluna < self::getNumeroColunas($matriz); $coluna++) { 
            $transposta[] = [];

            foreach ($matriz as $linha => $elemento) {
                $transposta[$coluna][$linha] = $elemento[$coluna];
            }
        }

        return $transposta;
    }

    // Essa função retorna a matriz adjunta de uma matriz, ou seja a transposta da matriz de cofatores da matriz informada como parametro
    private static function adjunta(array $matriz): array 
    {
        return self::transposta(self::getMatrizCofatores($matriz));
    }

    // Essa função percorre os elementos de uma matriz e multiplica eles pelo valor informado
    private static function multiplicaMatrizPorNumero(array $matriz, float $numero): array
    {
        for($linha = 0; $linha < self::getNumeroLinhas($matriz); $linha++) {
            for ($coluna = 0; $coluna < self::getNumeroColunas($matriz); $coluna++) {
                $matriz[$linha][$coluna] *= $numero;
            }
        }

        return $matriz;
    }

    //Para fazer a inversa de uma matriz ele verifica se a determinante é diferente de zero, caso seja retorna a matriz adjunta multiplicada por 1 dividido pela determinante
    public static function inversa(array $matriz): array
    {
        $determinante = self::determinante($matriz); 

        if ($determinante == 0) {
            throw new Exception("A determinante da matriz é igual a 0", 1);
        }

        return self::multiplicaMatrizPorNumero(self::adjunta($matriz), (1/$determinante));
    }
}