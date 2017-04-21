<?php
	
	namespace wt_converter;
	
	class dewPoint {
		
		/*
			Compute dewPoint for given temperature T[Deg.C] and relative humidity RH[%].
		*/
		
		function __construct($T, $RH) {
			if (!is_numeric($T)) {
				$this->res = $T;
				return;
			}
			$T = $T + 273.15; // C to K
			$this->res = self::solve($RH / 100 * self::PVS($T), $T) - 273.15;
			return;
		}
		
		/*
			* Saturation Vapor Pressure formula for range -100..0 Deg. C.
			* This is taken from
			*   ITS-90 Formulations for Vapor Pressure, Frostpoint Temperature,
			*   Dewpoint Temperature, and Enhancement Factors in the Range 100 to +100 C
			* by Bob Hardy
			* as published in "The Proceedings of the Third International Symposium on Humidity & Moisture",
			* Teddington, London, England, April 1998
		*/
		
		private static function pvsIce($T) {
			
			$k0 = -5.8666426e3;
			$k1 = 2.232870244e1;
			$k2 = 1.39387003e-2;
			$k3 = -3.4262402e-5;
			$k4 = 2.7040955e-8;
			$k5 = 6.7063522e-1;
			
			$lnP = $k0 / $T + $k1 + ($k2 + ($k3 + ($k4 * $T)) * $T) * $T + $k5 * log($T);
			return exp($lnP);
		}
		
		/*
			* Saturation Vapor Pressure formula for range 273..678 Deg. K.
			* This is taken from the
			*   Release on the IAPWS Industrial Formulation 1997
			*   for the Thermodynamic Properties of Water and Steam
			* by IAPWS (International Association for the Properties of Water and Steam),
			* Erlangen, Germany, September 1997.
			*
			* This is Equation (30) in Section 8.1 "The Saturation-Pressure Equation (Basic Equation)"
		*/
		
		private static function pvsWater($T) {
			
			$n1 = 0.11670521452767e4;
			$n2 = -0.72421316703206e6;
			$n3 = -0.17073846940092e2;
			$n4 = 0.12020824702470e5;
			$n5 = -0.32325550322333e7;
			$n6 = 0.14915108613530e2;
			$n7 = -0.48232657361591e4;
			$n8 = 0.40511340542057e6;
			$n9 = -0.23855557567849;
			$n10 = 0.65017534844798e3;
			
			$th = $T + $n9 / ($T - $n10);
			$A = ($th + $n1) * $th + $n2;
			$B = ($n3 * $th + $n4) * $th + $n5;
			$C = ($n6 * $th + $n7) * $th + $n8;
			$p = 2 * $C / (-$B + sqrt($B * $B - 4 * $A * $C));
			$p *= $p;
			$p *= $p;
			return $p * 1e6;
		}
		
		/*
			Compute Saturation Vapor Pressure for minT<T[Deg.K]<maxT.
		*/
		private static function PVS($T) {
			if ($T < 173 || $T > 678)
            return null;
			else if ($T < 273.15)
            return self::pvsIce($T);
			else
            return self::pvsWater($T);
		}
		
		/*
			Newton's Method to solve f(x)=y for x with an initial guess of x0.
		*/
		private static function solve($y, $x0) {
			$x = $x0;
			$maxCount = 10;
			$count = 0;
			do {
				$xNew;
				$dx = $x / 1000;
				$z = self::PVS($x);
				$xNew = $x + $dx * ($y - $z) / (self::PVS($x + $dx) - $z);
				if (abs(($xNew - $x) / $xNew) < 0.0001)
                return $xNew;
				else if ($count > $maxCount) {
					$xnew = null;
					return 273.15;
				}
				$x = $xNew;
				$count++;
			} while (TRUE);
		}
	}
	
	class apparentTemp {
		
		function __construct($T, $H, $W, $Q = null,$t_u = null, $v_u = null) {
			/*
				Version including the effects of temperature, humidity, and wind:
				AT = Ta + 0.33×e - 0.70×ws - 4.00
				Version including the effects of temperature, humidity, wind, and radiation:
				AT = Ta + 0.348×e - 0.70×ws + 0.70×Q/(ws + 10) - 4.25
				where:
				Ta     = Dry bulb temperature (°C)
				e       = Water vapour pressure (hPa) [humidity]
				ws    = Wind speed (m/s) at an elevation of 10 meters
				Q        = Net radiation absorbed per unit area of body surface (w/m2)
				The vapour pressure can be calculated from the temperature and relative humidity using the equation:
				e = rh / 100 × 6.105 × exp ( 17.27 × Ta / ( 237.7 + Ta ) )
				where:
				rh    = Relative Humidity [%]
				Source: Norms of apparent temperature in Australia, Aust. Met. Mag., 1994, Vol 43, 1-16
				More Info http://www.bom.gov.au/info/thermal_stress/#atapproximation
			*/
			if (!is_numeric($T) || !is_numeric($H) || !is_numeric($W))
            return false;
			$t_u = strtolower($t_u);
			switch ($t_u) {
				case "f":
                $T = ($T - 32) * (5/9);
                $rconv = 1;
                break;
				case "k":
                $T = $T - 273.15;
                $rconv = 2;
                break;
				default:
                $T = $T;
                $rconv = 0;
                break;
			}
			$v_u = strtolower($v_u);
			switch ($v_u) {
				case "kmh":
                $W = $W * 0.27777777777778;
                break;
				case "mph":
                $W = $W * 0.44704;
                break;
				case "fts":
                $W = $W * 0.3048;
                break;
				case "kn":
                $W = $W * 0.51444444444444;
                break;
				default:
                $W = $W;
                break;
			}
			
			$e = ($H / 100) * 6.105 * exp((17.27 * $T) / (237.7 + $T));
			
			if (is_numeric($Q) && $Q >= 0){
				$old = round(($T + 0.33 * $e - 0.7 * $W - 4), 2);
				$rconv == 1 ? $old = $old * (9 / 5) + 32: '';
				$rconv == 2 ? $old = $old + 273.15 : '';
				return $this->res = $old;
			}
            $new = round(($T + 0.348 * $e - 0.7 * $W + 0.70 * $Q / ($W + 10) - 4.25), 2);
			$rconv == 1 ? $new = $new * (9 / 5) + 32: '';
			$rconv == 2 ? $new = $new + 273.15 : '';
			return $this->res = $new;
		}
		
	}
	
	class heatIndex {
		
		function __construct($T, $RH, $unit = "f") {
			if (!is_numeric($T) || !is_numeric($RH))
            return false;
			$unit = strtolower($unit);
			switch ($unit) {
				case "c":
                $T = $T * (9 / 5) + 32;
                $rconv = 1;
                break;
				case "k":
                $T = $T * (9 / 5) - 459.67;
                $rconv = 2;
                break;
				default:
                $T = $T;
                $rconv = 0;
                break;
			}
			if ($T < 80) {
				$o1 = ($T - 68.0) * 1.2;
				$o2 = $T + 61.0 + $o1 + ($RH * 0.094);
				$hi_def = 0.5 * $o2;
				$rconv == 1 ? $hi_def = ($hi_def - 32) * (5 / 9) : '';
				$rconv == 2 ? $hi_def = ($hi_def + 459.67) * (5 / 9) : '';
				return $this->res = $hi_def;
			}
			$hi_def = self::HI($T, $RH);
			if ($T > 80 && $T < 112 && $RH < 13) {
				$a1 = (13 - $RH) / 4;
				$a2 = 17 - abs($T - 95);
				$adjust = $a1 * sqrt($a2 / 17);
				$hi_def = $hi_def - $adjust;
				$rconv == 1 ? $hi_def = ($hi_def - 32) * (5 / 9) : '';
				$rconv == 2 ? $hi_def = ($hi_def + 459.67) * (5 / 9) : '';
				return $this->res = $hi_def;
			}
			if ($T > 80 && $T < 87 && $RH > 85) {
				$a1 = (13 - $RH) / 4;
				$a2 = 17 - abs($T - 95);
				$adjust = $a1 * sqrt($a2 / 17);
				$hi_def = $hi_def + $adjust;
				$rconv == 1 ? $hi_def = ($hi_def - 32) * (5 / 9) : '';
				$rconv == 2 ? $hi_def = ($hi_def + 459.67) * (5 / 9) : '';
				return $this->res = $hi_def;
			}
		}
		
		private static function HI($T, $RH) {
			$c1 = -42.379;
			$c2 = -2.04901523;
			$c3 = -10.14333127;
			$c4 = -0.22475541;
			$c5 = -6.83783e-3;
			$c6 = -5.481717e-2;
			$c7 = -1.22874e-3;
			$c8 = 8.5282e-4;
			$c9 = -1.99e-6;
			return $c1 + $c2 * $T + $c3 * $RH + $c4 * $T * $RH + $c5 * ($T * 2) + $c6 * ($RH * 2) + $c7 * ($T * 2) * $RH + $c8 * $T * ($RH * 2) + $c9 * ($T * 2) * ($RH * 2);
		}
	}
	
	class windChill {
		/*
			North American and United Kingdom wind chill index
			In November 2001, Canada, the U.S., and the U.K. implemented a new wind chill index developed by scientists and medical experts on the Joint Action Group for Temperature Indices (JAG/TI). It is determined by iterating a model of skin temperature under various wind speeds and temperatures using standard engineering correlations of wind speed and heat transfer rate. Heat transfer was calculated for a bare face in wind, facing the wind, while walking into it at 1.4 metres per second (3.1 mph). The model corrects the officially measured wind speed to the wind speed at face height, assuming the person is in an open field.
		*/
		
		function __construct($T, $V, $type = true, $t_u = null, $v_u = null) {
			if (!is_numeric($T) || !is_numeric($V))
            return false;
			$t_u = strtolower($t_u);
			switch ($t_u) {
				case "c":
                $T = $T * (9 / 5) + 32;
                $rconv = 1;
                break;
				case "k":
                $T = $T * (9 / 5) - 459.67;
                $rconv = 2;
                break;
				default:
                $T = $T;
                $rconv = 0;
                break;
			}
			$v_u = strtolower($v_u);
			switch ($v_u) {
				case "kmh":
                $V = $V * 0.62137119273443;
                break;
				case "ms":
                $V = $V * 2.2369362920544;
                break;
				case "fts":
                $V = $V * 0.68181818181818;
                break;
				case "kn":
                $V = $V * 1.1507794480136;
                break;
				default:
                $V = $V;
                break;
			}
			if ($type === false) {
				$wc = 0.0817 * (3.71 * pow($V, 0.5) + 5.81 - 0.25 * $V) * ($T - 91.4) + 91.4;
				$rconv == 1 ? $wc = ($wc - 32) * (5 / 9) : '';
				$rconv == 2 ? $wc = ($wc + 459.67) * (5 / 9) : '';
				return $this->res = $wc; // old 
			}
			$wc = 35.74 + 0.6215 * $T - 35.75 * pow($V, 0.16) + 0.4275 * $T * pow($V, 0.16);
			$rconv == 1 ? $wc = ($wc - 32) * (5 / 9) : '';
			$rconv == 2 ? $wc = ($wc + 459.67) * (5 / 9) : '';
			return $this->res = $wc;
		}
	}
	
?>
