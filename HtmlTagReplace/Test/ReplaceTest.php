<?php

namespace HtmlTagReplace\Test;

use HtmlTagReplace\HtmlTagReplace;

/**
 * Class ReplaceTest
 * @package HtmlTagReplace\Test
 */
class ReplaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HtmlTagReplace
     */
    private $replacer;

    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->replacer = new HtmlTagReplace(<<<EOF
<img src="#" alt="nope">
<img src="#">
<div id="foo">bar</div>
<em class="foo">bar</em>
<input type="text" name="foo">
EOF
        );
    }

    public function testMarkupManipulation()
    {
        $expected = <<<EOF
<a title="show image" href="#">show image</a> <a title="show image" href="#">show image</a> <hr><article class="foo">bar</article> <strong class="foo">bar</strong> <input type="text" name="foo" id="foo">
EOF;


        $actual = $this->replacer->replaceTag(
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


        $this->assertEquals($expected, $actual);
    }
}