<?php

namespace App\Models;

use Database\Factories\BrandFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Native\Mobile\Facades\System;

class Brand extends Model
{
    /** @use HasFactory<BrandFactory> */
    use HasFactory;

    protected $appends = ['logo_url', 'colored_logo_url', 'pdf_url'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (! $this->logo_path) {
            return null;
        }
        if(System::isMobile()) {
            return '../images/'.$this->logo_path;
        }
        return asset('/images/'.$this->logo_path);
    }

    public function getColoredLogoUrlAttribute(): ?string
    {
        if (! $this->colored_logo_path) {
            return null;
        }
        if(System::isMobile()) {
            return '../images/'.$this->colored_logo_path;
        }
        return asset('/images/'.$this->colored_logo_path);
    }

    public function getPdfUrlAttribute(): ?string
    {
        if (! $this->pdf_path) {
            return null;
        }

        if (! $this->pdf_path) {
            return null;
        }
        if(System::isMobile()) {
            return '../pdfs/'.$this->pdf_path;
        }
        return asset('/pdfs/'.$this->pdf_path);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }
}
