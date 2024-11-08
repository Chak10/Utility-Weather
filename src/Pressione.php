<?php

namespace WtConverter;

class Pressure {

    public $res = false;

    // Mappa di conversione per i fattori di conversione tra le unità di pressione
    private static $conversionMap = [
        'hpa' => [
            'atm' => 0.00098692326671601, // Fattore di conversione da hPa a atm
            'torr' => 0.75006157818041,   // Fattore di conversione da hPa a Torr
        ],
        'atm' => [
            'hpa' => 1013.25,             // Fattore di conversione da atm a hPa
            'torr' => 760,                // Fattore di conversione da atm a Torr
        ],
        'torr' => [
            'hpa' => 1.33322387,          // Fattore di conversione da Torr a hPa
            'atm' => 0.001315789474,      // Fattore di conversione da Torr a atm
        ],
    ];

    /**
     * Costruttore della classe Pressure.
     * @param float|null $pres Il valore della pressione da convertire.
     * @param string|null $unit_in L'unità di partenza della pressione (hpa, atm, torr).
     * @param string|null $unit_out L'unità di destinazione della pressione (hpa, atm, torr).
     */
    function __construct($pres = null, $unit_in = null, $unit_out = null) {
        if ($pres !== null && is_numeric($pres)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);

            // Se le unità di input e output sono uguali, ritorna il valore di input
            if ($unit_in === $unit_out) {
                $this->res = $pres;
            }
            // Se esiste una conversione valida, applica il fattore di conversione
            elseif (isset(self::$conversionMap[$unit_in][$unit_out])) {
                $this->res = $pres * self::$conversionMap[$unit_in][$unit_out];
            }
        }
    }

    /**
     * Ritorna il risultato della conversione.
     * @return float Il valore della pressione convertita.
     */
    public function getResult() {
        return $this->res;
    }

}
