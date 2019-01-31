<?php

namespace Core\Http\Component;


class Session implements SessionInterface
{
    private $sessions = [];

    /**
     * Session constructor.
     * @param array $sessions
     */
    public function __construct(array $sessions)
    {
        $this->sessions = $sessions;
    }

    public function getAttribute(string $key): string
    {
        return isset($this->sessions[$key]) ? $this->sessions[$key] : "";
    }

    public function setAttribute(string $key, string $value)
    {
        $this->sessions[$key] = $value;
    }
}