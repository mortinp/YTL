<?php

App::uses('ModelBehavior', 'Model');

class OperatorScopeBehavior extends ModelBehavior {

    public function setup(Model $Model, $settings = array()) {
        if (!isset($this->settings[$Model->alias])) {
            $this->settings[$Model->alias] = array(
                'match'=> null, // El modelo donde se debe buscar el matcheo. Ej. Driver.operator_id
                'action' => null, // La accion que otros operadores permiten al operador y que el operador acepta. Se usa para cargar las filas donde match matchee con el id del operador. Ej. 'M' (Leer nuevos mensajes)
            );
        }
        $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array)$settings);
    }
        
    public function beforeFind(Model $Model, $query = array()) {
        
        // Definir los elementos a los que este operador tiene acceso por defecto: los elementos propios y los que no estan asignados a nadie
        $match = array(
            array($this->settings[$Model->alias]['match']=>AuthComponent::user('id')),
            array($this->settings[$Model->alias]['match']=>null)
        );
        
        // Buscar el resto de los operadores que le permiten al que esta logueado la accion dada
        $opActionRuleModel = ClassRegistry::init('Operations.OpActionRule');
        $allowedByOthers = $opActionRuleModel->find('all', array(
            'conditions'=>array(
                'op_other'=>AuthComponent::user('id'), 
                'action_allowed'=>$this->settings[$Model->alias]['action'], 
                'OpActionRule.allowed_by_owner'=>true, 
                'OpActionRule.accepted_by_other'=>true)
        ));
        
        // ... y adicionarlos a $accessTo
        foreach ($allowedByOthers as $value) {
            $match[] = array($this->settings[$Model->alias]['match']=>$value['Owner']['id']);
        }        
        
        // Adcionar condiciones a la $query (un listado de expresiones OR con los id de todos los elementos a los que este operador tiene acceso: los suyos propios, los no asignados a nadie, y los que le permiten otros operadores)
        if(isset($query['conditions']) && !empty($query['conditions'])) {
            $query['conditions'][]['OR'] = $match;
                       
        } else {
            $query['conditions']['OR'] = $match;
        }
        
        return $query;
    }
}
