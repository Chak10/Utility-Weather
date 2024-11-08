<?php

namespace WtConverter;

class Temperature {

    public $res = false;

    // Mappa di conversione per trovare il metodo giusto tra le diverse unità
    private static $conversionMap = [
        'c' => [
            'f' => 'cel2far',
            'k' => 'cel2kel',
            'r' => 'cel2ran',
        ],
        'f' => [
            'c' => 'far2cel',
            'k' => 'far2kel',
            'r' => 'far2ran',
        ],
        'k' => [
            'c' => 'kel2cel',
            'f' => 'kel2far',
            'r' => 'kel2ran',
        ],
        'r' => [
            'c' => 'ran2cel',
            'f' => 'ran2far',
            'k' => 'ran2kel',
        ],
    ];

    /**
     * Costruttore della classe Temperature.
     * @param float|null $temp La temperatura da convertire.
     * @param string|null $unit_in L'unità di partenza della temperatura (c, f, k, r).
     * @param string|null $unit_out L'unità di destinazione della temperatura (c, f, k, r).
     */
    function __construct($temp = null, $unit_in = null, $unit_out = null) {
        if ($temp !== null && is_numeric($temp)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);

            // Se le unità di input e output sono uguali, ritorna il valore stesso
            if ($unit_in === $unit_out) {
                $this->res = $temp;
            }
            // Se esiste una conversione valida, esegue la conversione
            elseif (isset(self::$conversionMap[$unit_in][$unit_out])) {
                $conversionMethod = self::$conversionMap[$unit_in][$unit_out];
                $this->res = self::$conversionMethod($temp);
            } else {
                $this->res = NAN; // Se non esiste una conversione valida
            }
        }
    }

    /**
     * Ritorna il risultato della conversione.
     * @return float Il valore della temperatura convertita o NAN se non valida.
     */
    public function getResult() {
        return $this->res;
    }

    // Metodi di conversione
    
    /**
     * Converte Celsius a Fahrenheit.
     * @param float $n Temperatura in Celsius.
     * @return float Temperatura in Fahrenheit, o NAN se sotto lo zero assoluto.
     */
    public static function cel2far($n) {
        return $n >= -273.15 ? ($n * 1.8) + 32 : NAN;
    }

    /**
     * Converte Celsius a Kelvin.
     * @param float $n Temperatura in Celsius.
     * @return float Temperatura in Kelvin, o NAN se sotto lo zero assoluto.
     */
    public static function cel2kel($n) {
        return $n >= -273.15 ? $n + 273.15 : NAN;
    }

    /**
     * Converte Celsius a Rankine.
     * @param float $n Temperatura in Celsius.
     * @return float Temperatura in Rankine, o NAN se sotto lo zero assoluto.
     */
    public static function cel2ran($n) {
        return $n >= -273.15 ? ($n + 273.15) * 1.8 : NAN;
    }

    /**
     * Converte Fahrenheit a Celsius.
     * @param float $n Temperatura in Fahrenheit.
     * @return float Temperatura in Celsius, o NAN se sotto lo zero assoluto.
     */
    public static function far2cel($n) {
        return $n >= -459.67 ? ($n - 32) * (5 / 9) : NAN;
    }

    /**
     * Converte Fahrenheit a Kelvin.
     * @param float $n Temperatura in Fahrenheit.
     * @return float Temperatura in Kelvin, o NAN se sotto lo zero assoluto.
     */
    public static function far2kel($n) {
        return $n >= -459.67 ? ($n + 459.67) * (5 / 9) : NAN;
    }

    /**
     * Converte Fahrenheit a Rankine.
     * @param float $n Temperatura in Fahrenheit.
     * @return float Temperatura in Rankine, o NAN se sotto lo zero assoluto.
     */
    public static function far2ran($n) {
        return $n >= -459.67 ? $n + 459.67 : NAN;
    }

    /**
     * Converte Kelvin a Fahrenheit.
     * @param float $n Temperatura in Kelvin.
     * @return float Temperatura in Fahrenheit, o NAN se sotto lo zero assoluto.
     */
    public static function kel2far($n) {
        return $n >= 0 ? ($n * 1.8) - 459.67 : NAN;
    }

    /**
     * Converte Kelvin a Celsius.
     * @param float $n Temperatura in Kelvin.
     * @return float Temperatura in Celsius, o NAN se sotto lo zero assoluto.
     */
    public static function kel2cel($n) {
        return $n >= 0 ? $n - 273.15 : NAN;
    }

    /**
     * Converte Kelvin a Rankine.
     * @param float $n Temperatura in Kelvin.
     * @return float Temperatura in Rankine, o NAN se sotto lo zero assoluto.
     */
    public static function kel2ran($n) {
        return $n >= 0 ? $n * 1.8 : NAN;
    }

    /**
     * Converte Rankine a Celsius.
     * @param float $n Temperatura in Rankine.
     * @return float Temperatura in Celsius, o NAN se sotto lo zero assoluto.
     */
    public static function ran2cel($n) {
        return $n >= 0 ? ($n - 491.67) * (5 / 9) : NAN;
    }

    /**
     * Converte Rankine a Fahrenheit.
     * @param float $n Temperatura in Rankine.
     * @return float Temperatura in Fahrenheit, o NAN se sotto lo zero assoluto.
     */
    public static function ran2far($n) {
        return $n >= 0 ? $n - 459.67 : NAN;
    }

    /**
     * Converte Rankine a Kelvin.
     * @param float $n Temperatura in Rankine.
     * @return float Temperatura in Kelvin, o NAN se sotto lo zero assoluto.
     */
    public static function ran2kel($n) {
        return $n >= 0 ? $n * (5 / 9) : NAN;
    }
}
