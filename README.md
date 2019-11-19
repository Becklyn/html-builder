HTML Builder
============


Elements Builder
----------------

```php
use Becklyn\HtmlBuilder\Builder\HtmlBuilder;
use Becklyn\HtmlBuilder\Node\HtmlElement;

$builder = new HtmlBuilder();

$link = new HtmlElement("a", [
    "href" => "https://becklyn.com", 
], [
    "Becklyn Studios"
]);

assert('<a href="https://becklyn.com">Becklyn Studios</a>' === $builder->buildElement($link));
```


Attributes Builder
------------------


```php
use Becklyn\HtmlBuilder\Builder\HtmlBuilder;
use Becklyn\HtmlBuilder\Node\HtmlAttributes;

$builder = new HtmlBuilder();

$attributes = $builder->buildAttributes(new HtmlAttributes([
    "href" => "https://becklyn.com",
    "target" => "_blank",
]));

echo "<a {$attributes}>Becklyn</a>"; 
```


Special values:

*   `false`: entry will be omitted
*   `null`: will be omitted
*   `true`: will be rendered as boolean attribute, eg. `"checked" => true` as `<input checked>`.


```php
$full = $builder->build([
    "first" => "a",
    "removed1" => false,
    "removed2" => null,
    "checked" => true,
    "last" => "b",
]);


assert($full === 'first="a" checked last="b"'); // true
```

Adding pre-compiled HTML to an element
--------------------------------------

To avoid automatic escaping of the content, you can use `SafeMarkup`:

```php
$link = new HtmlElement("div");
$link->addContent(new SafeMarkup("This will <b>not</b> be escaped!"));

assert('<div>This will <b>not</b> be escaped!</div>' === $builder->buildElement($link));
```
