<?php
/**
 * code example implementing base OOP principles
 * Inheritance (extending from parent class)
 * Encapsulation ( using public, private, protected)
 * Polymorphism (overriding base class method by child class)
 *
 * @author     Eugen <ivanov.yauhen@gmail.com>
 * @link       https://github.com/LosFormento
 */

/**
 * base tag class
 */
class Tag
{
    /**
     * @var $attributes array
     * @var $tag string
     */
    protected array $attributes = [];
    protected string $tag;

    /**
     * @param string $tag tag name (a || label || button ...)
     *
     */
    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Adds attribute to tag
     * @param string $name Name of the attribute
     * @param string $value Value of the attribute
     * @return void
     */
    public function attr(string $name, string $value)
    {
        $this->attributes[] = "{$name} = \"{$value}\"";
    }

    /**
     * renders single tag with its attributes
     * @return string
     */
    public function render(): string
    {
        return "<{$this->tag} {$this->renderAttributes()}>";
    }

    /**
     * renders tag attributes that was set
     * @return string
     */

    protected function renderAttributes(): string
    {
        return implode(' ', $this->attributes);
    }
}

/**
 * single tag
 */
class SingleTag extends Tag
{
}

/**
 * Pair tag class
 */
class PairTag extends Tag
{
    /**
     * @var $children Tag[] Array of children tags
     */
    private array $children = [];

    /**
     * Adds child tag to pair tag object
     * @param Tag $tag Tag object to be added as child
     * @return void
     */
    public function addChild(Tag $tag)
    {
        $this->children[] = $tag;
    }

    /**
     * renders pair tag with its children tags
     *
     * @return string
     */
    public function render(): string
    {
        $result = parent::render();
        if (!empty($this->children)) {
            foreach ($this->children as $child) {
                $result .= $child->render();
            }
        }
        $result .= "</$this->tag>";
        return $result;
    }
}
/*
 * rendering form as example
 */
$imgA = new SingleTag('img');
$imgA->attr('src', 'img1.jpg');
$imgA->attr('alt', '1 not found ');

$inputA = new SingleTag('input');
$inputA->attr('type', 'text');
$inputA->attr('name', 'inputA');

$labelA = new PairTag('label');
$labelA->addChild($imgA);
$labelA->addChild($inputA);

$imgB = new SingleTag('img');
$imgB->attr('src', 'img2.jpg');
$imgB->attr('alt', '2 not found ');

$inputB = new SingleTag('input');
$inputB->attr('type', 'password');
$inputB->attr('name', 'inputB');

$labelB = new PairTag('label');
$labelB->addChild($imgB);
$labelB->addChild($inputB);


$submit = new SingleTag('input');
$submit->attr('type', 'submit');
$submit->attr('value', 'Send');
$form = new PairTag('form');

$form->addChild($labelA);
$form->addChild($labelB);
$form->addChild($submit);

echo($form->render());