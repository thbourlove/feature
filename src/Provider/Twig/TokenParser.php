<?php
namespace Feature\Provider\Twig;

class TokenParser extends \Twig_TokenParser
{
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();

        $parser = $this->parser;
        $stream = $parser->getStream();

        $name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
        $value = '';
        if (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
            $stream->expect(\Twig_Token::OPERATOR_TYPE, '-');
            $value = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
        };
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new Node($name, $value, $body, $lineno, $this->getTag());
    }

    public function decideBlockEnd(\Twig_Token $token)
    {
        return $token->test('endfeature');
    }

    public function getTag()
    {
        return 'feature';
    }
}
