<?php

namespace WtConverter;

class Rain {
    
    public $res = false;

    // Mappa dei fattori di conversione per diverse unità di misura della pioggia (mm e in).
    private static $conversionMap = [
        'mm' => ['in' => 0.039370078740157], // 1 mm = 0.03937 pollici
        'in' => ['mm' => 25.4],              // 1 pollice = 25.4 mm
    ];

    /**
     * Costruttore della classe Rain.
     * @param float|null $rain Il valore della precipitazione da convertire.
     * @param string|null $unit_in L'unità di partenza della precipitazione (mm o in).
     * @param string|null $unit_out L'unità di destinazione della precipitazione.
     */
    function __construct($rain = null, $unit_in = null, $unit_out = null) {
        if ($rain !== null && is_numeric($rain)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);
            
            // Se le unità di input e output sono le stesse, ritorna il valore di input
            if ($unit_in === $unit_out) {
                $this->res = $rain;
            }
            // Se esiste un fattore di conversione valido, applicalo
            elseif (isset(self::$conversionMap[$unit_in][$unit_out])) {
                $this->res = $rain * self::$conversionMap[$unit_in][$unit_out];
            }
        }
    }

    /**
     * Metodo statico per convertire da millimetri a pollici.
     * @param float $n Il valore in millimetri.
     * @return float Il valore convertito in pollici.
     */
    public static function mm2in($n) {
        return $n * self::$conversionMap['mm']['in'];
    }

    /**
     * Metodo statico per convertire da pollici a millimetri.
     * @param float $n Il valore in pollici.
     * @return float Il valore convertito in millimetri.
     */
    public static function in2mm($n) {
        return $n * self::$conversionMap['in']['mm'];
    }
    
    /**
     * Ritorna il risultato della conversione della precipitazione.
     * @return float Il valore convertito della precipitazione.
     */
    public function getResult() {
        return $this->res;
    }
}
