# [Wirecard AG](http://www.wirecard.com/) PHP API

## Installation

Configure your serializer:
``` php
$serializer = SerializerBuilder::create()
    ->addMetadataDir('path/to/src/Serializer/Metadata', 'Wirecard\Element')
    ->build();
```            

## Usage

See [GatewayTest](tests/Functional/GatewayTest.php) for general use and [Gateway3DSecureTest](tests/Functional/Gateway3DSecureTest.php) for 3-D secure.

## Testing

For full test:
``` bash
$ phpunit
```

For test without gateway testing:
``` bash
$ phpunit --exclude-group large
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.