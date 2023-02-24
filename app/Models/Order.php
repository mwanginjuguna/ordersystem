<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function extras() {
        return $this->belongsToMany(AdditionalFeatures::class, 'order_extras');
    }

    protected $fillable = [
        'user_id', 'title',
        'service_type_id', 'academic_level_id',
        'subject_id', 'instructions',
        'deadline', 'pages', 'slides',
        'sources', 'spacing_id', 'referencing_style_id',
        'language_id', 'writer_category_id', 'amount',
        'currency_id', 'cpp', 'discount_id',
        'paid', 'discounted', 'due_at',
        'referral_website', 'status',
        'revision_instructions', 'assigned_to','files', 'assigned_to', 'writer_deadline'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function service()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function writerCategory()
    {
        return $this->belongsTo(WriterCategory::class);
    }
}
