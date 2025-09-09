<?php // INÍCIO DO ARQUIVO PHP

namespace App\Models; // NAMESPACE DO MODEL

use Illuminate\Database\Eloquent\Model; // CLASSE BASE DO ELOQUENT
use Illuminate\Database\Eloquent\Relations\BelongsTo; // TIPO DE RELACIONAMENTO

class Simples extends Model // DEFINIÇÃO DA CLASSE SIMPLES
{
    protected $connection = 'mysql_dados';
    protected $table = 'simples'; // NOME DA TABELA
    protected $primaryKey = 'cnpj_basico'; // CHAVE PRIMÁRIA
    protected $keyType = 'string'; // TIPO DA CHAVE PRIMÁRIA
    public $incrementing = false; // CHAVE PRIMÁRIA NÃO É AUTOINCREMENTAL
    public $timestamps = false; // DESATIVA TIMESTAMPS

    protected $fillable = [ // ATRIBUTOS PREENCHÍVEIS
        'cnpj_basico', // COLUNA
        'opcao_pelo_simples', // COLUNA
        'data_opcao_pelo_simples', // COLUNA
        'data_exclusao_do_simples', // COLUNA
        'opcao_pelo_mei', // COLUNA
        'data_opcao_pelo_mei', // COLUNA
        'data_exclusao_do_mei', // COLUNA
    ]; // FIM DO ARRAY

    // RELACIONAMENTO N-1
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'cnpj_basico', 'cnpj_basico'); // RETORNA O RELACIONAMENTO
    }
}