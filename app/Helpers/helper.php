<?php

use App\Models\Address\District;
use App\Models\Address\LocalBody;
use App\Models\Address\Province;
use App\Models\Settings\LetterHead;
use App\Models\Settings\OfficeSetting;
use App\Models\Settings\Revenue;
use App\Models\Settings\RevenueCategory;
use App\Traits\NepaliDateConverter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

if (! function_exists('officeSetting')) {
    function officeSetting(?int $ward = null)
    {
        $officeSettings = Cache::rememberForever('office_setting', function () {
            if (Schema::hasTable('office_settings')) {

                return OfficeSetting::with(['fiscalYear', 'province', 'district', 'localBody'])->first();
            }
            return [];
        });

            return $officeSettings?->whereNull('ward_no')->first();

    }
}

if (! function_exists('letterHead')) {
    function letterHead($type = 'header')
    {
        if (Schema::hasTable('letter_heads')) {
            $letterHead = auth()->user()->letterHead
                ?? (auth()->user()->role->letterHead ?? null)
                ?? LetterHead::first();

            return $type == 'letter_head' ? ($letterHead->letter_head ?? '') : ($letterHead->header ?? '');
        }

        return [];
    }
}
if (! function_exists('letterHeadEn')) {
    function letterHeadEn()
    {
        if (Schema::hasTable('letter_heads')) {
            $letterHead = auth()->user()->letterHead
                ?? (auth()->user()->role->letterHead ?? null)
                ?? LetterHead::first();

            return $letterHead?->header_en;
        }

        return [];
    }
}

if (! function_exists('get_provinces')) {
    function get_provinces(?int $provinceId = null)
    {
        $provinces = Cache::rememberForever('provinces', function () {
            if (Schema::hasTable('provinces')) {
                return Province::all();
            }

            return [];
        });
        if ($provinceId !== null) {
            $provinces = $provinces->where('id', $provinceId)->first();
        }

        return $provinces ?? [];
    }
}

if (! function_exists('get_districts')) {
    function get_districts($province_ids = [], ?int $districtId = null)
    {
        $province_ids = is_array($province_ids) ? $province_ids : [$province_ids];
        $allDistricts = Cache::rememberForever('allDistricts', function () {
            if (Schema::hasTable('districts')) {
                return District::orderBy('province_id')->get();
            }

            return [];
        });
        if (! empty($province_ids)) {
            $allDistricts = $allDistricts->whereIn('province_id', $province_ids);
        }
        if ($districtId !== null) {
            $allDistricts = $allDistricts->where('id', $districtId)->first();
        }

        return $allDistricts ?? [];
    }
}

if (! function_exists('get_local_bodies')) {
    function get_local_bodies($district_ids = [], ?int $localBodyId = null)
    {
        $district_ids = is_array($district_ids) ? $district_ids : [$district_ids];
        $allLocalBodies = Cache::rememberForever('localBodies', function () {
            if (Schema::hasTable('local_bodies')) {
                return LocalBody::all();
            }

            return [];
        });
        if (! empty($district_ids)) {
            $allLocalBodies = $allLocalBodies->whereIn('district_id', $district_ids);
        }
        if ($localBodyId !== null) {
            $allLocalBodies = $allLocalBodies->where('id', $localBodyId)->first();
        }

        return $allLocalBodies ?? [];
    }
}

if (! function_exists('getArrayKeys')) {
    function getArrayKeys($array = []): array
    {
        $keys = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $keys = array_merge($keys, getArrayKeys($value));
            } else {
                $keys[] = $key;
            }
        }

        return array_unique($keys);
    }
}

if (! function_exists('removeColumns')) {
    function removeColumns($array, $excludeColumns): Collection
    {
        foreach ($array as &$element) {
            if (is_array($element)) {
                $element = removeColumns($element, $excludeColumns);
            } else {
                foreach ($excludeColumns as $column) {
                    if (array_key_exists($column, $array)) {
                        unset($array[$column]);
                    }
                }
            }
        }

        return collect($array);
    }
}

if (! function_exists('renderListData')) {
    function renderListData($data): void
    {
        foreach ($data as $value) {
            if (is_array($value)) {
                renderListData($value);
            } else {
                echo '<td>' . $value . '</td>';
            }
        }
    }
}

if (! function_exists('getFileType')) {
    function getFileType($base64String): string
    {
        $startPos = strpos($base64String, ':') + 1;
        $endPos = strpos($base64String, ';');

        return substr($base64String, $startPos, $endPos - $startPos);
    }
}

if (! function_exists('base64ToFile')) {
    function base64ToFile($base64String, $fileType): string
    {
        $randomString = Str::random(32);
        $extension = explode('/', $fileType)[1];
        $fileName = "images/{$randomString}.{$extension}";
        $data = base64_decode($base64String);
        Storage::put($fileName, $data);

        return $fileName;
    }
}

if (! function_exists('isBase64')) {
    function isBase64($string): bool
    {
        $bool = false;
        if (str_contains($string, 'data:')) {
            $bool = true;
        }

        return $bool;
    }
}

if (! function_exists('getAllForSideBarFolders')) {
    function getAllForSideBarFolders(string $folder)
    {
        if (Storage::disk('public')->exists($folder)) {
            $directories = collect(Storage::disk('public')->directories($folder, true))->map(function ($item) {
                return explode('/', $item);
            });

            return convertPathsToTree($directories);
        }

        return [];
    }
}

if (! function_exists('getAllFilesAndFolder')) {
    function getAllFilesAndFolder(string $folder): array
    {
        if (Storage::disk('public')->exists($folder)) {
            $directories = collect(Storage::disk('public')->directories($folder))->map(function ($item) {
                return explode('/', $item);
            });
            $files = collect(Storage::disk('public')->files($folder))->map(function ($item) {
                return explode('/', $item);
            });

            return [
                'directories' => convertPathsToTree($directories),
                'files' => convertPathsToTree($files),
            ];
        }

        return [];
    }
}

if (! function_exists('convertPathsToTree')) {
    function convertPathsToTree($paths, $separator = '/', $parent = null)
    {
        return $paths
            ->groupBy(function ($parts) {
                return $parts[0];
            })->map(function ($parts, $key) use ($separator, $parent) {
                $childrenPaths = $parts->map(function ($parts) {
                    return array_slice($parts, 1);
                })->filter();
                $path = $parent . $key;
                $response = [
                    'label' => (string) $key,
                    'path' => $path,
                ];
                if ($isFile = File::isFile(public_path('storage/' . $path))) {
                    $response['isFile'] = $isFile;
                    $response['detail'] = [
                        'size' => convert_to_highest_unit(File::size(public_path('storage/' . $path))),
                        'icon' => getFileIconClass(File::mimeType(public_path('storage/' . $path))),
                        'extension' => File::extension(public_path('storage/' . $path)),
                        'name' => File::name(public_path('storage/' . $path)),
                    ];
                } else {
                    $response['isFile'] = false;
                    $response['children'] = convertPathsToTree(
                        $childrenPaths,
                        $separator,
                        $path . $separator
                    );
                }

                return $response;
            })->values();
    }
}

if (! function_exists('convert_to_highest_unit')) {
    function convert_to_highest_unit($bytes): string
    {
        $bytes = (int) $bytes;
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes >= 1) {
            $bytes = $bytes . ' bytes';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}

if (! function_exists('getFileIconClass')) {
    function getFileIconClass(string $mime): string
    {
        return match ($mime) {
            'pdf' => 'fa-file-pdf',
            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'fa-file-word',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'fa-file-excel',
            'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'fa-file-powerpoint',
            'application/zip', 'application/x-rar-compressed' => 'fa-file-archive',
            'jpeg', 'png', 'gif', 'jpg' => 'fa-file-image',
            'mpeg', 'x-wav' => 'fa-file-audio',
            'mp4', 'x-msvideo' => 'fa-file-video',
            default => 'fa-file',
        };
    }
}

if (! function_exists('get_revenue_categories')) {
    function get_revenue_categories(?int $revenueCategoryId = null, bool $all = false)
    {
        $revenueCategories = Cache::remember('revenueCategories',60*60*24, function () {
            if (Schema::hasTable('revenue_categories')) {
                return RevenueCategory::with('revenueCategories')->get();
            }

            return [];
        });
        if ($all) {
            $revenueCategories = $revenueCategories->whereNull('revenue_category_id');
        }
        if ($revenueCategoryId !== null) {
            $revenueCategories = $revenueCategories->where('id', $revenueCategoryId)->first();
        }
        return $revenueCategories ?? [];
    }
}

if (! function_exists('get_revenues')) {
    function get_revenues($revenueCategories = [], ?int $revenueId = null)
    {
        $revenueCategories = is_array($revenueCategories) ? $revenueCategories : [$revenueCategories];
        $revenues = Cache::rememberForever('revenues', function () {
            if (Schema::hasTable('revenues')) {
                return Revenue::orderBy('revenue_category_id')->get();
            }

            return [];
        });
        if (! empty($revenueCategories)) {
            $revenues = $revenues->whereIn('revenue_category_id', $revenueCategories);
        }
        if ($revenueId !== null) {
            $revenues = $revenues->where('id', $revenueId)->first();
        }

        return $revenues ?? [];
    }
}

if (! function_exists('get_file_type')) {
    function get_file_type($extension): string
    {
        return match ($extension) {
            'jpg', 'jpeg', 'png', 'gif', 'bmp', 'ico', 'webp' => 'image',
            'pdf' => 'PDF',
            'doc', 'docx', 'odt', 'rtf', 'txt' => 'document',
            'mp3', 'wav', 'wma', 'aac', 'flac' => 'audio',
            'mp4', 'avi', 'wmv', 'mov', 'flv' => 'video',
            'zip', 'rar', '7z', 'tar' => 'archive',
            default => 'unknown',
        };
    }
}

if (! function_exists('get_nepali_number')) {
    function get_nepali_number($data): string|array
    {
        return str_replace(['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'], ['१', '२', '३', '४', '५', '६', '७', '८', '९', '०'], $data);
    }
}
if (! function_exists('get_english_number')) {
    function get_english_number($data): string|array
    {
        return str_replace(['१', '२', '३', '४', '५', '६', '७', '८', '९', '०'], ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'], $data);
    }
}
if (! function_exists('get_nepali_count')) {
    function get_nepali_count(int $key, string $language = 'ne'): string
    {
        $count = [
            2 => [
                'ne' => 'पहिलो प्रतिलिपि',
                'en' => 'First Copy',
            ],
            3 => [
                'ne' => 'दोस्रो प्रतिलिपि',
                'en' => 'Second Copy',
            ],
            4 => [
                'ne' => 'तेस्रो प्रतिलिपि',
                'en' => 'Third Copy',
            ],
            5 => [
                'ne' => 'चौथो प्रतिलिपि',
                'en' => 'Fourth Copy',
            ],
            6 => [
                'ne' => 'पाँचौं प्रतिलिपि',
                'en' => 'Fifth Copy',
            ],
            7 => [
                'ne' => 'छैटौं प्रतिलिपि',
                'en' => 'Sixth Copy',
            ],
            8 => [
                'ne' => 'सातौं प्रतिलिपि',
                'en' => 'Seventh Copy',
            ],
            9 => [
                'ne' => 'आठौं प्रतिलिपि',
                'en' => 'Eighth Copy',
            ],
            10 => [
                'ne' => 'नवौं प्रतिलिपि',
                'en' => 'Ninth Copy',
            ],
            11 => [
                'ne' => 'दसौं प्रतिलिपि',
                'en' => 'Tenth Copy',
            ],
        ];

        return $count[$key][$language] ?? '';
    }
}

if (! function_exists('replaceFormPlaceholderWith')) {
    function replaceFormPlaceholderWith($fieldName, $fieldValue, $formContent): array|string
    {
        return str_replace($fieldName, $fieldValue, $formContent);
    }
}

if (! function_exists('checkWard')) {
    function checkWard(array $wards) {}
}

if (! function_exists('checkSuperAdmin')) {
    function checkSuperAdmin(): bool
    {
        return auth()->user()->load('role')?->role?->type == 'Super';
    }
}
if (! function_exists('generateRandomRGBAColor')) {
    function generateRandomRGBAColor(): string
    {
        // Generate random intensities for red, green, and blue channels
        $red = mt_rand(0, 255);
        $green = mt_rand(0, 255);
        $blue = mt_rand(0, 255);

        // Set alpha channel to 1
        $alpha = 1;

        // Create RGBA color code with random intensities for red, green, and blue channels
        return "rgba($red, $green, $blue, $alpha)";
    }

    if (! function_exists('extractBulkYouTubeVideoId')) {
        function extractBulkYouTubeVideoId($videos): ?string
        {
            $videoIds = collect();
            collect($videos)->each(function ($video) use ($videoIds) {
                $videoIds->push(extractYouTubeVideoId($video));
            });

            return implode(',', $videoIds->filter()->toArray());
        }
    }

    if (! function_exists('extractYouTubeVideoId')) {
        function extractYouTubeVideoId($url): ?string
        {
            // Define the regex pattern to extract video ID
            $pattern = '/youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)([a-zA-Z0-9_-]{11})/';

            // Check if the URL matches the pattern
            preg_match($pattern, $url, $matches);

            // Return the video ID if found, or null otherwise
            return $matches[1] ?? null;
        }
    }

    if (!function_exists('adToBs')) {
        function adToBs($date): string
        {
            // Create an instance of a class that uses the NepaliDateConverter trait
            $converter = new class {
                use NepaliDateConverter;
            };

            $dateParts = explode('-', $date);

            $nepaliDate = $converter->get_nepali_date($dateParts[0], $dateParts[1], $dateParts[2]);

            return "{$nepaliDate['y']}-{$nepaliDate['m']}-{$nepaliDate['d']}";
        }
    }
}

