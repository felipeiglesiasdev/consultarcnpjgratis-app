<?php // INÍCIO DO ARQUIVO PHP

namespace App\Models; // NAMESPACE DO MODEL

use Illuminate\Database\Eloquent\Model; // CLASSE BASE DO ELOQUENT
use Illuminate\Database\Eloquent\Relations\HasMany; // TIPO DE RELACIONAMENTO

class Pais extends Model // DEFINIÇÃO DA CLASSE PAIS
{
    protected $connection = 'mysql_dados';
    protected $table = 'paises'; // NOME DA TABELA
    protected $primaryKey = 'codigo'; // CHAVE PRIMÁRIA
    public $incrementing = false; // CHAVE PRIMÁRIA NÃO É AUTOINCREMENTAL
    public $timestamps = false; // DESATIVA TIMESTAMPS

    protected $fillable = [ // ATRIBUTOS PREENCHÍVEIS
        'codigo', // COLUNA
        'descricao', // COLUNA
    ]; // FIM DO ARRAY

    // RELACIONAMENTO 1-N
    public function estabelecimentos(): HasMany
    {
        return $this->hasMany(Estabelecimento::class, 'pais', 'codigo'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO 1-N
    public function socios(): HasMany
    {
        return $this->hasMany(Socio::class, 'pais', 'codigo'); // RETORNA O RELACIONAMENTO
    }
}