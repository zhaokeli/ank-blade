<?php


namespace ank\blade;

use Illuminate\View\Compilers\BladeCompiler;

class Compiler extends BladeCompiler
{
    protected $isDebug = false;

    public function debug(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * Determine if the view at the given path is expired.
     * @param string $path
     * @return bool
     */
    public function isExpired($path)
    {
        if ($this->isDebug) {
            return true;
        }
        $compiled = $this->getCompiledPath($path);

        // If the compiled file doesn't exist we will indicate that the view is expired
        // so that it can be re-compiled. Else, we will verify the last modification
        // of the views is less than the modification times of the compiled views.
        if (!$this->files->exists($compiled)) {
            return true;
        }

        return $this->files->lastModified($path) >=
            $this->files->lastModified($compiled);
    }
}