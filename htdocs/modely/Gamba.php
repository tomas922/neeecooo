<?php

class Gamba {

    public $pks;

    // Základní otočení - vygeneruje náhodné číslo pro Pokémona
    public static function Otocit() {
        return random_int(1, 1010); // Pokémoni až do generace 9
    }
    
    // Otočení s váhami - vzácnější Pokémoni mají menší šanci
    public static function OtocitSVahami() {
        $nahodne = random_int(1, 100);
        
        if ($nahodne <= 50) {
            // 50% šance na obyčejné Pokémony (1-386)
            return random_int(1, 386);
        } elseif ($nahodne <= 75) {
            // 25% šance na středně vzácné (387-649)
            return random_int(387, 649);
        } elseif ($nahodne <= 90) {
            // 15% šance na vzácné (650-809)
            return random_int(650, 809);
        } else {
            // 10% šance na velmi vzácné (810-1010)
            return random_int(810, 1010);
        }
    }
    
    // Získá kategorii vzácnosti podle ID
    public static function getVzacnost($pokemonId) {
        if ($pokemonId <= 151) {
            return "Klasický";
        } elseif ($pokemonId <= 386) {
            return "Obyčejný";
        } elseif ($pokemonId <= 649) {
            return "Vzácný";
        } elseif ($pokemonId <= 809) {
            return "Velmi vzácný";
        } else {
            return "Legendární";
        }
    }
    
    // Simuluje výběr ze tří karet
    public static function VyberZeTriKaret() {
        return [
            'karta1' => self::Otocit(),
            'karta2' => self::Otocit(),
            'karta3' => self::Otocit()
        ];
    }
    
    // Zkontroluje jestli má uživatel už tohoto Pokémona
    public static function maPokemona($uzivatelId, $pokemonId) {
        $vysledek = Db::dotazJeden(
            "SELECT id FROM uzivatel_pokemon WHERE uzivatel_id = ? AND pokemon_id = ?",
            [$uzivatelId, $pokemonId]
        );
        
        return $vysledek !== false;
    }
}
?>