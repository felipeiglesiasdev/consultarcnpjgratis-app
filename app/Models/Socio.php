<?php // INÍCIO DO ARQUIVO PHP

namespace App\Models; // NAMESPACE DO MODEL

use Illuminate\Database\Eloquent\Model; // CLASSE BASE DO ELOQUENT
use Illuminate\Database\Eloquent\Relations\BelongsTo; // TIPO DE RELACIONAMENTO

class Socio extends Model // DEFINIÇÃO DA CLASSE SOCIO
{
    protected $connection = 'mysql_dados';
    protected $table = 'socios'; // NOME DA TABELA
    public $timestamps = false; // DESATIVA TIMESTAMPS

    protected $fillable = [ // ATRIBUTOS PREENCHÍVEIS
        'cnpj_basico', // COLUNA
        'identificador_socio', // COLUNA
        'nome_socio', // COLUNA
        'cnpj_cpf_socio', // COLUNA
        'qualificacao_socio', // COLUNA
        'data_entrada_sociedade', // COLUNA
        'pais', // COLUNA
        'representante_legal', // COLUNA
        'nome_representante', // COLUNA
        'qualificacao_representante_legal', // COLUNA
        'faixa_etaria', // COLUNA
    ]; // FIM DO ARRAY

    // RELACIONAMENTO N-1
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'cnpj_basico', 'cnpj_basico'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO N-1
    public function qualificacao(): BelongsTo
    {
        return $this->belongsTo(QualificacaoSocio::class, 'qualificacao_socio', 'codigo'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO N-1
    public function qualificacaoRepresentante(): BelongsTo
    {
        return $this->belongsTo(QualificacaoSocio::class, 'qualificacao_representante_legal', 'codigo'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO N-1
    public function paisRel(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais', 'codigo'); // RETORNA O RELACIONAMENTO
    }
}