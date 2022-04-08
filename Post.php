<?php

class Post {
    public static $outputRuleMessages = [];
    public static $outputMessages = [];
    public static $cleanOutputs = [];
    public static $messages = [
        'required' => '%s kısmı boş bırakılmamalıdır.',
        'idrequired' => '%s değeri bulunamadı.',
        'email' => '%s kısmı e-posta formatında olmalıdır.',
        'phone' => '%s kısmı istenilen formatta girilmelidir.',
        'url' => '%s kısmı link formatında olmalıdır.',
        'min' => '%s kısmı en az %s karakter içermelidir.',
        'max' => '%s kısmı en fazla %s karakter içerebilir.',
        'number' => '%s kısmı sayısal bir değer olmalıdır.',
        'float' => '%s kısmı sayısal bir değer olmalıdır.',
        'username' => '%s kısmı harf, sayı ve alt tire (_) karakterlerinden oluşmalıdır.'
    ];

    public static function set($name, $value) {
        $_POST[$name] = $value;
    }

    public static function get($name) {
        return isset($_POST[$name]) ? $_POST[$name] : false;
    }

    public static function ruleCheck($output, $rules) {
        $rules = explode('|', $rules);
        $cleanOutput = self::clean($output);
        foreach ($rules as $rule) {
            if ($rule == 'required') {
                if (!strlen($cleanOutput)) {
                    self::$outputMessages[$output] = self::$outputRuleMessages[$output . '.' . $rule];
                    break;
                }
            } else {
                if (strlen($cleanOutput) != 0) {
                    if ($rule == 'email'){
                        if (!filter_var($cleanOutput, FILTER_VALIDATE_EMAIL)) self::$outputMessages[$output][] = self::$outputRuleMessages[$output . '.' . $rule];
                    } elseif ($rule == 'checkbox' || $rule == 'radio') {
                        if ($cleanOutput == '') $cleanOutput = 0;
                        else $cleanOutput = 1;
                    } elseif ($rule == 'phone') {
                        if (!preg_match('/^\+90 \(\d{3}\) \d{3} \d{2} \d{2}$/', $cleanOutput)) self::$outputMessages[$output][] = self::$outputRuleMessages[$output . '.' . $rule];
                    } elseif ($rule == 'link') {
                        if (!preg_match('/(https?:\/\/)?(www\.)?[a-z]{1}[a-z-]{1,61}[a-z]{1}\.[a-z]{2,10}[-a-zA-Z0-9@:%_\+\.~#?&\/=]*/', $cleanOutput)) self::$outputMessages[$output][] = self::$outputRuleMessages[$output . '.' . $rule];
                    } elseif (strstr($rule, 'min:')) {
                        if (strlen($cleanOutput) < explode(':', $rule)[1]) self::$outputMessages[$output][] = self::$outputRuleMessages[$output . '.' . $rule];
                    } elseif (strstr($rule, 'max:')) {
                        if (strlen($cleanOutput) >= explode(':', $rule)[1]) self::$outputMessages[$output][] = self::$outputRuleMessages[$output . '.' . $rule];
                    } elseif ($rule == 'number') {
                        if (!preg_match('/^\d+$/', $cleanOutput)) self::$outputMessages[$output][] = self::$outputRuleMessages[$output . '.' . $rule];
                    } elseif ($rule == 'float') {
                        if (!preg_match('/^(\d+)(\.\d{1,2})?$/', $cleanOutput)) self::$outputMessages[$output][] = self::$outputRuleMessages[$output . '.' . $rule];
                    } elseif ($rule == 'username') {
                        if (!preg_match('/^[A-Za-zçöışğüÜĞŞİÇÖ0-9_]+$/', $cleanOutput)) self::$outputMessages[$output][] = self::$outputRuleMessages[$output . '.' . $rule];
                    }
                }
            }
        }
        if(empty(self::$outputMessages[$output]) && strlen($cleanOutput) != 0) {
            self::$cleanOutputs[$output] = $cleanOutput;
        }
    }

    public static function clean($name) {
        return trim(str_replace("\xc2\xa0", '', self::get($name)));
    }

    public static function check($outputs, $outputRuleMessages = []) {
        self::$outputRuleMessages = $outputRuleMessages;
        foreach($outputs as $output => $rules) {
            if (strlen($rules) != 0) {
                self::ruleCheck($output, $rules);
            } else {
                self::$cleanOutputs[$output] = self::clean($output);
            }
        }
    }
}

?>
