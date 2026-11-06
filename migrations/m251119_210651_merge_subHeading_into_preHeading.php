<?php

namespace craft\contentmigrations;

use Craft;
use craft\migrations\BaseFieldMergeMigration;

/**
 * m251119_210651_merge_subHeading_into_preHeading migration.
 */
class m251119_210651_merge_subHeading_into_preHeading extends BaseFieldMergeMigration
{
    public string $persistingFieldUid = 'a65ec270-2111-40c2-bf47-f3d6d929603a';
    public string $outgoingFieldUid = '3b943244-76d1-4973-9d71-6ec6c109e255';
}
