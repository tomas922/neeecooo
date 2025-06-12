<?php
class UzivatelIndexKontroler extends Kontroler {
    
    public function zpracuj($parametry) {
        $this->pohled = "uzivatel-index";
        
        session_start();
        
        // Zkontroluj jestli je uživatel přihlášený
        if (!isset($_SESSION['uzivatel_id'])) {
            $this->presmeruj("login");
            return;
        }
        
        // Odhlášení
        if (isset($_POST['odhlasit'])) {
            session_destroy();
            $this->presmeruj("uvod");
            return;
        }
        
        $uzivatelId = $_SESSION['uzivatel_id'];
        
        // Získej uživatele
        $uzivatel = Db::dotazJeden(
            "SELECT * FROM uzivatele WHERE id = ?", 
            [$uzivatelId]
        );
        
        // Získej všechny Pokémony uživatele
        $uzivatelPokemony = Db::dotazVsechny(
            "SELECT * FROM uzivatel_pokemon WHERE uzivatel_id = ? ORDER BY datum_ziskani DESC", 
            [$uzivatelId]
        );
        
        // Získej statistiky
        $pocetPokemonu = count($uzivatelPokemony);
        $posledniPokemon = $pocetPokemonu > 0 ? $uzivatelPokemony[0] : null;
        
        // Získej data o posledním Pokémonovi z API
        $posledniPokemonData = null;
        if ($posledniPokemon) {
            $pokemon = new Pokemon();
            try {
                $posledniPokemonData = $pokemon->getPokemonData($posledniPokemon['pokemon_id']);
            } catch (Exception $e) {
                // Pokud se nepodaří načíst data, pokračuj bez nich
            }
        }
        
        $this->data["uzivatel"] = $uzivatel;
        $this->data["uzivatelPokemony"] = $uzivatelPokemony;
        $this->data["pocetPokemonu"] = $pocetPokemonu;
        $this->data["posledniPokemon"] = $posledniPokemon;
        $this->data["posledniPokemonData"] = $posledniPokemonData;
    }
}
?>