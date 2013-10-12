<?php

class Elfic_Smarty extends Smarty { 
    function __construct() {
        $this->template_dir = SMARTY_TPLS_DIR . 'templates';
        $this->compile_dir = SMARTY_TPLS_DIR . 'templates_c';
        $this->config_dir = SMARTY_TPLS_DIR . 'configs';
        $this->cache_dir = SMARTY_TPLS_DIR . 'cache';
    }
}

?>