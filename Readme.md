# PHP Payload data class
You can build data with any format, extract and send to any other server. Then can rebuild and retrieve by exactly the data key that was being used to build it without any issues

### Installation

You can pull the package via composer :

```bash
composer require satheez/php-payload
```

### Usage
```php
// Build & export the added data:
$payload = new \Php\Data\Payload();
$payload->add('animal.dog.name', 'Zoe');
$payload->add('animal.dog.age', 8);

$payload->add('animal.cat', [
    'name' => 'Snowy',
    'age' => 3
]);

$data = $payload->export();// Exported data

// Import and retrieve the data:
// Method 1:
$payload1 = new \Php\Data\Payload($data);

// Method 2:
$payload2 = new \Php\Data\Payload();
$payload2->import($data);

// Retrieve
$dog = $payload1->get('animal.dog.name'); // Zoe
```

### Testing

```sh
> ./vendor/bin/phpunit tests
```
