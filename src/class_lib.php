<?php 

	class Waiver2 {
		var $player;
		var $waiveDate;
		var $waivedBy;
		var $claimedBy;
		
		function set_player($new_player) {
			$this->player = $new_player;
		}
		function get_player() {
			return $this->player;
		}
		
		function set_waiveDate($new_waiveDate) {
		    $this->waiveDate = $new_waiveDate;
		}
		function get_waiveDate() {
			return $this->waiveDate;
		}
		
		function set_waivedBy($new_waivedBy) {
			$this->waivedBy = $new_waivedBy;
		}
		function get_waivedBy() {
			return $this->waivedBy;
		}
		
		function set_claimedBy($new_claimedBy) {
			$this->claimedBy = $new_claimedBy;
		}
		function get_claimedBy() {
			return $this->claimedBy;
		}
	}
	
	class Waivers2 {
	    var $waivers = array();
		
		public function __construct(string $file) {
			
			$c = 1;
			$d = 0;
			$e = 0;
			$f = 0;
			$g = 0;
			$waivName = ''; 
			$waivDate = ''; 
			$waivBy = ''; 
			$waivClaim = ''; 
			
			if(!file_exists($file)) {
				 throw new InvalidArgumentException('File does not exist');
			}
			
			$contents = file($file);
	
			while(list($cle,$val) = each($contents)) {
				$val = utf8_encode($val);
				//no players on waivers
				if(substr_count($val, 'NO PLAYERS ON WAIVERS')){
					break;
				}

				$counter = 1;
				//interate through each waiver entry and add to array
				if($d == 2 && $g < 5 && !substr_count($val, '<')) {
					if($c == 1) $c = 2;
					else $c = 1;
					$reste = trim($val);
					$waivName = substr($reste, 0, strpos($reste, '  '));
					$reste = trim(substr($reste, strpos($reste, '  ')));
					$waivDate = substr($reste, 0, strpos($reste, '  '));
					$reste = trim(substr($reste, strpos($reste, '  ')));
					$waivBy = substr($reste, 0, strpos($reste, '  '));
					$reste = trim(substr($reste, strpos($reste, '  ')));
					$waivClaim = $reste;
					
					$waiver = new Waiver();
					$waiver->player = $waivName;
					$waiver->waiveDate = $waivDate;
					$waiver->waivedBy = $waivBy;
					$waiver->claimedBy = $waivClaim;

					
					//$waivers->addItem($waiver, $counter);
					array_push($this->waivers, $waiver);

					$e = 1;
					$g++;
					$counter++;
				}
				
				if($d == 1 && (substr_count($val, '<br>') || substr_count($val, '<BR>'))){
					$d = 2;
					$c = 1;
				}
				
				//header
				if(substr_count($val, '<pre>') || substr_count($val, '<PRE>')){				
					$d = 1;
				}
	
				
			}

		}

		public function get_waivers() {
			return $this->waivers;
		}
		
	}
?>