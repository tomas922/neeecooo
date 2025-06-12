<?php

// Model pro interakci s API Pokémonů
class Pokemon {
    
    // Metoda pro získání seznamu Pokémonů
    public function getPokemonList($limit = 1000) {
        $url = "https://pokeapi.co/api/v2/pokemon?limit={$limit}";
        $response = file_get_contents($url);
        return json_decode($response, true)['results']; // Vrací seznam Pokémonů
    }

    // Metoda pro získání informací o Pokémona podle jeho jména nebo ID
    public function getPokemonData($input) {
        $url = "https://pokeapi.co/api/v2/pokemon/{$input}";
        $response = file_get_contents($url);
        return json_decode($response, true); // Vrací data jako asociativní pole
    }

    // Metoda pro získání evolučního řetězce pro daného Pokémona
    public function getEvolutionChain($speciesUrl) {
        $response = file_get_contents($speciesUrl);
        $speciesData = json_decode($response, true);

        $evoResponse = file_get_contents($speciesData['evolution_chain']['url']);
        $evoData = json_decode($evoResponse, true);

        $evoChain = [];
        $evoStage = $evoData['chain'];

        while ($evoStage) {
            $evoChain[] = $evoStage['species']['name'];
            $evoStage = $evoStage['evolves_to'] ? $evoStage['evolves_to'][0] : null;
        }

        return $evoChain;
    }
}
?>
