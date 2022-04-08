<?php

Post::check([
    'site_url' => 'required|link|max:150',
    'admin_url' => 'required|link|max:150',
    'username' => 'required|max:100',
    'password' => 'required|max:100',
    'titles' => 'max:1000',
    'who' => 'checkbox',
    'special' => 'checkbox'
], [
    'site_url.required' => 'Site adresi girilmelidir.',
    'admin_url.required' => 'Yönetim paneli adresi girilmelidir.',
    'username.required' => 'Yönetim paneli kullanıcı adı girilmelidir.',
    'password.required' => 'Yönetim paneli şifresi girilmelidir.',

    'site_url.max:150' => 'Site adresi en fazla 150 karakter olmalıdır.',
    'admin_url.max:150' => 'Yönetim paneli adresi en fazla 150 karakter olmalıdır.',
    'username.max:100' => 'Yönetim paneli kullanıcı adı en fazla 100 karakter olmalıdır.',
    'password.max:100' => 'Yönetim paneli şifresi en fazla 100 karakter olmalıdır.',
    'titles.max:1000' => 'Başlıklar en fazla 1000 karakter olmalıdır.',

    'site_url.link' => 'Site adresi link olarak girilmelidir.',
    'admin_url.link' => 'Yönetim paneli adresi link olarak girilmelidir.'
]);

if (Post::$outputMessages) {
    echo json_encode(Post::$outputMessages);
} else {
    $cleanOutputs = Post::$cleanOutputs;

    /*
        Array
        (
            [site_url] => asd.com
            [admin_url] => asd.com
            [username] => asd
            [password] => asdasdasd
            [who] => 1
            [special] => 0
        )
    */

}

?>
