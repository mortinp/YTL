<?php
    App::uses('Travel', 'Model');
    
    class SearchController extends AppController { 
        public $uses = array('Search.Search', 'Travel', 'Driver', 'DriverTravel', 'Locality', 'User');
        public $components = array('Paginator');  
        
        public function index(){
            $in = strtolower( trim($this->request->query['q']) );
            $case = $this->parse($in);
            $conditions = $this->conditions($case);
            $this->set('case', $case);

            Travel::prepareFullConversations($this);
            $this->Paginator->settings = array(
                'limit' => 500/*TODO: Realmente es mejor quitar la paginacion completamente*/, 
                'order' => array('Travel.date' => 'desc') );
            $this->set('travels', $this->Paginator->paginate('Travel', $conditions) );
            $this->set('drivers', $this->Driver->getAsSuggestions()); // Esto es para notificar a otros choferes
        }  
        
        private function parse($in){
            if( filter_var($in, FILTER_VALIDATE_EMAIL) )
                return array('case' => 'EMAIL', 'value' => $in);
            
            if( filter_var($in, FILTER_VALIDATE_INT) )
                return array('case' => 'INT', 'value' => $in);    
            
            try{ 
                $result = $this->parse_date($in);
                if($result)  return $result;
                
                $inflect = array('lunes' => 'monday', 'martes' => 'tuesday', 'miercoles' => 'wednesday', 'miércoles' => 'wednesday', 'jueves' => 'thursday', 'viernes' => 'friday', 'sabado' => 'saturday', 'sábado' => 'saturday', 'domingo' => 'sunday');
                if( isset($inflect[$in]) ) 
                    $in = $inflect[$in];
                $date = new DateTime($in); 
                return array('case' => 'DATE', 'value' => $date->format('Y/m/d'));  
            }
            catch(Exception $error){
                throw new NotFoundException ('El valor proporcionado no tiene el formato correcto');
            }
        }
        
        private function conditions($case){
            switch($case['case']){
                case 'EMAIL':
                    $user = $this->User->findByUsername($case['value']);
                    if(!$user) throw new NotFoundException ('Este correo no corresponde a ningún usuario');
                    return array( 'Travel.user_id' => $user['User']['id'] );
                break;
            
                case 'INT':
                    return array('Travel.id' => $case['value']);
                break;

                case 'DATE': case 'DMY_DATE':
                    return array('Travel.date' => $case['value']);
                break;
            
                case 'DM_DATE':
                    return array('extract(DAY from Travel.date)' => $case['DAY'], 'extract(MONTH from Travel.date)' => $case['MONTH']);
                break;
            
                case 'MY_DATE':
                    return array('extract(MONTH from Travel.date)' => $case['MONTH'], 'extract(YEAR from Travel.date)' => $case['YEAR']);
                break;
            }
            
            return null;
        }
        
        private function parse_date($in){
            $in = str_replace('/', '-', $in);
            $parts = split('-', $in);
            if( count($parts) == 3 ){
                if( checkdate($parts[1], $parts[0], $parts[2]) )
                    return array('case' => 'DMY_DATE', 'value' => $in);
            }    
            else if( count($parts) == 2 ){
                if( strlen($parts[1]) == 4 ){
                    if( checkdate($parts[0], '01', $parts[1]) )
                        return array('case' => 'MY_DATE', 'value' => $in, 'MONTH' => $parts[0], 'YEAR' => $parts[1]);
                }
                else{
                    if( checkdate($parts[1], $parts[0], '2016') )
                        return array('case' => 'DM_DATE', 'value' => $in, 'DAY' => $parts[0], 'MONTH' => $parts[1]);
                }
            }
            return false;
        }
    }
?>
