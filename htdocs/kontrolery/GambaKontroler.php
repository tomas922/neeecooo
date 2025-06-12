<?php
class GambaKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $this->pohled = "gamba";

        
        $cislo = -5; 
        $vybranaPokemon = null;
        $zprava = "";

        if (isset($_POST['tocka'])) {
            $cislo = Gamba::Otocit();

            $pokemon = new Pokemon();
            try {
                $vybranaPokemon = $pokemon->getPokemonData($cislo);

                $this->pridejPokemonaDoIndexu($_SESSION['uzivatel_id'], $cislo, $vybranaPokemon['name']);

                $zprava = "Gratulace! Dostal jsi " . ucfirst($vybranaPokemon['name']) . "!";
            } catch (Exception $e) {
                $zprava = "Něco se pokazilo při získávání Pokémona.";
            }
        }

        $this->data["gigus"] = $cislo;
        $this->data["vybranaPokemon"] = $vybranaPokemon;
        $this->data["zprava"] = $zprava;
    }

    // Nová metoda na uložení Pokémona přes AJAX
public function ulozitPokemon($parametry) {
    session_start();
    header('Content-Type: application/json');

    if (!isset($_SESSION['uzivatel_id'])) {
        echo json_encode(['success' => false, 'error' => 'Nejste přihlášen']);
        return;
    }

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (empty($data['pokemon_id']) || empty($data['pokemon_jmeno'])) {
        echo json_encode(['success' => false, 'error' => 'Chybí data o Pokémonovi']);
        return;
    }

    try {
        $this->pridejPokemonaDoIndexu($_SESSION['uzivatel_id'], $data['pokemon_id'], $data['pokemon_jmeno']);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        error_log("Chyba při ukládání Pokémona: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Chyba při ukládání do DB']);
    }
}


    private function pridejPokemonaDoIndexu($uzivatelId, $pokemonId, $pokemonJmeno) {
        try {
            Db::vloz("uzivatel_pokemon", [
                'uzivatel_id' => $uzivatelId,
                'pokemon_id' => $pokemonId,
                'pokemon_jmeno' => $pokemonJmeno,
                'datum_ziskani' => date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            error_log("Chyba při přidávání Pokémona do indexu: " . $e->getMessage());
        }
    }
}
?>
