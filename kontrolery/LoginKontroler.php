<?php
class LoginKontroler extends Kontroler {
    
    public function zpracuj($parametry) {
        $this->pohled = "login";
        
        session_start();
        
        $chyba = "";
        $uspech = "";
        
        // Pokud už je uživatel přihlášený, přesměruj na index
        if (isset($_SESSION['uzivatel_id'])) {
            $this->presmeruj("uzivatel-index");
            return;
        }
        
        // Zpracování přihlášení
        if (isset($_POST['prihlasit'])) {
            $uzivatelskejmeno = trim($_POST['uzivatelskejmeno'] ?? '');
            $heslo = $_POST['heslo'] ?? '';
            
            if (empty($uzivatelskejmeno) || empty($heslo)) {
                $chyba = "Vyplň všechna pole!";
            } else {
                $uzivatel = Db::dotazJeden(
                    "SELECT * FROM uzivatele WHERE uzivatelske_jmeno = ?", 
                    [$uzivatelskejmeno]
                );
                
                if ($uzivatel && password_verify($heslo, $uzivatel['heslo'])) {
                    $_SESSION['uzivatel_id'] = $uzivatel['id'];
                    $_SESSION['uzivatelske_jmeno'] = $uzivatel['uzivatelske_jmeno'];
                    $this->presmeruj("uzivatel-index");
                } else {
                    $chyba = "Špatné uživatelské jméno nebo heslo!";
                }
            }
        }
        
        // Zpracování registrace
        if (isset($_POST['registrovat'])) {
            $uzivatelskejmeno = trim($_POST['reg_uzivatelskejmeno'] ?? '');
            $heslo = $_POST['reg_heslo'] ?? '';
            $heslo2 = $_POST['reg_heslo2'] ?? '';
            
            if (empty($uzivatelskejmeno) || empty($heslo) || empty($heslo2)) {
                $chyba = "Vyplň všechna pole!";
            } elseif ($heslo !== $heslo2) {
                $chyba = "Hesla se neshodují!";
            } elseif (strlen($heslo) < 6) {
                $chyba = "Heslo musí mít alespoň 6 znaků!";
            } else {
                // Zkontroluj jestli už uživatel neexistuje
                $existujiciUzivatel = Db::dotazJeden(
                    "SELECT id FROM uzivatele WHERE uzivatelske_jmeno = ?", 
                    [$uzivatelskejmeno]
                );
                
                if ($existujiciUzivatel) {
                    $chyba = "Uživatel s tímto jménem už existuje!";
                } else {
                    // Vytvoř nového uživatele
                    $hesloHash = password_hash($heslo, PASSWORD_DEFAULT);
                    
                    try {
                        Db::vloz("uzivatele", [
                            'uzivatelske_jmeno' => $uzivatelskejmeno,
                            'heslo' => $hesloHash,
                            'datum_registrace' => date('Y-m-d H:i:s')
                        ]);
                        
                        $uspech = "Registrace proběhla úspěšně! Můžeš se přihlásit.";
                    } catch (Exception $e) {
                        $chyba = "Chyba při registraci. Zkus to znovu.";
                    }
                }
            }
        }
        
        $this->data["chyba"] = $chyba;
        $this->data["uspech"] = $uspech;
    }
}
?>