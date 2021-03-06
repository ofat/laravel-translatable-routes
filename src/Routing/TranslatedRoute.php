<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes\Routing;

use Illuminate\Routing\Route;

class TranslatedRoute extends Route
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->action['as'] ?? $this->action['defaultName'] ?? null;
    }

    /**
     * Get locale of the route instance
     */
    public function getLocale(): mixed
    {
        return $this->action['locale'] ?? null;
    }

    /**
     * Add default name for the route instance
     *
     * @param $name
     *
     * @return $this
     */
    public function defaultName($name): static
    {
        $this->action['defaultName'] = isset($this->action['locale']) ? $this->action['locale'] . '.' . $name : $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function name($name): static
    {
        if (isset($this->action['as'])) {
            $this->action['as'] .= $name;
        } elseif (isset($this->action['locale'])) {
            $this->action['as'] = $this->action['locale'] . '.' . $name;
        } else {
            $this->action['as'] = $name;
        }

        return $this;
    }
}
