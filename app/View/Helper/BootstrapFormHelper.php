<?php

App::uses('FormHelper', 'View/Helper');

/**
 * BootstrapFormHelper.
 *
 * Applies styling-rules for Bootstrap 3
 *
 * To use it, just save this file in /app/View/Helper/BootstrapFormHelper.php
 * and add the following code to your AppController:
 *   	public $helpers = array(
 * 		    'Form' => array(
 * 		        'className' => 'BootstrapForm'
 * 	  	  	)
 * 		);
 *
 * @link https://gist.github.com/Suven/6325905
 */
class BootstrapFormHelper extends FormHelper {

    public function create($model = null, $options = array()) {
        
        $defaultOptions = array(
            'inputDefaults' => array(
		'div' => 'form-group',
		'wrapInput' => false,
		'class' => 'form-control'
            ),
        );

        if (!empty($options['inputDefaults'])) {
            $options = array_merge($defaultOptions['inputDefaults'], $options['inputDefaults']);
        } else {
            $options = array_merge($defaultOptions, $options);
        }
        return parent::create($model, $options);
    } 
    
    /*public function checkbox($fieldName, $options = array()) {
        $defaultOptions = array(
            'wrapInput' => true
        );
        $options = array_merge_recursive($defaultOptions, $options);
        return parent::checkbox($fieldName, $options);
    }*/

    public function submit($caption = null, $options = array(), $asLink = false) {
        $defaultOptions = array(
            'class' => 'btn btn-primary',
        );
        if(!$asLink) $defaultOptions['class'] .= ' btn-block'; // Hacer que los botones que no son links, salgan como blocks
        
        $options = array_merge($defaultOptions, $options);
        
        if(!$asLink) return parent::submit($caption, $options);
        
        else {
            $options['onclick'] = "form=get_form(this);if($(form).valid())form.submit();return false;";
            return $this->Html->link($caption, 'javascript:void', $options);
        }
        
    }
    
    public function button($caption = null, $options = array(), $asLink = false) {
        $defaultOptions = array(
            'class' => 'btn',
            'type'=>'button',
            'style'=>'display:inline-block'
        );
        $options = array_merge_recursive($defaultOptions, $options);
        
        if(!$asLink) return parent::submit($caption, $options);
        
        else {
            $linkDef = array();
            if(isset ($options['controller'])) $linkDef['controller'] = $options['controller'];
            if(isset ($options['action'])) $linkDef['action'] = $options['action'];
            return $this->Html->link($caption, $linkDef, $options);
        }
    }
    
    public function input($caption = null, $options = array()) {
        $defaultOptions = array( 
            'class'=>'form-control'
        );
        $options = array_merge_recursive($defaultOptions, $options);
        $result = parent::input($caption, $options);
        
        /* Hacer cosas específicas para cada tipo de input >>> */
        
        // SELECT
        if(isset ($options['type']) && $options['type'] === 'select') {
            
            for ($index = 0; $index < count($options); $index++) {
                if(!isset ($options[$index])) break;
                
                // Para selects multiples, hacer un hack para que los valores se pasen como un arreglo al servidor
                // Source: http://stackoverflow.com/questions/12354848/cakephp-select-multiple-only-passing-first-value/12355224#12355224
                if($options[$index] == 'multiple') {
                    $result = str_replace('['.$caption.']', '['.$caption.'][]', $result);
                    break;
                }
            }
            
        }
        
        return $result;
    }
    
    public function inputs($fields = null, $blacklist = null, $options = array()) {
        $options = array_merge(array('fieldset' => false), $options);
        return parent::inputs($fields, $blacklist, $options);
    }
    
    public function select($fieldName, $options = array(), $attributes = array()) {
        $defaultOptions = array(
            'class' => 'form-control selectpicker',
        );
        $attributes = array_merge($defaultOptions, $attributes);
        return parent::select($fieldName, $options, $attributes);
    }
    
    
    /**
     * CUSTOM
     */
    
    public function custom_date($fieldName, $options = array()) {
        
        $defaultOptions = array(
            'class'=>'datepicker', //Needs datepicker at ... 
            'type'=>'text', 
            'div'=>'form-group input-group', 
            'after'=>'<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>'
        );
        $options = array_merge_recursive($defaultOptions, $options);
        
        
        $output = '';
        if($options['label']) {
            $output .= $this->label($fieldName, $options['label']);
            $options['label'] = false;
        }
        else $output .= $this->label($fieldName, $options['label']);
        
        $output .= $this->input($fieldName, $options);
        return $output;
    }
    
    public function checkbox_group(array $checkboxes, $options = array()) {
        $header = 'Options';
        if(isset ($options['header'])) $header = $options['header'];
        
        echo '<div style="clear:both;height:100%;overflow:auto;padding-bottom:10px">';
        echo '<div><label>'.$header.'</label></div>';
        //echo '<div>';
        foreach ($checkboxes as $field => $label) {
            echo '<div style="padding-right:10px;float:left">'.$this->checkbox($field).' '.$label.'</div>';
        }
        //echo '</div>';
        echo '</div>';
    }
    
    
    
    public function file($caption = null, $options = array()) {
        $result = "";
        if(isset ($options['multiple']) && is_numeric($options['multiple'])) {
            for ($i = 0; $i < $options['multiple']; $i++) {
                $fileElem = parent::file($caption, $options);
                $fileElem = str_replace('['.$caption.']', '['.$caption.'][]', $fileElem);
                $result .= $fileElem;
            }
        } else {
            $result = parent::file($caption, $options);
        }
        
        return $result;
    }
}

?>
