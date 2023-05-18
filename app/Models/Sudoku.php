<?php

namespace App\Models;

class Sudoku
{

    function genererGrilleSudoku()
    {
        $grille = array();

        // Générer une grille vide
        for ($i = 0; $i < 9; $i++) {
            $grille[$i] = array();
            for ($j = 0; $j < 9; $j++) {
                $grille[$i][$j] = 0;
            }
        }

        // Remplir la grille avec des nombres valides
        $this->remplirGrilleSudoku($grille);

        return $grille;
    }

    function remplirGrilleSudoku(&$grille)
    {
        return $this->remplirCase(0, 0, $grille);
    }

    function remplirCase($ligne, $colonne, &$grille)
    {
        if ($colonne == 9) {
            $colonne = 0;
            $ligne++;
            if ($ligne == 9) {
                return true; // Toutes les cases ont été remplies
            }
        }

        if ($grille[$ligne][$colonne] != 0) {
            // Case déjà remplie, passer à la case suivante
            return $this->remplirCase($ligne, $colonne + 1, $grille);
        }

        // Mélanger les nombres possibles
        $nombresPossibles = range(1, 9);
        shuffle($nombresPossibles);

        foreach ($nombresPossibles as $nombre) {
            if ($this->validerPlacement($grille, $ligne, $colonne, $nombre)) {
                $grille[$ligne][$colonne] = $nombre;

                if ($this->remplirCase($ligne, $colonne + 1, $grille)) {
                    return true;
                }
            }
        }

        // Aucun nombre possible pour cette case, réinitialiser la valeur
        $grille[$ligne][$colonne] = 0;

        return false;
    }

    function validerPlacement($grille, $ligne, $colonne, $nombre)
    {
        // Vérifier la ligne
        for ($i = 0; $i < 9; $i++) {
            if ($grille[$ligne][$i] == $nombre) {
                return false;
            }
        }

        // Vérifier la colonne
        for ($i = 0; $i < 9; $i++) {
            if ($grille[$i][$colonne] == $nombre) {
                return false;
            }
        }

        // Vérifier la sous-grille 3x3
        $sousGrilleLigne = floor($ligne / 3) * 3;
        $sousGrilleColonne = floor($colonne / 3) * 3;

        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($grille[$sousGrilleLigne + $i][$sousGrilleColonne + $j] == $nombre) {
                    return false;
                }
            }
        }

        return true;
    }

    function estGrilleSudokuValide($grille)
    {
        // Vérification des lignes
        for ($i = 0; $i < 9; $i++) {
            $ligne = $grille[$i];
            if (!$this->validerGroupe($ligne)) {
                return false;
            }
        }

        // Vérification des colonnes
        for ($j = 0; $j < 9; $j++) {
            $colonne = array();
            for ($i = 0; $i < 9; $i++) {
                $colonne[] = $grille[$i][$j];
            }
            if (!$this->validerGroupe($colonne)) {
                return false;
            }
        }

        // Vérification des sous-grilles 3x3
        for ($i = 0; $i < 9; $i += 3) {
            for ($j = 0; $j < 9; $j += 3) {
                $sousGrille = array();
                for ($x = 0; $x < 3; $x++) {
                    for ($y = 0; $y < 3; $y++) {
                        $sousGrille[] = $grille[$i + $x][$j + $y];
                    }
                }
                if (!$this->validerGroupe($sousGrille)) {
                    return false;
                }
            }
        }

        return true;
    }

    function validerGroupe($groupe)
    {
        $chiffres = array();
        foreach ($groupe as $chiffre) {
            if ($chiffre != 0 && isset($chiffres[$chiffre])) {
                return false; // Le chiffre est déjà présent dans le groupe
            }
            $chiffres[$chiffre] = true;
        }
        return true;
    }


    function enleverCasesGrilleSudoku($grille, $difficulte = 'Easy')
    {
        // Valider la difficulté
        $difficulte = strtolower($difficulte);
        // Déterminer le nombre de cases à enlever en fonction de la difficulté
        $casesAEnlever = 0;
        switch ($difficulte) {
            case 'easy':
                $casesAEnlever = 40;
                break;
            case 'medium':
                $casesAEnlever = 50;
                break;
            case 'hard':
                $casesAEnlever = 60;
                break;
        }

        // Générer un tableau avec toutes les coordonnées possibles
        $coordonnees = array();
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $coordonnees[] = array($i, $j);
            }
        }

        // Mélanger les coordonnées
        shuffle($coordonnees);

        // Enlever les cases en commençant par les coordonnées mélangées
        foreach ($coordonnees as $coordonnee) {
            $ligne = $coordonnee[0];
            $colonne = $coordonnee[1];
            // Supprimer la case de la grille
            $grille[$ligne][$colonne] = 0;

            // Vérifier si la grille reste toujours valide après la suppression de la case

            // Vérifier si suffisamment de cases ont été enlevées
            $casesAEnlever--;
            if ($casesAEnlever <= 0) {
                break;
            }
        }

        return $grille;
    }

    public static function sudoku()
    {
        $sudoku = new Sudoku();
        // génération du sudoku
        $generateSudoku = $sudoku->genererGrilleSudoku();

        $sudokuVide = (isset($_GET['niveau'])) 
                    ? $sudoku->enleverCasesGrilleSudoku($generateSudoku, $_GET['niveau'])
                    : $sudoku->enleverCasesGrilleSudoku($generateSudoku);

        return [
            'sudoku' => $sudokuVide,
            'solution' => $sudoku
        ];
    }
}