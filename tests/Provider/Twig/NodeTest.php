<?php
namespace Feature\Tests\Provider\Twig;

use Feature\Provider\Twig\Node;

class NodeTest extends \Twig_Test_NodeTestCase
{
    public function testConstruct()
    {
        $body = new \Twig_Node(array(new \Twig_Node_Text('nothing', 2)));
        $node = new Node('foo', 'a', $body, 1);

        $this->assertEquals($node->getNode('body'), $body);
        $this->assertEquals($node->getAttribute('name'), 'foo');
        $this->assertEquals($node->getAttribute('value'), 'a');
    }

    public function getTests()
    {
        $body = new \Twig_Node(array(new \Twig_Node_Text('nothing', 2)));
        $nodeFoo = new Node('foo', 'a', $body, 1);

        $tests[] = array(
            $nodeFoo,
            "// line 1\nif (\$context['features']->variant('foo') == 'a') {\n".
            "    // line 2\n    echo \"nothing\";\n".
            "}"
        );

        $nodeBar = new Node('bar', '', $body, 1);
        $tests[] = array(
            $nodeBar,
            "// line 1\nif (\$context['features']->variant('bar')) {\n".
            "    // line 2\n    echo \"nothing\";\n".
            "}"
        );

        return $tests;
    }
}
