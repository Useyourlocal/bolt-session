<?php

namespace Bolt\Session\Handler;

use Bolt\Filesystem\Exception\IOException;
use Bolt\Filesystem\Handler\DirectoryInterface;
use Bolt\Filesystem\Handler\FileInterface;

/**
 * Bolt's Filesystem abstraction session handler.
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class FilesystemHandler extends AbstractHandler
{
    /** @var DirectoryInterface */
    protected $directory;

    /**
     * Constructor.
     *
     * @param DirectoryInterface $directory
     */
    public function __construct(DirectoryInterface $directory)
    {
        $this->directory = $directory;
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function read($sessionId)
    {
        try {
            return $this->directory->getFile($sessionId)->read();
        } catch (IOException $e) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function write($sessionId, $data)
    {
        $this->directory->getFile($sessionId)->put($data);
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function destroy($sessionId)
    {
        try {
            $this->directory->getFile($sessionId)->delete();
        } catch (IOException $e) {
        }
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function gc($maxlifetime)
    {
        if (!$this->directory->exists()) {
            return;
        }

        $files = $this->directory->find()
            ->files()
            ->ignoreDotFiles(false)
            ->date("< now - $maxlifetime seconds")
        ;
        foreach ($files as $file) {
            /* @var $file FileInterface */
            $file->delete();
        }
    }
}
