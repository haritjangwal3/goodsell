<?php 

class Validate {
    private $_passed =false, $_errors=[], $_db=null;

    public function __construct()
    {
        $this->_db =  DB::getInstance();
    }

    public function check($source, $items=[]){
        // takes a $_POST/$_GET in a source
        // takes set of requirements for the validation

        $this->_errors = [];
        foreach($items as $item => $rules){
            $item = Input::sanitize($item);
            $display = $rules['display'];
            $required = $rules['required'];
            foreach($rules as $rule => $rule_val){
                $input_value = Input::sanitize(trim($source[$item]));

                if($rule === 'required' && empty($input_value)){
                    $this->addError(["{$display} is required", $item]);
                }
                else if(!empty($input_value)){
                    switch($rule){
                        case 'min': 
                            if(strlen($input_value) < $rule_val){
                                $this->addError(["{$display} must be a minimum of {$rule_val} characters.", $item]);
                            }
                        break;

                        case 'max':
                            if(strlen($input_value) > $rule_val){
                                $this->addError(["{$display} must be a maximum of {$rule_val} characters.", $item]);
                            }
                        break;

                        case 'matches':
                            if($input_value != $source[$rule_val]){
                                $matchDisplay = ucwords($rule_val);
                                $this->addError(["{$matchDisplay} and {$display} must match.", $item]);
                            }
                        break;

                        case 'unique':
                            $check =  $this->_db->query("select {$item} from {$rule_val} where {$item} = ?", [$input_value]);
                            if($check->count()){
                                $this->addError(["{$display} already exists. Please choose another {$display}", $item]);
                            }
                        break;

                        case 'unique_update':
                            $t = explode(',', $rule_val);
                            $table = $t[0];
                            $id = $t[1];
                            $qry = $this->_db->query("select * from {$table} where id = ? and {$item} = ?",[$id, $input_value]);
                            if($qry->count()){
                                $this->addError(["{$display} exists. Please choose another {$display}.", $item]);
                            }
                        break;

                        case 'is_numeric':
                            if(!is_numeric($input_value)){
                                $this->addError(["{$display} has to be a number. Please use a numeric value.", $item]);
                            }
                        break;
                        case 'valid_email':
                            {
                                if(!filter_var($input_value, FILTER_VALIDATE_EMAIL)) {
                                    $this->addError(["{$display} must be a valid email address.", $item]);
                                }
                            }
                        break;
                    }
                }
            }
        }
        if(empty($this->_errors)){
            $this->_passed = true;
        }
    }

    public function addError($error){
        $this->_errors[] = $error;
        $this->_passed = (empty($this->_errors)) ? true : false;
    }

    public function passed(){
        return $this->_passed;
    }

    public function errors(){
        return $this->_errors;
    }
    public function displayErrors(){
        $html = '<ul class="bg-danger">';
        foreach($this->errors() as $error){
            if(is_array($error)){
                $html .= '<li class="white">'. $error[0] .'</li>';
                $html .= 
                '<script>
                jQuery("document").ready(function(){
                    jQuery("#'.$error[1].'").parent().closest("div").addClass("has-error");
                });
                </script>'; 
            }
            else {
                $html .= '<li class="white">'. $error .'</li>'; 
            }
                  
        }
        $html .= '</ul>';
        return $html;
    }
}