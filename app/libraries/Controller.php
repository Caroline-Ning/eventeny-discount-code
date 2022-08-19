<?php
    /**
     * all controller will extend this Controller
     * make all controllers able to - loads models and views
     */
    class Controller {
        // load model
        public function model($model){
            // require and instantiate model
            require_once '../app/models/' . $model . '.php';
            return new $model();
        }

        // load view
        public function view($view, $data = []){
            if(file_exists('../app/views/' . $view . '.php')){
                require_once '../app/views/' . $view . '.php';
            }else{
                die('view does not exists');
            }
        }
    }