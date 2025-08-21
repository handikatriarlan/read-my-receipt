<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class Helper
{
    public function cleanCohereResponse(string $responseText)
    {
        $cleaned = trim(preg_replace('/^[^{\[]+/', '', $responseText));

        $closingPos = strrpos($cleaned, '}');

        if ($closingPos !== false) {
            $cleaned = substr($cleaned, 0, $closingPos + 1);
        }

        try {
            return json_decode($cleaned, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            Log::warning('Gagal Decode JSON AI: ' . $e->getMessage(), [
                'response' => $responseText,
                'cleaned' => $cleaned,
            ]);
            return null;
        }
    }

    public function extarctSpecialFieldsAndCleanItems(array $items)
    {
        $unwantedNames = ['subtotal', 'total', 'vat', 'kembalian'];

        $cleanedItems = [];
        $extractedFields = [];

        foreach ($items as $item) {
            if (!isset($item['name'])) {
                continue;
            }

            $name = strtolower($item['name']);

            if (in_array($name, $unwantedNames, true)) {
                $column = $name;

                $value = $item['Subtotal'] ?? $item['Price'] ?? null;
                $extractedFields[$column] = $value;
            } else {
                $cleanedItems[] = $item;
            }
        }

        return [
            'cleanedItems' => $cleanedItems,
            'extractedFields' => $extractedFields,
        ];
    }
}
