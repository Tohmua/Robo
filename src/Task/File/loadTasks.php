<?php
namespace Robo\Task\File;

use Robo\Collection\Temporary;

trait loadTasks
{
    /**
     * @param $files
     * @return Concat
     */
    protected function taskConcat($files)
    {
        return new Concat($files);
    }

    /**
     * @param $file
     * @return Replace
     */
    protected function taskReplaceInFile($file)
    {
        return new Replace($file);
    }

    /**
     * @param $file
     * @return Write
     */
    protected function taskWriteToFile($file)
    {
        return new Write($file);
    }

    protected function taskReadFile($file)
    {
        return new Read($file);
    }

    protected function taskCheckMd5($file)
    {
        return new MD5($file);
    }

    /**
     * @param $prefix
     * @param $base
     * @param $includeRandomPart
     * @return TmpFile
     */
    protected function taskTmpFile($filename = 'tmp', $extension = '', $baseDir = '', $includeRandomPart = true)
    {
        return Temporary::wrap(new TmpFile($filename, $extension, $baseDir, $includeRandomPart));
    }
}
