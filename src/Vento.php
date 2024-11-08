<?php

namespace WtConverter;


class Wind {
    
    public $res = false;

    // Mappa dei fattori di conversione per diverse unità di velocità del vento
    private static $conversionMap = [
        'kmh' => ['ms' => 0.27777777778, 'mph' => 0.62137119273443, 'fts' => 0.9113444160105, 'kn' => 0.53995680389235],
        'ms' => ['kmh' => 3.6, 'mph' => 2.2369362920544, 'fts' => 3.2808398950131, 'kn' => 1.9438444924574],
        'mph' => ['kmh' => 1.6093439987125, 'ms' => 0.44704, 'fts' => 1.4666666666667, 'kn' => 0.86897624190816],
        'fts' => ['kmh' => 1.0972799991222, 'ms' => 0.3048, 'mph' => 0.68181818181818, 'kn' => 0.59248380130101],
        'kn' => ['kmh' => 1.8519999985024, 'ms' => 0.27777777778, 'mph' => 1.1507794480136, 'fts' => 1.6878098570866],
    ];

    /**
     * Costruttore della classe Wind.
     * @param float|null $wind Il valore della velocità del vento da convertire.
     * @param string|null $unit_in L'unità di partenza della velocità del vento (kmh, ms, mph, fts, kn).
     * @param string|null $unit_out L'unità di destinazione della velocità del vento.
     */
    function __construct($wind = null, $unit_in = null, $unit_out = null) {
        if ($wind !== null && is_numeric($wind)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);

            // Se le unità di input e output sono le stesse, ritorna il valore di input
            if ($unit_in === $unit_out) {
                $this->res = $wind;
            }
            // Se esiste un fattore di conversione valido, applicalo
            elseif (isset(self::$conversionMap[$unit_in][$unit_out])) {
                $conversionFactor = self::$conversionMap[$unit_in][$unit_out];
                $this->res = $wind * $conversionFactor;
            }
        }
    }

    /**
     * Metodo statico per convertire gradi in direzione del vento.
     * @param float $num Angolo in gradi (0-360).
     * @return string Direzione cardinal (es. "N", "NE", "E", ecc.).
     */
    public static function degToCom($num) {
        $val = floor(($num / 22.5) + 0.5); // Divide il valore in settori di 22.5° per ogni direzione
        $arr = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW"];
        return $arr[$val % 16]; // Ritorna la direzione in base all'indice calcolato
    }

    /**
     * Ritorna il risultato della conversione della velocità del vento.
     * @return float Il valore convertito della velocità del vento.
     */
    public function getResult() {
        return $this->res;
    }
}

?>
