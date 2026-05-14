<?php

class NewsService
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct()
    {
        // Usa a chave carregada no config.php
        $this->apiKey = NEWS_API_KEY;
        $this->baseUrl = 'https://newsapi.org/v2';

        if (empty($this->apiKey) || $this->apiKey === 'changeme') {
            throw new RuntimeException('NEWS_API_KEY não está configurada no .env');
        }
    }

    /**
     * Busca notícias financeiras.
     *
     * @param string $q Termo de busca (padrão: finance)
     * @param string $language Código do idioma (padrão: pt)
     * @return array Lista de artigos
     */
    public function getFinancialNews(string $q = 'finance', string $language = 'pt'): array
    {
        $tentativas = [
            ['q' => $q,          'language' => $language],        // Ex: finance + pt
            ['q' => 'economia',  'language' => 'pt'],             // Fallback: economia + pt
            ['q' => 'finance',   'language' => 'en'],             // Fallback final: finance + en
        ];

        foreach ($tentativas as $parametros) {
            $url = "{$this->baseUrl}/top-headlines?" . http_build_query([
                'q'       => $parametros['q'],
                'language' => $parametros['language'],
                'apiKey'  => $this->apiKey,
            ]);

            $curl = curl_init($url);
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_HTTPHEADER     => [
                    'Accept: application/json',
                    'User-Agent: PHP-Financas-App'
                ]
            ]);

            $response = curl_exec($curl);
            $error    = curl_error($curl);
            curl_close($curl);

            if ($response === false || $error) {
                if (DEBUG) {
                    error_log("Erro ao buscar notícias: $error");
                }
                continue;
            }

            $data = json_decode($response, true);
            if (isset($data['status']) && $data['status'] === 'ok' && !empty($data['articles'])) {
                return [
                    'artigos' => $data['articles'],
                    'termo'   => $parametros['q'],
                    'idioma'  => $parametros['language']
                ];
            }

            if (DEBUG) {
                error_log("Tentativa falhou: q={$parametros['q']}, lang={$parametros['language']}");
            }
        }

        return ['artigos' => [], 'termo' => '', 'idioma' => ''];
    }
}