stejny jak pokemon kontroler boa nvm
<?php

class OblPokemonKontroler extends Kontroler {

    private $model;


    public function __construct() {
        $this->model = new Oblpokemon();
    }

public function showPokemonList() {
    $pokemonFromDb = $this->model->getPokemonFromDatabase();

    // Pokud chceš pouze jména z DB
    $pokemonList = [];
    foreach ($pokemonFromDb as $pokemon) {
        // Pokud chceš více info z API, můžeš volat getPokemonData($pokemon['name'])
        // Nebo použij jen data z DB přímo, pokud tam máš dost info.
        $pokemonList[] = $pokemon; // tady můžeš rozšířit dle potřeby
    }

    $this->pohled = "oblpokemon";
    $this->data = ['pokemonList' => $pokemonList];
   // $this->vypisPohled(); bratře a dost už
}






    // Metoda zpracující požadavky
    public function zpracuj($parametry) {
        // Zkontrolujeme, jestli byl předán parametr pro Pokémona (buď ID nebo jméno)
        if (isset($parametry[0])) {
            // Pokud ano, zobrazíme detail daného Pokémona
            $this->showPokemonInfo($parametry[0]);
            //$this->ziskejcislo();
        } else {
            // Pokud není žádný parametr, zobrazíme seznam Pokémonů
            $this->showPokemonList();
            //$this->ziskejcislo();  k nicemu boa
        }


    }

    // Metoda pro zobrazení seznamu Pokémonů dělá chpší bo nevim
   /* public function showPokemonList() { //hažus erorus
         $pokemonList = $this->model->getPokemonList(); // Načteme seznam Pokémonů
        // Uložíme pohled a data do vlastností
        $this->pohled = "oblpokemon"; // Nastavíme pohled
        $this->data = ['pokemonList' => $pokemonList]; // Uložíme data
        // Vykreslíme pohled
        //$this->vypisPohled(); //haha velmi funny chat gpt velmi fuuny boa blin
    }*/

public function ziskejcislo(){
    $this->data["gigus"]= $pokemonId;
}


    // Metoda pro zobrazení detailu o konkrétním Pokémonovi
    public function showPokemonInfo($pokemonId) {
        $pokemonData = $this->model->getPokemonData($pokemonId);
        $evolutionChain = $this->model->getEvolutionChain($pokemonData['species']['url']);
        // Uložíme pohled a data do vlastností
        $this->pohled = "oblpokemon"; // Nastavíme pohled
        $this->data = [
            'pokemonData' => $pokemonData,
            'evolutionChain' => $evolutionChain
        ]; // Uložíme data
        // Vykreslíme pohled
        $this->vypisPohled(); //kdyz neco nebude fungovat zkus to dat zpatky
    }


}
?>
