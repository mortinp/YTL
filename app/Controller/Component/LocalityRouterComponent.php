<?php

App::uses('Component', 'Controller');

class LocalityRouterComponent extends Component {
    
    private static $MAX_MATCHING_OFFSET = 0.3;
    
    public function getMatch($origin, $destination) {
        $split = explode('|', $origin);
        $origin = $split[0];
                
        $split = explode('|', $destination);
        $destination = $split[0];
        
        
        $shortest = -1;
        $closest = array();
        $perfectMatch = false;
        
        $this->Locality = ClassRegistry::init('Locality');
        $this->LocalityThesaurus = ClassRegistry::init('LocalityThesaurus');
        
        $localities = $this->Locality->getAsList();
        foreach ($localities as $province => $municipalities) {            
            foreach ($municipalities as $munId=>$munName) {
                
                $result = $this->match($origin, $destination, $munName, $shortest);
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
                
                $result = $this->match($origin, $destination, $target, $shortest);
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
    
    private function match($origin, $destination, $target, $shortestSoFar) {
        $closest = null;
        
        $levOrigin = levenshtein(strtoupper($target), strtoupper($origin));
        $levDestination = levenshtein(strtoupper($target), strtoupper($destination));

        $percentOrigin = $levOrigin/strlen($target);
        $percentDestination = $levDestination/strlen($target);

        // Calculate only if inside offset
        if($percentOrigin > LocalityRouterComponent::$MAX_MATCHING_OFFSET && 
           $percentDestination > LocalityRouterComponent::$MAX_MATCHING_OFFSET) return null;
            
        // Check for an exact match
        if ($levOrigin == 0 || $levDestination == 0) {
            $direction = $levOrigin == 0? 0 : 1;

            // Closest locality (exact match)
            $shortestSoFar = 0;
            $closest = array('name'=>$target, 'direction'=>$direction, 'distance'=>$shortestSoFar);                
            return $closest;
        }

        if ($levOrigin < $shortestSoFar || $shortestSoFar < 0) {
            // set the closest match, and shortest distance
            $shortestSoFar = $levOrigin;
            $closest = array('name'=>$target, 'direction'=>0, 'distance'=>$shortestSoFar);                
        }
        if ($levDestination < $shortestSoFar || $shortestSoFar < 0) {
            // set the closest match, and shortest distance
            $shortestSoFar = $levDestination;
            $closest = array('name'=>$target, 'direction'=>1, 'distance'=>$shortestSoFar);                
        } 
        
        return $closest;
        
    } 
}
?>
