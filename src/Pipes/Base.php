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
    public function prefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return string|null
     */
    public function field(): ?string
    {
        return !empty($fields = $this->fields()) ? $fields[0] : null;
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return $this->columns ?? ((array)$this->key);
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

    protected function shouldIgnore(string|array|int|float|bool|null $value): bool
    {
        return collect((array) $value)->every(fn($item) => in_array($item, $this->ignores));
    }

    /**
     * @param string|array|int|float|bool|null $value
     * @return bool
     */
    public function shouldSkip(string|array|int|float|bool|null $value): bool
    {
        return empty($value) || $this->shouldIgnore($value);
    }

    /**
     * @param BuilderContract $query
     * @return BuilderContract
     */
    public function handle(BuilderContract $query): BuilderContract
    {
        if ($this->shouldSkip($value = $this->value())) {
            return $query;
        }

        return $this->apply($query, $value);
    }

    abstract protected function apply(BuilderContract $query, string|array|int|float|bool|null $value): BuilderContract;

}
