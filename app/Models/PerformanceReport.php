<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceReport extends Model
{
    use HasFactory;

    protected $table = 'performance_reports';

    protected $fillable = [
        'institution_id',
        'generated_by',
        'report_title',
        'report_code',
        'month',
        'year',
        'total_evaluations',
        'average_percentage',
        'count_cemerlang',
        'count_sederhana',
        'count_lemah',
        'status',
        'remarks',
    ];

    protected $casts = [
        'average_percentage' => 'decimal:2',
        'month' => 'integer',
        'year' => 'integer',
        'total_evaluations' => 'integer',
        'count_cemerlang' => 'integer',
        'count_sederhana' => 'integer',
        'count_lemah' => 'integer',
    ];

    /**
     * Get the institution this performance report belongs to.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    /**
     * Get the user who generated this report.
     */
    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    /**
     * Get all evaluations for the month and year of this report.
     */
    public function evaluations()
    {
        $query = SupplierEvaluation::whereMonth('evaluation_date', $this->month)
            ->whereYear('evaluation_date', $this->year);

        if ($this->institution_id) {
            $query->where('institution_id', $this->institution_id);
        }

        return $query;
    }
}
