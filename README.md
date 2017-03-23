#### unlembilisim/ileti-merkezi-sms Overview:

Laravel 5 ve üzeri sürümler için

Basit ve kolay kullanım.

##### 1. Kurulum

```bash
composer require unlembilisim/ileti-merkezi-sms 
```

##### 2. `config/services.php` içerisine:

```php
'iletimerkezi' => [
        'username' => env('ILETIMERKEZI_USERNAME'),
        'password' => env('ILETIMERKEZI_PASSWORD'),
        'endpoint' => env('ILETIMERKEZI_ENDPOINT'),
        'title' => env('ILETIMERKEZI_TITLE'),
    ],
```

##### 3. Daha sonra `config/app.php` dosyasına


```php
UnlemBilisim\IletiMerkeziServiceProvider::class,
``` 

Ekleyip. Notification nesnesi olarak kullanabilirsiniz.