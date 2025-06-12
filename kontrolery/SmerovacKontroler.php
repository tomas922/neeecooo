<?php
class SmerovacKontroler extends Kontroler {
  protected $kontroler; // objekt kontroleru
  
  // podle URL ($parametry[0]) "předané z indexu" 
    // nalezne správný kontroler a předá mu řízení 
public function zpracuj($parametry) {
    $url = $parametry[0];
    $castiCesty = $this->parsujURL($url);

    if (empty($castiCesty[0])) {
        $this->presmeruj("uvod");
    } else {
        $castNazvuKontroleru = array_shift($castiCesty);
        $nazevKontroleru = $this->pomlckyDoVelbloudiNotace($castNazvuKontroleru) . "Kontroler";

        if (file_exists("kontrolery/$nazevKontroleru.php")) {
            $this->kontroler = new $nazevKontroleru;

            // Zjistíme, zda je další část URL akce/metoda
            if (!empty($castiCesty)) {
                $akce = array_shift($castiCesty);

                // Převod pomlček na camelCase (např. ulozit-pokemon → ulozitPokemon)
                $akceMetoda = $this->pomlckyDoVelbloudiNotace($akce);
                // malé písmeno na začátku (camelCase)
                $akceMetoda = lcfirst($akceMetoda);

                if (method_exists($this->kontroler, $akceMetoda)) {
                    // Zavoláme danou metodu s případnými dalšími parametry z URL
                    call_user_func([$this->kontroler, $akceMetoda], $castiCesty);
                    
                    // Pokud je to AJAX volání, může být vhodné zde ukončit skript
                    exit;
                } else {
                    // Pokud metoda neexistuje, zavoláme defaultní zpracuj
                    $this->kontroler->zpracuj($castiCesty);
                }
            } else {
                // Žádná akce, zavoláme standardní zpracuj
                $this->kontroler->zpracuj($castiCesty);
            }

            $this->pohled = "rozlozeni";
        } else {
            // TODO: kontroler neexistuje → přesměrovat na chybu nebo 404
            $this->presmeruj("chyba");
        }
    }
}

  
  // z kebab-case do CamelCase // z editace-studenta udělá EditaceStudenta
  private function pomlckyDoVelbloudiNotace($text) {
      $text = str_replace("-", " ", $text);
      $text = ucwords($text);
      $text = str_replace(" ", "", $text);
      return $text;
  }
  
  // z https://localhost/uzivatel/10/editace 
  // udělá pole
  // ["uzivatel", "10", "editace"]
  private function parsujURL($url) {
      $naparsovanaURL = parse_url($url);
      $cesta = $naparsovanaURL["path"];
      
      $cesta = ltrim($cesta, "/"); // odebere počáteční lomítko
      $cesta = trim($cesta); // odebere bílé znaky
      
      $rozdelenaCesta = explode("/", $cesta);
      
      return $rozdelenaCesta;
  }
}