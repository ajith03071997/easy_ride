<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_category_id',
        'daily_session_id',
        'amount',
        'note'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    /**
     * Get the expense category that owns the expense.
     */
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    /**
     * Get the daily session that owns the expense.
     */
    public function dailySession()
    {
        return $this->belongsTo(DailySession::class);
    }
}
