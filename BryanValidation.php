<?php

namespace Form__Validate{
    class Validation
    {
        //property
        private $name;

        // GET $name
//        public function getName()
//        {
//            return $this->name;
//        }

        //SET $name
        public function setName($value)
        {
            $this->name = $value;
        }

        //constructor for $name
        public function __construct($name)
        {
            $this->setName($name);
        }

        //method to display the name entered into text field
        public function displayName()
        {
            if(empty($this->name)){
                return ' Name not provided';
            }
            return 'Name: ' . $this->name;
        }

        //Validate whether text field is left empty or not
        public function isNotEmpty()
        {
            if (!$this->name == '/^\s(?=[[:graph:]])?/')
            {
                $value =  " inValid";
            }
            else
            {
                $value = "Valid";
            }
            return 'Is it valid:' . $value;
        }

        // Validate whether the checkbox is checked or not
        public function isChecked()
        {
            if (!isset($_POST['_c']))
            {
                $msg =  " Is Not Checked";
            }
            else
            {
                $msg = " Is Checked";
            }
            return 'Is it checked: ' . $msg;
        }
    }

}

