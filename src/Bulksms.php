<?php

declare(strict_types=1);

namespace Eddieodira\Messager;

use CodeIgniter\HTTP\CURLRequest;
use Eddieodira\Messager\Constant\Constants;
use Eddieodira\Messager\Services\Templates;
use Eddieodira\Messager\Entities\SMSRecord;
use Eddieodira\Messager\Entities\SMSTemplate;
use Eddieodira\Messager\Exception\MessagerException;

class Bulksms extends Constants
{
    protected Templates $service;
    protected CURLRequest $client;

    public function __construct()
    {
        $this->service = new Templates();
        $this->client = service('curlrequest');
    }

    private function request(string $endPoint, array $params): array
    {
        $response = $this->client->request('POST', 
            setting('Bulksms.baseUrl') . $endPoint, [
            'headers' => [
                'apikey'        => setting('Bulksms.apikey'),
                'cache-control' => 'no-cache',
                'content-type'  => 'application/x-www-form-urlencoded',
            ],
            'form_params' => array_merge([
                self::PARAM_USERID          => setting('Bulksms.userId'),
                self::PARAM_PASSWORD        => setting('Bulksms.password'),
                self::PARAM_SENDERID        => setting('Bulksms.senderId'),
                self::PARAM_SEND_METHOD     => self::QUICK_MESSAGE,
                self::PARAM_FORMAT          => self::FORMAT_JSON,
                self::PARAM_MESSAGE_TYPE    => self::TYPE_TEXT_MESSAGE
            ], $params),
            self::PARAM_SSL_VERIFY => setting('Bulksms.verify'),
            self::PARAM_TIMEOUT => setting('Bulksms.timeout'),
            self::PARAM_CONNECT_TIMEOUT => setting('Bulksms.connectTimeout'),
            self::PARAM_HTTP_ERRORS => setting('Bulksms.httpErrors'),
            self::PARAM_DEBUG => setting('Bulksms.debug')
        ]);
        
        return [
            'status'  => $response->getStatusCode(),
            'body'    => json_decode($response->getBody(), true)
        ];
    }

    public function send(string|array $phone, string $msg, ?string $date = null)
    {
        if (! $this->is_connected()) {
            return [
                'status'  => 'error',
                'message' => 'No internet connection'
            ];
        }
        
        $recipient = (is_array($phone)) ? implode(',', $phone) : $phone;
        $result = $this->request('send', [
            self::PARAM_CHECK_DUPLICATE => self::CHECK_DUPLICATE,
            self::PARAM_SCHEDULE   => (! is_null($date)) ? $date : null,
            self::PARAM_PHONE      => $recipient,
            self::PARAM_MESSAGE    => $msg,
        ]);
        return $this->is_successful($result);
    }

    public function balance()
    {
        return $this->request('balance', []);
    }

    public function findTemplates()
    {
        return $this->service->findTemplates();
    }

    public function findTemplate(int|string $id): ?SMSTemplate
    {
        return $this->service->findTemplate($id);
    }

    public function findByWhere(string $column, string|int $where): ?SMSTemplate
    {
        return $this->service->findByWhere($column, $where);
    }

    public function create(array $data)
    {
        return $this->service->create($data);
    }

    public function update(array $data, int|string $id)
    {
        return $this->service->update($data, $id);
    }

    public function render(string $code, array $data): ?string
    {
        return $this->service->renderTemplate($code, $data);
    }

    public function extractPlaceholders(string $code): array
    {
         return $this->service->extractPlaceholders($code);
    }
}