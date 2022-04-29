<?php

require_once('Matrizes.php');

$matriz = [
    [3, 2, -1],
    [1, 6,  3],
    [2, -4, 0],
];

try {

    define('ENTER', '
');

    print('Soma:'.ENTER);
    print_r(Matrizes::soma($matriz, $matriz));

    print('Subtração:'.ENTER);
    print_r(Matrizes::subtrai($matriz, $matriz));

    print('Multiplicação:'.ENTER);
    print_r(Matrizes::multiplica($matriz, $matriz));

    print('Determinante: ');
    print_r(Matrizes::determinante($matriz, $matriz));
    print(ENTER);

    print('Inversa:'.ENTER);
    print_r(Matrizes::inversa($matriz, $matriz));
} catch (Exception $ex) {
    echo $ex->getMessage();
}