HTML Builder
============


Attributes Builder
------------------


```php
use Becklyn\HtmlBuilder\AttributesBuilder;

$builder = new AttributesBuilder();

$attributes = $builder->build([
    "href" => "https://becklyn.com",
    "target" => "_blank",
]);

echo "<a {$attributes}>Becklyn</a>"; 
```

Special values:

*   `false`: entry will be omitted
*   `null`: will be omitted
*   `true`: will be rendered as boolean attribute, eg. `"checked" => true` as `<input checked>`.
