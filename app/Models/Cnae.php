<?php // INÍCIO DO ARQUIVO PHP

namespace App\Models; // NAMESPACE DO MODEL

use Illuminate\Database\Eloquent\Model; // CLASSE BASE DO ELOQUENT
use Illuminate\Database\Eloquent\Relations\HasMany; // TIPO DE RELACIONAMENTO

class Cnae extends Model // DEFINIÇÃO DA CLASSE CNAE
{
    protected $connection = 'mysql_dados';
    protected $table = 'cnaes'; // NOME DA TABELA
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
        return $this->hasMany(Estabelecimento::class, 'cnae_fiscal_principal', 'codigo'); // RETORNA O RELACIONAMENTO
    }
}