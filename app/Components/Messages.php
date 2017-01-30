<?php

namespace App\Components;

class Messages
{
    const ERROR = 'error';
    const SUCCESS = 'success';
    const WARNING = 'warning';

    public function displayError()
    {
        return $this->display($this->getError());
    }

    public function displayWarning()
    {
        return $this->display($this->getWarning());
    }

    public function displaySuccess()
    {
        return $this->display($this->getSuccess());
    }

    public function error(array $messages)
    {
        $this->set(self::ERROR, $messages);
    }

    public function success(array $messages)
    {
        $this->set(self::SUCCESS, $messages);
    }

    public function warning(array $messages)
    {
        $this->set(self::WARNING, $messages);
    }

    public function getError()
    {
        return $this->get(self::ERROR);
    }

    public function getSuccess()
    {
        return $this->get(self::SUCCESS);
    }

    public function getWarning()
    {
        return $this->get(self::WARNING);
    }

    public function hasError()
    {
        return $this->has(self::ERROR);
    }

    public function hasSuccess()
    {
        return $this->has(self::SUCCESS);
    }

    public function hasWarning()
    {
        return $this->has(self::WARNING);
    }

    private function has($type)
    {
        return \Session::has($type);
    }

    private function set($type, array $messages)
    {
        \Session::push($type, $messages);
    }

    private function get($type)
    {
        $messages = \Session::get($type);
        \Session::forget($type);
        return $this->filterMessages($messages);
    }

    private function filterMessages($messages)
    {
        $uniqueMessages = [];
        foreach ($messages as $message) {
            if (!in_array($message[0], $uniqueMessages)) {
                $uniqueMessages[] = $message[0];
            }
        }

        return $uniqueMessages;
    }

    private function display($messages)
    {
        $response = '';
        foreach ($messages as $message) {
            if (is_array($message)) {
                foreach ($message as $item) {
                    if (!is_array($item)) {
                        $response .= '<li>' . $item . '</li>';
                    } else {
                        foreach ($item as $i) {
                            $response .= '<li>' . $i . '</li>';
                        }
                    }
                }
            } else {
                $response .= '<li>' . $message . '</li>';
            }
        }

        return $response;
    }
}