<?php

App::uses('Component', 'Controller');

class LocalityRouterComponent extends Component {
    
    private static $MAX_MATCHING_OFFSET = 0.2;
    
    public function getMatch($origin, $destination) {
        // Hay algunas localidades que tienen un separador '|'. Ej. Aeropuerto Jose Marti | La Habana... la idea es escoger solamente la parte de alante...
        $split = explode('|', $origin);
        $origin = $split[0];
                
        // ... lo mismo con destination
        $split = explode('|', $destination);
        $destination = $split[0];
        
        $closest = array();
        
        // Buscar locality_id del origen
        $origin_result = $this->matchLocality($origin);
        if( ($origin_result != null && !empty($origin_result)) )
            $closest['origin'] = $origin_result;
         
        // Buscar locality_id del destino
        $destination_result = $this->matchLocality($destination);
        if( ($destination_result != null && !empty($destination_result)) )
            $closest['destination'] = $destination_result;
      
        return $closest;;
        
    }
    
    private function matchLocality($locality) {
        $shortest = -1;
        $closest = array();
        $perfectMatch = false;
        
        $this->Locality = ClassRegistry::init('Locality');
        $this->LocalityThesaurus = ClassRegistry::init('LocalityThesaurus');
        
        $localities = $this->Locality->getAsList();
        foreach ($localities as $province => $municipalities) {            
            foreach ($municipalities as $munId=>$munName) {
                
                $result = $this->match1($locality, $munName, $shortest);
                
                if($result != null && !empty ($result)) {
                    $closest = $result + array('locality_id'=>$munId);                    
                    $shortest = $closest['distance'];
                    
                    if($shortest == 0) {
                        $perfectMatch = true;
                        break;
                    }
                }
            }
            
            if($perfectMatch) break;
        }
        
        if(!$perfectMatch) { // Si no hay match perfecto, ver si hay un mejor matcheo con el tesauro
            $thesaurus = $this->LocalityThesaurus->find('all');
            foreach ($thesaurus as $t) {
                
                $target = $t['LocalityThesaurus']['fake_name'];
                $split = explode('|', $target);
                $target = $split[0];                
                
                $result = $this->match1($locality, $target, $shortest);
                
                if($result != null && !empty ($result)) {
                    $closest = $result + array('locality_id'=>$t['LocalityThesaurus']['locality_id']);
                    $shortest = $closest['distance'];
                    
                    if($shortest == 0) {
                        $perfectMatch = true;
                        break;
                    }
                }
            }
        }
        
        return $closest;
    }
    
    private function match1($locality, $target, $shortestSoFar) {
        $closest = null;
        
        $lev = $this->levenshtein(strtoupper($target), strtoupper($locality));

        $percent = $lev/strlen($target);

        // Calculate only if inside offset
        if($percent > LocalityRouterComponent::$MAX_MATCHING_OFFSET) return null;
            
        // Check for an exact match
        if ($lev == 0) {
            // Closest locality (exact match)
            $shortestSoFar = 0;
            $closest = array('name'=>$target, 'distance'=>$shortestSoFar);
            return $closest;
        }

        if ($lev < $shortestSoFar || $shortestSoFar < 0) {
            // set the closest match, and shortest distance
            $shortestSoFar = $lev;
            $closest = array('name'=>$target, 'distance'=>$shortestSoFar);                
        }
        
        return $closest;        
    }
    
    private function levenshtein($str1, $str2) {
	$length1 = mb_strlen( $str1, 'UTF-8');
	$length2 = mb_strlen( $str2, 'UTF-8');
	if( $length1 < $length2) return levenshtein($str2, $str1);
	if( $length1 == 0 ) return $length2;
	if( $str1 === $str2) return 0;
	$prevRow = range( 0, $length2);
	$currentRow = array();
	for ( $i = 0; $i < $length1; $i++ ) {
            $currentRow=array();
            $currentRow[0] = $i + 1;
            $c1 = mb_substr( $str1, $i, 1, 'UTF-8') ;
            for ( $j = 0; $j < $length2; $j++ ) {
                $c2 = mb_substr( $str2, $j, 1, 'UTF-8' );
                $insertions = $prevRow[$j+1] + 1;
                $deletions = $currentRow[$j] + 1;
                $substitutions = $prevRow[$j] + (($c1 != $c2)?1:0);
                $currentRow[] = min($insertions, $deletions, $substitutions);
            }
            $prevRow = $currentRow;
	}
	return $prevRow[$length2];
    }
}
?>
