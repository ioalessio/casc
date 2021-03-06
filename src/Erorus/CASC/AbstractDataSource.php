<?php

namespace Erorus\CASC;

abstract class AbstractDataSource
{
    abstract public function findHashInIndexes($hash);
    abstract protected function fetchFile($locationInfo, $destPath);

    public function extractFile($locationInfo, $destPath, $contentHash = false) {
        $success = $this->fetchFile($locationInfo, $destPath);

        $success &= file_exists($destPath);
        $success &= filesize($destPath) > 0;
        $success &= !$contentHash || ($contentHash === md5_file($destPath, true));

        if (!$success) {
            unlink($destPath);
        }

        return $success;
    }
}