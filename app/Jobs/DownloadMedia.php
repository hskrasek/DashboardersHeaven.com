<?php

namespace DashboardersHeaven\Jobs;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Uuid;

class DownloadMedia extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $media;

    public function __construct(Model $media)
    {
        $this->media = $media;
    }

    /**
     * Execute the job.
     *
     * @param Filesystem $filesystem
     *
     * @return bool|void
     */
    public function handle(Filesystem $filesystem, Repository $config)
    {
        $domain = $config->get('app.url');
        if (strpos($this->media->url, $domain)) {
            return;
        }

        $filename = $this->getFileName();
        $path     = $this->getPath($filename);

        if ($filesystem->exists($path . '/' . $filename)) {
            return;
        }

        if ($filesystem->put($path . '/' . $filename, fopen($this->media->url, 'r'))) {
            $this->media->update([
                'downloaded' => true,
                'url'        => $domain . '/' . $path . '/' . $filename
            ]);
        }
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return (string) Uuid::uuid5(Uuid::NAMESPACE_DNS, $this->getParsedUrl()) . '.MP4';
    }

    private function getPath($filename)
    {
        return trim(implode('/', [
            substr($filename, 0, 2),
            substr($filename, 2, 2),
        ]), '/');
    }

    private function getParsedUrl()
    {
        $parsed = explode('?', $this->media->url);

        return head($parsed);
    }
}
