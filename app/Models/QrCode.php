<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCode extends Model
{
    protected $fillable = [
        'student_id',
        'code',
        'generated_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Generate a unique QR code for a student
     */
    public static function generateForStudent(Student $student): self
    {
        // Deactivate existing QR codes
        self::where('student_id', $student->id)->update(['is_active' => false]);

        // Create new QR code
        return self::create([
            'student_id' => $student->id,
            'code' => 'STU-' . $student->student_id_number . '-' . Str::random(8),
            'generated_at' => now(),
            'is_active' => true,
        ]);
    }

    /**
     * Generate the QR code image as SVG
     */
    public function generateImage(): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        
        return $writer->writeString($this->code);
    }

    /**
     * Get the QR code as a data URI for embedding in HTML
     */
    public function getDataUri(): string
    {
        $svg = $this->generateImage();
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
