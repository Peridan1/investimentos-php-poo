<?php

class CotaService
{
    private string $baseUrl;

    public function __construct()
    {
        // Usa constante global do config, se existir, senão fallback.
        $this->baseUrl = defined('AWESOME_API_BASE')
            ? rtrim(AWESOME_API_BASE, '/')
            : 'https://economia.awesomeapi.com.br/json';
    }

    /**
     * Busca a cotação de uma ou mais moedas.
     * @param string $moedas Exemplo: "USD-BRL,EUR-BRL,BTC-BRL"
     * @return array Estrutura: [ 'USDBRL' => ['name' => 'Dólar/Real', 'high' => 5.10, ...], ... ]
     */
    public function getCotacao(string $moedas): array
    {
        $url = $this->baseUrl . '/last/' . $moedas;

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
        ]);

        $response = curl_exec($curl);
        $error    = curl_error($curl);
        curl_close($curl);

        if ($response === false || $error) {
            // Se não conseguiu resposta, retorna array vazio
            return [];
        }

        $data = json_decode($response, true);

        if (!is_array($data)) {
            return [];
        }

        // Padroniza os valores numéricos
        foreach ($data as &$info) {
            $info['high']  = (float)($info['high'] ?? 0);
            $info['low']   = (float)($info['low'] ?? 0);
            $info['bid']   = (float)($info['bid'] ?? 0);
        }

        return $data;
    }
}