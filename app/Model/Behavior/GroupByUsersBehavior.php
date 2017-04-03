<?php
    App::uses('ModelBehavior', 'Model');

    class GroupByUsersBehavior extends ModelBehavior {
        public function setup(Model $Model, $settings = array()) {
            if (!isset($this->settings[$Model->alias])) {
                $this->settings[$Model->alias] = array(
                    'users_order'=> null  // orden de selección de los usuarios ej: 'max(Travel.id) desc'
                );
            }
            $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array)$settings);
        }
        
        public function paginateCount(Model $model, $conditions = null, $recursive = 0, $extra = array()){
            $parameters = compact('conditions');
            if ($recursive != $model->recursive)
                $parameters['recursive'] = $recursive;

            return $model->find('count', array_merge($parameters, array('group' => 'Travel.user_id'), $extra));
        }


        public function paginate(Model $model, $conditions, $fields, $order, $limit, $page = 1, $recursive = null){
            $map = array();
            $users = $model->find('list', array(
                'fields'     => 'Travel.user_id',
                'group'      => 'Travel.user_id',
                'order'      => $this->settings[$model->alias]['users_order'],
                'recursive'  => 0,
                'conditions' => $conditions,
                'limit'      => $limit,
                'page'       => $page
            ));
            
            $conditions = array_merge($conditions, array('Travel.user_id' => $users));
            $data = $model->find('all', compact('conditions', 'fields', 'order', 'recursive'));

            $result = array();
            $last_empty_index = 0;
            foreach ($data as $travel){
                $user_id = $travel['User']['id'];
                if( !isset( $map[$user_id] ) )
                    $map[$user_id] = $last_empty_index++;

                $result[ $map[$user_id] ][] = $travel;
            }

            return $result;
        }
        
        /*public function paginate(Model $model, $conditions, $fields, $order, $limit, $page = 1, $recursive = null){
            $map = array();
            $data = $model->find('all', compact('conditions', 'fields', 'order', 'recursive'));

            $result = array();
            $last_empty_index = 0;
            foreach ($data as $travel){
                $user_id = $travel['User']['id'];
                if( !isset( $map[$user_id] ) )
                    $map[$user_id] = $last_empty_index++;

                if($map[$user_id] >= ($page - 1) * $limit)
                    $result[ $map[$user_id] ][] = $travel;

                if($last_empty_index == $page * $limit)
                    return $result;
            }

            return $result;
        }*/
    }
?>