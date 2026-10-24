<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPenanganan extends Model
{
    protected $table = 'riwayat_penanganan';

    protected $fillable = [
        'laporan_id',
        'admin_id',
        'status_sebelumnya',
        'status_baru',
        'catatan',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}