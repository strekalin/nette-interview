<?php
namespace App\Macros;

use \Latte\Macros\MacroSet;
use \Latte\MacroNode;
use \Latte\PhpWriter;
use \Latte\Compiler;

final class DatetimeMacros extends MacroSet
{
    /**
     * {@inheritDoc}
     * @see MacroSet::install()
     */
    public static function install(Compiler $compiler) :self
    {
        $self = new static($compiler);
        $self->addMacro('datetime', [$self, 'datetime']);
        return $self;
    }
    
    /**
     * Datetime macros
     *
     * @param MacroNode $node
     * @param PhpWriter $writer
     * @return string
     */
    public function datetime(MacroNode $node, PhpWriter $writer)
    {
        return $writer->write(
            'echo %node.word->format(\'d.m.Y H:i:s\');'
            );
    }
}