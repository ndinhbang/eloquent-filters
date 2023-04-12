<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Http\Request;
use Ndinhbang\EloquentFilters\Contracts\Pipe;

abstract class Base implements Pipe
{
    public function __construct(
        protected Request $request,
        protected ?string $key,
        protected ?string $prefix = null,
        protected array   $ignores = [null, ''],
    )
    {
        //
    }

    protected function value()
    {
        return $this->request->input($this->accessor());
    }

    /**
     * @return string
     */
    public function accessor(): string
    {
        return !is_null($this->prefix)
            ? $this->prefix . '.' . $this->key
            : $this->key;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @param array $ignores
     * @return $this
     */
    public function ignores(array $ignores): static
    {
        $this->ignores = $ignores;

        return $this;
    }

    /**
     * @return bool
     */
    protected function shouldSkip(): bool
    {
        if (!$this->request->has($this->accessor()) || in_array($this->value(), $this->ignores)) {
            return true;
        }

        return false;
    }

    /**
     * @param BuilderContract $query
     * @return BuilderContract
     */
    public function handle(BuilderContract $query): BuilderContract
    {
        if ($this->shouldSkip()) {
            return $query;
        }

        return $this->apply($query);
    }

    abstract protected function apply(BuilderContract $query): BuilderContract;

}
