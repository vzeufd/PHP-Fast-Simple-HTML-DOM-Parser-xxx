<?php

namespace FastSimpleHTMLDom;


use DOMElement;
use DOMNode;

/**
 * Class Element
 * @package FastSimpleHTMLDom
 * @property string outertext Get dom node's outer html
 * @property string innertext Get dom node's inner html
 * @property string plaintext Get dom node's plain text
 */
class Element implements \IteratorAggregate
{
    /**
     * @var DOMElement
     */
    protected $node;

    public function __construct(DOMNode $node)
    {
        $this->node = $node;
    }

    /**
     * @return DOMNode
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Replace this node
     *
     * @param $string
     * @return $this
     */
    protected function replaceNode($string)
    {
        $newDocument = new Document($string);
        $newNode = $this->node->ownerDocument->importNode($newDocument->getDocument()->lastChild->firstChild->firstChild, true);

        $this->node->parentNode->replaceChild($newNode, $this->node);

        return $this;
    }

    /**
     * Replace child node
     *
     * @param $string
     * @return $this
     */
    protected function replaceChild($string)
    {
        $newDocument = new Document($string);
        $newNode = $this->node->ownerDocument->importNode($newDocument->getDocument()->lastChild->firstChild->firstChild, true);

        foreach ($this->node->childNodes as $node) {
            $this->node->removeChild($node);
        }
        $this->node->appendChild($newNode);

        return $this;
    }

    /**
     * @return Document
     */
    public function getDom()
    {
        return new Document($this);
    }

    /**
     * Find list of nodes with a CSS selector
     *
     * @param string $selector
     * @param int $idx
     * @return NodeList|Element|null
     */
    public function find($selector, $idx = null)
    {
        return $this->getDom()->find($selector, $idx);
    }

    /**
     * Return Element by id
     *
     * @param $id
     * @return Element|null
     */
    public function getElementById($id)
    {
        return $this->find("#$id", 0);
    }

    /**
     * Returns Elements by id
     *
     * @param $id
     * @param null $idx
     * @return Element|NodeList|null
     */
    public function getElementsById($id, $idx = null)
    {
        return $this->find("#$id", $idx);
    }

    /**
     * Return Element by tag name
     *
     * @param $name
     * @return Element|null
     */
    public function getElementByTagName($name)
    {
        return $this->find($name, 0);
    }

    /**
     * Returns Elements by tag name
     *
     * @param $name
     * @param null $idx
     * @return Element|NodeList|null
     */
    public function getElementsByTagName($name, $idx = null)
    {
        return $this->find($name, $idx);
    }

    /**
     * Returns children of node
     *
     * @param int $idx
     * @return NodeList|Element|null
     */
    public function childNodes($idx = -1)
    {
        $nodeList = $this->getIterator();

        if ($idx === -1) {
            return $nodeList;
        }

        if (isset($nodeList[$idx])) {
            return $nodeList[$idx];
        }

        return null;
    }

    /**
     * Returns children of node
     *
     * @param int $idx
     * @return NodeList|Element|null
     */
    public function children($idx = -1)
    {
        return $this->childNodes($idx);
    }

    /**
     * Returns the first child of node
     *
     * @return Element|null
     */
    public function firstChild()
    {
        $node = $this->node->firstChild;

        if ($node === null) {
            return null;
        }

        return new Element($node);
    }

    /**
     * Returns the first child of node
     *
     * @return Element|null
     */
    public function first_child()
    {
        return $this->firstChild();
    }

    /**
     * Returns the last child of node
     *
     * @return Element|null
     */
    public function lastChild()
    {
        $node = $this->node->lastChild;

        if ($node === null) {
            return null;
        }

        return new Element($node);
    }

    /**
     * Returns the last child of node
     *
     * @return Element|null
     */
    public function last_child()
    {
        return $this->lastChild();
    }

    /**
     * Returns the next sibling of node
     *
     * @return Element|null
     */
    public function nextSibling()
    {
        $node = $this->node->nextSibling;

        if ($node === null) {
            return null;
        }

        return new Element($node);
    }

    /**
     * Returns the next sibling of node
     *
     * @return Element|null
     */
    public function next_sibling()
    {
        return $this->nextSibling();
    }

    /**
     * Returns the previous sibling of node
     *
     * @return Element|null
     */
    public function previousSibling()
    {
        $node = $this->node->previousSibling;

        if ($node === null) {
            return null;
        }

        return new Element($node);
    }

    /**
     * Returns the previous sibling of node
     *
     * @return Element|null
     */
    public function prev_sibling()
    {
        return $this->previousSibling();
    }

    /**
     * Returns the parent of node
     *
     * @return Element
     */
    public function parentNode()
    {
        return new Element($this->node->parentNode);
    }

    /**
     * Returns the parent of node
     *
     * @return Element
     */
    public function parent()
    {
        return $this->parentNode();
    }

    /**
     * Get dom node's outer html
     *
     * @return string
     */
    public function html()
    {
        return $this->getDom()->html();
    }

    /**
     * Get dom node's inner html
     *
     * @return string
     */
    public function innerHtml()
    {
        return $this->getDom()->innerHtml();
    }

    /**
     * Get dom node's plain text
     *
     * @return string
     */
    public function text()
    {
        return $this->node->textContent;
    }

    /**
     * Get dom node's outer html
     *
     * @return string
     */
    public function outertext()
    {
        return $this->innerHtml();
    }

    /**
     * Get dom node's inner html
     *
     * @return string
     */
    public function innertext()
    {
        return $this->html();
    }

    /**
     * Returns array of attributes
     *
     * @return array|null
     */
    public function getAllAttributes()
    {
        if ($this->node->hasAttributes()) {
            $attributes = [];
            foreach ($this->node->attributes as $attr) {
                $attributes[$attr->name] = $attr->value;
            }
            return $attributes;
        }
        return null;
    }

    /**
     * Return attribute value
     *
     * @param string $name
     * @return string|null
     */
    public function getAttribute($name)
    {
        return $this->node->getAttribute($name);
    }

    /**
     * Set attribute value
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function setAttribute($name, $value)
    {
        if (empty($value)) {
            $this->node->removeAttribute($name);
        } else {
            $this->node->setAttribute($name, $value);
        }

        return $this;
    }

    /**
     * Determine if an attribute exists on the element.
     *
     * @param $name
     * @return bool
     */
    public function hasAttribute($name)
    {
        return $this->node->hasAttribute($name);
    }

    /**
     * @param $name
     * @return array|null|string
     */
    function __get($name) {
        switch ($name) {
            case 'outertext': return $this->outertext();
            case 'innertext': return $this->innertext();
            case 'plaintext': return $this->text();
            case 'tag'      : return $this->node->nodeName;
            case 'attr'     : return $this->getAllAttributes();
            default         : return $this->getAttribute($name);
        }
    }

    function __set($name, $value) {
        switch ($name) {
            case 'outertext': return $this->replaceNode($value);
            case 'innertext': return $this->replaceChild($value);
            default         : return $this->setAttribute($name, $value);
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name) {
        switch ($name) {
            case 'outertext':
            case 'innertext':
            case 'plaintext':
            case 'tag'      : return true;
            default         : return $this->hasAttribute($name);
        }
    }
    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return NodeList An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        $elements = new NodeList();
        if ($this->node->hasChildNodes()) {
            foreach ($this->node->childNodes as $node) {
                $elements[] = new Element($node);
            }
        }
        return $elements;
    }
}
