<?php

class PokemonKontroler extends Kontroler {

    private $model;

    public function __construct() {
        $this->model = new Pokemon();
    }

    // Metoda zpracující požadavky
    public function zpracuj($parametry) {
        // Zkontrolujeme, jestli byl předán parametr pro Pokémona (buď ID nebo jméno)
        if (isset($parametry[0])) {
            // Pokud ano, zobrazíme detail daného Pokémona
            $this->showPokemonInfo($parametry[0]);
        } else {
            // Pokud není žádný parametr, zobrazíme seznam Pokémonů
            $this->showPokemonList();
        }
    }

    // Metoda pro zobrazení seznamu Pokémonů
    public function showPokemonList() {
        $pokemonList = $this->model->getPokemonList(); // Načteme seznam Pokémonů
        // Uložíme pohled a data do vlastností
        $this->pohled = "pokemon"; // Nastavíme pohled
        $this->data = ['pokemonList' => $pokemonList]; // Uložíme data
        // Vykreslíme pohled
        //$this->vypisPohled(); //haha velmi funny chat gpt velmi fuuny boa blin
    }

    // Metoda pro zobrazení detailu o konkrétním Pokémonovi
    public function showPokemonInfo($pokemonId) {
        $pokemonData = $this->model->getPokemonData($pokemonId);
        $evolutionChain = $this->model->getEvolutionChain($pokemonData['species']['url']);
        // Uložíme pohled a data do vlastností
        $this->pohled = "pokemon"; // Nastavíme pohled
        $this->data = [
            'pokemonData' => $pokemonData,
            'evolutionChain' => $evolutionChain
        ]; // Uložíme data
        // Vykreslíme pohled
        $this->vypisPohled();
    }

    // Tato metoda je zděděná z třídy Kontroler
    // Jednoduše vykreslí pohled, na který byla nastavena $this->pohled
    // a předá data přes $this->data
}
?>
