<?php declare(strict_types=1);

namespace PhpAT\Selector;

use PhpAT\File\FileFinder;

class PathSelector implements SelectorInterface
{
    private const DEPENDENCIES = [
        FileFinder::class
    ];

    /** @var string */
    private $path;

    /** @var FileFinder */
    private $fileFinder;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /** @return string[] */
    public function getDependencies(): array
    {
        return self::DEPENDENCIES;
    }

    public function injectDependencies(array $dependencies): void
    {
        $this->fileFinder = $dependencies[FileFinder::class];
    }

    /** @return \SplFileInfo[] */
    public function select(): array
    {
        $result = [];
        foreach ($this->fileFinder->findFiles($this->path) as $file) {
            $result[$file->getPathname()] = $file;
        }
        return $result;
    }
}
