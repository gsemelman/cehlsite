<?php 

	class Collection {
		private $items = array();
	 
		public function addItem($obj, $key = null) 
		{
			if ($key == null) 
			{
				$this->items[] = $obj;
			}
			else 
			{
				if (isset($this->items[$key])) 
				{
					//throw new KeyHasUseException("Key $key already in use.");
				}
				else 
				{
					$this->items[$key] = $obj;
				}
			}
		}
		public function deleteItem($key) 
		{
			if (isset($this->items[$key])) 
			{
				unset($this->items[$key]);
			}
			else 
			{
				//throw new KeyInvalidException("Invalid key $key.");
			}
		}
		public function getItem($key) 
		{
			if (isset($this->items[$key])) 
			{
				return $this->items[$key];
			}
			else 
			{
				//throw new KeyInvalidException("Invalid key $key.");
			}
		}
		public function keys() 
		{
			return array_keys($this->items);
		}
		public function length() 
		{
			return count($this->items);
		}
		public function keyExists($key) 
		{
			return isset($this->items[$key]);
		}
		
		public function getItems() {
			return $this->items;
		}
	}

	class Waiver {
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
			$this->waiveDate = $waiveDate;
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
	
	class Waivers {
	    private $waivers = array();
		
		public function __construct(string $file) {
			
			//$waivers = new Collection();
		    //$waivers = array();
			
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
					array_push($waivers, $waiver);

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
/* 					echo '<tr class="tableau-top">';
					echo '<td>'.$waiversPlayer.'</td>';
					echo '<td>'.$waiversDate.'</td>';
					echo '<td>'.$waiversBy.'</td>';
					echo '<td>'.$waiversClaimed.'</td>';
					echo '</tr>'; */
									
					$d = 1;
				}
	
				
			}
			
 			foreach($waivers as $waiver){
				echo $waiver->player;
			} 
			
			print_r ($waivers);
			
			//$this->waivers = $value;
		}

		public function get_waivers() {
			return $this->waivers;
		}
		
	}
?>