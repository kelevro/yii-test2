<?php

namespace mail;

/**
 * Mail module
 *
 * @property bool $now is use queue manager
 * @property int  $testMailsCount count mails in test mode
 * @package mail
 */
class Module extends \common\base\Module
{
    public $now = true;

    public $useTestEmail = false;

    public $testMailsCount = 10;
}