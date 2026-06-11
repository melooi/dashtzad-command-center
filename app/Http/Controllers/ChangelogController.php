<?php

namespace App\Http\Controllers;

class ChangelogController extends Controller
{
    public function index()
    {
        $path = base_path('CHANGELOG.md');
        $releases = file_exists($path)
            ? $this->parse(file_get_contents($path))
            : [];

        return view('changelog.index', compact('releases'));
    }

    private function parse(string $content): array
    {
        $releases    = [];
        $current     = null;
        $catIdx      = null;

        foreach (explode("\n", $content) as $line) {
            // ## [v0.1.0] - 1405/03/21
            if (preg_match('/^##\s+\[(.+?)\]\s+-\s+(.+)$/u', $line, $m)) {
                if ($current !== null) {
                    $releases[] = $current;
                }
                $current = [
                    'version'    => $m[1],
                    'date'       => trim($m[2]),
                    'categories' => [],
                ];
                $catIdx = null;
                continue;
            }

            if ($current === null) continue;

            // ### Added / Fixed / ...
            if (preg_match('/^###\s+(.+)$/u', $line, $m)) {
                $name = trim($m[1]);
                $meta = $this->categoryMeta($name);
                $current['categories'][] = [
                    'name'  => $name,
                    'label' => $meta['label'],
                    'class' => $meta['class'],
                    'items' => [],
                ];
                $catIdx = count($current['categories']) - 1;
                continue;
            }

            // - item  or  * item
            if ($catIdx !== null && preg_match('/^[-*]\s+(.+)$/u', $line, $m)) {
                $current['categories'][$catIdx]['items'][] = trim($m[1]);
            }
        }

        if ($current !== null) {
            $releases[] = $current;
        }

        return array_values(array_filter($releases, fn($r) => !empty($r['categories'])));
    }

    private function categoryMeta(string $name): array
    {
        return match (strtolower(trim($name))) {
            'added'                 => ['label' => 'اضافه‌شده', 'class' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30'],
            'changed'               => ['label' => 'تغییر',      'class' => 'bg-blue-500/15 text-blue-400 border-blue-500/30'],
            'fixed'                 => ['label' => 'اصلاح',      'class' => 'bg-amber-500/15 text-amber-400 border-amber-500/30'],
            'removed'               => ['label' => 'حذف',        'class' => 'bg-red-500/15 text-red-400 border-red-500/30'],
            'security'              => ['label' => 'امنیت',      'class' => 'bg-rose-500/15 text-rose-400 border-rose-500/30'],
            'docs', 'documentation' => ['label' => 'مستندات',    'class' => 'bg-slate-600/30 text-slate-300 border-slate-600/40'],
            default                 => ['label' => $name,        'class' => 'bg-slate-500/15 text-slate-400 border-slate-500/30'],
        };
    }
}
