<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Hosts that disable PHP's symlink() (most shared hosting, this included)
 * can't use `storage:link`, and where the Laravel app lives one directory
 * below the actual document root (see DEPLOYMENT.md's "flatten public"
 * setup), there's no live symlink keeping storage/app/public in sync with
 * the public web root at all. This command copies anything new or changed
 * across, so uploads show up without a manual step after every deploy.
 */
class SyncPublicStorage extends Command
{
    protected $signature = 'storage:sync-public';

    protected $description = 'Copy new/changed files from storage/app/public to PUBLIC_STORAGE_SYNC_PATH';

    public function handle(): int
    {
        $dest = config('filesystems.public_storage_sync_path');

        if (empty($dest)) {
            $this->comment('PUBLIC_STORAGE_SYNC_PATH is not set — skipping (nothing to do on hosts with a working storage:link).');

            return self::SUCCESS;
        }

        $source = storage_path('app/public');

        if (! is_dir($source)) {
            $this->comment('No storage/app/public directory yet — skipping.');

            return self::SUCCESS;
        }

        $copied = 0;
        $copied += $this->syncDir($source, rtrim($dest, '/'));

        $this->info($copied > 0 ? "Synced {$copied} file(s) to {$dest}." : 'Nothing new to sync.');

        return self::SUCCESS;
    }

    private function syncDir(string $source, string $dest): int
    {
        if (! is_dir($dest)) {
            mkdir($dest, 0755, true);
        }

        $copied = 0;

        foreach (scandir($source) as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $srcPath = "$source/$entry";
            $destPath = "$dest/$entry";

            if (is_dir($srcPath)) {
                $copied += $this->syncDir($srcPath, $destPath);
                continue;
            }

            if (! file_exists($destPath) || filemtime($srcPath) > filemtime($destPath) || filesize($srcPath) !== filesize($destPath)) {
                copy($srcPath, $destPath);
                $copied++;
            }
        }

        return $copied;
    }
}
