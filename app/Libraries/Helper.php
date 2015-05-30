<?php
	namespace Eternal\Libraries;

	class Helper {

		public function nf($int) {
			return number_format($int, 0, ',', '.');
		}

		public function dt($dt) {
			return new \DateTime($dt);
		}

		public function htime($sec) {
			// Weeks
			$sec_rest = $sec % 604800;
			$weeks    = ($sec - $sec_rest) / 604800;
			$sec      = $sec_rest;

			// Days
			$sec_rest = $sec % 86400;
			$days	  = ($sec - $sec_rest) / 86400;
			$sec	  = $sec_rest;

			// Hours
			$sec_rest = $sec % 3600;
			$hours	  = ($sec - $sec_rest) / 3600;
			$sec	  = $sec_rest;

			// Minutes & Seconds
			$sec_rest = $sec % 60;
			$mins	  = ($sec - $sec_rest) / 60;
			$sec	  = $sec_rest;

			$weeks = $weeks > 0 ? ($weeks > 1 ? $weeks.'w ' : $weeks.'w ') : '';
			$days  = $days > 0 ? ($days > 1 ? $days.'d ' : $days.'d ') : '';
			$hours = $hours < 10 ? "0".$hours : $hours;
			$mins  = $mins < 10 ? "0".$mins : $mins;
			$sec   = $sec < 10 ? "0".$sec : $sec;
			$time  = $weeks.$days.$hours.':'.$mins.':'.$sec;

			return $time;
		}
	}