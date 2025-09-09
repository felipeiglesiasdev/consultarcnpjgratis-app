<?php // INÍCIO DO ARQUIVO PHP

namespace App\Models; // NAMESPACE DO MODEL


use Illuminate\Database\Eloquent\Model; // CLASSE BASE DO ELOQUENT
use Illuminate\Database\Eloquent\Relations\BelongsTo; // TIPO DE RELACIONAMENTO

class Estabelecimento extends Model // DEFINIÇÃO DA CLASSE ESTABELECIMENTO
{
    protected $connection = 'mysql_dados';
    protected $table = 'estabelecimentos'; // NOME DA TABELA
    protected $primaryKey = null; // CHAVE PRIMÁRIA NULA DEVIDO A SER COMPOSTA
    public $incrementing = false; // DESATIVA O AUTOINCREMENTO
    public $timestamps = false; // DESATIVA TIMESTAMPS

    protected $fillable = [ // ATRIBUTOS PREENCHÍVEIS
        'cnpj_basico', // COLUNA
        'cnpj_ordem', // COLUNA
        'cnpj_dv', // COLUNA
        'identificador_matriz_filial', // COLUNA
        'nome_fantasia', // COLUNA
        'situacao_cadastral', // COLUNA
        'data_situacao_cadastral', // COLUNA
        'motivo_situacao_cadastral', // COLUNA
        'nome_cidade_exterior', // COLUNA
        'pais', // COLUNA
        'data_inicio_atividade', // COLUNA
        'cnae_fiscal_principal', // COLUNA
        'cnae_fiscal_secundaria', // COLUNA
        'tipo_logradouro', // COLUNA
        'logradouro', // COLUNA
        'numero', // COLUNA
        'complemento', // COLUNA
        'bairro', // COLUNA
        'cep', // COLUNA
        'uf', // COLUNA
        'municipio', // COLUNA
        'ddd1', // COLUNA
        'telefone1', // COLUNA
        'ddd2', // COLUNA
        'telefone2', // COLUNA
        'ddd_fax', // COLUNA
        'fax', // COLUNA
        'correio_eletronico', // COLUNA
        'situacao_especial', // COLUNA
        'data_situacao_especial', // COLUNA
    ]; // FIM DO ARRAY

    // RELACIONAMENTO N-1
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'cnpj_basico', 'cnpj_basico'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO N-1
    public function paisRel(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais', 'codigo'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO N-1
    public function municipioRel(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio', 'codigo'); // RETORNA O RELACIONAMENTO
    }

    // RELACIONAMENTO N-1
    public function cnaePrincipal(): BelongsTo
    {
        return $this->belongsTo(Cnae::class, 'cnae_fiscal_principal', 'codigo'); // RETORNA O RELACIONAMENTO
    }
}