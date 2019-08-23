<?php
/*
 * @ PHP 5.6
 * @ Decoder version : 1.0.0.1
 * @ Release on : 24.03.2018
 * @ Website    : http://EasyToYou.eu
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\Translation\Tests\Writer;

use Symfony\Component\Translation\Dumper\DumperInterface;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Writer\TranslationWriter;
class TranslationWriterTest extends \PHPUnit_Framework_TestCase
{
    public function testWriteTranslations()
    {
        $dumper = $this->getMock('Symfony\\Component\\Translation\\Dumper\\DumperInterface');
        $dumper->expects($this->once())->method('dump');
        $writer = new TranslationWriter();
        $writer->addDumper('test', $dumper);
        $writer->writeTranslations(new MessageCatalogue(array()), 'test');
    }
    public function testDisableBackup()
    {
        $nonBackupDumper = new NonBackupDumper();
        $backupDumper = new BackupDumper();
        $writer = new TranslationWriter();
        $writer->addDumper('non_backup', $nonBackupDumper);
        $writer->addDumper('backup', $backupDumper);
        $writer->disableBackup();
        $this->assertFalse($backupDumper->backup, 'backup can be disabled if setBackup() method does exist');
    }
}
class NonBackupDumper implements DumperInterface
{
    public function dump(MessageCatalogue $messages, $options = array())
    {
    }
}
class BackupDumper implements DumperInterface
{
    public $backup = true;
    public function dump(MessageCatalogue $messages, $options = array())
    {
    }
    public function setBackup($backup)
    {
        $this->backup = $backup;
    }
}

?>