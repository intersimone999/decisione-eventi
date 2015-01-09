<?php
        define( 'ROOT_DIR', dirname(__FILE__) );
        $CFG = array();

        $EVT_SHARED = 0;
        $EVT_SHOP = 1;

        $CFG['EVT_NAME'] = "Capodanno 2015";
        $CFG['EVT_TYPE'] = $EVT_SHOP;

        $CFG['DB_HOST'] = "fox9.me";
        $CFG['DB_USERNAME'] = "standard";
        $CFG['DB_PASSWORD'] = "pleaseletmein";
        $CFG['DB_NAME'] = "decisioni";


        function redirect($page) {
                header("Location: ../interface/$page");
        }

        function abspath($path) {
                return "../$path";
        }
?>

