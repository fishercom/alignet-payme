# Laravel Payme Alignet :credit_card:

Este paquete está destinado para la integración de una manera más rápida y sencilla de la pasarela de pagos de Alignet.

## Instalación
Registra el Service Provider de esta aplicación en `config/app.php`
```php
    'providers' => [
        // ... Otros providers aquí
        LaravelPaymeAlignet\Providers\LaravelPaymeServiceProvider::class,   
    ]
```

Agrega el Facade a la lista de alias en `config/app.php`
```php
    'aliases' => [
        // ... Otros aliases aquí
        'LaravelPayme' => LaravelPaymeAlignet\Facades\LaravelPayme::class,   
    ]
```

### Colocar las variables de entorno
Este paquete usa su configuración interna, la cual siempre apunta al archivo interno `laravel-payme.php`.
Necesitas configurar de siguientes variables en tu archivo `.env`
```ini
PAYME_URL=
PAYME_ACQUIRER_ID=
PAYME_WALLET_COMMERCE_ID=
PAYME_WALLET_COMMERCE_SECRET=
PAYME_COMMERCE_ID=
PAYME_VPOS_SECRET_KEY=
PAYME_CURRENCY_CODE=
```

## Uso
### Registrar u obtener usuario en Payme
```php
use LaravelPayme;

LaravelPayme::registerUser($userId, $emailUser, $nameUser, $lastnameUser, array $moreData = []);
```

### Crear una orden de compra en Payme
```php
use LaravelPayme;

LaravelPayme::generatePaymentOrderByTokenUser($tokenUser, $purchaseUniqueId, $purchaseTotal);
```

### Pendientes
- Add config publication docs
- Add english readme
