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
    
    // Accessor para o CNPJ completo (para a URL)
    public function getCnpjCompletoAttribute(): string
    {
        // CORREÇÃO APLICADA AQUI:
        // Preenche cada parte com zeros à esquerda para garantir o tamanho correto.
        $base = str_pad($this->cnpj_basico, 8, '0', STR_PAD_LEFT);
        $ordem = str_pad($this->cnpj_ordem, 4, '0', STR_PAD_LEFT);
        $dv = str_pad($this->cnpj_dv, 2, '0', STR_PAD_LEFT);

        return $base . $ordem . $dv;
    }

    // Accessor para o CNPJ formatado (para exibição)
    public function getCnpjCompletoFormatadoAttribute(): string
    {
        $cnpj = $this->getCnpjCompletoAttribute(); // Usa o método de cima
        
        if (strlen($cnpj) !== 14) {
            return $cnpj; // Retorna o CNPJ sem formatação se não tiver 14 dígitos
        }

        return sprintf('%s.%s.%s/%s-%s',
            substr($cnpj, 0, 2),
            substr($cnpj, 2, 3),
            substr($cnpj, 5, 3),
            substr($cnpj, 8, 4),
            substr($cnpj, 12, 2)
        );
    }

    // Accessor para data formatada
    public function getDataInicioAtividadeFormatadaAttribute(): ?string
    {
        return $this->data_inicio_atividade ? 
            date('d/m/Y', strtotime($this->data_inicio_atividade)) : 
            'Não informado';
    }
}