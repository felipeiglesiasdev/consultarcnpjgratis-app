<?php // INÍCIO DO ARQUIVO PHP

namespace App\Models; // NAMESPACE DO MODEL

use Illuminate\Database\Eloquent\Model; // CLASSE BASE DO ELOQUENT
use Illuminate\Database\Eloquent\Relations\HasMany; // TIPO DE RELACIONAMENTO

class QualificacaoSocio extends Model // DEFINIÇÃO DA CLASSE QUALIFICAÇÃO SÓCIO
{
    protected $connection = 'mysql_dados';
    protected $table = 'qualificacoes_socios'; // NOME DA TABELA
    protected $primaryKey = 'codigo'; // CHAVE PRIMÁRIA
    public $incrementing = false; // CHAVE PRIMÁRIA NÃO É AUTOINCREMENTAL
    public $timestamps = false; // DESATIVA TIMESTAMPS

    protected $fillable = [ // ATRIBUTOS PREENCHÍVEIS
        'codigo', // COLUNA
        'descricao', // COLUNA
    ]; // FIM DO ARRAY

    // RELACIONAMENTO 1-N
    public function empresas(): HasMany
    {
        return $this->hasMany(Empresa::class, 'qualificacao_responsavel', 'codigo'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO 1-N
    public function socios(): HasMany
    {
        return $this->hasMany(Socio::class, 'qualificacao_socio', 'codigo'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO 1-N
    public function representantes(): HasMany
    {
        return $this->hasMany(Socio::class, 'qualificacao_representante_legal', 'codigo'); // RETORNA O RELACIONAMENTO
    }
}