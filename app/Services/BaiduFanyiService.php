<?php

namespace App\Services;

class BaiduFanyiService
{
  protected string $apiUrl = 'https://fanyi-api.baidu.com/api/trans/vip/translate';
  protected string $appid;
  protected string $seckey;

  public function __construct(string $appid, string $seckey)
  {
    $this->appid = trim($appid);
    $this->seckey = trim($seckey);
  }

  public function translate(string $query, string $from, string $to): ?array
  {
    $args = [
      'q' => $query,
      'appid' => $this->appid,
      'salt' => rand(10000, 99999),
      'from' => $from,
      'to' => $to,
      'tts' => 0,
    ];

    $args['sign'] = $this->buildSign($query, $this->appid, $args['salt'], $this->seckey);
    $response = $this->call($this->apiUrl, $args, 'get');

    return json_decode($response, true);
  }

  protected function buildSign(string $query, string $appID, int $salt, string $secKey): string
  {
    return md5($appID . $query . $salt . $secKey);
  }

  protected function call(string $url, ?array $args = null, string $method = 'post', int $timeout = 10): string|false
  {
    $ch = curl_init();

    if (stripos($url, "https://") !== false) {
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }

    $data = $this->convert($args);
    if ($method === 'post') {
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_POST, 1);
    } elseif ($data) {
      $url .= (stripos($url, '?') > 0 ? '&' : '?') . $data;
    }

    curl_setopt_array($ch, [
      CURLOPT_URL => $url,
      CURLOPT_TIMEOUT => $timeout,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_HTTPHEADER => ["content-type: application/x-www-form-urlencoded; charset=UTF-8"],
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }

  protected function convert(?array $args): string
  {
    if (!$args) return '';
    return http_build_query($args, '', '&', PHP_QUERY_RFC3986);
  }
}
