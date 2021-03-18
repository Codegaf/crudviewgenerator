# CrudViewGenerator Frontend

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codegaf/crudviewgenerator.svg?style=flat-square)](https://packagist.org/packages/codegaf/crudviewgenerator)
[![Total Downloads](https://img.shields.io/packagist/dt/codegaf/crudviewgenerator.svg?style=flat-square)](https://packagist.org/packages/codegaf/crudviewgenerator)

Generador de crud frontend para 10codesoftware.

## Instalación

Puedes instalar el paquete via composer:

```bash
composer require codegaf/crudviewgenerator
```

## Guía de uso

El comando crud generator de la parte del front genera los siguientes archivos dentro de la carpeta del nombre del modelo en camel case:

- Index (index.blade.php).
- Create (create.blade.php).
- Edit (edit.blade.php).
- CreateEditForm (create.edit.form.blade.php).

El crud generator necesita conocer unos datos previos para su funcionamiento correcto. Estos datos lo especificaremos en una plantilla config que tendrá su ubicación en la carpeta config/models. El nombre del archivo seguirá la convención singular camelCase. Ejemplos: user, userContact, car… Por ejemplo, imaginemos que los usuarios tienen contactos, relación 1:N, un usuario tiene muchos contactos y cada contacto pertenece a un usuario.

Al igual que en el crud generator del backend, necesitamos incorporar un nuevo índice en el config.

Este índice puede tener la siguiente estructura ejemplo:

``` php
'form' => [
   'name' => [
       'input' => 'text',
       'id' => 'name',
       'label' => 'global.name'
   ],

   'surname' => [
       'input' => 'text',
       'id' => 'surname',
       'label' => 'global.surname'
   ],

   'email' => [
       'input' => 'email',
       'id' => 'email',
       'label' => 'global.email'
   ],

   'phone' => [
       'input' => 'text',
       'id' => 'phone',
       'label' => 'global.phone'
   ],

   'born_date' => [
       'input' => 'date',
       'id' => 'born_date',
       'label' => 'global.born_date'
   ],

],
```

Los índices del array form serán los name del formulario, que tendrá que coincidir con los nombres de la columna de la base de datos para que la automatización de almacenamiento de datos, sea correcta.

Los parámetros aceptados en cada array name son los siguientes:

input -> String. Obligatorio. Es el tipo de campo que se generará en el formulario. 
id -> String. Opcional. El id que tendrá el campo.
label -> String. Obligatorio. Es el label del campo del formulario.

En esta primera versión de la plantilla, los tipo de inputs que están soportados son: text, email, date, time, textarea.

El comando que genera la parte frontend del crud generator es el siguiente:

```bash
php artisan crud:viewgenerator model --all
```

En el comando podemos observar dos opciones:

model -> Obligatorio. Tendremos que facilitar el nombre del modelo en formato mayúscula, singular y camel case. Ejemplos: User, UserContact, Cars…

--all -> Opcional. Si añadimos esta opción el crud generator creará todas las clases especificadas arriba sin preguntar. Si no lo añadimos, el comando nos pedirá confirmación de cada una de las clases para crearlas o no.


### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

### Security

If you discover any security related issues, please email isaaccamrod@gmail.com instead of using the issue tracker.

## Credits

- [Isaac Campos](https://github.com/10codesoftware)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
