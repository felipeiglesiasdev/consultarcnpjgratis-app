<?php // INÍCIO DO ARQUIVO PHP

namespace App\Models; // NAMESPACE DO MODEL

use Illuminate\Database\Eloquent\Model; // CLASSE BASE DO ELOQUENT
use Illuminate\Database\Eloquent\Relations\HasMany; // TIPO DE RELACIONAMENTO
use Illuminate\Database\Eloquent\Relations\HasOne; // TIPO DE RELACIONAMENTO
use Illuminate\Database\Eloquent\Relations\BelongsTo; // TIPO DE RELACIONAMENTO

class Empresa extends Model // DEFINIÇÃO DA CLASSE EMPRESA
{
    protected $table = 'empresas'; // NOME DA TABELA
    protected $primaryKey = 'cnpj_basico'; // CHAVE PRIMÁRIA
    protected $keyType = 'string'; // TIPO DA CHAVE PRIMÁRIA
    public $incrementing = false; // CHAVE PRIMÁRIA NÃO É AUTOINCREMENTAL
    public $timestamps = false; // DESATIVA TIMESTAMPS

    protected $fillable = [ // ATRIBUTOS PREENCHÍVEIS
        'cnpj_basico', // COLUNA
        'razao_social', // COLUNA
        'natureza_juridica', // COLUNA
        'qualificacao_responsavel', // COLUNA
        'capital_social', // COLUNA
        'porte_empresa', // COLUNA
        'ente_federativo_responsavel', // COLUNA
    ]; // FIM DO ARRAY

    // RELACIONAMENTO 1-N
    public function estabelecimentos(): HasMany
    {
        return $this->hasMany(Estabelecimento::class, 'cnpj_basico', 'cnpj_basico'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO 1-1
    public function simples(): HasOne
    {
        return $this->hasOne(Simples::class, 'cnpj_basico', 'cnpj_basico'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO 1-N
    public function socios(): HasMany
    {
        return $this->hasMany(Socio::class, 'cnpj_basico', 'cnpj_basico'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO N-1
    public function naturezaJuridica(): BelongsTo
    {
        return $this->belongsTo(NaturezaJuridica::class, 'natureza_juridica', 'codigo'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO N-1
    public function qualificacaoResponsavel(): BelongsTo
    {
        return $this->belongsTo(QualificacaoSocio::class, 'qualificacao_responsavel', 'codigo'); // RETORNA O RELACIONAMENTO
    }
}