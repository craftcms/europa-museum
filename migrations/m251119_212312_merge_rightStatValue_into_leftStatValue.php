<?php

namespace craft\contentmigrations;

use Craft;
use craft\migrations\BaseFieldMergeMigration;

/**
 * m251119_212312_merge_rightStatValue_into_leftStatValue migration.
 */
class m251119_212312_merge_rightStatValue_into_leftStatValue extends BaseFieldMergeMigration
{
    public string $persistingFieldUid = '7cce3872-9055-454a-8fdc-45cbccec785b';
    public string $outgoingFieldUid = '5f06df0c-02b7-4b2d-9b75-4b22a09c3a12';
}
