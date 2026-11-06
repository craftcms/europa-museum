<?php

namespace craft\contentmigrations;

use Craft;
use craft\migrations\BaseFieldMergeMigration;

/**
 * m251119_212300_merge_rightStatLabel_into_leftStatLabel migration.
 */
class m251119_212300_merge_rightStatLabel_into_leftStatLabel extends BaseFieldMergeMigration
{
    public string $persistingFieldUid = '4c127ec9-df18-4d62-bd02-cf8b5044f7ea';
    public string $outgoingFieldUid = '5ccbb75b-a9e9-455a-baf9-60aaa799d452';
}
