<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConnectionTestController extends Controller
{
    public function test(Request $request): JsonResponse
    {
        $service = $request->input('service', '');
        $fields  = (array) $request->input('fields', []);

        try {
            $result = match ($service) {
                'OpenAI'             => $this->testOpenAI($fields),
                'Claude'             => $this->testClaude($fields),
                'Gemini'             => $this->testGemini($fields),
                'TelegramBot'        => $this->testTelegram($fields),
                'BaleBot'            => $this->testBale($fields),
                'WordPress'          => $this->testWordPress($fields),
                'WooCommerce'        => $this->testWooCommerce($fields),
                'GoogleCustomSearch' => $this->testGoogleSearch($fields),
                'GoogleSearchConsole'=> $this->testGoogleSearchConsole($fields),
                'GoogleAnalytics'    => $this->testGoogleServiceAccountJson($fields),
                'GoogleSheets'       => $this->testGoogleServiceAccountJson($fields),
                'MSGway'             => $this->testMSGway($fields),
                'SMTPEmail'          => $this->testSMTP($fields),
                default              => ['ok' => false, 'message' => 'سرویس ناشناخته'],
            };
        } catch (\Throwable $e) {
            $result = ['ok' => false, 'message' => 'خطا در ارتباط با سرور: ' . $e->getMessage()];
        }

        return response()->json($result);
    }

    private function testOpenAI(array $f): array
    {
        if (empty($f['api_key'])) return ['ok' => false, 'message' => 'API Key الزامی است'];
        $res = Http::timeout(8)->withToken($f['api_key'])->get('https://api.openai.com/v1/models');
        if ($res->successful()) return ['ok' => true, 'message' => 'اتصال برقرار شد'];
        if ($res->status() === 401) return ['ok' => false, 'message' => 'API Key نامعتبر است'];
        return ['ok' => false, 'message' => 'خطا: HTTP ' . $res->status()];
    }

    private function testClaude(array $f): array
    {
        if (empty($f['api_key'])) return ['ok' => false, 'message' => 'API Key الزامی است'];
        $res = Http::timeout(8)->withHeaders([
            'x-api-key'         => $f['api_key'],
            'anthropic-version' => '2023-06-01',
        ])->get('https://api.anthropic.com/v1/models');
        if ($res->successful()) return ['ok' => true, 'message' => 'اتصال برقرار شد'];
        if ($res->status() === 401) return ['ok' => false, 'message' => 'API Key نامعتبر است'];
        return ['ok' => false, 'message' => 'خطا: HTTP ' . $res->status()];
    }

    private function testGemini(array $f): array
    {
        if (empty($f['api_key'])) return ['ok' => false, 'message' => 'API Key الزامی است'];
        $res = Http::timeout(8)->get('https://generativelanguage.googleapis.com/v1beta/models', [
            'key' => $f['api_key'],
        ]);
        if ($res->successful()) return ['ok' => true, 'message' => 'اتصال برقرار شد'];
        if (in_array($res->status(), [400, 403])) return ['ok' => false, 'message' => 'API Key نامعتبر است'];
        return ['ok' => false, 'message' => 'خطا: HTTP ' . $res->status()];
    }

    private function testTelegram(array $f): array
    {
        if (empty($f['bot_token'])) return ['ok' => false, 'message' => 'Bot Token الزامی است'];
        $res  = Http::timeout(8)->get("https://api.telegram.org/bot{$f['bot_token']}/getMe");
        $json = $res->json();
        if ($res->successful() && ($json['ok'] ?? false)) {
            $username = $json['result']['username'] ?? '';
            return ['ok' => true, 'message' => 'اتصال برقرار شد' . ($username ? ": @{$username}" : '')];
        }
        return ['ok' => false, 'message' => 'توکن نامعتبر است'];
    }

    private function testBale(array $f): array
    {
        if (empty($f['bot_token'])) return ['ok' => false, 'message' => 'Bot Token الزامی است'];
        $base = rtrim($f['api_base_url'] ?? 'https://tapi.bale.ai', '/');
        $res  = Http::timeout(8)->get("{$base}/bot{$f['bot_token']}/getMe");
        $json = $res->json();
        if ($res->successful() && ($json['ok'] ?? false)) return ['ok' => true, 'message' => 'اتصال برقرار شد'];
        return ['ok' => false, 'message' => 'توکن یا آدرس API نامعتبر است'];
    }

    private function testWordPress(array $f): array
    {
        if (empty($f['site_url'])) return ['ok' => false, 'message' => 'آدرس سایت الزامی است'];
        $url = rtrim($f['site_url'], '/') . '/wp-json/wp/v2/users/me';
        $res = Http::timeout(8)
            ->withBasicAuth($f['username'] ?? '', $f['application_password'] ?? '')
            ->get($url);
        if ($res->successful()) return ['ok' => true, 'message' => 'اتصال برقرار شد'];
        if ($res->status() === 401) return ['ok' => false, 'message' => 'نام کاربری یا Application Password نامعتبر است'];
        if ($res->status() === 404) return ['ok' => false, 'message' => 'آدرس سایت یافت نشد یا REST API غیرفعال است'];
        return ['ok' => false, 'message' => 'خطا: HTTP ' . $res->status()];
    }

    private function testWooCommerce(array $f): array
    {
        if (empty($f['site_url'])) return ['ok' => false, 'message' => 'آدرس سایت الزامی است'];
        $version = trim($f['api_version'] ?? 'wc/v3', '/');
        $url = rtrim($f['site_url'], '/') . '/wp-json/' . $version . '/';
        $res = Http::timeout(8)
            ->withBasicAuth($f['consumer_key'] ?? '', $f['consumer_secret'] ?? '')
            ->get($url);
        if ($res->successful()) return ['ok' => true, 'message' => 'اتصال برقرار شد'];
        if ($res->status() === 401) return ['ok' => false, 'message' => 'Consumer Key یا Consumer Secret نامعتبر است'];
        return ['ok' => false, 'message' => 'خطا: HTTP ' . $res->status()];
    }

    private function testGoogleSearch(array $f): array
    {
        if (empty($f['api_key']) || empty($f['cx'])) {
            return ['ok' => false, 'message' => 'API Key و CX هر دو الزامی هستند'];
        }
        $res = Http::timeout(8)->get('https://www.googleapis.com/customsearch/v1', [
            'key' => $f['api_key'],
            'cx'  => $f['cx'],
            'q'   => 'test',
            'num' => 1,
        ]);
        if ($res->successful()) return ['ok' => true, 'message' => 'اتصال برقرار شد'];
        if (in_array($res->status(), [400, 403])) return ['ok' => false, 'message' => 'API Key یا CX نامعتبر است'];
        return ['ok' => false, 'message' => 'خطا: HTTP ' . $res->status()];
    }

    private function testGoogleSearchConsole(array $f): array
    {
        if (empty($f['refresh_token'])) return ['ok' => false, 'message' => 'Refresh Token الزامی است'];
        $tokenRes = Http::timeout(8)->asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id'     => $f['oauth_client_id'] ?? '',
            'client_secret' => $f['oauth_client_secret'] ?? '',
            'refresh_token' => $f['refresh_token'],
            'grant_type'    => 'refresh_token',
        ]);
        if (!$tokenRes->successful()) return ['ok' => false, 'message' => 'Refresh Token یا OAuth Client نامعتبر است'];
        $accessToken = $tokenRes->json('access_token');
        $siteUrl = $f['site_url'] ?? '';
        $res = Http::timeout(8)->withToken($accessToken)->get(
            'https://searchconsole.googleapis.com/webmasters/v3/sites/' . urlencode($siteUrl)
        );
        if ($res->successful()) return ['ok' => true, 'message' => 'اتصال برقرار شد'];
        return ['ok' => false, 'message' => 'دسترسی به Search Console ممکن نبود'];
    }

    private function testGoogleServiceAccountJson(array $f): array
    {
        if (empty($f['service_account_json'])) {
            return ['ok' => false, 'message' => 'Service Account JSON الزامی است'];
        }
        $json = json_decode($f['service_account_json'], true);
        if (!$json) return ['ok' => false, 'message' => 'فرمت JSON نامعتبر است'];
        if (!isset($json['private_key'], $json['client_email'])) {
            return ['ok' => false, 'message' => 'JSON ناقص است — private_key یا client_email یافت نشد'];
        }
        return ['ok' => true, 'message' => 'Service Account JSON معتبر است'];
    }

    private function testMSGway(array $f): array
    {
        if (empty($f['api_key'])) return ['ok' => false, 'message' => 'API Key الزامی است'];
        if (strlen($f['api_key']) < 16) return ['ok' => false, 'message' => 'فرمت API Key نامعتبر است'];
        return ['ok' => true, 'message' => 'اطلاعات ذخیره شد'];
    }

    private function testSMTP(array $f): array
    {
        if (empty($f['host']) || empty($f['port'])) {
            return ['ok' => false, 'message' => 'Host و Port الزامی هستند'];
        }
        $host    = $f['host'];
        $port    = (int) $f['port'];
        $timeout = 8;

        $errno = $errstr = null;
        $sock = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!$sock) {
            return ['ok' => false, 'message' => "اتصال به {$host}:{$port} ممکن نبود — {$errstr}"];
        }
        fclose($sock);
        return ['ok' => true, 'message' => "اتصال به {$host}:{$port} برقرار شد"];
    }
}
