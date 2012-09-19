<?php

class modTemplateVarInputRenderAsides extends modTemplateVarInputRender {
//    public function getLexiconTopics() {
//        //return array('tv_widget','asides:default');
//        return 'asides:default';
//    }
//
//    public function render($value,array $params = array()) {
//        $this->_loadLexiconTopics();
//        //return $this->process($value,$params);
//        $this->setPlaceholder('tv',$this->tv);
//        $this->setPlaceholder('id',$this->tv->get('id'));
//        $this->setPlaceholder('ctx',isset($_REQUEST['ctx']) ? $_REQUEST['ctx'] : 'web');
//        $this->setPlaceholder('params',$params);
//
//        $output = parent::render($value,$params);
//
//        $tpl = $this->getTemplate();
//        return !empty($tpl) ? $this->modx->controller->fetchTemplate($tpl) : $output;
//    }

    public function getTemplate() {
        return $this->modx->getOption('asides.core_path', null, $this->modx->getOption('core_path').'components/asides/') .'elements/tv/input/tpl/asides.tpl';
    }

    public function process($value, array $params = array()) {
        //$this->modx->log(modX::LOG_LEVEL_ERROR, 'in asides process');
        //$this->modx->log(modX::LOG_LEVEL_ERROR, $value ."\n". print_r($params, true));

        $default = explode('||', $this->tv->default_text); // all standard values
        $value = trim($value);
        $value = empty($value) ? $default : explode('||', $value); // current saved values or default

        $inputoptions = $this->prepareRecords();

        $options = array();
        if (!empty($value[0]) && count($value) > 0){
            foreach ($value as $itemvalue){
                $option = $inputoptions[$itemvalue];
                $option['checked'] = true;
                $options[] = $option;
                unset($inputoptions[$itemvalue]);
            }
        }

        $options = count($options) > 0 ? array_merge($options, $inputoptions) : $inputoptions;
        //$this->modx->log(modX::LOG_LEVEL_ERROR, print_r($options, true));

//        $this->modx->lexicon->load('asides:default');
//        $this->modx->smarty->assign('asides', $this->modx->lexicon->fetch());

        $this->setPlaceholder('opts', $options);
    }

    /**
     * Prepares the default input options to be usable within the grid store
     *
     * @return array The store array
     */
    public function prepareRecords() {
        $options = $this->getInputOptions();
        //$this->modx->log(modX::LOG_LEVEL_ERROR, print_r($index_list, true));

        $inputoptions = array();
        foreach ($options as $inputoption){
            $inputopt_array = (is_array($inputoption)) ? $inputoption : explode('==', $inputoption);
            $option['value'] = isset($inputopt_array[1]) ? $inputopt_array[1] : $inputopt_array[0];
            $option['text'] = htmlspecialchars($inputopt_array[0], ENT_COMPAT, $this->modx->getOption('modx_charset'));
            $option['checked'] = false;
            $inputoptions[$option['value']] = $option;
        }

        return $inputoptions;
    }
}

return 'modTemplateVarInputRenderAsides';