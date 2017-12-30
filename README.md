# HtmlTagReplace

a helper to replace and enhance html tags and their attributes.

## Features

* Append, prepend and switch tags.
* Add custom attributes to tags
* Switch, clone or remove attributes.

## Usage

Create an Instance of `HtmlTagReplace` passing existing markup.

Use `replaceTag` method of said instance passing the following arguments:

* `search` Name of the tag to be replaced
* `replace` Name of the new tag
* `closingTag` (bool, default: false) defines whether searched tag has closing tag
* `argumentsReplace` (array) key-value pairs (`search => replace`) of attributes to be replaced. Multidimensional (`search => array`) to clone value into multiple arguments.
* `arguments` custom arguments injected
* `append` injected after targeted tag
* `prepend` injected before targeted tag

You can call the method `compress` to minify the markup.

Finally retrieve the altered markup calling `getMarkup`

## Example

```php
$markup = '
    <img src="#" alt="foo">
    <img src="#">
    <div id="foo">bar</div>
    <em class="foo">bar</em>
    <input type="text" name="foo">
';
  
$replacer = new HtmlTagReplace($markup);
  
echo $replacer->replaceTag(
        'img',
        'a',
        false,
        ['src' => 'href', 'alt' => false],
        'title="show image"',
        'show image</a>'
    )->replaceTag(
        'div',
        'article',
        true,
        ['id' => 'class'],
        null,
        null,
        '<hr>'
    )->replaceTag(
        'em',
        'strong',
        true
    )->replaceTag(
        'input',
        'input',
        false,
        ['name' => ['name', 'id']]
    )->compress()->getMarkup();
```

will result in (not minified for readability):

```html
<a title="show image" href="#">show image</a>
<a title="show image" href="#">show image</a>
<hr><article class="foo">bar</article>
<strong class="foo">bar</strong>
<input type="text" name="foo" id="foo">
```

# Todos

* add more filter options for targeting tags
* optimize method for filtering and replacing arguments
* content manipulation
* synchronized replacement