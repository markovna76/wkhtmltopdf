<?php

namespace App\Converter;

final class Client
{
    private const URI = 'http://topdf.k8s.example/';
    private static $instance = [];

    /**
     * @return static::class
     */
    public static function getInstance(): self
    {
        if (empty(self::$instance[static::class])) {
            self::$instance[static::class] = new static();
        }
        return self::$instance[static::class];
    }

    public function get(string $source, int $dpi, string $footer = null): ?string
    {
        $ch = curl_init(self::URI);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ['html' => $source, 'dpi' => $dpi, 'footer' => $footer]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        if ((int) curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200) {
            return $data;
            curl_close($ch);
        }
        return null;
    }

    public function getWithGuzzle1(string $source, int $dpi, string $footer = null): ?string
    {
        $data = null;
        try {
            $response = (new \GuzzleHttp\Client())
                ->request(
                    'POST',
                    self::URI,
                    ['form_params' => ['html' => $source, 'dpi' => $dpi, 'footer' => $footer]]
                );
            if ((int) $response->getStatusCode() === 200) {
                $data = $response->getBody()->getContents();
            }
        } catch (\Throwable $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
        }
        return $data;
    }

    public function getWithGuzzle2(string $source, int $dpi, string $footer = null): ?string
    {
        $data = null;
        try {
            $response = (new \GuzzleHttp\Client())
                ->send(
                    new \GuzzleHttp\Psr7\ServerRequest('POST', self::URI),
                    ['body' => ['html' => $source, 'dpi' => $dpi, 'footer' => $footer]]
                );
            if ((int) $response->getStatusCode() === 200) {
                $data = $response->getBody()->getContents();
            }
        } catch (\Throwable $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
        }
        return $data;
    }
}

// usage:
// $pdf = Client::getInstance()->get($htmlString, 94);
