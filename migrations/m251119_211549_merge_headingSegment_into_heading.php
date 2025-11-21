<?php

namespace craft\contentmigrations;

use Craft;
use craft\migrations\BaseFieldMergeMigration;

/**
 * m251119_211549_merge_headingSegment_into_heading migration.
 */
class m251119_211549_merge_headingSegment_into_heading extends BaseFieldMergeMigration
{
    public string $persistingFieldUid = 'cf7038b3-3aa7-4d1f-8a12-1cf0017d5b2c';
    public string $outgoingFieldUid = 'a65ec270-2111-40c2-bf47-f3d6d929603a';
}
