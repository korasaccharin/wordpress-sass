<?php
class FileException extends Exception {};
class IOError extends FileException {};
class TypeError extends FileException {};

class SASS_Stylesheet
{
    private $debug_mode;
    private $src;
    private $path;
    private $file;
    private $target;
    private $uri;
    # ----------------------------------------------------------------------
    # Public methods
    # ----------------------------------------------------------------------
    public function __construct($src)
    {
        $this->debug_mode = false;
        $this->src        = $src;
    }
    public function is_valid()
    {
        if (!file_exists($this->file())) {
            if ($this->debug_mode) {
                throw new IOError(sprintf("No such file or directory: %s", $this->file()));
            }
            return false;
        }
        $extension = $this->file()->getExtension();
        if ('sass' !== $extension and 'scss' !== $extension) {
            if ($this->debug_mode) {
                throw new TypeError(sprintf("Unexpected file type: %s", $this->file()));
            }
            return false;
        }
        return true;
    }
    public function is_uptodate()
    {
        if (!file_exists($this->target())) return false;

        return $this->file()->getMTime() > $this->target()->getMTime();
    }
    public function compile()
    {
        if (!class_exists('SassParser')) return false;

        $parser = new SassParser(array('cache' => false));
        $css    = $parser->toCss($this->file()->getRealPath());

        if (!is_writable($this->target()) and $this->debug_mode) {
            throw new IOError(sprintf("Access error: %s", $this->target()));
        }
        $this->target()->fwrite($css);

        return true;
    }
    public function version()
    {
        return $this->target()->getMTime();
    }
    # ----------------------------------------------------------------------
    # Accessors
    # ----------------------------------------------------------------------
    public function file()
    {
        if (!$this->path()) return null;
        if (!isset($this->file)) {
            $this->file = new SplFileInfo(get_stylesheet_directory() . DIRECTORY_SEPARATOR . $this->path);
        }
        return $this->file;
    }
    public function path()
    {
        if (!isset($this->path)) {
            $this->path = str_replace(dirname(get_stylesheet_uri()) . '/', '', $this->src());
        }
        return $this->path;
    }
    public function target()
    {
        $file = $this->file();
        if (!isset($file)) return null;
        if (!isset($this->target)) {
            $filename = $this->file()->getBasename('.' . $this->file()->getExtension());
            $filepath = sprintf('%s/%s.css', $this->file()->getPath(), $filename);
            $this->target = new SplFileObject($filepath, 'w');
        }
        return $this->target;
    }
    public function uri()
    {
        if (!isset($this->uri)) {
            $this->uri = sprintf('%s/%s/%s', dirname(get_stylesheet_uri()), dirname($this->path()), $this->target->getFilename());
        }
        return $this->uri;
    }
    public function src()
    {
        return $this->src;
    }
    public function __get($attribute)
    {
        if (property_exists($this, $attribute)) return $this->$attribute;
    }
    public function __set($attribute, $value)
    {
        if (property_exists($this, $attribute)) {
            $this->$attribute = $value;
            return $this;
        }
    }
}