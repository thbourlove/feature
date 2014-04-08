<?php
namespace Feature\Provider\Twig;

class Node extends \Twig_Node
{
    public function __construct($name, $value, \Twig_NodeInterface $body, $lineno, $tag = 'feature')
    {
        parent::__construct(compact('body'), compact('name', 'value'), $lineno, $tag);
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $name = $this->getAttribute('name');
        $value = $this->getAttribute('value');
        $body = $this->getNode('body');
        $compiler
            ->addDebugInfo($this)
            ->write('if ($context[\'features\']->variant(\''.$name.'\')');
        if ($value) {
            $compiler->raw(" == '$value') {\n");
        } else {
            $compiler->raw(") {\n");
        }
        $compiler
            ->indent()
            ->subcompile($body)
            ->outdent()
            ->write("}\n");
    }
}
