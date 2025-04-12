    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\MorphTo;

    class Acesso extends Model
    {
        use HasFactory;

        protected $table = 'acesso';
        public $timestamps = false;

        protected $fillable = [
            'pessoa_id',
            'tipo_pessoa',
            'data_hora',
            'tipo',
            'dispositivo',
            'observacao',
        ];

        protected $casts = [
            'data_hora' => 'datetime',
        ];

        // Polymorphic Relationship
        public function pessoa(): MorphTo
        {
            // Laravel will look for 'pessoa_id' and 'tipo_pessoa' columns
            // The 'tipo_pessoa' column should store the related model class name
            // e.g., App\Models\Morador, App\Models\Funcionario, App\Models\Visitante
            return $this->morphTo(__FUNCTION__, 'tipo_pessoa', 'pessoa_id');
        }
    }