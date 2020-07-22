<?php
namespace App\Macros;

use \Latte\Macros\MacroSet;
use \Latte\MacroNode;
use \Latte\PhpWriter;
use \Latte\Compiler;

final class MarkdownMacros extends MacroSet
{
    /**
     * {@inheritDoc}
     * @see MacroSet::install()
     */
    public static function install(Compiler $compiler) : self
    {
        $self = new static($compiler);
        $self->addMacro('markdown', [$self, 'markdown']);
        return $self;
    }

    /**
     * Markdown macros
     * 
     * @param MacroNode $node
     * @param PhpWriter $writer
     * @return string
     */
    public function markdown(MacroNode $node, PhpWriter $writer)
    {
        return $writer->write(
            'echo \Michelf\Markdown::defaultTransform(%node.word);'
        );
    }
}