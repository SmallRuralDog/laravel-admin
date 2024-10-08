<?php

namespace SmallRuralDog\Admin\Renderer\Form;

/**
 * 树型选择框
 * @method self hideRoot($v)
 * @method self rootLabel($v)
 * @method self rootValue($v)
 * @method self showIcon($v)
 * @method self cascade($v)
 * @method self withChildren($v)
 * @method self onlyChildren($v)
 * @method self onlyLeaf($v)
 * @method self rootCreatable($v)
 * @method self hideNodePathLabel($v)
 * @method self enableNodePath($v)
 * @method self pathSeparator($v)
 * @method self showOutline($v)
 */
class TreeSelect extends InputTree
{
    public string $type = 'tree-select';

}
