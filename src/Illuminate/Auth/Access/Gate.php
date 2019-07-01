<?php

namespace MatthiasWilbrink\AfterGate\Illuminate\Auth\Access;

use Illuminate\Auth\Access\Gate as IlluminateGate;

class Gate extends IlluminateGate
{
    /**
     * Call all of the after callbacks with check result.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $ability
     * @param  array $arguments
     * @param  bool $result
     * @return bool|null
     */
    protected function callAfterCallbacks($user, $ability, array $arguments, $result)
    {
        foreach ($this->afterCallbacks as $after) {
            if (! $this->canBeCalledWithUser($user, $after)) {
                continue;
            }

            $afterResult = $after($user, $ability, $result, $arguments);

            // Let the Gate::after prevail over the result
            $result = $afterResult ?? $result;
        }

        return $result;
    }
}
