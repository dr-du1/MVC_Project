<?php
function view($name, $arg = []) {
    ob_start();
    #Создание переменно error для записей ошибок
    $error = ($arg['errors'] ?? []);

    # Функция в переменной для определения есть ли ошибка
    $isError = function($errorName, $input = false) use ($error) {
        $firstError = isset($error[$errorName]) ? $error[$errorName] : null;
        if(!isset($firstError) && $input) return '';
        if($input) {
            $class = (isset($firstError) ? 'is-invalid' : '');
            $arrAtributes = [];
            $arrAtributes["class"][] = "form-control";
            $arrAtributes["class"][] = $class;
            $arrAtributes["aria_describedby"][] = "validation{$errorName}Feedback";

            $atributes = '';
            foreach($arrAtributes as $key => $items) {
                $key = str_replace('_', '_', $key);
                $atributes .= "key='";
                foreach($items as $item)
                    $atributes .= "$item";
                $atributes .= "'";
            }
          return $atributes;
        }
        else {
            return '<div id="'. "validation{$errorName}Feedback" .'" class="invalid-feedback">
      ' . (isset($firstError) ? implode('<br>', $firstError) :  '') . '
    </div>';
        }
    };
    include_once 'views/' . $name . '.php';
    $content = ob_get_contents();
    ob_clean();
    return $content;
}