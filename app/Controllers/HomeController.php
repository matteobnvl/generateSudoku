<?php

namespace App\Controllers;

use App\Models\Sudoku;

class SudokuController
{
    public function index()
    {
        $sudoku = new Sudoku();
        $sudokuGenerate = $sudoku->genererGrilleSudoku();

        $sudokuVide = (isset($_GET['niveau']))
                        ? $sudoku->enleverCasesGrilleSudoku($sudokuGenerate, $_GET['niveau'])
                        : $sudoku->enleverCasesGrilleSudoku($sudokuGenerate);

        $data = [
            'sudoku' => $sudokuVide,
            'solution' => $sudokuGenerate
        ];

        return json_encode($data);
    }
}