<?php

declare(strict_types=1);

namespace Eddieodira\Messager\Services;

use Eddieodira\Messager\Entities\SMSTemplate;
use Eddieodira\Messager\Models\SMSTemplatesModel;

class Templates
{
    protected SMSTemplatesModel $model;

    public function __construct(SMSTemplatesModel $model = new SMSTemplatesModel)
    {
        $this->model = $model;
    }

    public function findTemplates()
    {
        return $this->model->findAll();
    }

    public function findById(int|string $id): ?SMSTemplate
    {
        return $this->model->find($id);
    }

    public function findByWhere(string $column, string|int $where): ?SMSTemplate
    {
        return $this->model->where($column, $where)->first();
    }

    /**
     * Fetch template by code and auto-extract placeholders.
     */
    private function getContentByCode(string $code): ?string
    {
        $template = $this->findByWhere('code', $code);
        if (! is_null($template)) {
            return $template->content;
        }

        return null;
    }

    public function create(array $post)
    {
        //$data = $entity->toRawArray();
        $data = $this->model->newSMSTemplate([
            'code'          => $post['code'], 
            'name'          => $post['name'], 
            'content'       => $post['content']
        ]);
        return $this->model->create($data);
    }

    public function update(array $data, int|string $id)
    {
        return $this->model->updateById($id, $data);
    }

    /**
     * Render a template string with placeholders and optional default values.
     *
     * Syntax: {key:default}
     * Example: "Hello {username:User}" → "Hello Eddy" or "Hello User"
     *
     * @param string $content The template string
     * @param array $data Key-value pairs to replace placeholders
     * @return string Rendered message
     */
    public function renderTemplate(string $code, array $data): ?string
    {
        // Fetch template by code
        $content = $this->getContentByCode($code);

        if (! is_null($content)) {
            // Match placeholders with optional default values
            preg_match_all('/\{(\w+)(?::([^}]+))?\}/', $content, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $key     = $match[1];              // e.g. "username"
                $default = $match[2] ?? '';        // e.g. "User"
                $value   = $data[$key] ?? $default;

                // If still empty and no default, throw error
                if ($value === '' && $default === '') {
                    throw new \RuntimeException("Missing placeholder: {$key}");
                }

                $content = str_replace($match[0], $value, $content);
            }
            return $content;
        }
        return null;
    }

    /**
     * Extract placeholders from a template string.
     *
     * @param string $template The template text
     * @return array<string,string|null> Associative array: [placeholder => default|null]
     */
    public function extractPlaceholders(string $code): ?array
    {
        // Fetch template by code
        $content = $this->getContentByCode($code);

        if (! is_null($content)) {
            preg_match_all('/\{([a-zA-Z_]\w*)(?::([^}]+))?\}/', $content, $matches);

            $placeholders = [];
            foreach ($matches[1] as $i => $name) {
                $placeholders[$name] = $matches[2][$i] !== '' ? $matches[2][$i] : null;
            }

            return $placeholders;
        }
        return null;
    }

}
